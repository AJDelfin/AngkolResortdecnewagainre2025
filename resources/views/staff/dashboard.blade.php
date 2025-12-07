@extends('layouts.admin')

@section('header', 'Staff Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-gray-600 text-sm">Total Customers</h2>
            <p class="text-3xl font-bold text-primary">1,234</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-gray-600 text-sm">Total Staff</h2>
            <p class="text-3xl font-bold text-primary">56</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-gray-600 text-sm">Reservations Today</h2>
            <p class="text-3xl font-bold text-primary">78</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-gray-600 text-sm">Total Revenue</h2>
            <p class="text-3xl font-bold text-primary">$12,345</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <canvas id="reservationsChart"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('reservationsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: 'Reservations',
                    data: [65, 59, 80, 81, 56, 55, 40],
                    backgroundColor: 'rgba(21, 128, 61, 0.2)',
                    borderColor: 'rgba(21, 128, 61, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
