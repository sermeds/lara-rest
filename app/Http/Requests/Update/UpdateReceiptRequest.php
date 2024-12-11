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

    public function messages(): array
    {
        return [
            'payment_id.required' => 'Идентификатор платежа обязателен для обновления.',
            'payment_id.exists' => 'Указанный идентификатор платежа не существует.',

            'receipt_number.required' => 'Номер чека обязателен для обновления.',
            'receipt_number.string' => 'Номер чека должен быть строкой.',
            'receipt_number.unique' => 'Чек с таким номером уже существует.',

            'amount.required' => 'Сумма обязательна для обновления.',
            'amount.numeric' => 'Сумма должна быть числом.',
            'amount.min' => 'Сумма не может быть отрицательной.',

            'issued_at.required' => 'Дата выдачи обязательна для обновления.',
            'issued_at.date' => 'Дата выдачи должна быть корректной датой.',

            'tax_amount.numeric' => 'Сумма налога должна быть числом.',
            'tax_amount.min' => 'Сумма налога не может быть отрицательной.',

            'pdf_url.url' => 'Ссылка на PDF должна быть корректным URL.',

            'status.required' => 'Статус обязателен для обновления.',
            'status.in' => 'Статус может быть только "issued" (выдано) или "cancelled" (отменено).',
        ];
    }

}

