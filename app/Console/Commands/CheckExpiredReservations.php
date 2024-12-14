<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use App\Models\Reservation;
use App\Traits\ReservationKeyGenerator;
use Illuminate\Support\Facades\Log;

class CheckExpiredReservations extends Command
{
    use ReservationKeyGenerator;

    protected $signature = 'reservations:check-expired';

    protected $description = 'Check for expired reservations in Redis and update their status to cancelled if necessary.';

    public function handle()
    {
        $this->info('Checking for expired reservations...');

        // Получить все бронирования со статусом "pending"
        $pendingReservations = Reservation::where('status', Reservation::STATUS_PENDING)->get();

        foreach ($pendingReservations as $reservation) {
            $key = $reservation->table_id
                ? $this->generateTableKey($reservation->table_id, $reservation->reservation_date, $reservation->start_time, $reservation->end_time)
                : $this->generateHallKey($reservation->hall_id, $reservation->reservation_date, $reservation->start_time, $reservation->end_time);

            // Проверяем существование ключа в Redis
            if (!Redis::exists($key)) {
                // Если ключа нет, обновляем статус брони
                $reservation->update(['status' => Reservation::STATUS_CANCELLED]);
                $this->info("Reservation ID {$reservation->id} was cancelled due to expiration.");
                Log::info("Reservation ID {$reservation->id} status updated to cancelled.");
            }
        }

        $this->info('Expired reservations check completed.');
        return 0;
    }
}
