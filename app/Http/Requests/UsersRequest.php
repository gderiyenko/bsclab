<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
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
            'name' => ['required', 'min:2', 'max:50'],
            'role' => ['required', 'in:admin,worker,accountant'],
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
            'name.required' => "Вкажіть ім'я",
            'name.min' => "Ім'я має містити принаймні :min символи",
            'name.max' => "Ім'я не повинно перевищувати :max символів",
            'email.required' => "Вкажіть email",
            'email.max' => "Email не повинен перевищувати :max символів",
            'email.unique' => "Такий Email вже існує",
            'email' => "Email повинен бути дійсною електронною адресою",
            'password.required' => "Вкажіть пароль",
            'password.min' => "Пароль має містити принаймні :min символи",
            'password.max' => "Пароль не повинен перевищувати :max символів",
            'password.confirmed' => "Паролі не співпадають",
            'role.required' => "Вкажіть роль користувача",
            'role.in' => "Роль повинна бути 'працівник', 'бухгалтер', або 'адміністратор'",
            'status.required' => "Вкажіть статус",
            'status.in' => "Статус повинен бути 'Активний',  або 'Заблокований'",
        ];
    }
}
