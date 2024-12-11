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
            'pdf_url' => 'nullable|url',
            'status' => 'required|in:issued,cancelled',
        ];
    }

    public function messages(): array
    {
        return [
            'payment_id.required' => 'Идентификатор платежа обязателен.',
            'payment_id.exists' => 'Указанный идентификатор платежа не существует.',

            'receipt_number.required' => 'Номер чека обязателен.',
            'receipt_number.string' => 'Номер чека должен быть строкой.',
            'receipt_number.unique' => 'Чек с таким номером уже существует.',

            'amount.required' => 'Сумма обязательна.',
            'amount.numeric' => 'Сумма должна быть числом.',
            'amount.min' => 'Сумма не может быть отрицательной.',

            'issued_at.required' => 'Дата выдачи обязательна.',
            'issued_at.date' => 'Дата выдачи должна быть корректной датой.',

            'tax_amount.numeric' => 'Сумма налога должна быть числом.',
            'tax_amount.min' => 'Сумма налога не может быть отрицательной.',

            'pdf_url.url' => 'Ссылка на PDF должна быть корректным URL.',

            'status.required' => 'Статус обязателен.',
            'status.in' => 'Статус может быть только "issued" (выдано) или "cancelled" (отменено).',
        ];
    }

}
