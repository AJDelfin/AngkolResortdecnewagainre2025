@extends('layouts.admin')

@section('header')
    @php
        $isGuests = request()->routeIs('admin.guests.*');
        $title = $isGuests ? 'View Guest' : 'View Customer';
    @endphp
    {{ $title }}
@endsection

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="mb-6">
            <h2 class="text-2xl font-headline">{{ $customer->name }}</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-gray-600 font-semibold">Email:</p>
                <p>{{ $customer->email }}</p>
            </div>
            <div>
                <p class="text-gray-600 font-semibold">Joined On:</p>
                <p>{{ $customer->created_at->format('M d, Y') }}</p>
            </div>
        </div>

        <div class="mt-8">
            <a href="{{ route('admin.customers.index') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-green-800 transition">
                Back to List
            </a>
        </div>
    </div>
@endsection
