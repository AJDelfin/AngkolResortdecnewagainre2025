<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PruneExpiredReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:prune-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prune unpaid reservations that have expired';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expirationTime = Carbon::now()->subMinutes(10);

        $expiredReservations = Reservation::where('status', 'pending')
            ->where('created_at', '<', $expirationTime)
            ->get();

        if ($expiredReservations->isEmpty()) {
            $this->info('No expired reservations to prune.');
            return;
        }

        $count = $expiredReservations->count();

        foreach ($expiredReservations as $reservation) {
            $reservation->delete();
        }

        $this->info("Successfully pruned {$count} expired reservations.");
    }
}
