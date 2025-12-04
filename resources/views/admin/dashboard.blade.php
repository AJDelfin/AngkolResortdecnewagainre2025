<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <p>Welcome, {{ Auth::user()->name }}</p>

    <h2>Manage Customers</h2>
    <a href="{{ route('admin.customers.index') }}">View Customers</a>

    <h2>Manage Staff</h2>
    <a href="{{ route('admin.staff.index') }}">View Staff</a>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
