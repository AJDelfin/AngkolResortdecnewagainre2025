@extends('layouts.authenticated')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="bg-cover bg-center h-56 p-4" style="background-image: url('{{ $reservation->room ? asset('images/rooms/' . $reservation->room->image) : asset('images/cottages/' . $reservation->cottage->image) }}')">
        </div>
        <div class="p-6">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-headline text-gray-800">Reservation Details</h1>
                <span class="text-sm font-semibold {{ $reservation->status === 'confirmed' ? 'bg-green-500' : ($reservation->status === 'pending' ? 'bg-yellow-500' : 'bg-red-500') }} text-white py-1 px-3 rounded-full">{{ ucfirst($reservation->status) }}</span>
            </div>
            <p class="text-gray-600 mt-2">Reservation #{{ $reservation->id }}</p>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Accommodation</h2>
                    <p class="text-gray-600 mt-2">
                        @if ($reservation->room)
                            Room: {{ $reservation->room->room_number }}
                        @elseif ($reservation->cottage)
                            Cottage: {{ $reservation->cottage->name }}
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Dates</h2>
                    <p class="text-gray-600 mt-2">Check-in: {{ $reservation->check_in_date }}</p>
                    <p class="text-gray-600">Check-out: {{ $reservation->check_out_date }}</p>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Guests</h2>
                    <p class="text-gray-600 mt-2">Adults: {{ $reservation->number_of_adults }}</p>
                    <p class="text-gray-600">Kids: {{ $reservation->number_of_kids }}</p>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Pricing</h2>
                    <p class="text-gray-600 mt-2">Total Price: ₱{{ number_format($reservation->total_price, 2) }}</p>
                    <p class="text-gray-600">Down Payment: ₱{{ number_format($reservation->down_payment, 2) }}</p>
                </div>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('customer.reservations.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Back to Reservations</a>
            </div>
        </div>
    </div>
</div>
@endsection
