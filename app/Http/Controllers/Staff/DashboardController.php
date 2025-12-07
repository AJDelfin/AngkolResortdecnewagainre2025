<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalGuests = User::role('customer')->count();
        $activeReservations = Reservation::where('status', 'confirmed')->count();
        $posts = Post::count();

        $reservationsByMonth = Reservation::select(
            DB::raw("strftime('%m', created_at) as month"),
            DB::raw('COUNT(*) as count')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $guestsByMonth = User::role('customer')->select(
            DB::raw("strftime('%m', created_at) as month"),
            DB::raw('COUNT(*) as count')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        return view('staff.dashboard', compact('totalGuests', 'activeReservations', 'posts', 'reservationsByMonth', 'guestsByMonth'));
    }
}
