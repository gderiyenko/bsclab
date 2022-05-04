<?php

namespace App\Http\Requests;

class ActsStoreRequest extends ActsRequest
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
            'number' => ['required', 'max:255', 'unique:acts,number'],
            'invoice_id' => ['required', 'max:255', 'exists:invoices,id', 'unique:acts,invoice_id'],
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
