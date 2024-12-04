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
            'payment_status' => 'required|in:paid,pending,canceled',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:card,cash',
        ];
    }
}

