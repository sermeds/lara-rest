<?php

namespace Tests\Feature;

use App\Models\Table;
use App\Models\Hall;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TableControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_table_can_be_created()
    {
        $hall = Hall::factory()->create();
        $data = [
            'hall_id' => $hall->id,
            'table_number' => 1,
            'capacity' => 4,
            'is_available' => true,
            'x' => 5,
            'y' => 6,
            'base_price' => 350,
        ];

        $response = $this->postJson('/api/tables', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tables', ['table_number' => 1]);
    }

    public function test_can_get_table_list()
    {
        Table::factory()->count(3)->create();

        $response = $this->getJson('/api/tables');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_table_can_be_updated()
    {
        $table = Table::factory()->create();

        $data = [
            'table_number' => 2,
            'capacity' => 6,
        ];

        $response = $this->putJson("/api/tables/{$table->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tables', ['table_number' => 2]);
    }

    public function test_table_can_be_deleted()
    {
        $table = Table::factory()->create();

        $response = $this->deleteJson("/api/tables/{$table->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('tables', ['id' => $table->id]);
    }
}
