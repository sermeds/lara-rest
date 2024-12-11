<?php

// app/Http/Requests/StoreReservationRequest.php
namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'nullable|exists:users,id',
            'table_id' => 'nullable|exists:tables,id',
            'hall_id' => 'nullable|exists:halls,id',
            'reservation_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'status' => 'nullable|string',
            'guests_count' => 'required|integer|min:1',
            'special_requests' => 'nullable|string',
            'guest_name' => 'required_without:user_id|string|max:255',
            'guest_phone' => 'required_without:user_id|string|max:15',
            'total_price' => 'nullable|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.exists' => 'Указанный пользователь не существует.',
            'table_id.exists' => 'Указанный стол не существует.',
            'hall_id.exists' => 'Указанный зал не существует.',

            'reservation_date.required' => 'Дата бронирования обязательна.',
            'reservation_date.date' => 'Дата бронирования должна быть корректной датой.',

            'start_time.required' => 'Время начала бронирования обязательно.',
            'start_time.date_format' => 'Время начала должно быть в формате ЧЧ:ММ.',

            'end_time.required' => 'Время окончания бронирования обязательно.',
            'end_time.date_format' => 'Время окончания должно быть в формате ЧЧ:ММ.',
            'end_time.after' => 'Время окончания должно быть позже времени начала.',

            'status.string' => 'Статус бронирования должен быть строкой.',

            'guests_count.required' => 'Количество гостей обязательно.',
            'guests_count.integer' => 'Количество гостей должно быть числом.',
            'guests_count.min' => 'Количество гостей должно быть не менее 1.',

            'special_requests.string' => 'Особые пожелания должны быть строкой.',

            'guest_name.required_without' => 'Имя гостя обязательно, если не указан пользователь.',
            'guest_name.string' => 'Имя гостя должно быть строкой.',
            'guest_name.max' => 'Имя гостя не должно превышать 255 символов.',

            'guest_phone.required_without' => 'Телефон гостя обязателен, если не указан пользователь.',
            'guest_phone.string' => 'Телефон гостя должен быть строкой.',
            'guest_phone.max' => 'Телефон гостя не должен превышать 15 символов.',

            'total_price.integer' => 'Итоговая цена должна быть целым числом.',
            'total_price.min' => 'Итоговая цена должна быть больше 0.',
        ];
    }

}

