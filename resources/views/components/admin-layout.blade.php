<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex bg-gray-100">
        <!-- Sidebar -->
        <aside class="w-64 bg-primary text-white p-6">
            <a href="{{ route('admin.dashboard') }}">
                <h1 class="text-2xl font-bold mb-8">Admin Panel</h1>
            </a>
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-green-700 {{ request()->routeIs('admin.dashboard') ? 'bg-green-700' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.customers.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-green-700 {{ request()->routeIs('admin.customers.index') ? 'bg-green-700' : '' }}">
                    Manage Customers
                </a>
                <a href="{{ route('admin.staff.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-green-700 {{ request()->routeIs('admin.staff.index') ? 'bg-green-700' : '' }}">
                    Manage Staff
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1">
            <!-- Top Navbar -->
            <nav class="bg-white border-b border-gray-200 shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <h1 class="text-xl font-bold text-gray-800">Admin: Angkol Resort Hub</h1>
                        </div>
                        <div class="flex items-center">
                            <!-- Logout Button -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-gray-500 hover:text-gray-700 text-sm font-medium">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <div class="p-6">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>
