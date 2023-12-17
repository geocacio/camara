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
        $maintenances = Maintenance::all();
        return view('panel.maintenance.index', compact('maintenances'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.maintenance.create');
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
            return redirect()->route('maintenance.index')->with('success', 'Manutenção criada com sucesso!');
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
        return view('panel.maintenance.edit', compact('maintenance'));
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
            return redirect()->route('maintenance.index')->with('success', 'Manutenção atualizada com sucesso!');
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
        return redirect()->back()->with('error', 'Erro ao remover Manutenção!');
    }
    
    public function visibility(Request $request)
    {
        $maintenance = Maintenance::find($request->id);

        $status = ($request->visibility == 'disabled') ? 0 : 1;
    
        if (!$maintenance->update(['status' => $status])) {
            return response()->json(['error' => true, 'message' => 'Erro, Por favor, tente novamente!']);
        }
    
        $message = $status == 1 ? 'Manutenção ativado com sucesso' : 'Manutenção desativado com sucesso';
        return response()->json(['success' => true, 'message' => $message]);
    }
    
    
}
