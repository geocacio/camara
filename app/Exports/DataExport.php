<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataExport implements FromCollection, WithHeadings
{
    protected $data;
    protected $columnMappings = [];

    public function __construct(array $data, $type)
    {
        $this->data = $data;
        $this->setColumnMappings($type);
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return $this->columnMappings;
    }

    private function setColumnMappings($type)
    {
        switch ($type) {
            case 'lrf':
                $this->columnMappings = [
                    'Título',
                    'Data',
                    'Detalhes',
                ];
                break;
            case 'licitacoes':
                $this->columnMappings = [
                    'Número',
                    'Data de abertura',
                    'Status',
                    'Valor estimado',
                    'Descrição',
                    'Endereço',
                    'Cidade',
                    'Estado',
                    'País',
                ];
                break;
            case 'contratos':
                $this->columnMappings = [
                    'Número do contrato',
                    'data inicial',
                    'data final',
                    'valor total',
                    'descrição',
                    'id da empresa',
                    'Empresa',
                ];
                break;
            case 'veiculos':
                $this->columnMappings = [
                    'Situação',
                    'Modelo',
                    'Marca',
                    'Placa',
                    'Renavam',
                    'Ano',
                    'Doação?',
                    'Tipo',
                    'Propósito do véiculo',
                    'Descrição',
                    'Periodo',
                ];
                break;
            case 'decretos-municipais':
                $this->columnMappings = [
                    'Número',
                    'Data',
                    'Descrição',
                    'id do exercicio',
                ];
                break;
            case 'publicacoes':
                $this->columnMappings = [
                    'Título',
                    'Número',
                    'Descrição',
                    'id do exercicio',
                ];
                break;
            case 'portarias':
                $this->columnMappings = [
                    'Número',
                    'Data',
                    'Agente',
                    'Detalhes',
                ];
                break;
            case 'diarias':
                $this->columnMappings = [
                    'Número',
                    'Data',
                    'Agente',
                    'Preço unitário',
                    'Quant',
                    'Valor Total',
                    'Justificativa',
                ];
                break;
        }
    }
}
