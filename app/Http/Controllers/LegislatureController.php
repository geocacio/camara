<?php

namespace App\Http\Controllers;

use App\Models\Legislature;
use App\Models\Page;
use App\Models\TransparencyGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LegislatureController extends Controller
{

    public function page()
    {
        $page_legislature = Page::where('name', 'Legislaturas')->first();
        $groups = TransparencyGroup::all();
        return view('panel.legislature.page.edit', compact('page_legislature', 'groups'));
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

        $page_legislature = Page::where('name', 'Legislaturas')->first();

        if ($page_legislature->update($validateData)) {
            $page_legislature->groupContents()->delete();
            $page_legislature->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('legislatures.page')->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->route('legislatures.page')->with('error', 'Por favor tente novamente!');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $legislatures = Legislature::all();
        return view('panel.legislature.index', compact('legislatures'));
    }
    
    public function allLegislatures(Request $request){
        
        $allLegislatures = Legislature::all();
        
        $page_legislature = Page::where('name', 'Legislaturas')->first();
        $query = Legislature::query();

        if($request->filled('legislature_id')){
            $query->where('id', $request->input('legislature_id'));
        }
        
        $legislatures = $query->paginate(10);
        $searchData = $request->only(['legislature_id']);
        return view('pages.legislature.index', compact('legislatures', 'allLegislatures', 'page_legislature', 'searchData'));
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

        return redirect()->back()->with('error', 'Erro ao cadastrar Legislatura. Por favor, tente novamente.');
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
