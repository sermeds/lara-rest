<?php

namespace App\Services;

use App\Models\Receipt;

class ReceiptService
{
    public function all()
    {
        return Receipt::all();
    }

    public function findOrFail($id)
    {
        return Receipt::findOrFail($id);
    }

    public function createReceipt(array $data)
    {
        return Receipt::create($data);
    }

    public function updateReceipt($id, array $data)
    {
        $receipt = $this->findOrFail($id);
        return $receipt->update($data);
    }

    public function deleteReceipt($id)
    {
        $receipt = $this->findOrFail($id);
        return $receipt->delete();
    }
}
