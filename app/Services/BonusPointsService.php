<?php

namespace App\Services;

use App\Models\BonusPoints;

class BonusPointsService
{

    public function all()
    {
        return BonusPoints::all();
    }

    public function findOrFail($id)
    {
        return BonusPoints::findOrFail($id);
    }

    public function createBonusPoints(array $data)
    {
        return BonusPoints::create($data);
    }

    public function updateBonusPoints($id, array $data)
    {
        $bonusPoints = $this->findOrFail($id);
        return $bonusPoints->update($data);
    }

    public function deleteBonusPoints($id)
    {
        $bonusPoints = $this->findOrFail($id);
        return $bonusPoints->delete();
    }
}
