<?php

namespace Tests\Feature;

use App\Models\Hall;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use App\Traits\ReservationKeyGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class ReservationControllerTest extends TestCase
{
    use RefreshDatabase, ReservationKeyGenerator;

    public function test_table_can_be_reserved()
    {
        $user = User::factory()->create();
        $table = Table::factory()->create();

        $data = [
            'user_id' => $user->id,
            'reservation_date' => now()->toDateString(),
            'table_id' => $table->id,
            'hall_id' => null,
            'start_time' => now()->addHours(2)->format('H:i'),
            'end_time' => now()->addHours(4)->format('H:i'),
            'guests_count' => 4,
            'status' => Reservation::STATUS_PENDING,
        ];

        // Создаем запрос на бронирование
        $response = $this->postJson('/api/reservations', $data);

        // Проверяем успешный статус ответа
        $response->assertStatus(201);

        // Проверяем наличие записи в базе данных
        $this->assertDatabaseHas('reservations', [
            'user_id' => $user->id,
            'table_id' => $table->id,
            'status' => Reservation::STATUS_PENDING,
        ]);

        // Проверяем, что запись блокировки существует в Redis
        $key = $this->generateTableKey($table->id, $data['reservation_date'], $data['start_time'], $data['end_time']);
        $this->assertTrue(Redis::exists($key) == 1);
    }

    public function test_test_2()
    {
        $hall = Hall::factory()->create();

        $data = [
            'user_id' => null,
            'reservation_date' => now()->toDateString(),
            'table_id' => null,
            'hall_id' => $hall->id,
            'start_time' => now()->addHours(2)->format('H:i'),
            'end_time' => now()->addHours(4)->format('H:i'),
            'guests_count' => 4,
            'guest_name' => 'Vlad',
            'guest_phone' => '1234521',
        ];

        // Создаем запрос на бронирование
        $response = $this->postJson('/api/reservations', $data);

        // Проверяем успешный статус ответа
        $response->assertStatus(201);

        // Проверяем наличие записи в базе данных
        $this->assertDatabaseHas('reservations', [
            'hall_id' => $hall->id,
            'status' => Reservation::STATUS_PENDING,
        ]);

        // Проверяем, что запись блокировки существует в Redis
        $key = $this->generateHallKey($hall->id, $data['reservation_date'], $data['start_time'], $data['end_time']);
        print("key2 " . $key . "\n");
        $this->assertTrue(Redis::exists($key) == 1);
    }

    public function test_hall_can_be_reserved()
    {
        $user = User::factory()->create();
        $hall = Hall::factory()->create();

        $data = [
            'user_id' => $user->id,
            'reservation_date' => now()->toDateString(),
            'table_id' => null, // Указываем null, так как бронируем весь зал
            'hall_id' => $hall->id,
            'start_time' => now()->addHours(2)->format('H:i'),
            'end_time' => now()->addHours(4)->format('H:i'),
            'guests_count' => 20,
            'status' => Reservation::STATUS_PENDING,
        ];

        // Создаем запрос на бронирование
        $response = $this->postJson('/api/reservations', $data);

        // Проверяем успешный статус ответа
        $response->assertStatus(201);

        // Проверяем наличие записи в базе данных
        $this->assertDatabaseHas('reservations', [
            'user_id' => $user->id,
            'hall_id' => $hall->id,
            'status' => Reservation::STATUS_PENDING,
        ]);

        // Проверяем, что запись блокировки существует в Redis
        $key = $this->generateHallKey($hall->id, $data['reservation_date'], $data['start_time'], $data['end_time']);
        $this->assertTrue(Redis::exists($key) == 1);
    }

    public function test_can_be_reserved_without_user()
    {
        $hall = Hall::factory()->create();

        $data = [
            'user_id' => null,
            'reservation_date' => now()->toDateString(),
            'table_id' => null,
            'hall_id' => $hall->id,
            'start_time' => now()->addHours(2)->format('H:i'),
            'end_time' => now()->addHours(4)->format('H:i'),
            'guests_count' => 20,
            'status' => Reservation::STATUS_PENDING,
            'guest_name' => 'VladiSlave IRusskiy',
            'guest_phone' => '142342',
        ];

        // Создаем запрос на бронирование
        $response = $this->postJson('/api/reservations', $data);

        // Проверяем успешный статус ответа
        $response->assertStatus(201);

        // Проверяем наличие записи в базе данных
        $this->assertDatabaseHas('reservations', [
            'user_id' => null,
            'hall_id' => $hall->id,
            'status' => Reservation::STATUS_PENDING,
            'guest_name' => 'VladiSlave IRusskiy',
            'guest_phone' => '142342'
        ]);

        // Проверяем, что запись блокировки существует в Redis
        $key = $this->generateHallKey($hall->id, $data['reservation_date'], $data['start_time'], $data['end_time']);
        $this->assertTrue(Redis::exists($key) == 1);
    }

    public function test_can_get_reservation_list()
    {
        Reservation::factory()->count(3)->create();

        $response = $this->getJson('/api/reservations');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_reservation_can_be_updated()
    {
        $reservation = Reservation::factory()->create();

        $data = [
            'status' => Reservation::STATUS_SUCCESSFUL,
        ];

        $response = $this->putJson("/api/reservations/{$reservation->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('reservations', ['status' => Reservation::STATUS_SUCCESSFUL]);
    }

    public function test_reservation_can_be_deleted()
    {
        $reservation = Reservation::factory()->create();

        $response = $this->deleteJson("/api/reservations/{$reservation->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('reservations', ['id' => $reservation->id]);
    }
}
