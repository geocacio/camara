<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Councilor;
use App\Models\Material;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Material $material)
    {
        return view('panel.materials.author.index', compact('material'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Material $material)
    {
        $councilors = Councilor::all();
        return view('panel.materials.author.create', compact('material', 'councilors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Material $material)
    {
        $validateData = $request->validate([
            'councilor_id' => 'required',
            'authorship' => 'nullable',
        ],[
            'councilor_id.required' => 'O campo Subescritor é obrigatório'
        ]);

        $author = $material->authors()->create($validateData);

        if($author){
            return redirect()->route('authors.index', $material->slug)->with('success', 'Subescritor cadastrado com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material, Author $author)
    {
        $councilors = Councilor::all();
        return view('panel.materials.author.edit', compact('material', 'author', 'councilors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material, Author $author)
    {
        $validateData = $request->validate([
            'councilor_id' => 'required',
            'authorship' => 'nullable',
        ],[
            'councilor_id.required' => 'O campo Subescritor é obrigatório'
        ]);

        if($author->update($validateData)){
            return redirect()->route('authors.index', $material->slug)->with('success', 'Subescritor atualizado com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material, Author $author)
    {
        if($author->delete()){
            return redirect()->route('authors.index', $material->slug)->with('success', 'Subescritor removido com sucesso!');
        }
        return redirect()->route('authors.index', $material->slug)->with('error', 'Erro, por favor tente novamente!');
    }
}
