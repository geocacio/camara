<?php

namespace App\Http\Controllers;

use App\Models\Glossary;
use Illuminate\Http\Request;

class GlossaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $glossarys = Glossary::get();

        return view('panel.glossary.index', compact('glossarys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.glossary.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ], [
           'title.required' => 'O campo titulo é obrigatorio', 
           'description.required' => 'O campo descrição é obrigatorio' 
        ]);

        $validateData['slug'] = Glossary::uniqSlug($validateData['title']);

        $glossary = Glossary::create($validateData);

        if($glossary){
            return redirect()->route('glossary.index')->with('success', 'Glossário cadastrado com sucesso!');
        }
        return redirect()->back()->with('error', 'Por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Glossary $glossary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Glossary $glossary)
    {
        return view('panel.glossary.edit', compact('glossary'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Glossary $glossary)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ], [
           'title.required' => 'O campo titulo é obrigatorio', 
           'description.required' => 'O campo descrição é obrigatorio' 
        ]);

        $validateData['slug'] = Glossary::uniqSlug($validateData['title']);

        if($glossary->update($validateData)){
            return redirect()->route('glossary.index')->with('success', 'Glossário atualizado com sucesso!');
        }
        return redirect()->back()->with('error', 'Por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Glossary $glossary)
    {
        if($glossary->delete()){
            return redirect()->back()->with('success', 'Glossário excluido com sucesso');
        }
        return redirect()->back()->with('error', 'Por favor tente novamente');
    }
}
