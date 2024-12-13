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
    protected $bonusPointsService;
    protected $dishService;
    protected $hallService;
    protected $tableService;
    protected $userService;

    public function __construct(BonusPointsService $bonusPointsService,
                                DishService        $dishService,
                                HallService        $hallService,
                                TableService       $tableService,
                                UserService        $userService)
    {
        $this->bonusPointsService = $bonusPointsService;
        $this->dishService = $dishService;
        $this->hallService = $hallService;
        $this->tableService = $tableService;
        $this->userService = $userService;
    }

    public function getAdminData(): array
    {
        return Cache::remember('admin_data', 600, function () {
            return [
                'BonusPoints' => $this->bonusPointsService->all(),
                'Dish' => $this->dishService->all(),
                'Hall' => $this->hallService->all(),
                'Table' => $this->tableService->all(),
                'User' => $this->userService->all(),
            ];
        });
    }

    public function clearCache(): void
    {
        Cache::forget('admin_data');
    }
}
