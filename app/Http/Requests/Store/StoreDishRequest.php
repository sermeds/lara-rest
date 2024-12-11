<?php

// app/Http/Requests/StoreDishRequest.php
namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreDishRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            '*.title' => 'required|string|max:255',
            '*.weight' => 'required|integer|min:1',
            '*.cost' => 'required|numeric|min:0',
            '*.image' => 'nullable|url',
            '*.type' => 'required|in:Salads,Snacks,Hot,Deserts,Drinks',
        ];
    }

    public function messages(): array
    {
        return [
            '*.title.required' => 'Название блюда обязательно.',
            '*.title.string' => 'Название блюда должно быть строкой.',
            '*.title.max' => 'Название блюда не может превышать 255 символов.',

            '*.weight.required' => 'Вес блюда обязателен.',
            '*.weight.integer' => 'Вес блюда должен быть целым числом.',
            '*.weight.min' => 'Вес блюда должен быть не менее 1.',

            '*.cost.required' => 'Стоимость блюда обязательна.',
            '*.cost.numeric' => 'Стоимость блюда должна быть числом.',
            '*.cost.min' => 'Стоимость блюда должна быть не менее 0.',

            '*.image.url' => 'URL изображения блюда должен быть валидным.',

            '*.type.required' => 'Тип блюда обязателен.',
            '*.type.in' => 'Тип блюда должен быть одним из: Salads, Snacks, Hot, Deserts, Drinks.',
        ];
    }

}

