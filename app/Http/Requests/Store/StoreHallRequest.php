<?php

// app/Http/Requests/StoreHallRequest.php
namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreHallRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'img' => 'nullable|string',
            'schemeImg' => 'nullable|string',
        ];
    }
}

