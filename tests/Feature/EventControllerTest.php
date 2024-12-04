<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Hall;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventControllerTest extends TestCase
{

    use RefreshDatabase;

    public function test_event_can_be_created()
    {
        $hall = Hall::factory()->create();
        $data = [
            'hall_id' => $hall->id,
            'name' => 'Birthday Party',
            'description' => 'A grand birthday celebration',
            'start_time' => now()->toDateTimeString(),
            'end_time' => now()->addHours(4)->toDateTimeString(),
            'is_public' => true,
        ];

        $response = $this->postJson('/api/events', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('events', ['name' => 'Birthday Party']);
    }

    public function test_can_get_event_list()
    {
        Event::factory()->count(3)->create();

        $response = $this->getJson('/api/events');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_event_can_be_updated()
    {
        $event = Event::factory()->create();

        $data = [
            'name' => 'Updated Event',
            'is_public' => false,
        ];

        $response = $this->putJson("/api/events/{$event->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('events', ['name' => 'Updated Event']);
    }

    public function test_event_can_be_deleted()
    {
        $event = Event::factory()->create();

        $response = $this->deleteJson("/api/events/{$event->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('events', ['id' => $event->id]);
    }
}
