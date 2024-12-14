<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            '*.id' => 'required|exists:users,id',
            '*.username' => 'sometimes|required|string|max:255',
            '*.email' => 'sometimes|required|email|unique:users,email,' . $this->route('user'),
            '*.password' => 'sometimes|nullable|string|min:8',
            '*.phone_number' => 'sometimes|nullable|string|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            '*.id.required' => 'ID пользователя обязателен.',
            '*.id.exists' => 'Указанный пользователь не существует.',
            '*.username.sometimes' => 'Имя пользователя требуется, если указано.',
            '*.username.required' => 'Имя пользователя обязательно.',
            '*.username.string' => 'Имя пользователя должно быть строкой.',
            '*.username.max' => 'Имя пользователя не может превышать 255 символов.',
            '*.email.sometimes' => 'Электронная почта требуется, если указана.',
            '*.email.required' => 'Электронная почта обязательна.',
            '*.email.email' => 'Введите действительный адрес электронной почты.',
            '*.email.unique' => 'Этот адрес электронной почты уже зарегистрирован.',
            '*.password.sometimes' => 'Пароль требуется, если указан.',
            '*.password.string' => 'Пароль должен быть строкой.',
            '*.password.min' => 'Пароль должен содержать не менее 8 символов.',
            '*.phone_number.sometimes' => 'Номер телефона требуется, если указан.',
            '*.phone_number.string' => 'Номер телефона должен быть строкой.',
            '*.phone_number.max' => 'Номер телефона не может превышать 20 символов.',
        ];
    }
}


