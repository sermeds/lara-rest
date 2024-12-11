<?php

// app/Http/Requests/StorePaymentRequest.php
namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'reservation_id' => 'required|exists:reservations,id',
            'amount' => 'required|numeric|min:0',
            'payment_status' => 'required|in:successful,pending,cancelled',
            'payment_date' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'reservation_id.required' => 'Идентификатор брони обязателен.',
            'reservation_id.exists' => 'Указанная бронь не найдена.',

            'amount.required' => 'Сумма оплаты обязательна.',
            'amount.numeric' => 'Сумма оплаты должна быть числом.',
            'amount.min' => 'Сумма оплаты не может быть отрицательной.',

            'payment_status.required' => 'Статус оплаты обязателен.',
            'payment_status.in' => 'Статус оплаты должен быть одним из: successful, pending, cancelled.',

            'payment_date.required' => 'Дата оплаты обязательна.',
            'payment_date.date' => 'Дата оплаты должна быть корректной датой.',
        ];
    }

}

