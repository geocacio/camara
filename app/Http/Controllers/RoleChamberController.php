<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\RoleChamber;
use App\Models\TransparencyGroup;
use Illuminate\Http\Request;

class RoleChamberController extends Controller
{

    public function page()
    {
        $page_role_chamber = Page::where('name', 'Papel da Câmara')->first();
        $groups = TransparencyGroup::all();
        return view('panel.chamber.page.edit', compact('page_role_chamber', 'groups'));
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

        $page_material = Page::where('name', 'Papel da Câmara')->first();

        if ($page_material->update($validateData)) {
            $page_material->groupContents()->delete();
            $page_material->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('chamber.page')->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->route('chamber.page')->with('error', 'Por favor tente novamente!');
    }

    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role_chamber = RoleChamber::first();
        
        return isset($role_chamber) ? view('panel.roleChamber.edit', compact('role_chamber')) : view('panel.roleChamber.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ],[
            'title.required' => 'O campo título é obrigatório',
            'description.required' => 'O campo categoria é obrigatório',
        ]);

        $validateData['slug'] = RoleChamber::uniqSlug($validateData['title']);

        $role_chamber = RoleChamber::create($validateData);

        if ($role_chamber) {
            return redirect()->back()->with('success', 'Página Papel da Câmara criada com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro, por favor tente novamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(RoleChamber $role_chamber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoleChamber $role_chamber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RoleChamber $role_chamber)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ],[
            'title.required' => 'O campo título é obrigatório',
            'description.required' => 'O campo Conteúdo é obrigatório',
        ]);

        if ($role_chamber->update($validateData)) {
            return redirect()->back()->with('success', 'Página Papel da Câmara atualizada com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro, por favor tente novamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoleChamber $role_chamber)
    {
        if($role_chamber->delete()){
            return redirect()->back()->with('success', 'Página Papel da Câmara excluida com sucesso');
        }
        return redirect()->back()->with('error', 'Por favor tente novamente');
    }
}
