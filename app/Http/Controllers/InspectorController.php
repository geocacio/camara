<?php

namespace App\Http\Controllers;

use App\Models\Inspector;
use Illuminate\Http\Request;

class InspectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inspectors = Inspector::all();

        return view('panel.inspectors.index', compact('inspectors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.inspectors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'start_date' => 'required|date',
            'type' => 'required|string',
            'end_date' => 'nullable|date',
        ], [
            'name.required' => 'O nome é obrigatório.',
            'start_date.required' => 'A data de início é obrigatória.',
        ]);

        $request['slug'] = Inspector::uniqSlug($request['name']);

        if(Inspector::create($request->all())){
            return redirect()->route('fiscais.index')->with('success', 'Fiscal criado com sucesso.');
        }

        return redirect()->route('fiscais.index')->with('error', 'Erro ao criar fiscal.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inspector $inspector)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inspector $fiscai)
    {
        return view('panel.inspectors.edit', compact('fiscai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inspector $fiscai)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
        ], [
            'name.required' => 'O nome é obrigatório.',
            'start_date.required' => 'A data de início é obrigatória.',
        ]);

        $fiscai->update($request->all());

        return redirect()->route('fiscais.index')->with('success', 'Fiscal atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inspector $fiscai)
    {
        if($fiscai->delete()){
            return redirect()->route('fiscais.index')->with('success', 'Fiscal removido com sucesso.');
        }

        return redirect()->route('fiscais.index')->with('error', 'Erro ao remover fiscal.');
    }
}
