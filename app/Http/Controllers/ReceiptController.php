<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Http\Requests\Store\StoreReceiptRequest;
use App\Http\Requests\Update\UpdateReceiptRequest;
use App\Services\ReceiptService;

class ReceiptController extends Controller
{
    protected $receiptService;

    public function __construct(ReceiptService $receiptService)
    {
        $this->receiptService = $receiptService;
    }

    public function index()
    {
        return $this->receiptService->all();
    }

    public function store(StoreReceiptRequest $request)
    {
        $validated = $request->validated();
        $receipt = $this->receiptService->createReceipt($validated);
        return response()->json($receipt, 201, options:JSON_UNESCAPED_UNICODE);
    }

    public function show(Receipt $receipt)
    {
        return $receipt;
    }

    public function update(UpdateReceiptRequest $request, $id)
    {
        $validated = $request->validated();
        $receipt = $this->receiptService->updateReceipt($id, $validated);
        return response()->json($receipt, 200, options:JSON_UNESCAPED_UNICODE);
    }

    public function destroy($id)
    {
        $this->receiptService->deleteReceipt($id);
        return response(null, 204);
    }
}
