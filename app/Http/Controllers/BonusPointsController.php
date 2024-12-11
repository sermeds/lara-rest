<?php

namespace App\Http\Controllers;

use App\Models\BonusPoints;
use App\Http\Requests\Store\StoreBonusPointsRequest;
use App\Http\Requests\Update\UpdateBonusPointsRequest;
use App\Services\BonusPointsService;
use Illuminate\Support\Facades\Request;

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

    public function show($id)
    {
        return $this->bonusPointService->findOrFail($id);
    }

    public function store(StoreBonusPointsRequest $request)
    {
        $validated = $request->validated();

        // Проверяем, является ли запрос массивом
        $bonusPoints = is_array($validated[0] ?? null) ? $validated : [$validated];

        $createdBonusPoints = [];
        foreach ($bonusPoints as $bonusPoint) {
            $createdBonusPoints[] = $this->bonusPointService->createBonusPoints($bonusPoint);
        }

        return response()->json($createdBonusPoints, 201, options: JSON_UNESCAPED_UNICODE);
    }

    public function update(UpdateBonusPointsRequest $request, $id = null)
    {
        $validated = $request->validated();

        // Если передан массив данных
        if (is_array($validated[0] ?? null)) {
            $updatedBonusPoints = [];
            foreach ($validated as $bonusPoint) {
                if (!isset($bonusPoint['id'])) {
                    return response()->json(['error' => 'ID is required for update.'], 400);
                }
                $updatedBonusPoints[] = $this->bonusPointService->updateBonusPoints($bonusPoint['id'], $bonusPoint);
            }
            return response()->json($updatedBonusPoints, 200, options: JSON_UNESCAPED_UNICODE);
        }

        // Если данные для одного элемента
        $bonusPoint = $this->bonusPointService->updateBonusPoints($id, $validated);
        return response()->json($bonusPoint, 200, options: JSON_UNESCAPED_UNICODE);
    }

    public function destroy(Request $request, $id = null)
    {
        if ($id !== null) {
            $this->bonusPointService->deleteBonusPoints($id);
            return response(null, 204);
        }

        $ids = $request->input('ids');
        if (!is_array($ids)) {
            return response()->json(['error' => 'IDs must be an array.'], 400);
        }

        foreach ($ids as $id) {
            $this->bonusPointService->deleteBonusPoints($id);
        }

        return response(null, 204);
    }
}
