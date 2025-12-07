@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-center">
        <div class="w-full lg:w-8/12">
            <div class="bg-white p-8 rounded-lg shadow-lg">
                <h1 class="text-3xl font-bold mb-6">Create a Reservation</h1>

                <form action="{{ route('guest.reservations.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Full Name:</label>
                        <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                        <input type="email" name="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>

                    <div class="mb-4">
                        <label for="phone_number" class="block text-gray-700 text-sm font-bold mb-2">Phone Number:</label>
                        <input type="text" name="phone_number" id="phone_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>

                    <div class="mb-4">
                        <label for="accommodation_type" class="block text-gray-700 text-sm font-bold mb-2">Accommodation Type:</label>
                        <select name="accommodation_type" id="accommodation_type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <option value="room">Room</option>
                            <option value="cottage">Cottage</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="accommodation_id" class="block text-gray-700 text-sm font-bold mb-2">Accommodation:</label>
                        <select name="accommodation_id" id="accommodation_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <!-- Accommodation options will be populated dynamically -->
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
                        <input type="number" name="number_of_guests" id="number_of_guests" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required min="1">
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Create Reservation
                        </button>
                        <a href="{{ route('welcome') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const accommodationType = document.getElementById('accommodation_type');
        const accommodationId = document.getElementById('accommodation_id');

        const accommodations = {
            room: @json(App\Models\Room::all()),
            cottage: @json(App\Models\Cottage::all())
        };

        function updateAccommodationOptions() {
            const type = accommodationType.value;
            const options = accommodations[type];

            accommodationId.innerHTML = '';

            options.forEach(option => {
                const optionElement = document.createElement('option');
                optionElement.value = option.id;
                optionElement.textContent = option.name || option.room_number;
                accommodationId.appendChild(optionElement);
            });
        }

        accommodationType.addEventListener('change', updateAccommodationOptions);

        // Initial population
        updateAccommodationOptions();
    });
</script>
@endpush
@endsection
