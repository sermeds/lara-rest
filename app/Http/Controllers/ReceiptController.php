<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Http\Requests\Store\StoreReceiptRequest;
use App\Http\Requests\Update\UpdateReceiptRequest;

class ReceiptController extends Controller
{
    public function index()
    {
        return Receipt::all();
    }

    public function store(StoreReceiptRequest $request)
    {
        $validated = $request->validated();
        $receipt = Receipt::create($validated);
        return response()->json($receipt, 201);
    }

    public function show(Receipt $receipt)
    {
        return $receipt;
    }

    public function update(UpdateReceiptRequest $request, $id)
    {
        $validated = $request->validated();
        $receipt = Receipt::findOrFail($id);
        $receipt->update($validated);
        return response()->json($receipt, 200);
    }

    public function destroy($id)
    {
        $receipt = Receipt::findOrFail($id);
        $receipt->delete();

        return response(null, 204);
    }
}
