<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Http\Requests\Store\StoreDishRequest;
use App\Http\Requests\Update\UpdateDishRequest;
use App\Services\DishService;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;


class DishController extends Controller
{
    protected $dishService;

    public function __construct(DishService $dishService)
    {
        $this->dishService = $dishService;
    }

    public function index()
    {
        return $this->dishService->all();
    }

    public function store(StoreDishRequest $request)
    {
        $validated = $request->validated();

        // Проверяем, является ли запрос массивом
        $dishes = is_array($validated[0] ?? null) ? $validated : [$validated];

        $createdDishes = [];
        foreach ($dishes as $dishData) {
            $createdDishes[] = $this->dishService->createDish($dishData);
        }

        return response()->json($createdDishes, 201, options: JSON_UNESCAPED_UNICODE);
    }

    public function show($id)
    {
        return $this->dishService->findOrFail($id);
    }

    public function update(UpdateDishRequest $request, $id = null)
    {
        $validated = $request->validated();

        // Если передан массив данных
        if (is_array($validated[0] ?? null)) {
            $updatedDishes = [];
            foreach ($validated as $dishData) {
                if (!isset($dishData['id'])) {
                    return response()->json(['error' => 'ID is required for update.'], 400);
                }
                $updatedDishes[] = $this->dishService->updateDish($dishData['id'], $dishData);
            }
            return response()->json($updatedDishes, 200, options: JSON_UNESCAPED_UNICODE);
        }

        // Если данные для одного элемента
        $dish = $this->dishService->updateDish($id, $validated);
        return response()->json($dish, 200, options: JSON_UNESCAPED_UNICODE);
    }

    public function destroy(Request $request, $id = null)
    {
        if ($id !== null) {
            $this->dishService->deleteDish($id);
            return response(null, 204);
        }

        $ids = json_decode($request->getContent(), true);
        if (!is_array($ids)) {
            return response()->json(['error' => 'IDs must be an array.'], 400);
        }

        foreach ($ids as $id) {
            $this->dishService->deleteDish($id);
        }

        return response(null, 204);
    }
}
