<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Room;
use App\Models\Cottage;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guests = User::where('role', 'guest')->get();
        $rooms = Room::all();
        $cottages = Cottage::all();

        if ($guests->isEmpty() || ($rooms->isEmpty() && $cottages->isEmpty())) {
            $this->command->info('Guests, rooms, or cottages not found. Please run the relevant seeders first.');
            return;
        }

        foreach ($guests as $guest) {
            for ($i = 0; $i < rand(1, 5); $i++) { 
                $checkIn = Carbon::now()->subDays(rand(1, 365));
                $checkOut = $checkIn->copy()->addDays(rand(1, 14));
                $numberOfGuests = rand(1, 5);

                $reservationDetails = [
                    'user_id' => $guest->id,
                    'check_in_date' => $checkIn,
                    'check_out_date' => $checkOut,
                    'number_of_guests' => $numberOfGuests,
                    'status' => Arr::random(['pending', 'confirmed', 'cancelled']),
                    'created_at' => $checkIn->copy()->subDays(rand(1, 30)),
                    'updated_at' => $checkIn->copy()->subDays(rand(1, 30)),
                ];

                if (rand(0, 1) && $rooms->isNotEmpty()) { // 50% chance of booking a room
                    $room = $rooms->random();
                    $reservationDetails['room_id'] = $room->id;
                    $reservationDetails['total_price'] = $room->price * $checkIn->diffInDays($checkOut);
                } elseif ($cottages->isNotEmpty()) { // Otherwise, book a cottage
                    $cottage = $cottages->random();
                    $reservationDetails['cottage_id'] = $cottage->id;
                    $reservationDetails['total_price'] = $cottage->price * $checkIn->diffInDays($checkOut);
                } else { // If neither rooms nor cottages are available
                    continue;
                }

                Reservation::create($reservationDetails);
            }
        }
    }
}