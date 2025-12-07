<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function processPayment(Request $request, Reservation $reservation)
    {
        $request->validate([
            'payment_method' => 'required|in:gcash,maya,credit_card',
            'payment_status' => 'required|in:success,failure',
        ]);

        $user = Auth::user();

        $paymentSuccessful = $request->input('payment_status') === 'success';

        if ($paymentSuccessful) {
            $downPayment = $reservation->total_price / 2;

            $reservation->update([
                'status' => 'partially_paid',
                'payment_method' => $request->input('payment_method'),
                'down_payment' => $downPayment,
            ]);
            $user->update(['failed_payment_attempts' => 0]);

            // Award loyalty points based on downpayment
            $loyaltyPoints = $user->loyaltyPoints()->firstOrCreate([]);
            $pointsToAdd = floor($downPayment / 100); // 1 point for every 100 pesos
            $loyaltyPoints->points += $pointsToAdd;
            $loyaltyPoints->save();

            return response()->json(['message' => 'Payment successful! Your reservation is partially paid. You can now download your receipt.']);
        } else {
            $user->increment('failed_payment_attempts');

            if ($user->failed_payment_attempts >= 3) {
                $user->update(['is_blocked' => true]);
                Auth::logout();
                return response()->json(['message' => 'Your account has been blocked due to multiple failed payment attempts. Please contact support.'], 403);
            }

            return response()->json(['message' => 'Payment failed. Please try again.'], 422);
        }
    }
}
