<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDishRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'weight' => 'sometimes|required|integer|min:1',
            'cost' => 'sometimes|required|numeric|min:0',
            'image' => 'sometimes|nullable|url',
            'type' => 'sometimes|required|in:Salads,Snacks,Hot,Deserts,Drinks',
        ];
    }
}

