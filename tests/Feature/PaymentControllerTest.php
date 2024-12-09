<?php

namespace Tests\Feature;

use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use App\Traits\ReservationKeyGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    use RefreshDatabase, ReservationKeyGenerator;

    public function test_payment_can_be_created()
    {
        $user = User::factory()->create();
        $table = Table::factory()->create();

        $reservationData  = [
            'user_id' => $user->id,
            'reservation_date' => now()->toDateString(),
            'table_id' => $table->id,
            'hall_id' => null,
            'start_time' => now()->addHours(2)->format('H:i'),
            'end_time' => now()->addHours(4)->format('H:i'),
            'guests_count' => 4,
        ];

        // Создаем запрос на бронирование
        $reservationResponse = $this->postJson('/api/reservations', $reservationData);

        $reservationResponse->assertStatus(201);

        $reservation = Reservation::first();

        $paymentData  = [
            'reservation_id' => $reservation->id,
            'amount' => 100.50,
        ];

        $response = $this->postJson('/api/payments', $paymentData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('payments', $paymentData);
    }

    public function test_payment_can_be_updated()
    {
        $payment = Payment::factory()->create();

        $data = [
            'payment_status' => Payment::STATUS_CANCELLED,
        ];

        $response = $this->putJson("/api/payments/{$payment->id}", $data);
        print ("PaymentController blablabla = {$response->getContent()}");

        $response->assertStatus(200);
        $this->assertDatabaseHas('payments', $data);
    }

    public function test_payment_can_be_deleted()
    {
        $payment = Payment::factory()->create();

        $response = $this->deleteJson("/api/payments/{$payment->id}");
        print ("PaymentController delete blablabla = {$response->getContent()}");
        $response->assertStatus(204);
        $this->assertSoftDeleted('payments', ['id' => $payment->id]);
    }
}
