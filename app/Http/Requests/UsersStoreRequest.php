<?php

namespace App\Http\Requests;

class UsersStoreRequest extends UsersRequest
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
            'email' => ['required', 'max:255', 'unique:users,email', 'email'],
            'password' => ['required', 'min:4', 'max:50'],
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
