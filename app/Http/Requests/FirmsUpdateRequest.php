<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class FirmsUpdateRequest extends FirmsRequest
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
            'firm_name' => ['required', 'min:3', 'max:255', Rule::unique('firms')->ignore($this->input('id'))],
            'edrpou' => ['sometimes', 'nullable', 'regex:/^[0-9]{8}$/', Rule::unique('firms')->ignore($this->input('id'))],
            'ipn' => ['sometimes', 'nullable', 'regex:/^[0-9]{9,12}$/', Rule::unique('firms')->ignore($this->input('id'))],
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
