<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'reservation_id' => 'sometimes|required|exists:reservations,id',
            'amount' => 'sometimes|required|numeric|min:0',
            'payment_status' => 'sometimes|required|in:successful,pending,cancelled',
            'payment_date' => 'sometimes|required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'reservation_id.required' => 'Идентификатор брони обязателен для обновления.',
            'reservation_id.exists' => 'Указанная бронь не найдена.',

            'amount.required' => 'Сумма оплаты обязательна для обновления.',
            'amount.numeric' => 'Сумма оплаты должна быть числом.',
            'amount.min' => 'Сумма оплаты не может быть отрицательной.',

            'payment_status.required' => 'Статус оплаты обязателен для обновления.',
            'payment_status.in' => 'Статус оплаты должен быть одним из: successful, pending, cancelled.',

            'payment_date.required' => 'Дата оплаты обязательна для обновления.',
            'payment_date.date' => 'Дата оплаты должна быть корректной датой.',
        ];
    }

}

