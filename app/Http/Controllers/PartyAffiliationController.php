<?php

namespace App\Http\Controllers;

use App\Models\PartyAffiliation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PartyAffiliationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $affiliations = PartyAffiliation::all();
        return view('panel.affiliation.index', compact('affiliations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.affiliation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'acronym' => 'nullable',
        ], [
            'name.required' => 'O campo nome é obrigatório.',
        ]);
        $validateData['slug'] = Str::Slug($validateData['name']);

        $legislature = PartyAffiliation::create($validateData);

        if ($legislature) {
            return redirect()->route('affiliations.index')->with('success', 'Partido cadastrado com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro ao cadastrar Partido. Por favor, tente novamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PartyAffiliation $party_affiliation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PartyAffiliation $affiliation)
    {
        return view('panel.affiliation.edit', compact('affiliation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PartyAffiliation $affiliation)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'acronym' => 'nullable',
        ], [
            'name.required' => 'O campo nome é obrigatório.',
        ]);
        $validateData['slug'] = Str::Slug($validateData['name']);

        if ($affiliation->update($validateData)) {
            return redirect()->route('affiliations.index')->with('success', 'Partido atualizado com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro ao atualizar Partido. Por favor, tente novamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PartyAffiliation $affiliation)
    {
        if ($affiliation->delete()) {
            return redirect()->route('affiliations.index')->with('success', 'Partido excluída com sucesso!');
        }

        return redirect()->route('affiliations.index')->with('error', 'Partido não encontrada ou já excluído.');
    }
}
