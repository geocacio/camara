<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialsProgress;
use App\Models\Session;
use Illuminate\Http\Request;

class MaterialsProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Material $material)
    {
        return view('panel.materials.proceedings.index', compact('material'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Material $material)
    {
        $sessions = Session::with('proceedings', 'proceedings.category')->get();
        return view('panel.materials.proceedings.create', compact('material', 'sessions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Material $material)
    {
        $validateDate = $request->validate([
            'session_id' => 'required|exists:sessions,id',
            'proceeding_id' => 'required|exists:proceedings,id',
            'phase' => 'required|in:leitura,votacao',
            'observations' => 'nullable|string',
        ], [
            'session_id.required' => 'O campo Sessão é obrigatório.',
            'session_id.exists' => 'A sessão selecionada não existe.',
            'proceeding_id.required' => 'O campo Expediente é obrigatório.',
            'proceeding_id.exists' => 'O expediente selecionado não existe.',
            'phase.required' => 'O campo Fase é obrigatório.',
            'phase.in' => 'A Fase selecionada é inválida.',
            'observations.string' => 'As Observações devem ser uma string.',
        ]);

        $progress = $material->progress()->create($validateDate);

        if($progress){
            return redirect()->route('material-proceedings.index',$material->slug)->with('success', 'Progresso cadastrado com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro ao cadastrar progresso');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(MaterialsProgress $material_proceeding)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material, MaterialsProgress $material_proceeding)
    {
        $sessions = Session::with('proceedings', 'proceedings.category')->get();
        return view('panel.materials.proceedings.edit', compact('material_proceeding', 'material', 'sessions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material, MaterialsProgress $material_proceeding)
    {
        $validateDate = $request->validate([
            'session_id' => 'required|exists:sessions,id',
            'proceeding_id' => 'required|exists:proceedings,id',
            'phase' => 'required|in:leitura,votacao',
            'observations' => 'nullable|string',
        ], [
            'session_id.required' => 'O campo Sessão é obrigatório.',
            'session_id.exists' => 'A sessão selecionada não existe.',
            'proceeding_id.required' => 'O campo Expediente é obrigatório.',
            'proceeding_id.exists' => 'O expediente selecionado não existe.',
            'phase.required' => 'O campo Fase é obrigatório.',
            'phase.in' => 'A Fase selecionada é inválida.',
            'observations.string' => 'As Observações devem ser uma string.',
        ]);

        if($material_proceeding->update($validateDate)){
            return redirect()->route('material-proceedings.index',$material->slug)->with('success', 'Progresso atualizado com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro ao atualizar progresso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Material $material, MaterialsProgress $material_proceeding)
    {
        if($material_proceeding->delete()){
            return redirect()->back()->with('success', 'Progresso removido com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro ao remover progresso');
    }
}
