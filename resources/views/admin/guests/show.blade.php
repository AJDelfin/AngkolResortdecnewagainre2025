@extends('layouts.admin')

@section('header', 'Guest Details')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
            <p class="text-gray-700">{{ $guest->name }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
            <p class="text-gray-700">{{ $guest->email }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Phone Number:</label>
            <p class="text-gray-700">{{ $guest->phone_number }}</p>
        </div>
        <div class="mt-6">
            <a href="{{ route('admin.guests.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Back to Guests
            </a>
        </div>
    </div>
@endsection
