@extends('layouts.admin')

@section('header', 'View Cottage')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="mb-6">
            <h2 class="text-2xl font-headline">{{ $cottage->name }}</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-gray-600 font-semibold">Price Per Night:</p>
                <p>${{ number_format($cottage->price_per_night, 2) }}</p>
            </div>
            <div>
                <p class="text-gray-600 font-semibold">Status:</p>
                <p class="{{ $cottage->status === 'available' ? 'text-green-600' : ($cottage->status === 'occupied' ? 'text-red-600' : 'text-yellow-600') }}">
                    {{ ucfirst($cottage->status) }}
                </p>
            </div>
            <div>
                <p class="text-gray-600 font-semibold">Description:</p>
                <p>{{ $cottage->description ?? 'N/A' }}</p>
            </div>
        </div>

        @if ($cottage->image)
            <div class="mt-6">
                <p class="text-gray-600 font-semibold">Image:</p>
                <img src="{{ asset('images/cottages/' . $cottage->image) }}" alt="{{ $cottage->name }}" class="mt-2 rounded-lg shadow-md w-full md:w-1/2">
            </div>
        @endif

        <div class="mt-8">
            <a href="{{ route('admin.cottages.index') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-green-800 transition">
                Back to List
            </a>
        </div>
    </div>
@endsection
