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
            'type' => 'sometimes|required|in:Salads,Snacks,Hot,Desserts,Drinks',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Название блюда обязательно для обновления.',
            'title.string' => 'Название блюда должно быть строкой.',
            'title.max' => 'Название блюда не может превышать 255 символов.',

            'weight.required' => 'Вес блюда обязателен для обновления.',
            'weight.integer' => 'Вес блюда должен быть целым числом.',
            'weight.min' => 'Вес блюда должен быть не менее 1.',

            'cost.required' => 'Стоимость блюда обязательна для обновления.',
            'cost.numeric' => 'Стоимость блюда должна быть числом.',
            'cost.min' => 'Стоимость блюда должна быть не менее 0.',

            'image.url' => 'URL изображения блюда должен быть валидным.',

            'type.required' => 'Тип блюда обязателен для обновления.',
            'type.in' => 'Тип блюда должен быть одним из: Salads, Snacks, Hot, Desserts, Drinks.',
        ];
    }

}

