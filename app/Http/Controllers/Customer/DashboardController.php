<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $loyaltyPoints = $user->loyaltyPoints()->firstOrCreate([]);

        return view('customer.dashboard', compact('loyaltyPoints'));
    }
}
