<?php

namespace App\Services;

use App\Models\Promotion;

class PromotionService
{
    public function all()
    {
        return Promotion::all();
    }

    public function findOrFail($id)
    {
        return Promotion::findOrFail($id);
    }

    public function createPromotion(array $data)
    {
        return Promotion::create($data);
    }

    public function updatePromotion($id, array $data)
    {
        $promotion = $this->findOrFail($id);
        return $promotion->update($data);
    }

    public function deletePromotion($id)
    {
        $promotion = $this->findOrFail($id);
        return $promotion->delete();
    }
}
