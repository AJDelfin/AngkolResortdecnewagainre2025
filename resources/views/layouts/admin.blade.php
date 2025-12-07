<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - Angkol Resort Hub</title>

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

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="font-sans antialiased bg-cream text-gray-800">

    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside class="w-64 bg-dark text-white p-6 flex flex-col justify-between">
            <div>
                <div class="font-headline text-2xl font-bold tracking-wide mb-10">
                    <h1 class="text-2xl font-bold text-white">Admin: Angkol Resort Hub</h1>
                </div>
                <nav class="space-y-2">
                    <!-- Main -->
                    <h3 class="text-xs uppercase text-gray-400 tracking-wider">Main</h3>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 py-2 px-4 rounded-md hover:bg-primary/20 transition text-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span>Dashboard</span>
                    </a>

                    <!-- Management -->
                    <h3 class="text-xs uppercase text-gray-400 tracking-wider mt-4">Management</h3>
                    <a href="{{ route('admin.guests.index') }}" class="flex items-center space-x-2 py-2 px-4 rounded-md hover:bg-primary/20 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 016-6h6a6 6 0 016 6v1h-3"></path></svg>
                        <span>Guests</span>
                    </a>
                    <a href="{{ route('admin.employees.index') }}" class="flex items-center space-x-2 py-2 px-4 rounded-md hover:bg-primary/20 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span>Employees</span>
                    </a>
                    <a href="{{ route('admin.rooms.index') }}" class="flex items-center space-x-2 py-2 px-4 rounded-md hover:bg-primary/20 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                        <span>Rooms</span>
                    </a>
                    <a href="{{ route('admin.cottages.index') }}" class="flex items-center space-x-2 py-2 px-4 rounded-md hover:bg-primary/20 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h7.5" /></svg>
                        <span>Cottages</span>
                    </a>
                     <a href="{{ route('admin.food-packages.index') }}" class="flex items-center space-x-2 py-2 px-4 rounded-md hover:bg-primary/20 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" /></svg>
                        <span>Food Packages</span>
                    </a>
                    <a href="{{ route('admin.services.index') }}" class="flex items-center space-x-2 py-2 px-4 rounded-md hover:bg-primary/20 transition">
                       <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c.51 0 .962-.343 1.087-.835l.383-1.437M7.5 14.25L5.106 5.165A2.25 2.25 0 0 0 2.868 3H2.25m5.25 11.25h11.218c.51 0 .962-.343 1.087-.835l.383-1.437M7.5 14.25L5.106 5.165A2.25 2.25 0 0 0 2.868 3H2.25m15.75 3-3.866-1.546a.75.75 0 0 0-.81.63L14.25 6H12m6.75 4.5h-1.5a.75.75 0 0 0-.75.75v3.75a.75.75 0 0 0 .75.75h1.5a.75.75 0 0 0 .75-.75V11.25a.75.75 0 0 0-.75-.75Z" /></svg>
                        <span>Services</span>
                    </a>
                    <a href="{{ route('admin.reservations.index') }}" class="flex items-center space-x-2 py-2 px-4 rounded-md hover:bg-primary/20 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>Reservations</span>
                    </a>

                    <!-- Financials -->
                    <h3 class="text-xs uppercase text-gray-400 tracking-wider mt-4">Financials</h3>
                    <a href="{{ route('admin.billing.index') }}" class="flex items-center space-x-2 py-2 px-4 rounded-md hover:bg-primary/20 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h6m3-3.75l-3 3m0 0l-3-3m3 3V1.5m6 5.25h6m-6 2.25h6m3-3.75l-3 3m0 0l-3-3m3 3V1.5" /></svg>
                        <span>Billing & Invoices</span>
                    </a>
                    <a href="{{ route('admin.financial-reports.index') }}" class="flex items-center space-x-2 py-2 px-4 rounded-md hover:bg-primary/20 transition">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125-1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" /></svg>
                        <span>Financial Reports</span>
                    </a>

                    <!-- Content -->
                    <h3 class="text-xs uppercase text-gray-400 tracking-wider mt-4">Content</h3>
                    <a href="{{ route('admin.posts.index') }}" class="flex items-center space-x-2 py-2 px-4 rounded-md hover:bg-primary/20 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 18V7.125c0-.621.504-1.125 1.125-1.125H9.75" /></svg>
                        <span>News & Announcements</span>
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
                <div class="flex items-center bg-gray-200 px-4 py-2 rounded-full">
                    <svg class="w-6 h-6 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span class="text-sm font-medium text-gray-700">
                        Welcome, {{ Auth::user()->name }}
                    </span>
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
