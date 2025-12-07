<?php

namespace App\Http\Controllers;

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
        return view('admin.reservations.index', compact('reservations'));
    }

    public function create()
    {
        $users = User::all();
        $rooms = Room::all();
        $cottages = Cottage::all();
        return view('admin.reservations.create', compact('users', 'rooms', 'cottages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'nullable|exists:rooms,id',
            'cottage_id' => 'nullable|exists:cottages,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after_or_equal:check_in_date',
            'number_of_guests' => 'required|integer|min:1',
            'status' => 'required|string|in:pending,confirmed,cancelled',
        ]);

        $reservation = Reservation::create($validated);

        return redirect()->route('admin.reservations.show', $reservation)->with('success', 'Reservation created successfully.');
    }

    public function show(Reservation $reservation)
    {
        return view('admin.reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        $users = User::all();
        $rooms = Room::all();
        $cottages = Cottage::all();
        return view('admin.reservations.edit', compact('reservation', 'users', 'rooms', 'cottages'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'nullable|exists:rooms,id',
            'cottage_id' => 'nullable|exists:cottages,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after_or_equal:check_in_date',
            'number_of_guests' => 'required|integer|min:1',
            'status' => 'required|string|in:pending,confirmed,cancelled',
        ]);

        $reservation->update($validated);

        return redirect()->route('admin.reservations.show', $reservation)->with('success', 'Reservation updated successfully.');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('admin.reservations.index')->with('success', 'Reservation deleted successfully.');
    }
}
