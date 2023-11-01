<?php

namespace App\Http\Controllers;

use App\Models\Construction;
use App\Models\ConstructionMeasurements;
use Illuminate\Http\Request;

class ConstructionMeasurementsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Construction $construction)
    {
        return view('panel.construction.measurements.index', compact('construction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Construction $construction)
    {
        return view('panel.construction.measurements.create', compact('construction'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Construction $construction, Request $request)
    {
        $validateData = $request->validate([
            "responsible_execution" => "required",
            "responsible_supervision" => "required",
            "folder_manager" => "required",
            "first_date" => "required|date",
            "end_date" => "required|date",
            "situation" => "required",
            "invoice" => "required|integer",
            "invoice_date" => "required|date",
            "price" => "required",
        ], [
            "responsible_execution.required" => "O campo Responsável pela Execução é obrigatório.",
            "responsible_supervision.required" => "O campo Responsável pela Fiscalização é obrigatório.",
            "folder_manager.required" => "O campo Responsável pela Pasta é obrigatório.",
            "first_date.required" => "O campo Período Inicial é obrigatório.",
            "first_date.date" => "O campo Período Inicial deve ser uma data válida.",
            "end_date.required" => "O campo Período Final é obrigatório.",
            "end_date.date" => "O campo Período Final deve ser uma data válida.",
            "situation.required" => "O campo Situação é obrigatório.",
            "invoice.required" => "O campo Nota Fiscal é obrigatório.",
            "invoice.integer" => "O campo Nota Fiscal deve ser um número inteiro.",
            "invoice_date.required" => "O campo Data da Nota Fiscal é obrigatório.",
            "invoice_date.date" => "O campo Data da Nota Fiscal deve ser uma data válida.",
            "price.required" => "O campo Valor é obrigatório.",
        ]);
        
        if (strpos($request->price, 'R$') !== false) {
            $validateData['price'] = $request->price ? str_replace(['R$', '.', ','], ['', '', '.'], $request->price) : null;
        }
        $validateData['slug'] = ConstructionMeasurements::uniqSlugByYearId();
        
        $constructionMeasurements = $construction->measurements()->create($validateData);
        if($constructionMeasurements){
            
            return redirect()->route('measurements.index', $construction->slug)->with('success', 'Medição cadastrada com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro, por favor tente novamente!');

    }

    /**
     * Display the specified resource.
     */
    public function show(ConstructionMeasurements $constructionMeasurements)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Construction $construction, ConstructionMeasurements $measurement)
    {
        return view('panel.construction.measurements.edit', compact('construction', 'measurement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Construction $construction, ConstructionMeasurements $measurement)
    {
        $validateData = $request->validate([
            "responsible_execution" => "required",
            "responsible_supervision" => "required",
            "folder_manager" => "required",
            "first_date" => "required|date",
            "end_date" => "required|date",
            "situation" => "required",
            "invoice" => "required|integer",
            "invoice_date" => "required|date",
            "price" => "required",
        ], [
            "responsible_execution.required" => "O campo Responsável pela Execução é obrigatório.",
            "responsible_supervision.required" => "O campo Responsável pela Fiscalização é obrigatório.",
            "folder_manager.required" => "O campo Responsável pela Pasta é obrigatório.",
            "first_date.required" => "O campo Período Inicial é obrigatório.",
            "first_date.date" => "O campo Período Inicial deve ser uma data válida.",
            "end_date.required" => "O campo Período Final é obrigatório.",
            "end_date.date" => "O campo Período Final deve ser uma data válida.",
            "situation.required" => "O campo Situação é obrigatório.",
            "invoice.required" => "O campo Nota Fiscal é obrigatório.",
            "invoice.integer" => "O campo Nota Fiscal deve ser um número inteiro.",
            "invoice_date.required" => "O campo Data da Nota Fiscal é obrigatório.",
            "invoice_date.date" => "O campo Data da Nota Fiscal deve ser uma data válida.",
            "price.required" => "O campo Valor é obrigatório.",
        ]);
        
        if (strpos($request->price, 'R$') !== false) {
            $validateData['price'] = $request->price ? str_replace(['R$', '.', ','], ['', '', '.'], $request->price) : null;
        }

        if($measurement->update($validateData)){
            return redirect()->route('measurements.index', $construction->slug)->with('success', 'Medição atualizada com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Construction $construction, ConstructionMeasurements $measurement)
    {
        if($measurement->delete()){
            return redirect()->route('measurements.index', $construction->slug)->with('success', 'Medição removida com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro, por favor tente novamente!');
    }
}
