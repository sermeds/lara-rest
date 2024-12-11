<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            '*.hall_id' => 'required|exists:halls,id',
            '*.name' => 'required|string|max:255',
            '*.description' => 'nullable|string',
            '*.start_time' => 'required|date',
            '*.end_time' => 'required|date|after:start_time',
            '*.is_public' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            '*.hall_id.required' => 'Идентификатор зала обязателен.',
            '*.hall_id.exists' => 'Указанный зал не существует.',
            '*.name.required' => 'Название мероприятия обязательно.',
            '*.name.string' => 'Название должно быть строкой.',
            '*.name.max' => 'Название не может превышать 255 символов.',
            '*.description.string' => 'Описание должно быть строкой.',
            '*.start_time.required' => 'Дата начала обязательна.',
            '*.start_time.date' => 'Дата начала должна быть корректной датой.',
            '*.end_time.required' => 'Дата окончания обязательна.',
            '*.end_time.date' => 'Дата окончания должна быть корректной датой.',
            '*.end_time.after' => 'Дата окончания должна быть позже даты начала.',
            '*.is_public.required' => 'Необходимо указать, является ли событие публичным.',
            '*.is_public.boolean' => 'Поле "публичность" должно быть логическим значением (true/false).',
        ];
    }
}


