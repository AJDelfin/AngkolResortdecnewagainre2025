<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch data for the graphs
        $totalCustomers = User::where('role', 'customer')->count() ?? 0;
        $totalStaff = User::where('role', 'staff')->count() ?? 0;
        $totalReservations = Reservation::count() ?? 0;
        $totalRevenue = Reservation::sum('total_price') ?? 0;

        // Fetch data for the charts
        $reservationsByMonth = Reservation::select(
            DB::raw("strftime('%m', created_at) as month"),
            DB::raw('COUNT(*) as count')
        )
        ->groupBy('month')
        ->get();

        $customersByMonth = User::where('role', 'customer')->select(
            DB::raw("strftime('%m', created_at) as month"),
            DB::raw('COUNT(*) as count')
        )
        ->groupBy('month')
        ->get();

        return view('admin.dashboard', compact('totalCustomers', 'totalStaff', 'totalReservations', 'totalRevenue', 'reservationsByMonth', 'customersByMonth'));
    }
}
