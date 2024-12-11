<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePromotionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'discount_percentage' => 'sometimes|required|numeric|min:0|max:100',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
            'hall_id' => 'sometimes|nullable|exists:halls,id',
            'is_active' => 'sometimes|required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Название акции обязательно для обновления.',
            'name.string' => 'Название акции должно быть строкой.',
            'name.max' => 'Название акции не может превышать 255 символов.',

            'description.string' => 'Описание акции должно быть строкой.',

            'discount_percentage.required' => 'Процент скидки обязателен для обновления.',
            'discount_percentage.numeric' => 'Процент скидки должен быть числом.',
            'discount_percentage.min' => 'Процент скидки не может быть отрицательным.',
            'discount_percentage.max' => 'Процент скидки не может превышать 100.',

            'start_date.required' => 'Дата начала акции обязательна для обновления.',
            'start_date.date' => 'Дата начала акции должна быть корректной датой.',

            'end_date.required' => 'Дата окончания акции обязательна для обновления.',
            'end_date.date' => 'Дата окончания акции должна быть корректной датой.',
            'end_date.after_or_equal' => 'Дата окончания акции должна быть позже или совпадать с датой начала.',

            'hall_id.exists' => 'Указанный зал не существует.',

            'is_active.required' => 'Поле активности акции обязательно для обновления.',
            'is_active.boolean' => 'Поле активности должно быть булевым значением.',
        ];
    }

}

