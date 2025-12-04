<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        Log::info('Showing customer registration form.');
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        Log::info('Customer registration attempt started.');

        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            Log::info('Validation successful for customer registration.');

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'customer',
            ]);

            Log::info('User created successfully.', ['user_id' => $user->id, 'email' => $user->email]);

            event(new Registered($user));

            Auth::login($user);

            Log::info('User logged in and will be redirected.', ['user_id' => $user->id]);

            return redirect()->route('customer.dashboard');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Customer registration validation failed.', [
                'errors' => $e->errors(),
                'request' => $request->all(),
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::critical('An unexpected error occurred during customer registration.', [
                'exception' => $e->getMessage(),
                'request' => $request->all(),
            ]);
            return redirect()->back()->withErrors(['email' => 'An unexpected error occurred. Please try again.']);
        }
    }
}
