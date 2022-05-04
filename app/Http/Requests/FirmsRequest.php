<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FirmsRequest extends FormRequest
{
    private $taxes = [
        'платник  податку на прибуток на  загальних  підставах',
        'платник єдиного податку з ПДВ',
        'платник єдиного податку без ПДВ',
    ];

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
            'firm_name_short' => ['max:255'],
            'boss_position' => ['max:255'],
            'boss_pib' => ['sometimes', 'nullable', 'max:255'], //, 'regex:/^[А-Я,Ё,Ї,І,Ґ,Є][а-я,ё,ї,і,ґ,є,`,\']{1,}([-][А-Я,Ё,Ї,І,Ґ,Є][а-я,ё,і,ї,ґ,є,`,\']{1,})?\s[А-Я,Ё,Ї,І,Ґ,Є][а-я,ё,ї,і,ґ,є,`,\']{1,}\s[А-Я,Ё,Ї,І,Ґ,Є][а-я,ё,ї,і,ґ,є,`,\']{2,}$/u'],
            'work_position' => ['max:255'],
            'work_pib' => ['sometimes', 'nullable', 'max:255'], //, 'regex:/^[А-Я,Ё,Ї,І,Ґ,Є][а-я,ё,ї,і,ґ,є,`,\']{1,}([-][А-Я,Ё,Ї,І,Ґ,Є][а-я,ё,і,ї,ґ,є,`,\']{1,})?\s[А-Я,Ё,Ї,І,Ґ,Є][а-я,ё,ї,і,ґ,є,`,\']{1,}\s[А-Я,Ё,Ї,І,Ґ,Є][а-я,ё,ї,і,ґ,є,`,\']{2,}$/u'],
            'addr_zip_ur' => ['sometimes', 'nullable', 'regex:/^[0-9]{5}$/'],
            'addr_obl_ur' => ['max:255'],
            'addr_city_ur' => ['max:255'],
            'addr_street_ur' => ['max:255'],
            'addr_house_ur' => ['max:255'],
            'addr_office_ur' => ['max:255'],
            'addr_zip_fact' => ['sometimes', 'nullable', 'regex:/^[0-9]{5}$/'],
            'addr_obl_fact' => ['max:255'],
            'addr_city_fact' => ['max:255'],
            'addr_street_fact' => ['max:255'],
            'addr_house_fact' => ['max:255'],
            'addr_office_fact' => ['max:255'],
            'tax' => ['sometimes', 'nullable', Rule::in($this->taxes)],
            'account_number' => ['max:255'],
            'bank_name' => ['max:255'],
            'bank_mfo' => ['max:255'],
            'phone_shared' => ['max:255'],
            'email_shared' => ['max:255'],
            'phone_acc' => ['max:255'],
            'email_acc' => ['max:255'],
            'phone_work' => ['max:255'],
            'email_work' => ['max:255'],
            'carr_name' => ['max:255'],
            'carr_city' => ['max:255'],
            'carr_dep' => ['max:255'],
            'carr_pib' => ['max:255'],
            'carr_phone' => ['max:255'],
            'note' => ['max:255'],
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
            'firm_name.required' => "Вкажіть назву",
            'firm_name.min' => "Назва має містити принаймні :min символи",
            'firm_name.max' => "Назва не повинна перевищувати :max символів",
            'firm_name.unique' => "Назва вже існує",
            'firm_name_short.max' => "Назва не повинна перевищувати :max символів",
            'boss_position.max' => "Посада керівника не повинна перевищувати :max символів",
            'boss_pib.max' => "ПІБ керівника не повинна перевищувати :max символів",
            'boss_pib.regex' => "Невірний формат прізвища, ім'я та по батькові",
            'work_position.max' => "Посада відповідального за роботи не повинна перевищувати :max символів",
            'work_pib.max' => "ПІБ відповідального за роботи не повинна перевищувати :max символів",
            'work_pib.regex' => "Невірний формат прізвища, ім'я та по батькові",
            'addr_zip_ur.regex' => "Невірний формат поштового індекса",
            'addr_obl_ur.max' => "Область не повинна перевищувати :max символів",
            'addr_city_ur.max' => "Місто (селище, село) не повинно перевищувати :max символів",
            'addr_street_ur.max' => "Вулиця не повинна перевищувати :max символів",
            'addr_house_ur.max' => "Будинок не повинен перевищувати :max символів",
            'addr_office_ur.max' => "Офіс (приміщення) не повинно перевищувати :max символів",
            'addr_zip_fact.regex' => "Невірний формат поштового індекса",
            'addr_obl_fact.max' => "Область не повинна перевищувати :max символів",
            'addr_city_fact.max' => "Місто (селище, село) не повинно перевищувати :max символів",
            'addr_street_fact.max' => "Вулиця не повинна перевищувати :max символів",
            'addr_house_fact.max' => "Будинок не повинен перевищувати :max символів",
            'addr_office_fact.max' => "Офіс (приміщення) не повинно перевищувати :max символів",
            'edrpou.regex' => "Невірний формат коду ЄДРПОУ",
            'edrpou.unique' => "ЄДРПОУ вже існує",
            'ipn.regex' => "Невірний формат ІПН",
            'ipn.unique' => "ІПН вже існує",
            'tax.in' => "Невірна форма оподаткування",
            'account_number.max' => "Номер рахунку не повинен перевищувати :max символів",
            'bank_name.max' => "Назва банку не повинна перевищувати :max символів",
            'bank_mfo.max' => "МФО банку не повинен перевищувати :max символів",
            'phone_shared.max' => "Телефон не повинен перевищувати :max символів",
            'email_shared.max' => "Email не повинен перевищувати :max символів",
            'phone_acc.max' => "Телефон не повинен перевищувати :max символів",
            'email_acc.max' => "Email не повинен перевищувати :max символів",
            'phone_work.max' => "Телефон не повинен перевищувати :max символів",
            'email_work.max' => "Email не повинен перевищувати :max символів",
            'carr_name.max' => "Назва не повинна перевищувати :max символів",
            'carr_city.max' => "Місто не повинно перевищувати :max символів",
            'carr_dep.max' => "Відділення не повинно перевищувати :max символів",
            'carr_pib.max' => "ПІБ отримувача не повинно перевищувати :max символів",
            'carr_phone.max' => "Телефон не повинен перевищувати :max символів",
            'note.max' => "Примітка не повинна перевищувати :max символів",
        ];
    }
}
