<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoicesRequest extends FormRequest
{
    protected $messages = [];

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
            //'invoice.date' => ['required', 'date', 'before_or_equal:' . date('Y-m-d')],
            'invoice.date' => ['required', 'date'],
            'invoice.firm_id' => ['required', 'exists:firms,id'],
            //'invoice.contract_id' => ['required', 'exists:contracts,id'],
            'invoice.contract_id' => ['sometimes', 'nullable', 'exists:contracts,id'],
            'invoice.payment_type' => ['required', 'in:all,partial'],
            'invoice.amount' => ['required', 'numeric', 'between:0,999999999999.99'],
            'invoice.amount_text' => ['required', 'max:255'],
            'invoice.pdv' => ['required', 'numeric', 'between:0,999999999999.99'],
            'invoice.pdv_text' => ['required', 'max:255'],
            'invoice.pdv_minus' => ['required', 'numeric', 'between:0,999999999999.99'],
            'invoice.pdv_minus_text' => ['required', 'max:255'],
            'invoiceServices.*.service_id' => ['required', 'exists:services,id'],
            'invoiceServices.*.service_quantity' => ['required', 'integer', 'between:1,10000'],
            'invoiceServices.*.service_price' => ['required', 'numeric', 'between:0,999999999999.99'],
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
        foreach ($this->get('invoiceServices') as $invoiceServiceKey => $invoiceServiceValue) {
            $this->messages['invoiceServices.' . $invoiceServiceKey . '.service_id.required'] = "Виберіть послугу.";
            $this->messages['invoiceServices.' . $invoiceServiceKey . '.service_id.in'] = "Невідома послуга.";
            $this->messages['invoiceServices.' . $invoiceServiceKey . '.service_quantity.required'] = "Вкажіть кількість.";
            $this->messages['invoiceServices.' . $invoiceServiceKey . '.service_quantity.integer'] = "Кількість повинна бути цілим числом.";
            $this->messages['invoiceServices.' . $invoiceServiceKey . '.service_quantity.between'] = "Кількість повинна бути більше :min та менше :max.";
            $this->messages['invoiceServices.' . $invoiceServiceKey . '.service_price.required'] = "Вкажіть ціну.";
            $this->messages['invoiceServices.' . $invoiceServiceKey . '.service_price.numeric'] = "Ціна повинна бути числом.";
            $this->messages['invoiceServices.' . $invoiceServiceKey . '.service_price.between'] = "Зменьшить ціну.";
        }

        $this->messages += [
            'invoice.number.required' => "Вкажіть номер рахунку",
            'invoice.number.max' => "Номер рахунку не повинен перевищувати :max символів",
            'invoice.number.unique' => "Такий номер рахунку вже існує",
            'invoice.date.required' => "Вкажіть дату",
            'invoice.date.date' => "Невірний формат дати",
            //'invoice.date.before_or_equal' => "Дата не повинна перевищувати поточну дату",
            'invoice.firm_id.required' => "Виберіть контрагента",
            'invoice.firm_id.in' => "Невідомий контрагент",
            //'invoice.contract_id.required' => "Виберіть договір",
            'invoice.contract_id.in' => "Невідомий договір",
            'invoice.payment_type.required' => "Виберіть вид оплати",
            'invoice.payment_type.in' => "Невірний вид оплати",
            'invoice.amount.required' => "Сума не зазначена",
            'invoice.amount.numeric' => "Сума повинна бути числом",
            'invoice.amount.between' => "Невірна сума",
            'invoice.amount_text.required' => "Вкажіть суму текстом",
            'invoice.amount_text.max' => "Сума не повинна перевищувати :max символів",
            'invoice.pdv.required' => "Сума не зазначена",
            'invoice.pdv.numeric' => "Сума повинна бути числом",
            'invoice.pdv.between' => "Невірна сума",
            'invoice.pdv_text.required' => "Вкажіть суму текстом",
            'invoice.pdv_text.max' => "Сума не повинна перевищувати :max символів",
            'invoice.pdv_minus.required' => "Сума не зазначена",
            'invoice.pdv_minus.numeric' => "Сума повинна бути числом",
            'invoice.pdv_minus.between' => "Невірна сума",
            'invoice.pdv_minus_text.required' => "Вкажіть суму текстом",
            'invoice.pdv_minus_text.max' => "Сума не повинна перевищувати :max символів",
        ];

        return $this->messages;
    }
}
