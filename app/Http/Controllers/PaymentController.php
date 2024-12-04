<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Requests\Update\UpdatePaymentRequest;
use App\Models\Reservation;
use Illuminate\Support\Facades\Redis;
use App\Traits\ReservationKeyGenerator;

class PaymentController extends Controller
{
    use ReservationKeyGenerator;

    public function index()
    {
        return Payment::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string',
        ]);

        $reservation = Reservation::findOrFail($validated['reservation_id']);

        // Проверяем статус бронирования
        if ($reservation->status !== Reservation::STATUS_PENDING) {
            return response()->json(['message' => 'Оплата уже обработана или отменена.'], 400);
        }

        // Логика обработки платежа (можно заменить на реальную интеграцию)
        $paymentStatus = $this->simulatePayment($validated['amount']);

        if ($paymentStatus === 'success') {
            // Создаем запись о платеже
            $payment = Payment::create([
                'reservation_id' => $reservation->id,
                'amount' => $validated['amount'],
                'payment_status' => 'successful',
                'payment_date' => now(),
                'payment_method' => $validated['payment_method'],
            ]);

            // Обновляем статус бронирования
            $reservation->update(['status' => Reservation::STATUS_SUCCESSFUL]);

            // Удаляем ключ блокировки из Redis
            $key = $reservation->table_id
                ? $this->generateTableKey($reservation->table_id, $reservation->reservation_date, $reservation->start_time, $reservation->end_time)
                : $this->generateHallKey($reservation->hall_id, $reservation->reservation_date, $reservation->start_time, $reservation->end_time);

            Redis::del($key);
            print("key21 " . $key . "\n");

            return response()->json(['message' => 'Оплата успешна.', 'payment' => $payment], 201);
        }

        // Обработка неудачного платежа
        $reservation->update(['status' => Reservation::STATUS_CANCELLED]);
        return response()->json(['message' => 'Оплата не выполнена.'], 402);
    }

    public function show(Payment $payment)
    {
        return $payment;
    }

    public function update(UpdatePaymentRequest $request, $id)
    {
        $validated = $request->validated();
        $payment = Payment::findOrFail($id);
        $payment->update($validated);
        return response()->json($payment, 200);
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return response(null, 204);
    }

    private function simulatePayment($amount): string
    {
        // Пример симуляции обработки платежа
        return $amount > 0 ? 'success' : 'fail';
    }

}
