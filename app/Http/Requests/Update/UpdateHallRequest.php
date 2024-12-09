<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHallRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'capacity' => 'sometimes|required|integer|min:1',
            'description' => 'sometimes|nullable|string',
            'img' => 'sometimes|nullable|string',
            'schemeImg' => 'sometimes|nullable|string',
            'base_price' => 'sometimes|required|integer|min:1',
        ];
    }
}

