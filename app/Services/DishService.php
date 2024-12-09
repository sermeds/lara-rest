<?php

namespace App\Services;

use App\Models\Dish;

class DishService
{
    public function all()
    {
        return Dish::all();
    }

    public function findOrFail($id)
    {
        return Dish::findOrFail($id);
    }

    public function createDish(array $data)
    {
        return Dish::create($data);
    }

    public function updateDish($id, array $data)
    {
        $dish = $this->findOrFail($id);
        return $dish->update($data);
    }

    public function deleteDish($id)
    {
        $dish = $this->findOrFail($id);
        return $dish->delete();
    }
}
