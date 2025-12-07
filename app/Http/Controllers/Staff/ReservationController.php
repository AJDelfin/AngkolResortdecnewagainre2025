<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Room;
use App\Models\Cottage;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['user', 'room', 'cottage'])->get();
        return view('staff.reservations.index', compact('reservations'));
    }

    public function create()
    {
        $users = User::role('customer')->get();
        $rooms = Room::all();
        $cottages = Cottage::all();
        return view('staff.reservations.create', compact('users', 'rooms', 'cottages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'reservation_type' => 'required|in:room,cottage',
            'room_id' => 'required_if:reservation_type,room|nullable|exists:rooms,id',
            'cottage_id' => 'required_if:reservation_type,cottage|nullable|exists:cottages,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after_or_equal:check_in_date',
            'number_of_guests' => 'required|integer|min:1',
            'status' => 'required|in:pending,confirmed,cancelled',
            'total_price' => 'required|numeric|min:0',
        ]);

        $data = $request->all();
        if ($request->input('reservation_type') === 'room') {
            $data['cottage_id'] = null;
        } elseif ($request->input('reservation_type') === 'cottage') {
            $data['room_id'] = null;
        }

        Reservation::create($data);

        return redirect()->route('staff.reservations.index')->with('success', 'Reservation created successfully.');
    }

    public function show(Reservation $reservation)
    {
        return view('staff.reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        $users = User::role('customer')->get();
        $rooms = Room::all();
        $cottages = Cottage::all();
        return view('staff.reservations.edit', compact('reservation', 'users', 'rooms', 'cottages'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'reservation_type' => 'required|in:room,cottage',
            'room_id' => 'required_if:reservation_type,room|nullable|exists:rooms,id',
            'cottage_id' => 'required_if:reservation_type,cottage|nullable|exists:cottages,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after_or_equal:check_in_date',
            'number_of_guests' => 'required|integer|min:1',
            'status' => 'required|in:pending,confirmed,cancelled',
            'total_price' => 'required|numeric|min:0',
        ]);

        $data = $request->all();
        if ($request->input('reservation_type') === 'room') {
            $data['cottage_id'] = null;
        } elseif ($request->input('reservation_type') === 'cottage') {
            $data['room_id'] = null;
        }

        $reservation->update($data);

        return redirect()->route('staff.reservations.index')->with('success', 'Reservation updated successfully.');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('staff.reservations.index')->with('success', 'Reservation deleted successfully.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['exists:reservations,id'],
        ]);

        Reservation::whereIn('id', $request->ids)->delete();

        return redirect()->route('staff.reservations.index')->with('success', 'Selected reservations deleted successfully.');
    }
}
