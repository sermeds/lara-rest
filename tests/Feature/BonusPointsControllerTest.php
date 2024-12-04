<?php

namespace Tests\Feature;

use App\Models\BonusPoints;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BonusPointsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_bonus_points_can_be_created()
    {
        $user = User::factory()->create();

        $data = [
            'user_id' => $user->id,
            'points' => 100,
            'expiration_date' => now()->addMonth()->toDateString(),
        ];

        $response = $this->postJson('/api/bonus-points', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('bonus_points', $data);
    }

    public function test_bonus_points_can_be_updated()
    {
        $bonusPoints = BonusPoints::factory()->create();

        $data = [
            'points' => 200,
        ];

        $response = $this->putJson("/api/bonus-points/{$bonusPoints->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('bonus_points', $data);
    }

    public function test_bonus_points_can_be_deleted()
    {
        $bonusPoints = BonusPoints::factory()->create();

        $response = $this->deleteJson("/api/bonus-points/{$bonusPoints->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('bonus_points', ['id' => $bonusPoints->id]);
    }
}
