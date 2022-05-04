<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActsRequest extends FormRequest
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
            //'protocol_date' => ['required', 'date', 'before_or_equal:' . date('Y-m-d')],
            'protocol_date' => ['required', 'date'],
            //'date' => ['required', 'date', 'before_or_equal:' . date('Y-m-d'), 'same:protocol_date'],
            'date' => ['required', 'date', 'same:protocol_date'],
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
            'number.required' => "Вкажіть номер акту",
            'number.max' => "Номер акту не повинен перевищувати :max символів",
            'number.unique' => "Такий номер акту вже існує",
            'invoice_id.required' => "Виберіть рахунок",
            'invoice_id.in' => "Невідомий рахунок",
            'invoice_id.unique' => "Акт з таким номером рахунку вже існує",
            'protocol_date.required' => "Вкажіть дату",
            'protocol_date.date' => "Невірний формат дати",
            //'protocol_date.before_or_equal' => "Дата не повинна перевищувати поточну дату",
            'date.required' => "Вкажіть дату",
            'date.date' => "Невірний формат дати",
            //'date.before_or_equal' => "Дата не повинна перевищувати поточну дату",
            'date.same' => "Дата акту повинна співпадати з датою протоколу",
        ];
    }
}
