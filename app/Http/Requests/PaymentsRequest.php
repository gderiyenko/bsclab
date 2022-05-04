<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentsRequest extends FormRequest
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
            //'date' => ['required', 'date', 'before_or_equal:' . date('Y-m-d')],
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'between:0,999999999999.99'],
            'invoice_id' => ['required', 'exists:invoices,id'],
            'description' => ['max:255'],
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
            'date.required' => "Введіть дату",
            'date.date' => "Невірний формат дати",
            //'date.before_or_equal' => "Дата не повинна перевищувати поточну дату",
            'amount.required' => "Введіть суму",
            'amount.numeric' => "Сума повинна бути числом",
            'amount.between' => "Невірна сума",
            'invoice_id.required' => "Виберіть рахунок",
            'invoice_id.in' => "Невідомий рахунок",
            'description.max' => "Замітка не повинна перевищувати :max символів",
        ];
    }
}
