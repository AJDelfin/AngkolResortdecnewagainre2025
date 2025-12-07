@extends('layouts.admin')

@section('header', 'Edit Cottage')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-headline">Edit Cottage</h2>
            <a href="{{ route('admin.cottages.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                Back to List
            </a>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <strong class="font-bold">Whoops! Something went wrong.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.cottages.update', $cottage->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Cottage Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Cottage Name</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('name', $cottage->name) }}" required>
                </div>

                <!-- Price per Night -->
                <div>
                    <label for="price_per_night" class="block text-sm font-medium text-gray-700">Price per Night</label>
                    <input type="number" name="price_per_night" id="price_per_night" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('price_per_night', $cottage->price_per_night) }}" required>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        <option value="available" {{ old('status', $cottage->status) == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="occupied" {{ old('status', $cottage->status) == 'occupied' ? 'selected' : '' }}>Occupied</option>
                        <option value="maintenance" {{ old('status', $cottage->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-primary text-white px-6 py-2 rounded-md hover:bg-green-800 transition">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                    Update Cottage
                </button>
            </div>
        </form>
    </div>
@endsection
