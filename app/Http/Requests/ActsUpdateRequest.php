<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class ActsUpdateRequest extends ActsRequest
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
            'number' => ['required', 'max:255', Rule::unique('acts')->ignore($this->input('id'))],
            'invoice_id' => ['required', 'max:255', 'exists:invoices,id', Rule::unique('acts')->ignore($this->input('id'))],
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
