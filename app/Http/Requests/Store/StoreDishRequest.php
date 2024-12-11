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
            '*.title' => 'required|string|max:255',
            '*.weight' => 'required|integer|min:1',
            '*.cost' => 'required|numeric|min:0',
            '*.image' => 'nullable|url',
            '*.type' => 'required|in:Salads,Snacks,Hot,Deserts,Drinks',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->isJsonArrayValid()) {
                $validator->errors()->add('data', 'The input must be a valid JSON array or a single object.');
            }
        });
    }

    private function isJsonArrayValid(): bool
    {
        return $this->isArray() || $this->keys()->containsOnly(['title', 'weight', 'cost', 'image', 'type']);
    }
}

