<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeedbackRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'sometimes|required|exists:users,id',
            'rating' => 'sometimes|required|integer|min:1|max:5',
            'comment' => 'sometimes|required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Идентификатор пользователя обязателен.',
            'user_id.exists' => 'Указанный пользователь не существует.',

            'rating.required' => 'Рейтинг обязателен.',
            'rating.integer' => 'Рейтинг должен быть целым числом.',
            'rating.min' => 'Рейтинг не может быть ниже 1.',
            'rating.max' => 'Рейтинг не может быть выше 5.',

            'comment.string' => 'Комментарий должен быть строкой.',
        ];
    }

}

