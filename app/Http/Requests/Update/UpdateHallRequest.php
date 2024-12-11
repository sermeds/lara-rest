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
            '*.name' => 'sometimes|required|string|max:255',
            '*.capacity' => 'sometimes|required|integer|min:1',
            '*.description' => 'sometimes|nullable|string',
            '*.img' => 'sometimes|nullable|string',
            '*.schemeImg' => 'sometimes|nullable|string',
            '*.base_price' => 'sometimes|required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            '*.name.string' => 'Название зала должно быть строкой.',
            '*.name.max' => 'Название зала не может превышать 255 символов.',
            '*.capacity.integer' => 'Вместимость зала должна быть целым числом.',
            '*.capacity.min' => 'Вместимость зала должна быть не менее 1.',
            '*.description.string' => 'Описание должно быть строкой.',
            '*.img.string' => 'URL изображения зала должен быть строкой.',
            '*.schemeImg.string' => 'URL схемы зала должен быть строкой.',
            '*.base_price.integer' => 'Базовая цена должна быть целым числом.',
            '*.base_price.min' => 'Базовая цена должна быть больше 0.',
        ];
    }
}


