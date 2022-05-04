<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'firm_id' => ['required', 'exists:firms,id'],
            //'date_contract' => ['required', 'date', 'before_or_equal:' . date('Y-m-d')],
            'date_contract' => ['required', 'date'],
            'date_end' => ['required', 'date', 'after:' . $this->get('date_contract')],
            'amount' => ['sometimes', 'nullable', 'numeric', 'between:0,999999999999.99'],
            'note' => ['max:255'],
        ];

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'number.required' => "Вкажіть номер договору",
            'number.max' => "Номер договору не повинен перевищувати :max символів",
            'number.unique' => "Такий номер договору вже існує",
            'date_contract.required' => "Вкажіть дату",
            'date_contract.date' => "Невірний формат дати",
            //'date_contract.before_or_equal' => "Дата не повинна перевищувати поточну дату",
            'date_end.required' => "Вкажіть дату",
            'date_end.date' => "Невірний формат дати",
            'date_end.after' => "Дата повинна перевищувати дату договору",
            'amount.numeric' => "Сума повинна бути числом",
            'amount.between' => "Невірна сума",
            'note.max' => "Примітка не повинна перевищувати :max символів",
        ];
    }
}
