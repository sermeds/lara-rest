<?php

namespace Database\Factories;

use App\Models\Hall;
use Illuminate\Database\Eloquent\Factories\Factory;

class HallFactory extends Factory
{
    protected $model = Hall::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'capacity' => $this->faker->numberBetween(10, 500),
            'description' => $this->faker->sentence(),
            'img' => $this->faker->imageUrl(),
            'schemeImg' => $this->faker->imageUrl(),
        ];
    }
}
