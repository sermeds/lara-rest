<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTableRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'hall_id' => 'sometimes|required|exists:halls,id',
            'table_number' => 'sometimes|required|integer|min:1',
            'capacity' => 'sometimes|required|integer|min:1',
            'is_available' => 'sometimes|required|boolean',
            'x' => 'sometimes|required|integer',
            'y' => 'sometimes|required|integer',
            'base_price' => 'sometimes|required|integer|min:1',
        ];
    }
}
