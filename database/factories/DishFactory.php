<?php

namespace Database\Factories;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Factories\Factory;

class DishFactory extends Factory
{
    protected $model = Dish::class;

    public function definition()
    {
        return [
            'title' => $this->faker->word(),
            'weight' => $this->faker->numberBetween(100, 1000),
            'cost' => $this->faker->randomFloat(2, 50, 1500),
            'image' => $this->faker->imageUrl(640, 480, 'food', true),
            'type' => $this->faker->randomElement(['Salads', 'Snacks', 'Hot', 'Desserts', 'Drinks']),
        ];
    }
}
