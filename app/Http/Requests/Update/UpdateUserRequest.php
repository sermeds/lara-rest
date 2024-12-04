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
            'username' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $this->route('user'),
            'password' => 'sometimes|nullable|string|min:8',
            'phone_number' => 'sometimes|nullable|string|max:20',
            'role' => 'sometimes|required|in:client,admin,staff',
        ];
    }
}

