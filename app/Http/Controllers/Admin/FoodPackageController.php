<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FoodPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FoodPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $foodPackages = FoodPackage::paginate(10);
        return view('admin.food-packages.index', compact('foodPackages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.food-packages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('food-packages', 'public');
        }

        FoodPackage::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.food-packages.index')->with('success', 'Food package created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FoodPackage $foodPackage)
    {
        return view('admin.food-packages.show', compact('foodPackage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FoodPackage $foodPackage)
    {
        return view('admin.food-packages.edit', compact('foodPackage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FoodPackage $foodPackage)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = $foodPackage->image_path;
        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('food-packages', 'public');
        }

        $foodPackage->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.food-packages.index')->with('success', 'Food package updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FoodPackage $foodPackage)
    {
        if ($foodPackage->image_path) {
            Storage::disk('public')->delete($foodPackage->image_path);
        }

        $foodPackage->delete();

        return redirect()->route('admin.food-packages.index')->with('success', 'Food package deleted successfully.');
    }

    /**
     * Remove the specified resources from storage.
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:food_packages,id',
        ]);

        $foodPackages = FoodPackage::whereIn('id', $request->ids)->get();

        foreach ($foodPackages as $foodPackage) {
            if ($foodPackage->image_path) {
                Storage::disk('public')->delete($foodPackage->image_path);
            }
            $foodPackage->delete();
        }

        return redirect()->route('admin.food-packages.index')->with('success', 'Selected food packages deleted successfully.');
    }
}
