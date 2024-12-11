<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            '*.username' => 'required|string|max:255',
            '*.email' => 'required|email|unique:users,email' . $this->route('user'),
            '*.password' => 'nullable|string|min:8',
            '*.phone_number' => 'nullable|string|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            '*.username.required' => 'Имя пользователя обязательно.',
            '*.username.string' => 'Имя пользователя должно быть строкой.',
            '*.username.max' => 'Имя пользователя не может превышать 255 символов.',
            '*.email.required' => 'Электронная почта обязательна.',
            '*.email.email' => 'Введите действительный адрес электронной почты.',
            '*.email.unique' => 'Этот адрес электронной почты уже зарегистрирован.',
            '*.password.string' => 'Пароль должен быть строкой.',
            '*.password.min' => 'Пароль должен содержать не менее 8 символов.',
            '*.phone_number.string' => 'Номер телефона должен быть строкой.',
            '*.phone_number.max' => 'Номер телефона не может превышать 20 символов.',
        ];
    }
}
