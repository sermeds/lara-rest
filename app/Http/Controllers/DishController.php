<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Http\Requests\Store\StoreDishRequest;
use App\Http\Requests\Update\UpdateDishRequest;


class DishController extends Controller
{
    public function index()
    {
        return Dish::all();
    }

    public function store(StoreDishRequest $request)
    {
        $validated = $request->validated();
        $dish = Dish::create($validated);
        return response()->json($dish, 201);
    }

    public function show(Dish $dish)
    {
        return $dish;
    }

    public function update(UpdateDishRequest $request, $id)
    {
        $validated = $request->validated();
        $dish = Dish::findOrFail($id);
        $dish->update($validated);
        return response()->json($dish, 200);
    }

    public function destroy($id)
    {
        $dish = Dish::findOrFail($id);
        $dish->delete();

        return response(null, 204);
    }
}
