<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Http\Requests\Store\StoreReservationRequest;
use App\Http\Requests\Update\UpdateReservationRequest;
use Illuminate\Support\Facades\Redis;
use App\Traits\ReservationKeyGenerator;

class ReservationController extends Controller
{

    use ReservationKeyGenerator;

    public function index()
    {
        return Reservation::all();
    }

    public function store(StoreReservationRequest $request)
    {
        $request->merge(['user_id' => auth()->id()]);
        $validated = $request->validated();
        // Генерация ключа для Redis
        $key = $validated['table_id']
            ? $this->generateTableKey($validated['table_id'], $validated['reservation_date'], $validated['start_time'], $validated['end_time'])
            : $this->generateHallKey($validated['hall_id'], $validated['reservation_date'], $validated['start_time'], $validated['end_time']);

        // Проверяем наличие блокировки
        print("key1 " . $key . "\n");
        if (Redis::exists($key)) {
            return response()->json(['message' => 'Место или зал временно недоступны.'], 409);
        }
        // Устанавливаем блокировку
        $this->blockPlace($key, $validated['user_id'], $validated['start_time'], $validated['end_time']);

        // Создаем бронирование со статусом `pending`
        $validated['status'] = Reservation::STATUS_PENDING;
        $reservation = Reservation::create($validated);

        $paymentData  = [
            'reservation_id' => $reservation->id,
            'amount' => 500,
        ];

        $response = $this->postJson('/api/payments', $paymentData);

        return response()->json($response, 201);
    }

    public function show(Reservation $request)
    {
        if ($request->user()) {
            // Для авторизованных пользователей показываем только их бронирования
            $reservation = Reservation::where('user_id', $request->user()->id)->get();
        } else {
            $reservation = Reservation::where('guest_phone', $request->input('guest_phone'))->get();
        }
        return $reservation;
    }

    public function update(UpdateReservationRequest $request, $id)
    {
        $validated = $request->validated();
        $reservation = Reservation::findOrFail($id);
        $reservation->update($validated);
        return response()->json($reservation, 200);
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return response(null, 204);
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
