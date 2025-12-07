<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuestController extends Controller
{
    public function index()
    {
        $guests = User::whereHas('roles', function ($query) {
            $query->where('name', 'customer');
        })->latest()->paginate(10);

        return view('admin.guests.index', compact('guests'));
    }

    public function create()
    {
        return view('admin.guests.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
        ]);

        $user->assignRole('customer');

        return redirect()->route('admin.guests.index')->with('success', 'Guest created successfully.');
    }

    public function show(User $guest)
    {
        return view('admin.guests.show', compact('guest'));
    }

    public function edit(User $guest)
    {
        return view('admin.guests.edit', compact('guest'));
    }

    public function update(Request $request, User $guest)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $guest->id,
            'phone_number' => 'nullable|string|max:20',
        ]);

        $guest->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->route('admin.guests.index')->with('success', 'Guest updated successfully.');
    }

    public function destroy(User $guest)
    {
        $guest->delete();

        return redirect()->route('admin.guests.index')->with('success', 'Guest deleted successfully.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids');
        User::whereIn('id', $ids)->delete();
        return redirect()->route('admin.guests.index')->with('success', 'Guests deleted successfully.');
    }
}
