<?php

// app/Http/Requests/StoreUserRequest.php
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
        $rules = [
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->route('user'),
            'password' => 'nullable|string|min:8',
            'phone_number' => 'nullable|string|max:20',
            'role' => 'required|in:user,admin,staff',
        ];

        return $rules;
    }
}
