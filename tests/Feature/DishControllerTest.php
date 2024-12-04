<?php

namespace Tests\Feature;

use App\Models\Dish;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DishControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_dish_can_be_created()
    {
        $data = [
            'title' => 'Pasta',
            'weight' => 500,
            'cost' => 12.50,
            'image' => 'http://example.com/pasta.jpg',
            'type' => 'Hot',
        ];

        $response = $this->postJson('/api/dishes', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('dishes', $data);
    }

    public function test_dish_can_be_updated()
    {
        $dish = Dish::factory()->create();

        $data = [
            'cost' => 15.00,
        ];

        $response = $this->putJson("/api/dishes/{$dish->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('dishes', $data);
    }

    public function test_dish_can_be_deleted()
    {
        $dish = Dish::factory()->create();

        $response = $this->deleteJson("/api/dishes/{$dish->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('dishes', ['id' => $dish->id]);
    }
}
