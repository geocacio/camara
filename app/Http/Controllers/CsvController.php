<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;

class CsvController extends Controller
{
    public function gerarCSV()
    {
        $dados = User::all();
        $filename = 'relatorio.csv';

        $colunas = Schema::getColumnListing('users');
        // Filtrar as colunas para remover as propriedades extras do modelo
        $colunasFiltradas = array_filter($colunas, function ($coluna) {
            return !str_starts_with($coluna, '*');
        });

        ini_set('auto_detect_line_endings', true);
        $delimiter = ';';

        $output = fopen('php://output', 'w');
        fputcsv($output, $colunasFiltradas, $delimiter);

        foreach ($dados as $item) {
            $dadosFiltrados = [];
            foreach ($colunasFiltradas as $coluna) {
                $dadosFiltrados[] = $item->$coluna;
            }
            fputcsv($output, $dadosFiltrados, $delimiter);
        }

        fclose($output);

        return Response::make('', 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }
}
