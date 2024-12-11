<?php

// app/Http/Requests/StorePromotionRequest.php
namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StorePromotionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:promotions,name,' . $this->route('promotion'),
            'description' => 'nullable|string',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'hall_id' => 'nullable|exists:halls,id',
            'is_active' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Название акции обязательно.',
            'name.string' => 'Название акции должно быть строкой.',
            'name.max' => 'Название акции не может превышать 255 символов.',
            'name.unique' => 'Акция с таким названием уже существует.',

            'description.string' => 'Описание акции должно быть строкой.',

            'discount_percentage.required' => 'Процент скидки обязателен.',
            'discount_percentage.numeric' => 'Процент скидки должен быть числом.',
            'discount_percentage.min' => 'Процент скидки не может быть отрицательным.',
            'discount_percentage.max' => 'Процент скидки не может превышать 100.',

            'start_date.required' => 'Дата начала акции обязательна.',
            'start_date.date' => 'Дата начала акции должна быть корректной датой.',

            'end_date.required' => 'Дата окончания акции обязательна.',
            'end_date.date' => 'Дата окончания акции должна быть корректной датой.',
            'end_date.after' => 'Дата окончания акции должна быть позже даты начала.',

            'hall_id.exists' => 'Указанный зал не существует.',

            'is_active.required' => 'Поле активности акции обязательно.',
            'is_active.boolean' => 'Поле активности должно быть булевым значением.',
        ];
    }

}
