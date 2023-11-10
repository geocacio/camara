<?php

namespace App\Http\Controllers;

use App\Models\Glossary;
use App\Models\Page;
use App\Models\TransparencyGroup;
use Illuminate\Http\Request;

class GlossaryController extends Controller
{
    public function page()
    {
        $page_glossary = Page::where('name', 'Glossário')->first();
        $groups = TransparencyGroup::all();
        return view('panel.glossary.page.edit', compact('page_glossary', 'groups'));
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

        $page_glossary = Page::where('name', 'Glossário')->first();

        if ($page_glossary->update($validateData)) {
            $page_glossary->groupContents()->delete();
            $page_glossary->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('glossary.page')->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->back('glossary.page')->with('error', 'Por favor tente novamente!');
    }

    public function allGlossary(Request $request){
        
        $page_glossary = Page::where('name', 'Glossário')->first();
        $query = Glossary::query();

        if($request->filled('description')){
            $query->where('description', 'LIKE', '%' . $request->input('description') . '%')
            ->orWhere('title', 'LIKE', '%' . $request->input('description') . '%');
        }
        
        $glossary = $query->paginate(10);
        $searchData = $request->only(['description']);
        return view('pages.glossary.index', compact('glossary', 'page_glossary', 'searchData'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $glossarys = Glossary::all();

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
