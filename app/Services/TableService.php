<?php

namespace App\Services;

use App\Models\Table;

class TableService
{
    public function all()
    {
        return Table::all();
    }

    public function findOrFail($id)
    {
        return Table::findOrFail($id);
    }

    public function createTable(array $data)
    {
        return Table::create($data);
    }

    public function updateTable($id, array $data)
    {
        $table = $this->findOrFail($id);
        return $table->update($data);
    }

    public function deleteTable($id)
    {
        $table = $this->findOrFail($id);
        return $table->delete();
    }
}
