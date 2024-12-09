<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Http\Requests\Store\StoreDishRequest;
use App\Http\Requests\Update\UpdateDishRequest;
use App\Services\DishService;


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
        $dish = $this->dishService->createDish($validated);
        return response()->json($dish, 201, options:JSON_UNESCAPED_UNICODE);
    }

    public function show($id)
    {
        return $this->dishService->findOrFail($id);
    }

    public function update(UpdateDishRequest $request, $id)
    {
        $validated = $request->validated();
        $dish = $this->dishService->updateDish($id, $validated);
        return response()->json($dish, 200, options:JSON_UNESCAPED_UNICODE);
    }

    public function destroy($id)
    {
        $this->dishService->deleteDish($id);
        return response(null, 204);
    }
}
