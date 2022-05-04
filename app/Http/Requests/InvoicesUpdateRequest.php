<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class InvoicesUpdateRequest extends InvoicesRequest
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
        return parent::rules() + [
            'invoice.number' => ['required', 'max:255', Rule::unique('invoices', 'number')->ignore($this->input('invoice')['id'])],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return parent::messages();
    }
}
