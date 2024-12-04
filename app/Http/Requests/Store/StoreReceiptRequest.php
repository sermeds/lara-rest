<?php

// app/Http/Requests/StoreReceiptRequest.php
namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreReceiptRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'payment_id' => 'required|exists:payments,id',
            'receipt_number' => 'required|string|unique:receipts,receipt_number,' . $this->route('receipt'),
            'amount' => 'required|numeric|min:0',
            'issued_at' => 'required|date',
            'tax_amount' => 'nullable|numeric|min:0',
            'payment_method' => 'required|in:card,cash',
            'pdf_url' => 'nullable|url',
            'status' => 'required|in:issued,cancelled',
        ];
    }
}
