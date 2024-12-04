<?php

namespace Database\Factories;

use App\Models\Feedback;
use App\Models\User;
use App\Models\Cafe;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    protected $model = Feedback::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'cafe_id' => $this->faker->numberBetween(1, 5),
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->sentence(),
        ];
    }
}
