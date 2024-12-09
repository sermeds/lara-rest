<?php

// app/Http/Requests/StoreReservationRequest.php
namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'nullable|exists:users,id',
            'table_id' => 'nullable|exists:tables,id',
            'hall_id' => 'nullable|exists:halls,id',
            'reservation_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'status' => 'nullable|string',
            'guests_count' => 'required|integer|min:1',
            'special_requests' => 'nullable|string',
            'guest_name' => 'required_without:user_id|string|max:255',
            'guest_phone' => 'required_without:user_id|string|max:15',
            'total_price' => 'nullable|integer|min:1',
        ];
    }
}

