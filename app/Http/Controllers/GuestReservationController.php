<?php

namespace App\Http\Controllers;

use App\Models\Cottage;
use App\Models\Post;
use App\Models\Room;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GuestReservationController extends Controller
{
    public function create()
    {
        return view('guest.reservations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],
            'accommodation_type' => ['required', 'string', 'in:room,cottage'],
            'accommodation_id' => ['required', 'integer'],
            'check_in_date' => ['required', 'date'],
            'check_out_date' => ['required', 'date', 'after_or_equal:check_in_date'],
            'number_of_guests' => ['required', 'integer', 'min:1'],
        ]);

        $user = User::firstOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'password' => Hash::make(Str::random(12)),
                'role' => 'customer',
            ]
        );

        $reservation = new Reservation($request->all());
        $reservation->user_id = $user->id;

        if ($request->accommodation_type === 'room') {
            $accommodation = Room::findOrFail($request->accommodation_id);
            $reservation->room_id = $accommodation->id;
            $reservation->total_price = $accommodation->price;
        } elseif ($request->accommodation_type === 'cottage') {
            $accommodation = Cottage::findOrFail($request->accommodation_id);
            $reservation->cottage_id = $accommodation->id;
            $reservation->total_price = $accommodation->price;
        }

        $reservation->save();

        return redirect()->route('welcome')->with('success', 'Reservation created successfully!');
    }
}
