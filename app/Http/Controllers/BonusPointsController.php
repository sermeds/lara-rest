<?php

namespace App\Http\Controllers;

use App\Models\BonusPoints;
use App\Http\Requests\Store\StoreBonusPointsRequest;
use App\Http\Requests\Update\UpdateBonusPointsRequest;

class BonusPointsController extends Controller
{
    public function index()
    {
        return BonusPoints::all();
    }

    public function store(StoreBonusPointsRequest $request)
    {
        $request->merge(['user_id' => auth()->id()]);
        $validated = $request->validated();
        $bonusPoints = BonusPoints::create($validated);
        return response()->json($bonusPoints, 201);
    }

    public function show(BonusPoints $bonusPoints)
    {
        return $bonusPoints;
    }

    public function update(UpdateBonusPointsRequest $request, $id)
    {
        $validated = $request->validated();
        $bonusPoints = BonusPoints::findOrFail($id);
        $bonusPoints->update($validated);
        return response()->json($bonusPoints, 200);
    }

    public function destroy($id)
    {
        $bonusPoints = BonusPoints::findOrFail($id);
        $bonusPoints->delete();

        return response(null, 204);
    }
}
