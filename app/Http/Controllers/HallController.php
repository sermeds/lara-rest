<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Http\Requests\Store\StoreHallRequest;
use App\Http\Requests\Update\UpdateHallRequest;

class HallController extends Controller
{
    public function index()
    {
        return Hall::all();
    }

    public function store(StoreHallRequest $request)
    {
        $validated = $request->validated();
        $hall = Hall::create($validated);
        return response()->json($hall, 201);
    }

    public function show(Hall $hall)
    {
        return $hall;
    }

    public function update(UpdateHallRequest $request, $id)
    {
        $validated = $request->validated();
        $hall = Hall::findOrFail($id);
        $hall->update($validated);
        return response()->json($hall, 200);
    }

    public function destroy($id)
    {
        $hall = Hall::findOrFail($id);
        $hall->delete();

        return response(null, 204);
    }
}
