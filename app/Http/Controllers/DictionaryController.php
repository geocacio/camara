<?php

namespace App\Http\Controllers;

use App\Models\Dictionary;
use App\Models\Page;
use App\Models\TransparencyGroup;
use Illuminate\Http\Request;

class DictionaryController extends Controller
{
    public function page()
    {
        $page_dictionary = Page::where('name', 'Dicionário')->first();
        $groups = TransparencyGroup::all();
        return view('panel.dictionary.page.edit', compact('page_dictionary', 'groups'));
    }

    public function pageUpdate(Request $request)
    {
        $validateData = $request->validate([
            'transparency_group_id' => 'required',
            'main_title' => 'required',
            'title' => 'required',
            'icon' => 'nullable',
            'description' => 'nullable',
        ], [
            'main_title.required' => 'O campo título principal é obrigatório',
            'transparency_group_id.required' => 'O campo Grupo é obrigatório!',
            'title.required' => 'O campo título é obrigatório'
        ]);
        $validateData['visibility'] = $request->visibility ? $request->visibility : 'disabled';

        $page_dictionary = Page::where('name', 'Dicionário')->first();

        if ($page_dictionary->update($validateData)) {
            $page_dictionary->groupContents()->delete();
            $page_dictionary->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('dictionary.page')->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->back('dictionary.page')->with('error', 'Por favor tente novamente!');
    }
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
