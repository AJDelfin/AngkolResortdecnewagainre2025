@extends('layouts.admin')

@section('header', 'Admin Dashboard')

@push('styles')
<style>
    .kpi-card {
        background-color: #ffffff;
        border-radius: 0.75rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        padding: 1.5rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .kpi-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    .kpi-title {
        color: #4A5568;
        font-size: 0.875rem;
        font-weight: 500;
    }
    .kpi-value {
        font-size: 2.25rem;
        font-weight: 700;
        color: #1a202c;
    }
    .chart-card {
        background-color: #ffffff;
        border-radius: 0.75rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        padding: 1.5rem;
    }
</style>
@endpush

@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="kpi-card">
            <h2 class="kpi-title">Total Customers</h2>
            <p class="kpi-value text-blue-600">{{ $totalCustomers }}</p>
        </div>
        <div class_="kpi-card">
            <h2 class="kpi-title">Total Staff</h2>
            <p class="kpi-value text-green-600">{{ $totalStaff }}</p>
        </div>
        <div class="kpi-card">
            <h2 class="kpi-title">Total Reservations</h2>
            <p class="kpi-value text-yellow-600">{{ $totalReservations }}</p>
        </div>
        <div class="kpi-card">
            <h2 class="kpi-title">Total Revenue</h2>
            <p class="kpi-value text-red-600">₱{{ number_format($totalRevenue, 2) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="chart-card">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Monthly Reservations</h3>
            <canvas id="reservationsChart"></canvas>
        </div>
        <div class="chart-card">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">New Customers per Month</h3>
            <canvas id="customersChart"></canvas>
        </div>
    </div>

    @php
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        
        $reservationCounts = array_fill(0, 12, 0);
        foreach ($reservationsByMonth as $record) {
            $reservationCounts[$record->month - 1] = $record->count;
        }

        $customerCounts = array_fill(0, 12, 0);
        foreach ($customersByMonth as $record) {
            $customerCounts[$record->month - 1] = $record->count;
        }
    @endphp

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const monthLabels = @json($monthNames);

            // Reservations Chart
            const reservationsCtx = document.getElementById('reservationsChart').getContext('2d');
            new Chart(reservationsCtx, {
                type: 'bar',
                data: {
                    labels: monthLabels,
                    datasets: [{
                        label: 'Reservations',
                        data: @json($reservationCounts),
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1,
                        borderRadius: 5,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(200, 200, 200, 0.2)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            // Customers Chart
            const customersCtx = document.getElementById('customersChart').getContext('2d');
            new Chart(customersCtx, {
                type: 'line',
                data: {
                    labels: monthLabels,
                    datasets: [{
                        label: 'New Customers',
                        data: @json($customerCounts),
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderColor: 'rgba(16, 185, 129, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                             grid: {
                                color: 'rgba(200, 200, 200, 0.2)'
                            }
                        },
                        x: {
                             grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
@endsection
