<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Http\Requests\Store\StoreTableRequest;
use App\Http\Requests\Update\UpdateTableRequest;


class TableController extends Controller
{
    public function index()
    {
        return Table::all();
    }

    public function store(StoreTableRequest $request)
    {
        $validated = $request->validated();
        $table = Table::create($validated);
        return response()->json($table, 201);
    }

    public function show(Table $table)
    {
        return $table;
    }

    public function update(UpdateTableRequest $request, $id)
    {
        $validated = $request->validated();
        $table = Table::findOrFail($id);
        $table->update($validated);
        return response()->json($table, 200);
    }

    public function destroy($id)
    {
        $table = Table::findOrFail($id);
        $table->delete();

        return response(null, 204);
    }
}
