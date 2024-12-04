<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Hall;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition()
    {
        return [
            'hall_id' => Hall::factory(),
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'start_time' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'end_time' => $this->faker->dateTimeBetween('+1 hour', '+1 day'),
            'is_public' => $this->faker->boolean(),
        ];
    }
}
