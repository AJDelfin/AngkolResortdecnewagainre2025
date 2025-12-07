<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Staff Dashboard - Angkol Resort Hub</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lato:wght@400;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#15803d',
                        cream: '#fdfbf6',
                        dark: '#1a1a1a',
                    },
                    fontFamily: {
                        headline: ["Playfair Display", "serif"],
                        sans: ["Lato", "sans-serif"],
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased bg-cream text-gray-800">

    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside class="w-64 bg-dark text-white p-6 flex flex-col justify-between">
            <div>
                <div class="font-headline text-2xl font-bold tracking-wide mb-10">
                    <a href="/">Angkol Resort Hub</a>
                </div>
                <nav class="space-y-2">
                    <!-- Main -->
                    <h3 class="text-xs uppercase text-gray-400 tracking-wider">Main</h3>
                    <a href="{{ route('staff.dashboard') }}" class="flex items-center space-x-2 py-2 px-4 rounded-md hover:bg-primary/20 transition text-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span>Dashboard</span>
                    </a>

                    <!-- Management -->
                    <h3 class="text-xs uppercase text-gray-400 tracking-wider mt-4">Management</h3>
                    <a href="#" class="flex items-center space-x-2 py-2 px-4 rounded-md hover:bg-primary/20 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>Reservations</span>
                    </a>

                    <!-- Operations -->
                    <h3 class="text-xs uppercase text-gray-400 tracking-wider mt-4">Operations</h3>
                    <a href="#" class="flex items-center space-x-2 py-2 px-4 rounded-md hover:bg-primary/20 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25H7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                        <span>Guest Check-in</span>
                    </a>
                     <a href="#" class="flex items-center space-x-2 py-2 px-4 rounded-md hover:bg-primary/20 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                        <span>Guest Check-out</span>
                    </a>
                </nav>
            </div>

            <!-- Logout Button -->
            <div class="mt-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-2 py-2 px-4 rounded-md bg-red-600 hover:bg-red-700 transition text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3h12"></path></svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col">
            <!-- Top Navbar -->
            <header class="bg-white shadow-md p-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-dark">@yield('header', 'Dashboard')</h1>
                <div>
                    <span class="text-sm">Welcome, {{ Auth::user()->name }} ({{ Auth::user()->role }})</span>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-6 overflow-y-auto">
                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>
