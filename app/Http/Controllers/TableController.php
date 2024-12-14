<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Http\Requests\Store\StoreTableRequest;
use App\Http\Requests\Update\UpdateTableRequest;
use App\Services\TableService;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;


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

    public function show($id)
    {
        return $this->tableService->findOrFail($id);
    }

    public function store(StoreTableRequest $request)
    {
        $validated = $request->validated();

        // Проверяем, является ли запрос массивом
        $tables = is_array($validated[0] ?? null) ? $validated : [$validated];

        $createdTables = [];
        foreach ($tables as $table) {
            $createdTables[] = $this->tableService->createTable($table);
        }

        return response()->json($createdTables, 201, options: JSON_UNESCAPED_UNICODE);
    }

    public function update(UpdateTableRequest $request, $id = null)
    {
        $validated = $request->validated();

        // Если передан массив данных
        if (is_array($validated[0] ?? null)) {
            $updatedTables = [];
            foreach ($validated as $table) {
                if (!isset($table['id'])) {
                    Log::debug($table);
                    return response()->json(['error' => 'ID is required for update.'], 400);
                }
                $updatedTables[] = $this->tableService->updateTable($table['id'], $table);
            }
            return response()->json($updatedTables, 200, options: JSON_UNESCAPED_UNICODE);
        }

        // Если данные для одного элемента
        $table = $this->tableService->updateTable($id, $validated);
        return response()->json($table, 200, options: JSON_UNESCAPED_UNICODE);
    }

    public function destroy(Request $request, $id = null)
    {
        if ($id !== null) {
            $this->tableService->deleteTable($id);
            return response(null, 204);
        }

        $ids = json_decode($request->getContent(), true);
        if (!is_array($ids)) {
            return response()->json(['error' => 'IDs must be an array.'], 400);
        }

        foreach ($ids as $id) {
            $this->tableService->deleteTable($id);
        }

        return response(null, 204);
    }
}
