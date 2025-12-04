<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        return Room::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'room_number' => 'required|string|max:255|unique:rooms',
            'type' => 'required|string|max:255',
            'price' => 'required|numeric',
            'is_available' => 'required|boolean',
        ]);

        $room = Room::create($validatedData);
        return response()->json($room, 201);
    }

    public function show(Room $room)
    {
        return $room;
    }

    public function update(Request $request, Room $room)
    {
        $validatedData = $request->validate([
            'room_number' => 'string|max:255|unique:rooms,room_number,' . $room->id,
            'type' => 'string|max:255',
            'price' => 'numeric',
            'is_available' => 'boolean',
        ]);

        $room->update($validatedData);
        return response()->json($room, 200);
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return response()->json(null, 204);
    }
}
