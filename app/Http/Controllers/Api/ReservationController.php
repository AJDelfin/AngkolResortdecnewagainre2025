<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        return Reservation::with(['user', 'room'])->get();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        $reservation = Reservation::create($validatedData);
        return response()->json($reservation, 201);
    }

    public function show(Reservation $reservation)
    {
        return $reservation->load(['user', 'room']);
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validatedData = $request->validate([
            'user_id' => 'exists:users,id',
            'room_id' => 'exists:rooms,id',
            'check_in_date' => 'date',
            'check_out_date' => 'date|after:check_in_date',
        ]);

        $reservation->update($validatedData);
        return response()->json($reservation, 200);
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return response()->json(null, 204);
    }
}
