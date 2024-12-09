<?php

// app/Http/Requests/StoreBonusPointsRequest.php
namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreBonusPointsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'points' => 'required|integer|min:0',
            'expiration_date' => 'nullable|date|after:today',
        ];
    }


    public function messages(): array
    {
        return [
            'user_id.required' => 'Необходим user_id'
        ];
    }
}
