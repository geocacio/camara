<?php

namespace App\Http\Requests;

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExportDataRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'format' => 'required|string|in:xls,csv,json,text,pdf,doc',
        ];
    }

    public function messages()
    {
        return [
            'format.in' => 'O formato selecionado não é permitido.',
        ];
    }
}
