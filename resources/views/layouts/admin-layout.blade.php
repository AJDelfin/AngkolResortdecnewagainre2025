<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #15803d;
            --cream-color: #fdfbf6;
            --dark-color: #1a1a1a;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--cream-color);
        }
        .sidebar {
            background-color: var(--dark-color);
            color: var(--cream-color);
        }
        .sidebar a {
            color: var(--cream-color);
        }
        .sidebar a:hover {
            background-color: var(--primary-color);
        }
        .navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e5e7eb;
        }
    </style>
</head>
<body class="flex h-screen">

    <!-- Sidebar -->
    <aside class="w-64 sidebar p-6">
        <div class="text-2xl font-bold mb-10">Admin Panel</div>
        <nav>
            <ul>
                <li class="mb-4"><a href="#" class="block py-2 px-4 rounded">Dashboard</a></li>
                <li class="mb-4"><a href="#" class="block py-2 px-4 rounded">Users</a></li>
                <li class="mb-4"><a href="#" class="block py-2 px-4 rounded">Reservations</a></li>
                <li class="mb-4"><a href="#" class="block py-2 px-4 rounded">Rooms</a></li>
                <li class="mb-4"><a href="#" class="block py-2 px-4 rounded">Settings</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Navbar -->
        <header class="navbar p-4 flex justify-between items-center">
            <div>
                <h1 class="text-xl font-bold">@yield('title', 'Dashboard')</h1>
            </div>
            <div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-gray-600 hover:text-gray-900">Logout</button>
                </form>
            </div>
        </header>

        <!-- Content Area -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

</body>
</html>
