<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'sometimes|nullable|exists:users,id',
            'table_id' => 'sometimes|nullable|exists:tables,id',
            'hall_id' => 'sometimes|nullable|exists:halls,id',
            'reservation_date' => 'sometimes|required|date',
            'start_time' => 'sometimes|required|date_format:H:i',
            'end_time' => 'sometimes|required|date_format:H:i|after:start_time',
            'status' => 'sometimes|required|string',
            'guests_count' => 'sometimes|required|integer|min:1',
            'special_requests' => 'sometimes|nullable|string',
            'total_price' => 'sometimes|nullable|integer|min:1',
        ];
    }
}

