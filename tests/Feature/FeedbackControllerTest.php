<?php

namespace Tests\Feature;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedbackControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_feedback_can_be_created()
    {
        // Создаем пользователя
        $user = User::factory()->create();

        // Данные для отзыва
        $data = [
            'user_id' => $user->id,
            'rating' => 4,
            'comment' => 'Amazing service!',
        ];

        // Отправляем запрос на создание отзыва
        $response = $this->postJson('/api/feedbacks', $data);

        // Проверяем статус и наличие данных в базе
        $response->assertStatus(201);
        $this->assertDatabaseHas('feedbacks', [
            'user_id' => $user->id,
            'rating' => 4,
            'comment' => 'Amazing service!',
        ]);
    }

    public function test_feedback_can_be_updated()
    {
        // Создаем отзыв
        $feedback = Feedback::factory()->create();

        // Данные для обновления отзыва
        $data = [
            'rating' => 5,
            'comment' => 'Updated comment!',
        ];

        // Отправляем запрос на обновление отзыва
        $response = $this->putJson("/api/feedbacks/{$feedback->id}", $data);

        // Проверяем статус и наличие обновленных данных в базе
        $response->assertStatus(200);
        $this->assertDatabaseHas('feedbacks', [
            'id' => $feedback->id,
            'rating' => 5,
            'comment' => 'Updated comment!',
        ]);
    }

    public function test_feedback_can_be_deleted()
    {
        // Создаем отзыв
        $feedback = Feedback::factory()->create();

        // Отправляем запрос на удаление отзыва
        $response = $this->deleteJson("/api/feedbacks/{$feedback->id}");

        // Проверяем статус и отсутствие данных в базе
        $response->assertStatus(204);
        $this->assertSoftDeleted('feedbacks', ['id' => $feedback->id]);
    }
}
