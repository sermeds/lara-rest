<?php

// app/Http/Requests/StoreTableRequest.php
namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreTableRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'hall_id' => 'required|exists:halls,id',
            'table_number' => 'required|integer|min:1',
            'capacity' => 'required|integer|min:1',
            'is_available' => 'required|boolean',
            'x' => 'required|integer',
            'y' => 'required|integer',
            'base_price' => 'required|integer|min:1',
        ];
    }
}
