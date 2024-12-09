<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Payment;
use App\Services\PaymentService;
use App\Traits\ReservationKeyGenerator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class ReservationService
{
    use ReservationKeyGenerator;

    public function all()
    {
        return Reservation::all();
    }

    public function findOrFail($id)
    {
        return Reservation::findOrFail($id);
    }

    public function createReservation(array $data)
    {
        // Генерация ключа для Redis
        $key = $data['table_id']
            ? $this->generateTableKey($data['table_id'], $data['reservation_date'], $data['start_time'], $data['end_time'])
            : $this->generateHallKey($data['hall_id'], $data['reservation_date'], $data['start_time'], $data['end_time']);

        print("key1 " . $key . "\n");

        // Проверяем наличие блокировки
        if (Redis::exists($key)) {
            return response()->json(['message' => 'Место или зал временно недоступны.'], 409, [], JSON_UNESCAPED_UNICODE);
        }

        try {
            // Устанавливаем блокировку
            $this->blockPlace($key, $data['user_id'], $data['start_time'], $data['end_time']);

            // Создаем бронирование со статусом `pending`
            $data['status'] = Reservation::STATUS_PENDING;

            return Reservation::create($data);
        } catch (\Exception $e) {
            // Удаляем блокировку в случае ошибки
            Redis::del($key);

            // Логируем ошибку
            Log::error('Ошибка создания бронирования', [
                'error' => $e->getMessage(),
                'data' => $data,
            ]);

            return response()->json(['message' => 'Ошибка создания бронирования.'], 500);
        }
    }

    public function updateReservation($id, array $data)
    {
        $reservation = $this->findOrFail($id);
        return $reservation->update($data);
    }

    public function deleteReservation($id)
    {
        $reservation = $this->findOrFail($id);
        return $reservation->delete();
    }

    /**
     * Установка временной блокировки.
     */
    private function blockPlace($key, $userId, $startTime, $endTime): void
    {
        $data = [
            'user_id' => $userId,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ];

        Redis::set($key, json_encode($data), 'EX', 1200); // Блокировка на 20 минут
        print(Redis::get($key) . "\n");
        print(Redis::exists($key) . "\n");
    }
}
