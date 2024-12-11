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
    protected $aboutPageService;

    public function __construct(AboutPageService $aboutPageService)
    {
        $this->aboutPageService = $aboutPageService;
    }

    public function getAdminData(): array
    {
        $this->aboutPageService->default();

        return Cache::remember('admin_data', 600, function () {
            return [
                'AboutPage' => AboutPage::all(),
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
