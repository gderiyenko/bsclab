<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use PhpOffice\PhpWord\Reader\Word2007;

class ValidDocx implements Rule
{
    public function passes($attribute, $value)
    {
        // сначала попробуем определить тип стандартным способом
        // optional() нужен на случай если в $value передан вообще не файл, а, например, строка
        $mimeType = optional($value)->getMimeType();

        if (!$mimeType) {
            // если нет никакого типа, то это не файл
            return false;
        }

        if ($mimeType == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
            // если тип уже определился как docx, нет нужды применять тяжелую проверку через PHPWord
            return true;
        }

        if ($mimeType != 'application/octet-stream') {
            // Если не octet-stream, то это файл какого-то другого типа
            // например, картинка. Нет нужны проверять через PHPWord.
            return false;
        }

        // проверяем файл через PHPWord
        $doc = new Word2007();

        try {
            $doc->load($value->getRealPath());
        } catch (\Exception $e) {
            return false;
        }

        if ($doc) {
            return true;
        }

        return false;
    }

    public function message()
    {
        return 'Файл повинен бути .docx файлом.';
    }
}
