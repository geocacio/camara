<?php

namespace App\Http\Controllers;

use App\Models\Construction;
use App\Models\GeneralProgress;
use Illuminate\Http\Request;

class ConstructionProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Construction $construction)
    {
        return view('panel.construction.situation.index', compact('construction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Construction $construction)
    {
        return view('panel.construction.situation.create', compact('construction'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Construction $construction)
    {
        $validateData = $request->validate(
            [
                'date' => 'required',
                'situation' => 'required',
            ],
            [
                'date.required' => 'O campo data é obrigatório',
                'situation.required' => 'O campo situação é obrigatório',
            ]
        );

        if($construction->generalProgress()->create($validateData)){
            return redirect()->route('constructions.progress.index', $construction->slug)->with('success', 'Progresso cadastrado com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Construction $construction, GeneralProgress $progress)
    {
        return view('panel.construction.situation.edit', compact('progress', 'construction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Construction $construction, GeneralProgress $progress)
    {
        $validateData = $request->validate(
            [
                'date' => 'required',
                'situation' => 'required',
            ],
            [
                'date.required' => 'O campo data é obrigatório',
                'situation.required' => 'O campo situação é obrigatório',
            ]
        );

        if($progress->update($validateData)){
            return redirect()->route('constructions.progress.index', $construction->slug)->with('success', 'Progresso atualizado com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Construction $construction, GeneralProgress $progress)
    {
        if($progress->delete()){
            return redirect()->route('constructions.progress.index', $construction->slug)->with('success', 'Progresso removido com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro, por favor tente novamente!');
    }
}
