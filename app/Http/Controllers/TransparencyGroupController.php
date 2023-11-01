<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\TransparencyGroup;
use App\Models\TransparencyPortal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransparencyGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transparencyGroup = TransparencyGroup::All();
        return view('panel.transparency.groups.index', compact('transparencyGroup'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {        
        return view('panel.transparency.groups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'transparency_id'  => 'nullable',
            'title' => 'required',
            'description' => 'nullable',
        ],[
            'transparency_id.required' => 'O campo Transparência é obrigatório',
            'title.required' => 'O campo Título é obrigatório',
        ]);
        
        $validateData['slug'] = Str::slug($request->title);
        if(TransparencyGroup::where('slug', $validateData['slug'])->exists()){
            $nextId = TransparencyGroup::max('id') + 1;
            $validateData['slug'] = $validateData['slug'].'-'.$nextId;
        }

        $transparencyPortal = TransparencyPortal::first();
        $validateData['transparency_id'] = $transparencyPortal->id;

        $transparencyGroup = TransparencyGroup::create($validateData);
        if($transparencyGroup){
            return redirect()->route('transparency.groups.index')->with('success', 'Grupo cadastrado com sucesso!');
        }
        return redirect()->route('transparency.groups.index')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TransparencyGroup $transparencyGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransparencyGroup $group)
    {
        return view('panel.transparency.groups.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransparencyGroup $group)
    {
        $validateData = $request->validate([
            'transparency_id'  => 'nullable',
            'title' => 'required',
            'description' => 'nullable',
        ],[
            'transparency_id.required' => 'O campo Transparência é obrigatório',
            'title.required' => 'O campo Título é obrigatório',
        ]);

        if($group->update($validateData)){
            return redirect()->route('transparency.groups.index')->with('success', 'Grupo atualizado com sucesso!');
        }
        return redirect()->route('transparency.groups.index')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransparencyGroup $group)
    {
        $group->delete();

        return redirect()->route('transparency.groups.index')->with('success', 'Grupo excluído com sucesso!');
    }
}
