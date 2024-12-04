<?php

namespace Tests\Feature;

use App\Models\Hall;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HallControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_hall_can_be_created()
    {
        $data = [
            'name' => 'Main Hall',
            'capacity' => 100,
            'description' => 'Spacious main hall',
            'schemeImg' => '/data/img/fakeImg.png',
        ];

        $response = $this->postJson('/api/halls', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('halls', ['name' => 'Main Hall']);
    }

    public function test_can_get_hall_list()
    {
        Hall::factory()->count(3)->create();

        $response = $this->getJson('/api/halls');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_hall_can_be_updated()
    {
        $hall = Hall::factory()->create();

        $data = [
            'name' => 'Updated Hall',
            'capacity' => 150,
        ];

        $response = $this->putJson("/api/halls/{$hall->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('halls', ['name' => 'Updated Hall']);
    }

    public function test_hall_can_be_deleted()
    {
        $hall = Hall::factory()->create();

        $response = $this->deleteJson("/api/halls/{$hall->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('halls', ['id' => $hall->id]);
    }
}
