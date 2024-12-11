<?php

namespace App\Services;

use App\Models\AboutPage;
use App\Models\BonusPoints;
use App\Models\Dish;
use App\Models\Hall;
use App\Models\Table;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class AdminService
{

    public function getAdminData(): array
    {
        return Cache::remember('admin_data', 600, function () {
            return [
                'BonusPoints' => BonusPoints::all(),
                'Dish' => Dish::all(),
                'Hall' => Hall::all(),
                'Table' => Table::all(),
                'User' => User::all(),
            ];
        });
    }

    public function clearCache(): void
    {
        Cache::forget('admin_data');
    }
}
