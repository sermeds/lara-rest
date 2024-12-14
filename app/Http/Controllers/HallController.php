<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Http\Requests\Store\StoreHallRequest;
use App\Http\Requests\Update\UpdateHallRequest;
use App\Services\HallService;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class HallController extends Controller
{
    protected $hallService;

    public function __construct(HallService $hallService)
    {
        $this->hallService = $hallService;
    }

    public function index()
    {
        return $this->hallService->all();
    }

    public function show($id)
    {
        return $this->hallService->findOrFail($id);
    }

    public function store(StoreHallRequest $request)
    {
        $validated = $request->validated();

        // Проверяем, является ли запрос массивом
        $halls = is_array($validated[0] ?? null) ? $validated : [$validated];

        $createdHalls = [];
        foreach ($halls as $hall) {
            $createdHalls[] = $this->hallService->createHall($hall);
        }

        return response()->json($createdHalls, 201, options: JSON_UNESCAPED_UNICODE);
    }

    public function update(UpdateHallRequest $request, $id = null)
    {
        $validated = $request->validated();

        // Если передан массив данных
        if (is_array($validated[0] ?? null)) {
            $updatedHalls = [];
            foreach ($validated as $hall) {
                if (!isset($hall['id'])) {
                    return response()->json(['error' => 'ID is required for update.'], 400);
                }
                $updatedHalls[] = $this->hallService->updateHall($hall['id'], $hall);
            }
            return response()->json($updatedHalls, 200, options: JSON_UNESCAPED_UNICODE);
        }

        // Если данные для одного элемента
        $hall = $this->hallService->updateHall($id, $validated);
        return response()->json($hall, 200, options: JSON_UNESCAPED_UNICODE);
    }

    public function destroy(Request $request, $id = null)
    {
        if ($id !== null) {
            $this->hallService->deleteHall($id);
            return response(null, 204);
        }

        $ids = json_decode($request->getContent(), true);
        if (!is_array($ids)) {
            return response()->json(['error' => 'IDs must be an array.'], 400);
        }

        foreach ($ids as $id) {
            $this->hallService->deleteHall($id);
        }

        return response(null, 204);
    }
}
