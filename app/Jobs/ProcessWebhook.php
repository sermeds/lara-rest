<?php

namespace App\Jobs;

use App\Models\Payment;
use App\Models\Reservation;
use App\Traits\ReservationKeyGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class ProcessWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, ReservationKeyGenerator;

    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        try {
            DB::transaction(function () {
                $payment = Payment::find($this->data['id']);
                $reservation = $payment->reservation;

                if ($this->data['status'] === 'success') {
                    $payment->update(['payment_status' => Payment::STATUS_SUCCESSFUL]);
                    $reservation->update(['status' => Reservation::STATUS_SUCCESSFUL]);
                    $this->removeRedisKey($reservation);
                } else {
                    $payment->update(['payment_status' => Payment::STATUS_CANCELLED]);
                    $reservation->update(['status' => Reservation::STATUS_CANCELLED]);
                }
                Log::info("Webhook processed: Payment ID {$this->data['id']}, Status: {$this->data['status']}");
            }, 3);
        } catch (\Exception $e) {
            // Если транзакция не удалась, явно переводим бронь в "отменено"
            $payment = Payment::find($this->data['id']);
            $payment->update(['payment_status' => Payment::STATUS_CANCELLED]);
            $payment->reservation->update(['status' => Reservation::STATUS_CANCELLED]);
            Log::error("Ошибка обработки вебхука: " . $e->getMessage());
        }

    }

    private function removeRedisKey(Reservation $reservation)
    {
        $key = $reservation->table_id
            ? $this->generateTableKey($reservation->table_id, $reservation->reservation_date, $reservation->start_time, $reservation->end_time)
            : $this->generateHallKey($reservation->hall_id, $reservation->reservation_date, $reservation->start_time, $reservation->end_time);

        Redis::del($key);
    }
}

