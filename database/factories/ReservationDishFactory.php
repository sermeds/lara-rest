<?php

namespace Database\Factories;

use App\Models\Dish;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationDishFactory extends Factory
{
    public function definition()
    {
        return [
            'reservation_id' => Reservation::factory(), // Генерируем бронирование
            'dish_id' => Dish::factory(), // Генерируем блюдо
            'quantity' => $this->faker->numberBetween(1, 5), // Количество блюд
            'price' => $this->faker->randomFloat(2, 50, 1500), // Цена блюда
        ];
    }
}

