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
        ]);

        $reservation = Reservation::findOrFail($validated['reservation_id']);

        // Проверяем статус бронирования
        if ($reservation->status !== Reservation::STATUS_PENDING) {
            return response()->json(['message' => 'Оплата уже обработана или отменена.'], 400);
        }

        $payment = Payment::create([
            'reservation_id' => $reservation->id,
            'amount' => $validated['amount'],
            'payment_status' => Payment::STATUS_PENDING,
            'payment_date' => now(),
        ]);

        return response()->json(['message' => 'Платеж создан, ожидается подтверждение.', 'payment' => $payment], 201);
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
