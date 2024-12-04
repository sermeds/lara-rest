<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Http\Requests\Store\StorePromotionRequest;
use App\Http\Requests\Update\UpdatePromotionRequest;

class PromotionController extends Controller
{
    public function index()
    {
        return Promotion::all();
    }

    public function store(StorePromotionRequest $request)
    {
        $validated = $request->validated();
        $promotion = Promotion::create($validated);
        return response()->json($promotion, 201);
    }

    public function show(Promotion $promotion)
    {
        return $promotion;
    }

    public function update(UpdatePromotionRequest $request, $id)
    {
        $validated = $request->validated();
        $promotion = Promotion::findOrFail($id);
        $promotion->update($validated);
        return response()->json($promotion, 200);
    }

    public function destroy($id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->delete();

        return response(null, 204);
    }
}
