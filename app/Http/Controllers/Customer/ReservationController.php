<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Admin;
use App\Models\Room;
use App\Models\Cottage;
use App\Models\LoyaltyPoint;
use App\Notifications\NewBookingNotification;
use App\Notifications\NewBookingForAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReservationController extends Controller
{
    const ADULT_PRICE = 100;
    const KID_PRICE = 50;

    public function index()
    {
        $reservations = Auth::user()->reservations()->with(['room', 'cottage'])->latest()->paginate(10);
        return view('customer.reservations.index', compact('reservations'));
    }

    public function create()
    {
        $rooms = Room::where('status', 'available')->get();
        $cottages = Cottage::where('status', 'available')->get();
        return view('customer.reservations.create', compact('rooms', 'cottages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reservation_type' => 'required|in:room,cottage',
            'room_id' => 'required_if:reservation_type,room|nullable|exists:rooms,id',
            'cottage_id' => 'required_if:reservation_type,cottage|nullable|exists:cottages,id',
            'phone_number' => 'required|string|max:20',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after_or_equal:check_in_date',
            'number_of_adults' => 'required|integer|min:0',
            'number_of_kids' => 'required|integer|min:0',
            'total_price' => 'required|numeric|min:0',
            'down_payment' => 'nullable|numeric|min:0|lte:total_price',
        ]);

        $accommodationPrice = 0;
        $accommodation = null;
        if ($request->reservation_type === 'room') {
            $accommodation = Room::find($request->room_id);
        } else if ($request->reservation_type === 'cottage') {
            $accommodation = Cottage::find($request->cottage_id);
        }

        if ($accommodation) {
            $accommodationPrice = $accommodation->price;
        }

        $checkIn = Carbon::parse($request->check_in_date);
        $checkOut = Carbon::parse($request->check_out_date);
        $diffDays = $checkOut->diffInDays($checkIn);

        $adultsTotal = $request->number_of_adults * self::ADULT_PRICE;
        $kidsTotal = $request->number_of_kids * self::KID_PRICE;

        $calculatedPrice = ($accommodationPrice * ($diffDays > 0 ? $diffDays : 1)) + $adultsTotal + $kidsTotal;
        
        if ($request->reservation_type === 'cottage' && $diffDays === 0) {
            $calculatedPrice = $accommodationPrice + $adultsTotal + $kidsTotal;
        }

        if (abs($calculatedPrice - $request->total_price) > 0.01) { // Allow for small floating point differences
            return response()->json(['message' => 'The total price has been tampered with. Please try again.'], 422);
        }

        // Check for booking conflicts
        $isConflict = Reservation::where(function ($query) use ($request) {
                if ($request->reservation_type === 'room') {
                    $query->where('room_id', $request->room_id);
                } else {
                    $query->where('cottage_id', $request->cottage_id);
                }
            })
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->where('check_in_date', '<', $checkOut)
                      ->where('check_out_date', '>', $checkIn);
            })
            ->exists();

        if ($isConflict) {
            return response()->json(['message' => 'The selected accommodation is not available for the chosen dates.'], 409);
        }

        $request->merge(['number_of_guests' => $request->number_of_adults + $request->number_of_kids]);

        $data = $request->all();
        if ($request->input('reservation_type') === 'room') {
            $data['cottage_id'] = null;
        } elseif ($request->input('reservation_type') === 'cottage') {
            $data['room_id'] = null;
        }

        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';
        $data['payment_method'] = 'gcash';

        $reservation = Reservation::create($data);

        // Notify the admin
        $admin = Admin::first();
        if ($admin) {
            $admin->notify(new NewBookingForAdmin($reservation));
        }

        return response()->json([
            'reservation_id' => $reservation->id,
            'created_at' => $reservation->created_at,
        ]);
    }

    public function show(Reservation $reservation)
    {
        // Ensure the authenticated user owns the reservation
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        return view('customer.reservations.show', compact('reservation'));
    }

    public function downloadReceipt(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id() || !in_array($reservation->status, ['paid', 'partially_paid'])) {
            abort(403);
        }

        $pdf = Pdf::loadView('customer.reservations.receipt', compact('reservation'));
        return $pdf->download('receipt-' . $reservation->id . '.pdf');
    }
    
    public function cancel(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id() || $reservation->status !== 'pending') {
            abort(403);
        }

        $reservation->status = 'cancelled';
        $reservation->save();

        return response()->json(['message' => 'Reservation cancelled successfully.']);
    }
}
