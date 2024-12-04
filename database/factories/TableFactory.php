<?php

namespace Database\Factories;

use App\Models\Table;
use App\Models\Hall;
use Illuminate\Database\Eloquent\Factories\Factory;

class TableFactory extends Factory
{
    protected $model = Table::class;

    public function definition()
    {
        return [
            'hall_id' => Hall::factory(),
            'table_number' => $this->faker->unique()->numberBetween(1, 50),
            'capacity' => $this->faker->numberBetween(2, 10),
            'is_available' => $this->faker->boolean(),
            'x' => $this->faker->numberBetween(0, 100),
            'y' => $this->faker->numberBetween(0, 100),
        ];
    }
}
