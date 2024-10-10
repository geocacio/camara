<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExportDataRequest;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\User; // Exemplo de modelo
use Maatwebsite\Excel\Facades\Excel; // Para XLS
use Illuminate\Support\Facades\Response; // Para retornar diferentes formatos
use Illuminate\Support\Facades\Storage; // Para salvar arquivos temporariamente
use Barryvdh\Snappy\Facades\SnappyPdf as PDF; // Para PDF
use PhpOffice\PhpSpreadsheet\Spreadsheet; // Para XLS
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; // Para XLSX
use Illuminate\Support\Str;

class DataExportController extends Controller
{
    protected $columns = [
        'Contract' => [
            'columns' => ['number', 'company_id'],
            'relationships' => [
                'company' => ['name', 'cnpj'],
            ]
        ]
    ];

    protected $labels = [
        'User' => ['Nome', 'Email'],
        'Contract' => ['Número do contrato', 'Empresa', 'CNPJ'],
    ];

    protected $page = [
        'Contract' => ['Contratos'],
    ];

    protected $hidden = [
        'Contract' => ['company_id'],
    ];    

    public function index($model = null)
    {
        if (!$model || !array_key_exists($model, $this->columns)) {
            return redirect()->back()->with('error', 'Modelo inválido');
        }

        $modelClass = 'App\\Models\\' . Str::ucfirst($model);
        
        // Criar uma query para buscar as colunas do modelo principal
        $query = $modelClass::select($this->columns[$model]['columns']);
        
        // Verificar se há relacionamentos a serem buscados
        if (isset($this->columns[$model]['relationships'])) {
            foreach ($this->columns[$model]['relationships'] as $relationship => $relationshipColumns) {
                // Usar `with` para buscar o relacionamento e selecionar as colunas necessárias
                $query->with([$relationship => function($query) use ($relationshipColumns) {
                    $query->select(array_merge(['id'], $relationshipColumns)); // Inclua 'id' no select
                }]);
            }
        }

        // Obter os dados com paginação
        $data = $query->paginate(10); // Você pode ajustar o número de itens por página

        $data->transform(function ($item) use ($model) {
            foreach ($this->hidden[$model] as $hiddenColumn) {
                unset($item->$hiddenColumn);
            }
            return $item;
        });

        $labels = $this->labels[$model];
        $page = $this->page[$model];
        $columns = $this->columns[$model];
        $hidden = $this->hidden[$model];

        return view('pages.export.index', compact('data', 'labels', 'page', 'columns', 'model', 'hidden'));
    }

    public function export(ExportDataRequest $request)
    {
        $model = $request->input('model');
        $format = $request->input('format');
    
        $modelClass = 'App\\Models\\' . Str::ucfirst($model);
        if (!class_exists($modelClass)) {
            return response()->json(['error' => 'Model not found'], 404);
        }
    
        // Obtenha todos os dados do modelo e os relacionamentos necessários
        $data = $modelClass::with($this->getRelationships($model))->get();
    
        // Remove as colunas que estão em hidden
        if (isset($this->hidden[$model])) {
            $data->makeHidden($this->hidden[$model]);
        }
    
        // Transforme os dados para incluir apenas as colunas necessárias
        $data = $data->map(function ($item) use ($model) {
            // Converte o item para um array
            $arrayItem = $item->toArray();
    
            // Adiciona os dados dos relacionamentos
            foreach ($this->hidden[$model] as $hiddenColumn) {
                unset($arrayItem[$hiddenColumn]);
            }
    
            return $arrayItem;
        });
    
        switch ($format) {
            case 'xls':
                return $this->exportXls($data);
            case 'csv':
                return $this->exportCsv($data);
            case 'json':
                return response()->json($data);
            case 'text':
                return response()->stream(function () use ($data) {
                    echo $this->convertToText($data);
                }, 200, [
                    'Content-Type' => 'text/plain',
                    'Content-Disposition' => 'attachment; filename="data.txt"',
                ]);
            case 'pdf':
                return $this->exportPdf($data);
            case 'doc':
                return $this->exportDoc($data);
            default:
                return response()->json(['error' => 'Format not supported'], 400);
        }
    }
    
    protected function getRelationships($model)
    {
        if (isset($this->columns[$model]['relationships'])) {
            return array_keys($this->columns[$model]['relationships']);
        }
        return [];
    }
    
    protected function exportXls($data)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Adicione os dados ao XLS
        $sheet->fromArray($data->toArray(), NULL, 'A1');

        $writer = new Xlsx($spreadsheet);
        $filename = 'data.xlsx';

        return response()->stream(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    protected function exportCsv($data)
    {
        $filename = 'data.csv';
        $handle = fopen('php://output', 'w');

        // Adicione cabeçalho ao CSV
        fputcsv($handle, array_keys($data[0]->getAttributes()));

        // Adicione os dados ao CSV
        foreach ($data as $row) {
            fputcsv($handle, $row->toArray());
        }

        fclose($handle);

        return response()->stream(function () use ($filename) {
            // Gera o arquivo
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    // protected function exportPdf($data)
    // {
    //     // Exemplo simples de exportação para PDF
    //     $pdf = PDF::loadView('pdf.template', compact('data'));
    //     return $pdf->download('data.pdf');
    // }

    protected function exportDoc($data)
    {
        // Você pode usar uma biblioteca como PHPWord para gerar documentos DOC
        // Exemplo simplificado:
        return response()->stream(function () use ($data) {
            // Lógica para criar e exportar um documento DOC
        }, 200, [
            'Content-Type' => 'application/msword',
            'Content-Disposition' => 'attachment; filename="data.doc"',
        ]);
    }

    protected function convertToText($data)
    {
        $output = "";
        foreach ($data as $row) {
            $output .= implode("\t", $row->toArray()) . "\n";
        }
        return $output;
    }
}
