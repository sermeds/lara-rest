<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreHallRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            '*.name' => 'required|string|max:255',
            '*.capacity' => 'required|integer|min:1',
            '*.description' => 'nullable|string',
            '*.img' => 'nullable|string',
            '*.schemeImg' => 'nullable|string',
            '*.base_price' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            '*.name.required' => 'Название зала обязательно.',
            '*.name.string' => 'Название зала должно быть строкой.',
            '*.name.max' => 'Название зала не может превышать 255 символов.',
            '*.capacity.required' => 'Вместимость зала обязательна.',
            '*.capacity.integer' => 'Вместимость зала должна быть целым числом.',
            '*.capacity.min' => 'Вместимость зала должна быть не менее 1.',
            '*.description.string' => 'Описание должно быть строкой.',
            '*.img.string' => 'URL изображения зала должен быть строкой.',
            '*.schemeImg.string' => 'URL схемы зала должен быть строкой.',
            '*.base_price.required' => 'Базовая цена обязательна.',
            '*.base_price.integer' => 'Базовая цена должна быть целым числом.',
            '*.base_price.min' => 'Базовая цена должна быть больше 0.',
        ];
    }
}

