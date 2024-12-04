<?php

namespace Tests\Feature;

use App\Models\Promotion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PromotionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_promotion_can_be_created()
    {
        $data = [
            'name' => 'Discount Week',
            'description' => '50% off on all items',
            'discount_percentage' => 50,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addDays(7)->toDateString(),
            'is_active' => true,
        ];

        $response = $this->postJson('/api/promotions', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('promotions', ['name' => 'Discount Week']);
    }

    public function test_can_get_promotion_list()
    {
        Promotion::factory()->count(3)->create();

        $response = $this->getJson('/api/promotions');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_promotion_can_be_updated()
    {
        $promotion = Promotion::factory()->create();

        $data = [
            'name' => 'Updated Promotion',
            'is_active' => false,
        ];

        $response = $this->putJson("/api/promotions/{$promotion->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('promotions', ['name' => 'Updated Promotion']);
    }

    public function test_promotion_can_be_deleted()
    {
        $promotion = Promotion::factory()->create();

        $response = $this->deleteJson("/api/promotions/{$promotion->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('promotions', ['id' => $promotion->id]);
    }
}
