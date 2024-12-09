<?php

namespace App\Http\Controllers;

use App\Models\BonusPoints;
use App\Http\Requests\Store\StoreBonusPointsRequest;
use App\Http\Requests\Update\UpdateBonusPointsRequest;
use App\Services\BonusPointsService;

class BonusPointsController extends Controller
{
    protected $bonusPointService;

    public function __construct(BonusPointsService $bonusPointService)
    {
        $this->bonusPointService = $bonusPointService;
    }

    public function index()
    {
        return $this->bonusPointService->all();
    }

    public function store(StoreBonusPointsRequest $request)
    {
        $request->merge(['user_id' => auth()->id()]);
        $validated = $request->validated();
        $bonusPoints = $this->bonusPointService->createBonusPoints($validated);
        return response()->json($bonusPoints, 201);
    }

    public function show($id)
    {
        return $this->bonusPointService->findOrFail($id);
    }

    public function update(UpdateBonusPointsRequest $request, $id)
    {
        $validated = $request->validated();
        $bonusPoints = $this->bonusPointService->updateBonusPoints($id, $validated);
        return response()->json($bonusPoints, 200);
    }

    public function destroy($id)
    {
        $this->bonusPointService->deleteBonusPoints($id);
        return response(null, 204);
    }
}
