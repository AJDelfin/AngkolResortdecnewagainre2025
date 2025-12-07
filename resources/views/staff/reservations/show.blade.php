@extends('layouts.staff')

@section('header', 'Reservation Details')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-lg max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Reservation #{{ $reservation->id }}</h2>
        <a href="{{ route('staff.reservations.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
            Back to List
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <div>
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Guest Information</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Name</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $reservation->user->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Email</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $reservation->user->email ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Phone Number</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $reservation->phone_number ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Reservation Details</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Accommodation</p>
                    <p class="text-lg font-semibold text-gray-800">
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
                    <p class="text-sm font-medium text-gray-500">Check-in Date</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $reservation->check_in_date->format('F d, Y') }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Check-out Date</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $reservation->check_out_date->format('F d, Y') }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Number of Guests</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $reservation->number_of_guests }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Price</p>
                    <p class="text-lg font-semibold text-gray-800">${{ number_format($reservation->total_price, 2) }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Status</p>
                    <p class="text-lg font-semibold text-gray-800">{{ ucfirst($reservation->status) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-end space-x-4 mt-8">
        <a href="{{ route('staff.reservations.edit', $reservation) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5m-1.414-9.414a2 2 0 1 1 2.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            Edit Reservation
        </a>
        <form class="delete-form" action="{{ route('staff.reservations.destroy', $reservation) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v3M4 7h16"></path></svg>
                Delete Reservation
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteForm = document.querySelector('.delete-form');
        if (deleteForm) {
            deleteForm.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteForm.submit();
                    }
                });
            });
        }
    });
</script>
@endpush
