@extends('layouts.admin')

@section('header', 'Add Reservation')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.reservations.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="mb-4">
                    <label for="user_id" class="block text-gray-700 text-sm font-bold mb-2">Guest:</label>
                    <select name="user_id" id="user_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="room_id" class="block text-gray-700 text-sm font-bold mb-2">Room:</label>
                    <select name="room_id" id="room_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Select a room</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}">{{ $room->room_number }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="cottage_id" class="block text-gray-700 text-sm font-bold mb-2">Cottage:</label>
                    <select name="cottage_id" id="cottage_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Select a cottage</option>
                        @foreach ($cottages as $cottage)
                            <option value="{{ $cottage->id }}">{{ $cottage->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="check_in_date" class="block text-gray-700 text-sm font-bold mb-2">Check-in Date:</label>
                    <input type="date" name="check_in_date" id="check_in_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="check_out_date" class="block text-gray-700 text-sm font-bold mb-2">Check-out Date:</label>
                    <input type="date" name="check_out_date" id="check_out_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="number_of_guests" class="block text-gray-700 text-sm font-bold mb-2">Number of Guests:</label>
                    <input type="number" name="number_of_guests" id="number_of_guests" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
                    <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center justify-between mt-6">
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Add Reservation
                </button>
                <a href="{{ route('admin.reservations.index') }}" class="inline-block align-baseline font-bold text-sm text-red-500 hover:text-red-800">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
