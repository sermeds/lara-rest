<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'reservation_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'start_time' => $this->faker->time('H:i'),
            'end_time' => $this->faker->time('H:i'),
            'guests_count' => $this->faker->numberBetween(1, 10),
            'status' => $this->faker->randomElement(['active', 'cancelled', 'completed']),
        ];
    }
}
