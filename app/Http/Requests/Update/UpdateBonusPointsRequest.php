<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBonusPointsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'sometimes|required|exists:users,id',
            'points' => 'sometimes|required|numeric|min:0',
            'expired_at' => 'sometimes|required|date',
        ];
    }
}

