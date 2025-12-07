<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = User::where('role', 'customer')->get();
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer',
        ]);

        $redirectRoute = str_starts_with($request->route()->getName(), 'admin.guests.') ? 'admin.guests.index' : 'admin.customers.index';
        return redirect()->route($redirectRoute)->with('success', 'Item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($customer->id)],
            'password' => 'nullable|string|min:8',
        ]);

        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $customer->update([
                'password' => Hash::make($request->password),
            ]);
        }

        $redirectRoute = str_starts_with($request->route()->getName(), 'admin.guests.') ? 'admin.guests.index' : 'admin.customers.index';
        return redirect()->route($redirectRoute)->with('success', 'Item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $customer)
    {
        $customer->delete();

        $redirectRoute = str_starts_with($request->route()->getName(), 'admin.guests.') ? 'admin.guests.index' : 'admin.customers.index';
        return redirect()->route($redirectRoute)->with('success', 'Item deleted successfully.');
    }
}
