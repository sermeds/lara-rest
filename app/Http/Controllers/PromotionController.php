<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Http\Requests\Store\StorePromotionRequest;
use App\Http\Requests\Update\UpdatePromotionRequest;
use App\Services\PromotionService;

class PromotionController extends Controller
{
    protected $promotionService;

    public function __construct(PromotionService $promotionService)
    {
        $this->promotionService = $promotionService;
    }

    public function index()
    {
        return $this->promotionService->all();
    }

    public function store(StorePromotionRequest $request)
    {
        $validated = $request->validated();
        $promotion = $this->promotionService->createPromotion($validated);
        return response()->json($promotion, 201);
    }

    public function show(Promotion $promotion)
    {
        return $promotion;
    }

    public function update(UpdatePromotionRequest $request, $id)
    {
        $validated = $request->validated();
        $promotion = $this->promotionService->updatePromotion($id, $validated);
        return response()->json($promotion, 200);
    }

    public function destroy($id)
    {
        $this->promotionService->deletePromotion($id);
        return response(null, 204);
    }
}
