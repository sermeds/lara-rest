<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReservationDish;

class ReservationDishSeeder extends Seeder
{
    public function run()
    {
        // Создаем 50 записей в таблице reservation_dishes
        ReservationDish::factory()->count(50)->create();
    }
}

