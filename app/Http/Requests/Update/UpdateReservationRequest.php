<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'sometimes|nullable|exists:users,id',
            'table_id' => 'sometimes|nullable|exists:tables,id',
            'hall_id' => 'sometimes|nullable|exists:halls,id',
            'reservation_date' => 'sometimes|required|date',
            'start_time' => 'sometimes|required|date_format:H:i',
            'end_time' => 'sometimes|required|date_format:H:i|after:start_time',
            'status' => 'sometimes|required|string',
            'guests_count' => 'sometimes|required|integer|min:1',
            'special_requests' => 'sometimes|nullable|string',
            'total_price' => 'sometimes|nullable|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.exists' => 'Указанный пользователь не существует.',
            'table_id.exists' => 'Указанный стол не существует.',
            'hall_id.exists' => 'Указанный зал не существует.',

            'reservation_date.required' => 'Дата бронирования обязательна для обновления.',
            'reservation_date.date' => 'Дата бронирования должна быть корректной датой.',

            'start_time.required' => 'Время начала бронирования обязательно для обновления.',
            'start_time.date_format' => 'Время начала должно быть в формате ЧЧ:ММ.',

            'end_time.required' => 'Время окончания бронирования обязательно для обновления.',
            'end_time.date_format' => 'Время окончания должно быть в формате ЧЧ:ММ.',
            'end_time.after' => 'Время окончания должно быть позже времени начала.',

            'status.string' => 'Статус бронирования должен быть строкой.',

            'guests_count.required' => 'Количество гостей обязательно для обновления.',
            'guests_count.integer' => 'Количество гостей должно быть числом.',
            'guests_count.min' => 'Количество гостей должно быть не менее 1.',

            'special_requests.string' => 'Особые пожелания должны быть строкой.',

            'total_price.integer' => 'Итоговая цена должна быть целым числом.',
            'total_price.min' => 'Итоговая цена должна быть больше 0.',
        ];
    }

}

