<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест создания пользователя.
     */
    public function test_user_can_be_created()
    {
        $data = [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password123',
            'role' => 'user',
            'phone_number' => '123456789',
        ];

        $response = $this->postJson('/api/users', $data);

        $response->assertStatus(201); // Проверяем, что статус ответа 201
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']); // Проверяем, что пользователь записан в БД
    }

    /**
     * Тест получения списка пользователей.
     */
    public function test_can_get_user_list()
    {
        User::factory()->count(5)->create(); // Создаем 5 тестовых пользователей

        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJsonCount(5); // Проверяем, что вернулось 5 записей
    }

    /**
     * Тест обновления пользователя.
     */
    public function test_user_can_be_updated()
    {
        $user = User::factory()->create(); // Создаем тестового пользователя

        $data = [
            'username' => 'updateduser',
            'phone_number' => '987654321'
        ];

        $response = $this->putJson("/api/users/{$user->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['username' => 'updateduser']); // Проверяем обновление в БД
    }

    /**
     * Тест удаления пользователя.
     */
    public function test_user_can_be_deleted()
    {
        $user = User::factory()->create(); // Создаем тестового пользователя

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(204); // Проверяем статус 204 No Content
        $this->assertSoftDeleted('users', ['id' => $user->id]); // Проверяем мягкое удаление
    }
}

