<?php

// app/Http/Requests/StoreDishRequest.php
namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreDishRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'weight' => 'required|integer|min:1',
            'cost' => 'required|numeric|min:0',
            'image' => 'nullable|url',
            'type' => 'required|in:Salads,Snacks,Hot,Deserts,Drinks',
        ];
    }
}
