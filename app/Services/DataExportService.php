<?php

namespace App\Services;

use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DataExportService
{
    protected $columns;

    public function __construct(array $columns)
    {
        $this->columns = $columns;
    }

    public function export($data, $format)
    {
        $data = $data;

        switch ($format) {
            case 'xls':
                return $this->exportXls($data, $this->columns);
            case 'csv':
                return $this->exportCsv($data, $this->columns);
            case 'pdf':
                return $this->exportPdf($data, $this->columns);
            case 'json':
                return $this->exportJson($data);
            case 'txt':
                return $this->convertToText($data);
            default:
                throw new \Exception('Format not supported');
        }
    }

    protected function exportXls($data, $columns)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Adiciona os nomes das colunas na primeira linha
        $sheet->fromArray([$columns], NULL, 'A1');
        
        // Adiciona os dados a partir da segunda linha
        $sheet->fromArray($data, NULL, 'A2');  // Removido o toArray()
    
        $writer = new Xlsx($spreadsheet);
    
        return response()->stream(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="data.xlsx"',
        ]);
    }
    

    protected function exportCsv($data, $columns)
    {
        $filename = 'data.csv';
        $handle = fopen('php://output', 'w');

        // Adiciona os nomes das colunas como cabeçalho
        fputcsv($handle, $columns);

        foreach ($data as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        return response()->stream(function () use ($filename) {
            // Gera o arquivo
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    protected function exportPdf($data, $columns)
    {
        $pdf = PDF::loadView('pdf.export.index', ['data' => $data, 'columns' => $columns]);
        return $pdf->download('data.pdf');
    }

    protected function exportJson($data)
    {
        return response()->json(['data' => $data]);
    }

    protected function convertToText($data)
    {
        return implode("\n", $data->toArray());
    }
}
