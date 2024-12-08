<?php

namespace Database\Seeders;

use App\Models\BonusPoints;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BonusPointsSeeder extends Seeder
{
    public function run(): void
    {
        BonusPoints::factory(15)->create();
    }
}
