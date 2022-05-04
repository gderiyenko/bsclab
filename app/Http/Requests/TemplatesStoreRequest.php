<?php

namespace App\Http\Requests;

use App\Rules\ValidDocx;
use Illuminate\Foundation\Http\FormRequest;

class TemplatesStoreRequest extends FormRequest
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
            'name' => ['required', 'max:255'],
            'type' => ['required', 'max:255', 'in:contract,act,invoice'],
            'file' => ['required', 'file'],
            //'file' => ['file', new ValidDocx()],
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
            'name.required' => "Введіть назву",
            'name.max' => "Назва не повинна перевищувати :max символів",
            'type.required' => "Виберіть тип",
            'type.max' => "Тип не повинен перевищувати :max символів",
            'type.in' => "Невірний тип шаблону",
            'file.required' => "Виберіть файл",
            'file.file' => "Виберіть файл",
        ];
    }
}
