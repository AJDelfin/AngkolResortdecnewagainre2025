<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // === KPI Cards ===
        $totalCustomers = User::where('role', 'guest')->count();
        $totalStaff = User::whereIn('role', ['staff', 'admin'])->count();

        $sevenDaysAgo = Carbon::now()->subDays(6)->startOfDay();

        // Calculate total reservations for the week
        $totalWeeklyReservations = Reservation::where('created_at', '>=', $sevenDaysAgo)->count();

        // Calculate total revenue for the week
        $totalWeeklyRevenue = Reservation::where('reservations.created_at', '>=', $sevenDaysAgo)
            ->join('rooms', 'reservations.room_id', '=', 'rooms.id') // Assuming revenue comes from rooms for now
            ->sum('rooms.price');


        // === Charts Data ===

        // 1. Customer/User Distribution Chart (Doughnut)
        $userDistributionData = User::select('role', DB::raw('count(*) as count'))
                                    ->whereIn('role', ['guest', 'staff', 'admin'])
                                    ->groupBy('role')
                                    ->get();
        $userDistributionChart = [
            'labels' => $userDistributionData->pluck('role')->map(fn($role) => ucfirst($role)),
            'data' => $userDistributionData->pluck('count'),
        ];


        // 2. Staff Roles Chart (Pie)
        $staffRolesData = User::select('role', DB::raw('count(*) as count'))
                              ->whereIn('role', ['staff', 'admin'])
                              ->groupBy('role')
                              ->get();
        $staffRolesChart = [
            'labels' => $staffRolesData->pluck('role')->map(fn($role) => ucfirst($role)),
            'data' => $staffRolesData->pluck('count'),
        ];


        // 3. Weekly Reservations Chart (Line)
        $reservations = Reservation::where('created_at', '>=', $sevenDaysAgo)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()->keyBy('date');

        $reservationDates = [];
        $reservationCounts = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $reservationDates[] = Carbon::parse($date)->format('D');
            $reservationCounts[] = $reservations->has($date) ? $reservations->get($date)->count : 0;
        }
        $reservationsChart = ['labels' => $reservationDates, 'data' => $reservationCounts];


        // 4. Weekly Revenue Chart (Bar)
        $revenue = Reservation::where('reservations.created_at', '>=', $sevenDaysAgo)
            ->join('rooms', 'reservations.room_id', '=', 'rooms.id')
            ->select(DB::raw('DATE(reservations.created_at) as date'), DB::raw('sum(rooms.price) as total'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()->keyBy('date');

        $revenueDates = [];
        $revenueTotals = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $revenueDates[] = Carbon::parse($date)->format('D');
            $revenueTotals[] = $revenue->has($date) ? $revenue->get($date)->total : 0;
        }
        $revenueChart = ['labels' => $revenueDates, 'data' => $revenueTotals];

        return view('admin.dashboard', [
            // KPIs
            'totalCustomers' => $totalCustomers,
            'totalStaff' => $totalStaff,
            'totalWeeklyReservations' => $totalWeeklyReservations,
            'totalWeeklyRevenue' => $totalWeeklyRevenue,

            // Charts
            'userDistributionChart' => $userDistributionChart,
            'staffRolesChart' => $staffRolesChart,
            'reservationsChart' => $reservationsChart,
            'revenueChart' => $revenueChart,
        ]);
    }
}
