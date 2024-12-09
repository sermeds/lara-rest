<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Reservation;

class PaymentService
{
    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function all()
    {
        return Payment::all();
    }

    public function findOrFail($id)
    {
        return Payment::findOrFail($id);
    }

    public function createPayment(array $data)
    {

        $reservation = $this->reservationService->findOrFail($data['reservation_id']);

        // Проверяем статус бронирования
        if ($reservation->status !== Reservation::STATUS_PENDING) {
            return response()->json(['message' => 'Оплата уже обработана или отменена.'], 400);
        }

        return Payment::create([
            'reservation_id' => $reservation->id,
            'amount' => $data['amount'],
            'payment_status' => Payment::STATUS_PENDING,
            'payment_date' => now(),
        ]);
    }

    public function updatePayment($id, array $data)
    {
        $payment = $this->findOrFail($id);
        return $payment->update($data);
    }

    public function deletePayment($id)
    {
        $payment = $this->findOrFail($id);
        return $payment->delete();
    }

    public function generatePaymentLink($id)
    {
        return "localhost:8081/checkId={$id}";
    }
}
