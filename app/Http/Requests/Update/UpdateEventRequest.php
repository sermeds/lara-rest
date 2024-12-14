<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            '*.id' => 'required|exists:events,id',
            '*.hall_id' => 'sometimes|required|exists:halls,id',
            '*.name' => 'sometimes|required|string|max:255',
            '*.description' => 'sometimes|nullable|string',
            '*.start_time' => 'sometimes|required|date',
            '*.end_time' => 'sometimes|required|date|after:start_time',
            '*.is_public' => 'sometimes|required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            '*.id.required' => 'ID события обязателен.',
            '*.id.exists' => 'Указанное событие не существует.',
            '*.hall_id.exists' => 'Указанный зал не существует.',
            '*.name.string' => 'Название должно быть строкой.',
            '*.name.max' => 'Название не может превышать 255 символов.',
            '*.description.string' => 'Описание должно быть строкой.',
            '*.start_time.date' => 'Дата начала должна быть корректной датой.',
            '*.end_time.date' => 'Дата окончания должна быть корректной датой.',
            '*.end_time.after' => 'Дата окончания должна быть позже даты начала.',
            '*.is_public.boolean' => 'Поле "публичность" должно быть логическим значением (true/false).',
        ];
    }
}


