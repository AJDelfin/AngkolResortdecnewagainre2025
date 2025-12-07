@extends('layouts.admin')

@section('header', 'Food Package Details')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-headline">{{ $foodPackage->name }}</h2>
            <a href="{{ route('admin.food-packages.index') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-green-800 transition">
                 <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to Packages
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                @if($foodPackage->image_path)
                    <img src="{{ asset('storage/' . $foodPackage->image_path) }}" alt="{{ $foodPackage->name }}" class="w-full h-auto object-cover rounded-lg shadow-md">
                @else
                    <div class="w-full h-64 bg-gray-200 flex items-center justify-center rounded-lg shadow-md">
                        <span class="text-gray-500">No Image Available</span>
                    </div>
                @endif
            </div>
            <div>
                <h3 class="text-xl font-headline mb-2">Package Details</h3>
                <p class="text-gray-700 mb-4">{{ $foodPackage->description }}</p>
                <div class="text-3xl font-bold text-primary mb-4">${{ number_format($foodPackage->price, 2) }}</div>

                <div class="flex space-x-4">
                    <a href="{{ route('admin.food-packages.edit', $foodPackage->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-800 transition">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5m-1.414-9.414a2 2 0 1 1 2.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit Package
                    </a>
                    <form action="{{ route('admin.food-packages.destroy', $foodPackage->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this package?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-800 transition">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v3M4 7h16"></path></svg>
                            Delete Package
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
