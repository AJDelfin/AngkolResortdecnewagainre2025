@extends('layouts.admin')

@section('header', 'Add New Room')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-headline">Add New Room</h2>
            <a href="{{ route('admin.rooms.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">
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

        <form action="{{ route('admin.rooms.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Room Number -->
                <div>
                    <label for="room_number" class="block text-sm font-medium text-gray-700">Room Number</label>
                    <input type="text" name="room_number" id="room_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('room_number') }}" required>
                </div>

                <!-- Room Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Room Type</label>
                    <input type="text" name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('type') }}" required>
                </div>

                <!-- Price per Night -->
                <div>
                    <label for="price_per_night" class="block text-sm font-medium text-gray-700">Price per Night</label>
                    <input type="number" name="price_per_night" id="price_per_night" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('price_per_night') }}" required>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-primary text-white px-6 py-2 rounded-md hover:bg-green-800 transition">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                    Create Room
                </button>
            </div>
        </form>
    </div>
@endsection
