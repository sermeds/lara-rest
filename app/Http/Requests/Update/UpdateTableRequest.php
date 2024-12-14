<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTableRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            '*.id' => 'required|exists:tables,id',
            '*.hall_id' => 'sometimes|required|exists:halls,id',
            '*.table_number' => 'sometimes|required|integer|min:1',
            '*.capacity' => 'sometimes|required|integer|min:1',
            '*.is_available' => 'sometimes|required|boolean',
            '*.x' => 'sometimes|required|integer',
            '*.y' => 'sometimes|required|integer',
            '*.base_price' => 'sometimes|required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            '*.id.required' => 'ID стола обязателен.',
            '*.id.exists' => 'Указанный стол не существует.',
            '*.hall_id.required' => 'Необходимо указать зал.',
            '*.hall_id.exists' => 'Выбранный зал не существует.',
            '*.table_number.required' => 'Номер стола обязателен.',
            '*.table_number.integer' => 'Номер стола должен быть числом.',
            '*.table_number.min' => 'Номер стола должен быть больше или равен 1.',
            '*.capacity.required' => 'Необходимо указать вместимость стола.',
            '*.capacity.integer' => 'Вместимость должна быть числом.',
            '*.capacity.min' => 'Вместимость должна быть больше или равна 1.',
            '*.is_available.required' => 'Укажите, доступен ли стол.',
            '*.is_available.boolean' => 'Значение доступности должно быть логическим (true или false).',
            '*.x.required' => 'Координата X обязательна.',
            '*.x.integer' => 'Координата X должна быть числом.',
            'y.required' => 'Координата Y обязательна.',
            '*.y.integer' => 'Координата Y должна быть числом.',
            '*.base_price.required' => 'Необходимо указать базовую стоимость.',
            '*.base_price.integer' => 'Базовая стоимость должна быть числом.',
            '*.base_price.min' => 'Базовая стоимость должна быть больше или равна 1.',
        ];
    }
}
