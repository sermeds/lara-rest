<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBonusPointsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            '*.user_id' => 'sometimes|required|exists:users,id',
            '*.points' => 'sometimes|required|numeric|min:0',
            '*.expired_at' => 'sometimes|required|date',
        ];
    }

    public function messages(): array
    {
        return [
            '*.user_id.exists' => 'Пользователь с таким ID не существует.',
            '*.points.numeric' => 'Бонусные баллы должны быть числом.',
            '*.expired_at.date' => 'Дата истечения должна быть корректной датой.',
        ];
    }
}

