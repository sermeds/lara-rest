<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Http\Requests\Store\StoreTableRequest;
use App\Http\Requests\Update\UpdateTableRequest;
use App\Services\TableService;


class TableController extends Controller
{
    protected $tableService;

    public function __construct(TableService $tableService)
    {
        $this->tableService = $tableService;
    }

    public function index()
    {
        return $this->tableService->all();
    }

    public function store(StoreTableRequest $request)
    {
        $validated = $request->validated();
        $table = $this->tableService->createTable($validated);
        return response()->json($table, 201, options:JSON_UNESCAPED_UNICODE);
    }

    public function show(Table $table)
    {
        return $table;
    }

    public function update(UpdateTableRequest $request, $id)
    {
        $validated = $request->validated();
        $table = $this->tableService->updateTable($id, $validated);
        return response()->json($table, 200, options:JSON_UNESCAPED_UNICODE);
    }

    public function destroy($id)
    {
        $this->tableService->deleteTable($id);
        return response(null, 204);
    }
}
