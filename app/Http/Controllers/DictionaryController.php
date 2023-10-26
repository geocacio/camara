<?php

namespace App\Http\Controllers;

use App\Models\Dictionary;
use Illuminate\Http\Request;

class DictionaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dicionaries = Dictionary::all();

        return view('panel.dictionary.index', compact('dicionaries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.dictionary.create');
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

        $validateData['slug'] = Dictionary::uniqSlug($validateData['title']);

        $dictionary = Dictionary::create($validateData);

        if($dictionary){
            return redirect()->route('dictionary.index')->with('success', 'Dicionário cadastrado com sucesso!');
        }
        return redirect()->back()->with('error', 'Por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dictionary $dictionary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dictionary $dictionary)
    {
        return view('panel.dictionary.edit', compact('dictionary'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dictionary $dictionary)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ], [
           'title.required' => 'O campo titulo é obrigatorio', 
           'description.required' => 'O campo descrição é obrigatorio' 
        ]);

        if($dictionary->update($validateData)){
            return redirect()->route('dictionary.index')->with('success', 'Dicionário atualizado com sucesso!');
        }
        return redirect()->back()->with('error', 'Por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dictionary $dictionary)
    {
        if($dictionary->delete()){
            return redirect()->back()->with('success', 'Dicionário excluido com sucesso');
        }
        return redirect()->back()->with('error', 'Por favor tente novamente');
    }
}
