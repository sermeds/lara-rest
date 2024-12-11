<?php

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
            '*.hall_id' => 'required|exists:halls,id',
            '*.table_number' => 'required|integer|min:1',
            '*.capacity' => 'required|integer|min:1',
            '*.is_available' => 'required|boolean',
            '*.x' => 'required|integer',
            '*.y' => 'required|integer',
            '*.*base_price' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
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
            '*.y.required' => 'Координата Y обязательна.',
            '*.y.integer' => 'Координата Y должна быть числом.',
            '*.base_price.required' => 'Необходимо указать базовую стоимость.',
            '*.base_price.integer' => 'Базовая стоимость должна быть числом.',
            '*.base_price.min' => 'Базовая стоимость должна быть больше или равна 1.',
        ];
    }
}

