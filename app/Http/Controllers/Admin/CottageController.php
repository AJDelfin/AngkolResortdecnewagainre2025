<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cottage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CottageController extends Controller
{
    public function index()
    {
        $cottages = Cottage::all();
        return view('admin.cottages.index', compact('cottages'));
    }

    public function create()
    {
        return view('admin.cottages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price_per_night' => 'required|numeric',
            'status' => ['required', Rule::in(['available', 'occupied', 'maintenance'])],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images/cottages'), $imageName);
        }

        Cottage::create([
            'name' => $request->name,
            'description' => $request->description,
            'price_per_night' => $request->price_per_night,
            'status' => $request->status,
            'image' => $imageName,
        ]);

        return redirect()->route('admin.cottages.index')->with('success', 'Cottage created successfully.');
    }

    public function show(Cottage $cottage)
    {
        //
    }

    public function edit(Cottage $cottage)
    {
        return view('admin.cottages.edit', compact('cottage'));
    }

    public function update(Request $request, Cottage $cottage)
    {
        $request->validate([
            'name' => 'required',
            'price_per_night' => 'required|numeric',
            'status' => ['required', Rule::in(['available', 'occupied', 'maintenance'])],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = $cottage->image;
        if ($request->hasFile('image')) {
            // Delete old image
            if ($imageName && file_exists(public_path('images/cottages/' . $imageName))) {
                unlink(public_path('images/cottages/' . $imageName));
            }
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images/cottages'), $imageName);
        }

        $cottage->update([
            'name' => $request->name,
            'description' => $request->description,
            'price_per_night' => $request->price_per_night,
            'status' => $request->status,
            'image' => $imageName,
        ]);

        return redirect()->route('admin.cottages.index')->with('success', 'Cottage updated successfully.');
    }

    public function destroy(Cottage $cottage)
    {
        // Delete image
        if ($cottage->image && file_exists(public_path('images/cottages/' . $cottage->image))) {
            unlink(public_path('images/cottages/' . $cottage->image));
        }

        $cottage->delete();

        return redirect()->route('admin.cottages.index')->with('success', 'Cottage deleted successfully.');
    }
}
