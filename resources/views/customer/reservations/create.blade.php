@extends('layouts.authenticated')

@section('content')
<div class="container mx-auto p-4 sm:p-8">
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-lg p-6 sm:p-10">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-6 text-center">
            {{ __('Make a New Reservation') }}
        </h2>

        @if($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded-lg">
            <div class="font-bold">Whoops! Something went wrong.</div>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(session('suggestions'))
        <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 rounded-lg">
            <p class="font-bold">We're sorry, the accommodation you selected is not available for the chosen dates.</p>
            <p>Here are some other accommodations available during that time:</p>
            <ul class="list-disc list-inside mt-2">
                @foreach(session('suggestions') as $suggestion)
                <li>{{ $suggestion['name'] }} - ₱{{ $suggestion['price'] }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form id="reservation-form" action="{{ route('customer.reservations.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Reservation Type</label>
                    <div class="flex gap-4">
                        <label for="type_room" class="flex-1 p-4 border border-gray-300 rounded-lg cursor-pointer hover:border-indigo-500 transition-all has-[:checked]:bg-indigo-50 has-[:checked]:border-indigo-500">
                            <input type="radio" id="type_room" name="reservation_type" value="room" class="hidden">
                            <div class="text-center">
                                <span class="text-lg font-semibold">Room</span>
                            </div>
                        </label>
                        <label for="type_cottage" class="flex-1 p-4 border border-gray-300 rounded-lg cursor-pointer hover:border-indigo-500 transition-all has-[:checked]:bg-indigo-50 has-[:checked]:border-indigo-500">
                            <input type="radio" id="type_cottage" name="reservation_type" value="cottage" class="hidden">
                            <div class="text-center">
                                <span class="text-lg font-semibold">Cottage</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div id="room_selection" style="display: none;">
                    <label for="room_id" class="block text-sm font-medium text-gray-700">Room</label>
                    <select name="room_id" id="room_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Select a Room</option>
                        @foreach($rooms as $room)
                        <option value="{{ $room->id }}" data-price="{{ $room->price }}">{{ $room->room_number }} - (₱{{number_format($room->price, 2)}}) </option>
                        @endforeach
                    </select>
                </div>

                <div id="cottage_selection" style="display: none;">
                    <label for="cottage_id" class="block text-sm font-medium text-gray-700">Cottage</label>
                    <select name="cottage_id" id="cottage_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Select a Cottage</option>
                        @foreach($cottages as $cottage)
                        <option value="{{ $cottage->id }}" data-price="{{ $cottage->price }}">{{ $cottage->name }} - (₱{{number_format($cottage->price, 2)}})</option>
                        @endforeach
                    </select>
                </div>

                 <div>
                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="text" name="phone_number" id="phone_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                <div>
                    <label for="check_in_date" class="block text-sm font-medium text-gray-700">Check-in Date</label>
                    <input type="date" name="check_in_date" id="check_in_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                <div>
                    <label for="check_out_date" class="block text-sm font-medium text-gray-700">Check-out Date</label>
                    <input type="date" name="check_out_date" id="check_out_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                <div>
                    <label for="number_of_adults" class="block text-sm font-medium text-gray-700">Number of Adults</label>
                    <input type="number" name="number_of_adults" id="number_of_adults" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="0">
                </div>

                <div>
                    <label for="number_of_kids" class="block text-sm font-medium text-gray-700">Number of Kids</label>
                    <input type="number" name="number_of_kids" id="number_of_kids" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="0">
                </div>

                <div class="md:col-span-2">
                    <div id="price_breakdown" class="p-4 bg-gray-50 rounded-lg">
                        <h4 class="font-bold text-lg mb-2">Price Breakdown</h4>
                        <div id="breakdown_content" class="text-sm text-gray-600">
                            Select accommodation and dates to see breakdown.
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label for="use_loyalty_points" class="inline-flex items-center">
                        <input type="checkbox" id="use_loyalty_points" name="use_loyalty_points" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-offset-0 focus:ring-indigo-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-600">Use my loyalty points (You have {{ Auth::user()->loyaltyPoints->points ?? 0 }} points)</span>
                        <div class="relative inline-block ml-2">
                            <svg class="w-5 h-5 text-gray-500 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" onmouseover="document.getElementById('loyalty-tooltip').style.display = 'block'" onmouseout="document.getElementById('loyalty-tooltip').style.display = 'none'">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div id="loyalty-tooltip" class="absolute z-10 w-48 p-2 -mt-16 text-sm text-white bg-gray-900 rounded-lg shadow-lg" style="display: none;">
                                10 points = 2 pesos discount<br>
                                20 points = 4 pesos discount<br>
                                30 points = 6 pesos discount<br>
                                40 points = 8 pesos discount<br>
                                50 points = 10 pesos discount<br>
                                Max discount is 20 pesos.
                            </div>
                        </div>
                    </label>
                </div>
                <div id="loyalty_points_input_container" style="display: none;">
                    <label for="loyalty_points_to_use" class="block text-sm font-medium text-gray-700">Points to Use</label>
                    <input type="number" name="loyalty_points_to_use" id="loyalty_points_to_use" min="0" max="{{ Auth::user()->loyaltyPoints->points ?? 0 }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="0">
                </div>

                <div class="md:col-span-2 flex justify-between items-center">
                    <div class="text-2xl font-bold text-gray-800">Total: <span id="total_price_display">₱0.00</span></div>
                    <input type="hidden" name="total_price" id="total_price">
                </div>
                
                <div class="md:col-span-2">
                    <label for="down_payment" class="block text-sm font-medium text-gray-700">Down Payment (50%)</label>
                    <input type="number" name="down_payment" id="down_payment" min="0" readonly class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-gray-100">
                </div>
            </div>

            <div class="mt-8 text-center">
                <button type="submit" id="book-now-button" class="w-full sm:w-auto inline-block bg-gradient-to-r from-green-500 to-teal-500 text-white font-bold py-4 px-10 rounded-full hover:from-green-600 hover:to-teal-600 transition-all duration-300 text-lg shadow-xl transform hover:scale-105">
                    Book Now
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Payment Details
                            </h3>
                            <div id="countdown-timer" class="font-bold text-lg">10:00</div>
                        </div>
                        <div class="mt-4">
                            <!-- Hidden input for selected payment method -->
                            <input type="hidden" id="selected_payment_method" value="gcash">

                            <div class="border-b border-gray-200">
                                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                                    <button class="payment-tab whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-payment-method="gcash">
                                        GCash
                                    </button>
                                    <button class="payment-tab whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-payment-method="maya">
                                        Maya
                                    </button>
                                </nav>
                            </div>
                            <div id="payment-details" class="mt-4">
                                <!-- GCash Details -->
                                <div class="payment-info hidden" data-payment-method="gcash">
                                    <div class="flex flex-col items-center">
                                        <img src="{{ asset('images/gcashqrcode.jpg') }}" alt="GCash QR Code" class="w-48 h-48 mb-4">
                                        <p class="text-lg font-semibold">GCash Number: 0963-566-8689</p>
                                    </div>
                                </div>
                                <!-- Maya Details -->
                                <div class="payment-info hidden" data-payment-method="maya">
                                    <div class="flex flex-col items-center">
                                        <img src="{{ asset('images/mayaqrcode.jpg') }}" alt="Maya QR Code" class="w-48 h-48 mb-4">
                                        <p class="text-lg font-semibold">Maya Number: 0998-765-4321</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="confirm-payment-btn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Confirm Payment
                </button>
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" id="cancel-payment-btn">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Elements
        const reservationTypeRadios = document.querySelectorAll('input[name="reservation_type"]');
        const roomSelection = document.getElementById('room_selection');
        const cottageSelection = document.getElementById('cottage_selection');
        const roomSelect = document.getElementById('room_id');
        const cottageSelect = document.getElementById('cottage_id');
        const checkInDateInput = document.getElementById('check_in_date');
        const checkOutDateInput = document.getElementById('check_out_date');
        const numberOfAdultsInput = document.getElementById('number_of_adults');
        const numberOfKidsInput = document.getElementById('number_of_kids');
        const useLoyaltyPoints = document.getElementById('use_loyalty_points');
        const loyaltyPointsInputContainer = document.getElementById('loyalty_points_input_container');
        const loyaltyPointsToUse = document.getElementById('loyalty_points_to_use');
        const totalPriceInput = document.getElementById('total_price');
        const totalPriceDisplay = document.getElementById('total_price_display');
        const downPaymentInput = document.getElementById('down_payment');
        const breakdownContent = document.getElementById('breakdown_content');
        const bookNowButton = document.getElementById('book-now-button');

        // Payment Modal Elements
        const paymentModal = document.getElementById('paymentModal');
        const countdownTimer = document.getElementById('countdown-timer');
        const confirmPaymentBtn = document.getElementById('confirm-payment-btn');
        const cancelPaymentBtn = document.getElementById('cancel-payment-btn');
        const paymentTabs = document.querySelectorAll('.payment-tab');
        const paymentInfos = document.querySelectorAll('.payment-info');
        const selectedPaymentMethodInput = document.getElementById('selected_payment_method');

        // Constants (in cents)
        const dayTourAdultPrice = 10000; // ₱100.00
        const dayTourKidPrice = 5000;    // ₱50.00
        const overnightAdultPrice = 15000; // ₱150.00
        const overnightKidPrice = 6000;    // ₱60.00
        
        let timerInterval;
        let reservationId;

        // --- 1. Date Logic: Disable Past Dates & Set Today ---
        const today = new Date().toISOString().split('T')[0];
        
        checkInDateInput.setAttribute('min', today);
        checkOutDateInput.setAttribute('min', today);
        
        // Default to today
        if(!checkInDateInput.value) checkInDateInput.value = today;
        if(!checkOutDateInput.value) checkOutDateInput.value = today;

        checkInDateInput.addEventListener('change', function() {
            const checkInDate = this.value;
            // Update min date for checkout to be equal or after checkin
            checkOutDateInput.setAttribute('min', checkInDate);
            
            // If checkout is now before checkin, update it
            if (checkOutDateInput.value < checkInDate) {
                checkOutDateInput.value = checkInDate;
            }
            calculateTotalPrice();
        });

        // --- 2. Reservation Type Toggling ---
        reservationTypeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'room') {
                    roomSelection.style.display = 'block';
                    cottageSelection.style.display = 'none';
                    cottageSelect.value = ""; // Reset
                } else if (this.value === 'cottage') {
                    roomSelection.style.display = 'none';
                    cottageSelection.style.display = 'block';
                    roomSelect.value = ""; // Reset
                }
                calculateTotalPrice();
            });
        });

        // --- 3. Loyalty Points Toggle ---
        useLoyaltyPoints.addEventListener('change', function() {
            loyaltyPointsInputContainer.style.display = this.checked ? 'block' : 'none';
            if (!this.checked) {
                loyaltyPointsToUse.value = 0;
            }
            calculateTotalPrice();
        });

        // --- 4. Main Price Calculation Logic (Fixed) ---
        function calculateTotalPrice() {
            let accommodationPriceCents = 0;
            let accommodationName = 'None';
            
            // Determine selected accommodation
            const reservationType = document.querySelector('input[name="reservation_type"]:checked');
            if (reservationType) {
                let selectedOption = null;
                if (reservationType.value === 'room') {
                    selectedOption = roomSelect.options[roomSelect.selectedIndex];
                } else if (reservationType.value === 'cottage') {
                    selectedOption = cottageSelect.options[cottageSelect.selectedIndex];
                }

                if (selectedOption && selectedOption.value) {
                    // FIX: Use parseFloat to handle strings like "1500.00", then multiply for cents
                    const rawPrice = parseFloat(selectedOption.dataset.price);
                    if (!isNaN(rawPrice)) {
                        accommodationPriceCents = Math.round(rawPrice * 100);
                        accommodationName = selectedOption.text.split('-')[0].trim();
                    }
                }
            }

            const adults = parseInt(numberOfAdultsInput.value) || 0;
            const kids = parseInt(numberOfKidsInput.value) || 0;
            const checkInVal = checkInDateInput.value;
            const checkOutVal = checkOutDateInput.value;

            let totalCents = 0;
            let breakdownHTML = '<p class="text-gray-500 italic">Please complete selection...</p>';

            if (checkInVal && checkOutVal) {
                // Normalize dates to midnight to ensure accurate day difference
                const startDate = new Date(checkInVal);
                startDate.setHours(0,0,0,0);
                const endDate = new Date(checkOutVal);
                endDate.setHours(0,0,0,0);

                // Check for Day Tour (Same Day)
                if (startDate.getTime() === endDate.getTime()) {
                    const entranceTotal = (adults * dayTourAdultPrice) + (kids * dayTourKidPrice);
                    totalCents = entranceTotal + accommodationPriceCents;

                    breakdownHTML = `
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between font-semibold border-b pb-1">
                                <span>Type:</span>
                                <span>Day Tour</span>
                            </div>
                            ${accommodationPriceCents > 0 ? `
                            <div class="flex justify-between">
                                <span>${accommodationName}:</span>
                                <span>₱${(accommodationPriceCents / 100).toFixed(2)}</span>
                            </div>` : ''}
                            <div class="flex justify-between">
                                <span>Entrance (${adults} Adults):</span>
                                <span>₱${((adults * dayTourAdultPrice) / 100).toFixed(2)}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Entrance (${kids} Kids):</span>
                                <span>₱${((kids * dayTourKidPrice) / 100).toFixed(2)}</span>
                            </div>
                        </div>
                    `;
                } 
                // Check for Overnight
                else if (endDate > startDate) {
                    const diffTime = Math.abs(endDate - startDate);
                    const nights = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
                    
                    const accommodationTotal = accommodationPriceCents * nights;
                    const entranceTotal = (adults * overnightAdultPrice) + (kids * overnightKidPrice);
                    totalCents = accommodationTotal + entranceTotal;

                    breakdownHTML = `
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between font-semibold border-b pb-1">
                                <span>Type:</span>
                                <span>Overnight (${nights} Night${nights > 1 ? 's' : ''})</span>
                            </div>
                            ${accommodationPriceCents > 0 ? `
                            <div class="flex justify-between">
                                <span>${accommodationName} (x${nights}):</span>
                                <span>₱${(accommodationTotal / 100).toFixed(2)}</span>
                            </div>` : ''}
                            <div class="flex justify-between">
                                <span>Entrance (${adults} Adults):</span>
                                <span>₱${((adults * overnightAdultPrice) / 100).toFixed(2)}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Entrance (${kids} Kids):</span>
                                <span>₱${((kids * overnightKidPrice) / 100).toFixed(2)}</span>
                            </div>
                        </div>
                    `;
                }
            }

            // Apply Loyalty Points
            let discountCents = 0;
            if (useLoyaltyPoints.checked) {
                const points = parseInt(loyaltyPointsToUse.value) || 0;
                // 20 cents per point, max 2000 cents (20 pesos)
                discountCents = Math.min(points * 20, 2000);
                
                if (discountCents > 0) {
                    breakdownHTML += `
                        <div class="flex justify-between text-green-600 font-medium mt-2 pt-2 border-t border-dashed">
                            <span>Loyalty Discount:</span>
                            <span>-₱${(discountCents / 100).toFixed(2)}</span>
                        </div>
                    `;
                }
            }

            totalCents -= discountCents;
            if (totalCents < 0) totalCents = 0;

            // Update UI
            const totalPesos = (totalCents / 100).toFixed(2);
            const downPaymentPesos = (totalCents / 200).toFixed(2); // 50%

            totalPriceInput.value = totalPesos;
            totalPriceDisplay.textContent = `₱${totalPesos}`;
            downPaymentInput.value = downPaymentPesos;
            breakdownContent.innerHTML = breakdownHTML;
        }

        // --- 5. Form Submission & Payment Timer ---
        bookNowButton.addEventListener('click', async (e) => {
            e.preventDefault();
            const formData = new FormData(document.getElementById('reservation-form'));
            
            try {
                const response = await fetch('{{ route('customer.reservations.store') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (response.ok) {
                    reservationId = result.reservation_id;
                    paymentModal.classList.remove('hidden');
                    startTimer(result.created_at || new Date());
                } else {
                    // Handle validation errors from backend
                    let msg = result.message || 'Something went wrong.';
                    if(result.errors) {
                        msg += '\n' + Object.values(result.errors).join('\n');
                    }
                    alert(msg);
                }
            } catch (error) {
                console.error(error);
                alert("An unexpected error occurred.");
            }
        });

        function startTimer(creationTime) {
            const endTime = new Date(creationTime).getTime() + 10 * 60 * 1000;

            timerInterval = setInterval(() => {
                const now = new Date().getTime();
                const distance = endTime - now;

                if (distance < 0) {
                    clearInterval(timerInterval);
                    countdownTimer.textContent = "EXPIRED";
                    // Call backend to cancel
                    fetch(`/reservations/${reservationId}/cancel`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    });
                    alert("Reservation expired.");
                    location.reload();
                    return;
                }

                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                countdownTimer.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            }, 1000);
        }

        // --- 6. Payment Method Handling ---
        paymentTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const method = this.dataset.paymentMethod;
                
                // UI Toggle
                paymentTabs.forEach(t => t.classList.remove('border-indigo-500', 'text-indigo-600'));
                this.classList.add('border-indigo-500', 'text-indigo-600');
                
                paymentInfos.forEach(info => {
                    info.classList.toggle('hidden', info.dataset.paymentMethod !== method);
                });

                // Update hidden input
                selectedPaymentMethodInput.value = method;
            });
        });

        confirmPaymentBtn.addEventListener('click', async function() {
            if (!reservationId) return;

            const paymentData = new FormData();
            paymentData.append('payment_method', selectedPaymentMethodInput.value);
            
            try {
                const url = '{{ route("payment.process", ["reservation" => ":id"]) }}'.replace(':id', reservationId);
                const response = await fetch(url, {
                    method: 'POST',
                    body: paymentData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (response.ok) {
                    clearInterval(timerInterval);
                    paymentModal.classList.add('hidden');
                    alert(result.message || 'Payment Confirmed!');
                    
                    const receiptUrl = '{{ route("reservations.receipt", ["reservation" => ":id"]) }}'.replace(':id', reservationId);
                    window.open(receiptUrl, '_blank');
                    window.location.href = '{{ route("customer.reservations.index") }}';
                } else {
                    alert(result.message || 'Payment failed.');
                }
            } catch (error) {
                console.error(error);
                alert("Payment processing error.");
            }
        });

        cancelPaymentBtn.addEventListener('click', function() {
            clearInterval(timerInterval);
            paymentModal.classList.add('hidden');
        });

        // --- 7. Event Listeners for Real-Time Updates ---
        roomSelect.addEventListener('change', calculateTotalPrice);
        cottageSelect.addEventListener('change', calculateTotalPrice);
        numberOfAdultsInput.addEventListener('input', calculateTotalPrice);
        numberOfKidsInput.addEventListener('input', calculateTotalPrice);
        loyaltyPointsToUse.addEventListener('input', calculateTotalPrice);

        // Initialize default tab and calculations
        if (paymentTabs.length > 0) paymentTabs[0].click();
        calculateTotalPrice();
    });
</script>
@endpush 