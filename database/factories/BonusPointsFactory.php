<?php

namespace Database\Factories;

use App\Models\BonusPoints;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BonusPointsFactory extends Factory
{
    protected $model = BonusPoints::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'points' => $this->faker->numberBetween(10, 500),
            'expiration_date' => $this->faker->dateTimeBetween('now', '+1 year'),
        ];
    }
}
