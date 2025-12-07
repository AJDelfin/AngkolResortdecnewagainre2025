@extends('layouts.staff')

@section('header', 'Edit Reservation')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Whoops!</strong>
                <span class="block sm:inline">There were some problems with your input.</span>
                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('staff.reservations.update', $reservation) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Guest Selection -->
                <div class="mb-4">
                    <label for="user_id" class="block text-gray-700 text-sm font-bold mb-2">Guest:</label>
                    <select name="user_id" id="user_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $reservation->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Phone Number -->
                <div class="mb-4">
                    <label for="phone_number" class="block text-gray-700 text-sm font-bold mb-2">Phone Number:</label>
                    <input type="text" name="phone_number" id="phone_number" value="{{ $reservation->phone_number }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <!-- Reservation Type -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Reservation Type:</label>
                    <div>
                        <input type="radio" id="type_room" name="reservation_type" value="room" {{ $reservation->room_id ? 'checked' : '' }} class="mr-2">
                        <label for="type_room" class="mr-4">Room</label>
                        <input type="radio" id="type_cottage" name="reservation_type" value="cottage" {{ $reservation->cottage_id ? 'checked' : '' }} class="mr-2">
                        <label for="type_cottage">Cottage</label>
                    </div>
                </div>

                <!-- Room Selection -->
                <div id="room_fields" class="mb-4 {{ $reservation->cottage_id ? 'hidden' : '' }}">
                    <label for="room_id" class="block text-gray-700 text-sm font-bold mb-2">Room:</label>
                    <select name="room_id" id="room_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="" data-price="0">Select a room</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}" data-price="{{ $room->price_per_night }}" {{ $reservation->room_id == $room->id ? 'selected' : '' }}>{{ $room->room_number }} ({{ $room->name }}) - (₱{{ $room->price_per_night }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Cottage Selection -->
                <div id="cottage_fields" class="mb-4 {{ $reservation->room_id ? 'hidden' : '' }}">
                    <label for="cottage_id" class="block text-gray-700 text-sm font-bold mb-2">Cottage:</label>
                    <select name="cottage_id" id="cottage_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="" data-price="0">Select a cottage</option>
                        @foreach ($cottages as $cottage)
                            <option value="{{ $cottage->id }}" data-price="{{ $cottage->price_per_night }}" {{ $reservation->cottage_id == $cottage->id ? 'selected' : '' }}>{{ $cottage->name }} - (₱{{ $cottage->price_per_night }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Other Fields -->
                <div class="mb-4">
                    <label for="check_in_date" class="block text-gray-700 text-sm font-bold mb-2">Check-in Date:</label>
                    <input type="date" name="check_in_date" id="check_in_date" value="{{ $reservation->check_in_date }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="check_out_date" class="block text-gray-700 text-sm font-bold mb-2">Check-out Date:</label>
                    <input type="date" name="check_out_date" id="check_out_date" value="{{ $reservation->check_out_date }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="number_of_adults" class="block text-gray-700 text-sm font-bold mb-2">Number of Adults:</label>
                    <input type="number" name="number_of_adults" id="number_of_adults" value="{{ $reservation->number_of_adults }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required min="0">
                </div>
                <div class="mb-4">
                    <label for="number_of_kids" class="block text-gray-700 text-sm font-bold mb-2">Number of Kids:</label>
                    <input type="number" name="number_of_kids" id="number_of_kids" value="{{ $reservation->number_of_kids }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required min="0">
                </div>
                <input type="hidden" name="number_of_guests" id="number_of_guests" value="{{ $reservation->number_of_guests }}">
                <div class="mb-4">
                    <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
                    <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $reservation->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="total_price" class="block text-gray-700 text-sm font-bold mb-2">Total Price:</label>
                    <input type="text" name="total_price" id="total_price" value="{{ number_format($reservation->total_price, 2) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly>
                </div>
                 <!-- Price Breakdown -->
                 <div id="price_breakdown" class="md:col-span-2 bg-gray-100 p-4 rounded-lg">
                    <h4 class="font-bold text-lg mb-2">Price Breakdown</h4>
                    <div id="breakdown_content"></div>
                </div>
            </div>
            <div class="flex items-center justify-between mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Reservation
                </button>
                <a href="{{ route('staff.reservations.index') }}" class="inline-block align-baseline font-bold text-sm text-red-500 hover:text-red-800">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const reservationTypeRadios = document.querySelectorAll('input[name="reservation_type"]');
        const roomFields = document.getElementById('room_fields');
        const cottageFields = document.getElementById('cottage_fields');
        const roomSelect = document.getElementById('room_id');
        const cottageSelect = document.getElementById('cottage_id');
        const numberOfAdultsInput = document.getElementById('number_of_adults');
        const numberOfKidsInput = document.getElementById('number_of_kids');
        const numberOfGuestsInput = document.getElementById('number_of_guests');
        const checkInDateInput = document.getElementById('check_in_date');
        const checkOutDateInput = document.getElementById('check_out_date');
        const totalPriceInput = document.getElementById('total_price');
        const breakdownContent = document.getElementById('breakdown_content');

        const dayTourAdultPrice = 100;
        const dayTourKidPrice = 50;
        const overnightAdultPrice = 150;
        const overnightKidPrice = 60;

        function toggleFields() {
            if (document.getElementById('type_room').checked) {
                roomFields.classList.remove('hidden');
                cottageFields.classList.add('hidden');
                cottageSelect.value = '';
            } else {
                roomFields.classList.add('hidden');
                cottageFields.classList.remove('hidden');
                roomSelect.value = '';
            }
            calculateTotalPrice();
        }

        function calculateTotalPrice() {
            let accommodationPrice = 0;
            let accommodationName = '';
            if (document.getElementById('type_room').checked) {
                const roomOption = roomSelect.options[roomSelect.selectedIndex];
                accommodationPrice = parseFloat(roomOption.dataset.price) || 0;
                accommodationName = roomOption.text;
            } else {
                const cottageOption = cottageSelect.options[cottageSelect.selectedIndex];
                accommodationPrice = parseFloat(cottageOption.dataset.price) || 0;
                accommodationName = cottageOption.text;
            }

            const numberOfAdults = parseInt(numberOfAdultsInput.value) || 0;
            const numberOfKids = parseInt(numberOfKidsInput.value) || 0;
            numberOfGuestsInput.value = numberOfAdults + numberOfKids;

            const checkInDate = checkInDateInput.value;
            const checkOutDate = checkOutDateInput.value;

            let total = 0;
            let breakdownHTML = '';

            if (checkInDate && checkOutDate) {
                const startDate = new Date(checkInDate);
                const endDate = new Date(checkOutDate);

                if (startDate.getTime() === endDate.getTime()) {
                    // Day Tour
                    const entranceFee = (numberOfAdults * dayTourAdultPrice) + (numberOfKids * dayTourKidPrice);
                    total = entranceFee + accommodationPrice;
                    breakdownHTML = `
                        <p><strong>Accommodation:</strong> ${accommodationName}</p>
                        <p><strong>Entrance Fees:</strong></p>
                        <ul>
                            <li>${numberOfAdults} Adults x ₱${dayTourAdultPrice} = ₱${numberOfAdults * dayTourAdultPrice}</li>
                            <li>${numberOfKids} Kids x ₱${dayTourKidPrice} = ₱${numberOfKids * dayTourKidPrice}</li>
                        </ul>
                    `;
                } else if (endDate > startDate) {
                    // Overnight Stay
                    const timeDifference = endDate.getTime() - startDate.getTime();
                    const numberOfNights = Math.ceil(timeDifference / (1000 * 3600 * 24));
                    const accommodationTotal = accommodationPrice * numberOfNights;
                    const entranceFee = (numberOfAdults * overnightAdultPrice) + (numberOfKids * overnightKidPrice);
                    total = accommodationTotal + entranceFee;
                    breakdownHTML = `
                        <p><strong>Accommodation:</strong> ${accommodationName}</p>
                        <p>₱${accommodationPrice} x ${numberOfNights} night(s) = ₱${accommodationTotal}</p>
                        <p><strong>Entrance Fees:</strong></p>
                        <ul>
                            <li>${numberOfAdults} Adults x ₱${overnightAdultPrice} = ₱${numberOfAdults * overnightAdultPrice}</li>
                            <li>${numberOfKids} Kids x ₱${overnightKidPrice} = ₱${numberOfKids * overnightKidPrice}</li>
                        </ul>
                    `;
                }
            }

            totalPriceInput.value = total.toFixed(2);
            breakdownContent.innerHTML = breakdownHTML;
        }

        reservationTypeRadios.forEach(radio => radio.addEventListener('change', toggleFields));
        roomSelect.addEventListener('change', calculateTotalPrice);
        cottageSelect.addEventListener('change', calculateTotalPrice);
        numberOfAdultsInput.addEventListener('input', calculateTotalPrice);
        numberOfKidsInput.addEventListener('input', calculateTotalPrice);
        checkInDateInput.addEventListener('change', calculateTotalPrice);
        checkOutDateInput.addEventListener('change', calculateTotalPrice);

        toggleFields();
        calculateTotalPrice();
    });
</script>
@endpush
