<?php

// app/Http/Requests/StorePromotionRequest.php
namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StorePromotionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:promotions,name,' . $this->route('promotion'),
            'description' => 'nullable|string',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'hall_id' => 'nullable|exists:halls,id',
            'is_active' => 'required|boolean',
        ];
    }
}
