<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maintenance = Maintenance::first();
        return view('panel.maintenance.index', compact('maintenance'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'text' => 'nullable|string',
            'more_info' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'boolean',
        ]);
        
        $maintenance = Maintenance::create($validatedData);
        
        if($maintenance){
            return redirect()->back()->with('success', 'Manutenção criada com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro ao criar manutenção!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Maintenance $maintenance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Maintenance $maintenance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Maintenance $maintenance)
    {
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'text' => 'nullable|string',
            'more_info' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'boolean',
        ]);
        
        if($maintenance->update($validatedData)){
            return redirect()->back()->with('success', 'Manutenção atualizada com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro ao atualizar manutenção!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maintenance $maintenance)
    {
        if($maintenance->delete()){
            return redirect()->back()->with('success', 'Manutenção removida com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro ao remover manutenção!');
    }
}
