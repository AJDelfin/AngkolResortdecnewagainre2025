<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        Log::info('Showing admin login form.');
        return view('auth.admin_login');
    }

    public function login(Request $request)
    {
        Log::info('Admin login attempt started.', ['email' => $request->email]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            Log::info('Authentication successful for user.', ['user_id' => $user->id, 'email' => $user->email]);

            if (in_array($user->role, ['admin', 'staff'])) {
                Log::info('User has valid role, redirecting to dashboard.', ['role' => $user->role]);
                return redirect()->intended('/' . $user->role . '/dashboard');
            }

            Log::warning('User does not have the required role.', ['user_id' => $user->id, 'role' => $user->role]);
            Auth::logout();
            return redirect()->back()->withErrors(['email' => 'You do not have the required role to access this page.']);
        }

        Log::warning('Invalid credentials for admin/staff login.', ['email' => $request->email]);
        return redirect()->back()->withErrors(['email' => 'Invalid credentials.']);
    }
}
