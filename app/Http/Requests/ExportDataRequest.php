<?php

namespace App\Http\Requests;

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExportDataRequest extends FormRequest
{
    // Defina os modelos permitidos
    protected $allowedModels = [
        'User',
        'Product',
        'Contract',
        // Adicione outros modelos permitidos aqui
    ];

    public function authorize()
    {
        return true; // Ajuste conforme necessário para sua lógica de autorização
    }

    public function rules()
    {
        return [
            'model' => 'required|string|in:' . implode(',', $this->allowedModels),
            'format' => 'required|string|in:xls,csv,json,text,pdf,doc', // formatos permitidos
        ];
    }

    public function messages()
    {
        return [
            'model.in' => 'O modelo selecionado não é permitido.',
            'columns.*.in' => 'Uma ou mais colunas selecionadas não são permitidas para o modelo.',
            'format.in' => 'O formato selecionado não é permitido.',
        ];
    }
}
