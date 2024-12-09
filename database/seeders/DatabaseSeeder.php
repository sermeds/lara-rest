<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\BonusPoints;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BonusPointsSeeder::class,
            DishSeeder::class,
            EventSeeder::class,
            FeedbackSeeder::class,
            HallSeeder::class,
            PaymentSeeder::class,
            PromotionSeeder::class,
            ReceiptSeeder::class,
            ReservationDishSeeder::class,
            ReservationSeeder::class,
            TableSeeder::class,
            UserSeeder::class,
        ]);
    }
}
