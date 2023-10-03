<?php

namespace App\Http\Controllers;

use App\Models\Legislature;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LegislatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $legislatures = Legislature::all();
        return view('panel.legislature.index', compact('legislatures'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.legislature.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ], [
            'start_date.required' => 'O campo data de início é obrigatório.',
            'start_date.date' => 'O campo data de início deve ser uma data válida.',
            'end_date.required' => 'O campo data de término é obrigatório.',
            'end_date.date' => 'O campo data de término deve ser uma data válida.',
        ]);
        $validateData['slug'] = Str::Slug($validateData['start_date'] . '-' . $validateData['end_date']);

        $legislature = Legislature::create($validateData);

        if ($legislature) {
            return redirect()->route('legislatures.index')->with('success', 'Legislatura cadastrado com sucesso!');
        }

        return redirect()->route('legislatures.create')->with('error', 'Erro ao cadastrar Legislatura. Por favor, tente novamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Legislature $legislature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Legislature $legislature)
    {
        return view('panel.legislature.edit', compact('legislature'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Legislature $legislature)
    {
        $validateData = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ], [
            'start_date.required' => 'O campo data de início é obrigatório.',
            'start_date.date' => 'O campo data de início deve ser uma data válida.',
            'end_date.required' => 'O campo data de término é obrigatório.',
            'end_date.date' => 'O campo data de término deve ser uma data válida.',
        ]);

        if ($legislature->update($validateData)) {
            return redirect()->route('legislatures.index')->with('success', 'Legislatura atualizada com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro ao atualizar Legislatura. Por favor, tente novamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Legislature $legislature)
    {
        if ($legislature->delete()) {
            return redirect()->route('legislatures.index')->with('success', 'Legislatura excluída com sucesso!');
        }

        return redirect()->route('legislatures.index')->with('error', 'Legislatura não encontrada ou já excluída.');
    }
}
