<?php

namespace App\Services;

use App\Exceptions\ReservationConflictException;
use App\Models\Dish;
use App\Models\Reservation;
use App\Models\Payment;
use App\Services\PaymentService;
use App\Traits\ReservationKeyGenerator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class ReservationService
{
    use ReservationKeyGenerator;

    protected $hallService;
    protected $tableService;

    public function __construct(HallService $hallService, TableService $tableService)
    {
        $this->hallService = $hallService;
        $this->tableService = $tableService;
    }

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
        $key = null;

//        try {
        // Генерация ключа для Redis
        $key = $data['table_id'] ?? null
                ? $this->generateTableKey($data['table_id'], $data['reservation_date'], $data['start_time'], $data['end_time'])
                : $this->generateHallKey($data['hall_id'], $data['reservation_date'], $data['start_time'], $data['end_time']);

        // Проверяем наличие блокировки
        if (Redis::exists($key)) {
            return response()->json(['message' => 'Место или зал временно недоступны.'], 409, [], JSON_UNESCAPED_UNICODE);
        }

        $conflictingReservations = $this->getConflictingReservations(
            $data['table_id'] ?? null,
            $data['hall_id'] ?? null,
            $data['reservation_date'],
            $data['start_time'],
            $data['end_time']
        );

        if ($conflictingReservations) {
            $suggestedTime = $this->findNextAvailableTime(
                $data['table_id'] ?? null,
                $data['hall_id'] ?? null,
                $data['reservation_date'],
                $data['end_time']
            );

            throw new ReservationConflictException(
                'Место или зал уже забронированы. Попробуйте изменить время бронирования или выбрать другой столик.',
                ['suggested_time' => $suggestedTime]
            );
        }

        // Устанавливаем блокировку
        $this->blockPlace($key, $data['user_id'] ?? $data['guest_name'], $data['start_time'], $data['end_time']);

        $data['status'] = Reservation::STATUS_PENDING;

        $reservation = Reservation::create($data);

        // Считаем общую стоимость
        $reservation->total_price = $this->calculateTotalPrice($reservation);

        return $reservation;
//        }
//        catch (ReservationConflictException $e) {
//            return response()->json([
//                'message' => $e->getMessage(),
//                'suggested_time' => $e->getData()['suggested_time'] ?? null,
//            ], 409, [], JSON_UNESCAPED_UNICODE);
//
//        }
//        catch (\Exception $e) {
//            // Удаляем блокировку в случае ошибки
//            Redis::del($key);
//
//            // Логируем ошибку
//            Log::error('Ошибка создания бронирования', [
//                'error' => $e->getMessage(),
//                'data' => $data,
//            ]);
//
//            return response()->json(['message' => 'Ошибка создания бронирования.'], 500, options: JSON_UNESCAPED_UNICODE);
//        }
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
    }

    public function calculateTotalPrice($reservation)
    {
        $total = 0;

        // Вычисляем продолжительность бронирования в часах
        $totalHours = $this->calculateReservationDuration($reservation);

        // Рассчитываем стоимость аренды
        $total += $this->calculateRentalCost($reservation, $totalHours);

        // Если арендуется зал, добавляем стоимость меню
        if ($reservation->hall_id) {
            $total += $this->calculateMenuCost($reservation);
        }

        return $total;
    }

    private function calculateReservationDuration($reservation)
    {
        if (!Carbon::canBeCreatedFromFormat($reservation->start_time, 'H:i') ||
            !Carbon::canBeCreatedFromFormat($reservation->end_time, 'H:i')) {
            throw new \InvalidArgumentException('Некорректный формат времени');
        }

        $startTime = Carbon::parse($reservation->start_time);
        $endTime = Carbon::parse($reservation->end_time);

        $interval = $startTime->diff($endTime);
        return $interval->h + ($interval->i / 60);
    }

    private function calculateRentalCost($reservation, $totalHours)
    {
        if ($reservation->table_id) {
            $table = $this->tableService->findOrFail($reservation->table_id);
            return $table->base_price * $totalHours;
        }

        if ($reservation->hall_id) {
            $hall = $this->hallService->findOrFail($reservation->hall_id);
            return $hall->base_price * $totalHours;
        }

        return 0;
    }

    private function calculateMenuCost($reservation)
    {
        $menuCostPerGuest = $reservation->dishes->sum(function ($dish) {
            return $dish->pivot->price * $dish->pivot->quantity;
        });

        return $menuCostPerGuest * $reservation->guests_count;
    }

    // Получить пересекающиеся бронирования.
    private function getConflictingReservations($tableId, $hallId, $reservationDate, $startTime, $endTime)
    {
        return Reservation::query()
            ->when($tableId, fn($query) => $query->where('table_id', $tableId))
            ->when($hallId, fn($query) => $query->where('hall_id', $hallId))
            ->where('reservation_date', $reservationDate)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhereRaw('? BETWEEN start_time AND end_time', [$startTime])
                    ->orWhereRaw('? BETWEEN start_time AND end_time', [$endTime]);
            })
            ->get()->isNotEmpty();
    }

    //Найти ближайшее доступное время после заданного интервала.
    private function findNextAvailableTime($tableId, $hallId, $reservationDate, $endTime)
    {
        $nextAvailable = Reservation::query()
            ->when($tableId, fn($query) => $query->where('table_id', $tableId))
            ->when($hallId, fn($query) => $query->where('hall_id', $hallId))
            ->where('reservation_date', $reservationDate)
            ->orderBy('end_time', 'asc')
            ->where('end_time', '>', $endTime)
            ->first();

        return $nextAvailable
            ? $nextAvailable->end_time
            : $endTime;
    }

}
