<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilesStoreRequest extends FormRequest
{
    private $titles = ['statut', 'vypyska', 'vytyah', 'nds', 'nakaz', 'protocol', 'other'];

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
            'title' => ['required', Rule::in($this->titles)],
        ];

        if ($this->get('title') == 'statut') {
            $rules += ['statut' => ['required', 'mimetypes:application/pdf,image/bmp,image/jpeg,image/png,image/gif,image/tiff,image/svg+xml', 'max:10240']];
        } elseif ($this->get('title') == 'vypyska') {
            $rules += ['vypyska' => ['required', 'mimetypes:application/pdf,image/bmp,image/jpeg,image/png,image/gif,image/tiff,image/svg+xml', 'max:10240']];
        } elseif ($this->get('title') == 'vytyah') {
            $rules += ['vytyah' => ['required', 'mimetypes:application/pdf,image/bmp,image/jpeg,image/png,image/gif,image/tiff,image/svg+xml', 'max:10240']];
        } elseif ($this->get('title') == 'nds') {
            $rules += ['nds' => ['required', 'mimetypes:application/pdf,image/bmp,image/jpeg,image/png,image/gif,image/tiff,image/svg+xml', 'max:10240']];
        } elseif ($this->get('title') == 'nakaz') {
            $rules += ['nakaz' => ['required', 'mimetypes:application/pdf,image/bmp,image/jpeg,image/png,image/gif,image/tiff,image/svg+xml', 'max:10240']];
        } elseif ($this->get('title') == 'protocol') {
            $rules += ['protocol' => ['required', 'mimetypes:application/pdf,image/bmp,image/jpeg,image/png,image/gif,image/tiff,image/svg+xml', 'max:10240']];
        } elseif ($this->get('title') == 'other') {
            $rules += ['other' => ['required', 'mimetypes:application/pdf,image/bmp,image/jpeg,image/png,image/gif,image/tiff,image/svg+xml', 'max:10240']];
        } else {
            $rules += ['file' => ['required']];
        }

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
            'title.required' => "Виберіть тип документу",
            'title.in' => "Невідомий тип документу",
            'statut.required' => "Виберіть файл",
            'statut.mimetypes' => "Файл повинен бути зображенням, або форматом pdf",
            'statut.max' => "Розмір файлу не повинен перевищувати 10 МБ",
            'vypyska.required' => "Виберіть файл",
            'vypyska.mimetypes' => "Файл повинен бути зображенням, або форматом pdf",
            'vypyska.max' => "Розмір файлу не повинен перевищувати 10 МБ",
            'vytyah.required' => "Виберіть файл",
            'vytyah.mimetypes' => "Файл повинен бути зображенням, або форматом pdf",
            'vytyah.max' => "Розмір файлу не повинен перевищувати 10 МБ",
            'nds.required' => "Виберіть файл",
            'nds.mimetypes' => "Файл повинен бути зображенням, або форматом pdf",
            'nds.max' => "Розмір файлу не повинен перевищувати 10 МБ",
            'nakaz.required' => "Виберіть файл",
            'nakaz.mimetypes' => "Файл повинен бути зображенням, або форматом pdf",
            'nakaz.max' => "Розмір файлу не повинен перевищувати 10 МБ",
            'protocol.required' => "Виберіть файл",
            'protocol.mimetypes' => "Файл повинен бути зображенням, або форматом pdf",
            'protocol.max' => "Розмір файлу не повинен перевищувати 10 МБ",
            'other.required' => "Виберіть файл",
            'other.mimetypes' => "Файл повинен бути зображенням, або форматом pdf",
            'other.max' => "Розмір файлу не повинен перевищувати 10 МБ",
        ];
    }
}
