<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::latest()->paginate(10);
        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_number' => ['required', 'string', 'max:255', 'unique:'.Room::class],
            'type' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price_per_night' => ['required', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(['available', 'occupied', 'maintenance'])],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/rooms');
            $data['image_path'] = Storage::url($path);
        }

        Room::create($data);

        return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        // Not implemented for this feature
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'room_number' => ['required', 'string', 'max:255', Rule::unique('rooms')->ignore($room->id)],
            'type' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price_per_night' => ['required', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(['available', 'occupied', 'maintenance'])],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($room->image_path) {
                Storage::delete(str_replace('/storage', 'public', $room->image_path));
            }
            $path = $request->file('image')->store('public/rooms');
            $data['image_path'] = Storage::url($path);
        }

        $room->update($data);

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        if ($room->image_path) {
            Storage::delete(str_replace('/storage', 'public', $room->image_path));
        }
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully.');
    }

    /**
     * Remove the specified resources from storage.
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['exists:rooms,id'],
        ]);

        $rooms = Room::whereIn('id', $request->ids)->get();

        foreach ($rooms as $room) {
            if ($room->image_path) {
                Storage::delete(str_replace('/storage', 'public', $room->image_path));
            }
            $room->delete();
        }

        return redirect()->route('admin.rooms.index')->with('success', 'Selected rooms deleted successfully.');
    }
}
