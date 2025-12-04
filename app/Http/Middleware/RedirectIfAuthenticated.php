<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $role = Auth::user()->role;

                switch ($role) {
                    case 'admin':
                        return redirect()->route('admin.dashboard');
                        break;
                    case 'staff':
                        return redirect()->route('staff.dashboard');
                        break;
                    case 'customer':
                        return redirect()->route('customer.dashboard');
                        break;
                    default:
                        return redirect('/');
                        break;
                }
            }
        }

        return $next($request);
    }
}
