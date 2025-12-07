<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Angkol Resort Hub</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lato:wght@400;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (Using CDN for immediate styling without build steps) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#15803d', // Green shade for buttons/icons
                        cream: '#fdfbf6',   // Background color
                        dark: '#1a1a1a',
                    },
                    fontFamily: {
                        headline: ['"Playfair Display"', 'serif'],
                        sans: ['"Lato"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <style>
        /* Custom scrollbar for a polished look */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        ::-webkit-scrollbar-thumb {
            background: #888; 
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555; 
        }
        .animate-fade-in-down {
            animation: fadeInDown 1s ease-out;
        }
        .animate-fade-in-up {
            animation: fadeInUp 1s ease-out;
        }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="font-sans antialiased bg-cream text-gray-800">

    <!-- Navigation / Auth Links -->
    <nav class="absolute top-0 w-full z-50 p-6 flex justify-between items-center text-white bg-gradient-to-b from-black/70 to-transparent">
        <div class="font-headline text-2xl font-bold tracking-wide">
            <a href="/">Angkol Resort Hub</a>
        </div>
        
        <div class="space-x-4 text-sm font-semibold flex items-center">
            @auth
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); this.closest('form').submit();" 
                       class="px-4 py-2 rounded-md hover:text-primary transition">
                       Logout
                    </a>
                </form>
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 rounded-md hover:bg-white hover:text-primary transition">Customer Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-green-800 transition">Sign Up</a>
                @endif
                <a href="{{ route('admin.login') }}" class="px-4 py-2 rounded-md hover:bg-white hover:text-primary transition">Admin/Staff Log in</a>
            @endauth
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative h-[80vh] w-full overflow-hidden flex items-center justify-center text-center bg-cover bg-center" style="background-image: url('{{ asset('images/image4.jpg') }}');">
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative z-10 p-4 text-white">
            <h1 class="text-5xl md:text-7xl font-headline font-bold drop-shadow-lg animate-fade-in-down">
                Escape to Angkol Resort Hub
            </h1>
            <p class="mt-4 text-lg md:text-xl max-w-2xl drop-shadow-md animate-fade-in-up text-gray-200">
                Discover a haven of peace and serenity. Book your perfect getaway today.
            </p>
            <div class="mt-8">
                <a href="{{ route('register') }}" class="bg-primary text-white font-bold py-3 px-8 rounded-lg hover:bg-green-700 transition duration-300 shadow-lg animate-fade-in-up">
                    Book Now
                </a>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column: Information -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- About Card -->
                <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100 transition hover:shadow-xl">
                    <h2 class="font-headline text-3xl font-bold text-gray-900 mb-4">About Our Resort</h2>
                    <div class="space-y-4 text-gray-600 leading-relaxed">
                        <p>
                            Nestled in the heart of a lush, verdant landscape, Angkol Resort Hub offers a tranquil retreat from the hustle and bustle of city life. Our resort is designed to blend seamlessly with its natural surroundings, providing a unique experience where luxury meets nature.
                        </p>
                        <p>
                            Whether you're looking for a fun day trip, an overnight stay under the stars, or a cozy room to unwind, we have something for everyone. Our commitment is to provide exceptional service and unforgettable memories. We are open Monday to Sunday, from 9am to 7pm.
                        </p>
                    </div>
                </div>

                <!-- Accommodations Card -->
                <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100 transition hover:shadow-xl">
                    <h2 class="font-headline text-3xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <!-- Users Icon SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-primary">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                        Our Accommodations
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Day Tour -->
                        <div class="space-y-3">
                            <div class="h-48 w-full overflow-hidden rounded-lg">
                                <img src="{{ asset('images/image2.jpg') }}" alt="Day Tour Pool" class="w-full h-full object-cover transition duration-300 hover:scale-105">
                            </div>
                            <h3 class="font-headline text-xl font-bold">Day Tour</h3>
                            <p class="text-sm text-gray-600">Adults: ₱100, Kids: ₱50. Enjoy full access to our pools and facilities.</p>
                        </div>
                        
                        <!-- Overnight Camping -->
                        <div class="space-y-3">
                            <div class="h-48 w-full overflow-hidden rounded-lg">
                                <img src="{{ asset('images/image3.jpg') }}" alt="Camping" class="w-full h-full object-cover transition duration-300 hover:scale-105">
                            </div>
                            <h3 class="font-headline text-xl font-bold">Overnight Camping</h3>
                            <p class="text-sm text-gray-600">Adults: ₱150, Kids: ₱60. Experience the magic of nature. Tent corkage: ₱100.</p>
                        </div>

                        <!-- Rooms & Huts -->
                        <div class="space-y-3 md:col-span-2">
                            <div class="h-64 w-full overflow-hidden rounded-lg">
                                <img src="{{ asset('images/image5.jpg') }}" alt="Rooms and Huts" class="w-full h-full object-cover transition duration-300 hover:scale-105">
                            </div>
                            <h3 class="font-headline text-xl font-bold">Rooms & Huts</h3>
                            <p class="text-sm text-gray-600">Stay in comfort in our well-appointed rooms and traditional huts. Check-in at 2pm, check-out at 12 noon.</p>
                        </div>
                    </div>
                </div>

                <!-- Policies Card -->
                <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100 transition hover:shadow-xl">
                    <h2 class="font-headline text-3xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <!-- Shield Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-primary">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                        </svg>
                        Resort Rules & Policies
                    </h2>
                    <ul class="list-disc list-inside space-y-2 text-gray-700">
                        <li>Walk-ins are accepted for Day Tours only (first come, first serve). Overnight stays must be booked in advance.</li>
                        <li>A 50% downpayment via Gcash is required for reservations.</li>
                        <li>Cancellation must be made at least 3 days before the scheduled reservation.</li>
                        <li>NO SHOW deposit is non-refundable.</li>
                        <li>Proper swimming attire is required for pool use.</li>
                        <li>NO PETS ALLOWED.</li>
                        <li>Discounts (20%) available for Senior Citizens and PWDs upon presentation of a valid ID.</li>
                        <li>Children 2 years old and below are free of charge.</li>
                    </ul>
                </div>

                <!-- Contact Card -->
                <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100 transition hover:shadow-xl">
                    <h2 class="font-headline text-3xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <!-- Sun/Contact Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-primary">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                        </svg>
                        Contact Us
                    </h2>
                    <div class="space-y-4 text-gray-700">
                        <div class="flex items-center gap-4">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>PRK 12B Tinagacan, General Santos City</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>contact@angkolresorthub.com</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span>09068134814 / 09352159941 / 09056256854</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Booking Form -->
            <div class="lg:col-span-1">
                <div class="sticky top-6 bg-[#f7f5ef] border border-gray-200 rounded-xl shadow-xl p-6">
                    <h2 class="font-headline text-3xl font-bold text-center text-gray-900 mb-6">Book Your Stay</h2>
                    
                    <!-- NOTE: Connect this form to your backend route -->
                    <form action="#" method="POST" class="space-y-4">
                        @csrf 
                        
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" name="name" placeholder="Juan dela Cruz" class="w-full bg-gray-100 border-none rounded-md px-4 py-2 text-sm focus:ring-2 focus:ring-primary focus:bg-white transition">
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" placeholder="you@example.com" class="w-full bg-gray-100 border-none rounded-md px-4 py-2 text-sm focus:ring-2 focus:ring-primary focus:bg-white transition">
                        </div>

                        <!-- Booking Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Booking Type</label>
                            <select name="type" class="w-full bg-gray-100 border-none rounded-md px-4 py-2 text-sm focus:ring-2 focus:ring-primary focus:bg-white transition cursor-pointer">
                                <option value="" disabled selected>Select a booking type</option>
                                <option value="day_tour">Day Tour</option>
                                <option value="overnight">Overnight Camping</option>
                                <option value="room">Room / Hut</option>
                            </select>
                        </div>

                        <!-- Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                            <div class="relative">
                                <input type="date" name="date" class="w-full bg-gray-100 border-none rounded-md px-4 py-2 text-sm focus:ring-2 focus:ring-primary focus:bg-white transition">
                            </div>
                        </div>

                        <!-- Discount Toggle (Visual Only) -->
                        <div class="border border-green-200 bg-green-50 rounded-lg p-3 flex items-start gap-3 mt-4">
                            <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" name="discount" id="toggle" class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 appearance-none cursor-pointer border-gray-300 checked:right-0 checked:border-primary"/>
                                <label for="toggle" class="toggle-label block overflow-hidden h-5 rounded-full bg-gray-300 cursor-pointer"></label>
                            </div>
                            <div class="text-xs text-gray-600">
                                <span class="font-bold text-gray-800">Avail PWD/Senior Citizen Discount (20%)</span>
                                <br>No valid ID, no discount.
                            </div>
                        </div>
                        <style>
                            .toggle-checkbox:checked { right: 0; border-color: #15803d; }
                            .toggle-checkbox:checked + .toggle-label { background-color: #15803d; }
                        </style>

                        <!-- Total Price Placeholder -->
                        <div class="pt-4 pb-2">
                            <p class="text-sm font-semibold text-gray-700">Total Price</p>
                            <p class="text-3xl font-bold text-primary">₱0.00</p>
                        </div>

                        <!-- Submit Button -->
                        <button type="button" class="w-full bg-primary text-white font-bold py-3 rounded-lg hover:bg-green-700 transition duration-300 shadow-lg">
                            Book Now
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <footer class="bg-gray-100 border-t border-gray-200 mt-12 py-8">
        <div class="container mx-auto px-4 text-center text-gray-500 text-sm">
            &copy; 2025 Angkol Resort Hub. All Rights Reserved.
        </div>
    </footer>

</body>
</html>
