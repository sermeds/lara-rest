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
}

