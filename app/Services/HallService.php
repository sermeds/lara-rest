<?php

namespace App\Services;

use App\Models\Hall;

class HallService
{
    public function all()
    {
        return Hall::all();
    }

    public function findOrFail($id)
    {
        return Hall::findOrFail($id);
    }

    public function createHall(array $data)
    {
        return Hall::create($data);
    }

    public function updateHall($id, array $data)
    {
        $hall = $this->findOrFail($id);
        return $hall->update($data);
    }

    public function deleteHall($id)
    {
        $hall = $this->findOrFail($id);
        return $hall->delete();
    }
}
