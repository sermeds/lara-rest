<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Http\Requests\Store\StoreHallRequest;
use App\Http\Requests\Update\UpdateHallRequest;
use App\Services\HallService;
use Illuminate\Support\Facades\Log;

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

    public function store(StoreHallRequest $request)
    {
        $validated = $request->validated();
        $hall = $this->hallService->createHall($validated);
        return response()->json($hall, 201, options:JSON_UNESCAPED_UNICODE);
    }

    public function show($id)
    {
        return $this->hallService->findOrFail($id);
    }

    public function update(UpdateHallRequest $request, $id)
    {
        $validated = $request->validated();
        $hall = $this->hallService->updateHall($id, $validated);
        return response()->json($hall, 200, options:JSON_UNESCAPED_UNICODE);
    }

    public function destroy($id)
    {
        $this->hallService->deleteHall($id);
        return response(null, 204);
    }
}
