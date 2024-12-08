<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReceiptRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'payment_id' => 'sometimes|required|exists:payments,id',
            'receipt_number' => 'sometimes|required|string|unique:receipts,receipt_number,' . $this->route('receipt'),
            'amount' => 'sometimes|required|numeric|min:0',
            'issued_at' => 'sometimes|required|date',
            'tax_amount' => 'sometimes|nullable|numeric|min:0',
            'pdf_url' => 'sometimes|nullable|url',
            'status' => 'sometimes|required|in:issued,cancelled',
        ];
    }
}

