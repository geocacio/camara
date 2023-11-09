<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\RoleCouncilor;
use App\Models\TransparencyGroup;
use Illuminate\Http\Request;

class RoleCouncilorController extends Controller
{

    public function page()
    {
        $page_role_councilor = Page::where('name', 'Papel do vereador')->first();
        $groups = TransparencyGroup::all();
        return view('panel.councilor.role.page.edit', compact('page_role_councilor', 'groups'));
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

        $page_role_councilor = Page::where('name', 'Papel do vereador')->first();

        if ($page_role_councilor->update($validateData)) {
            $page_role_councilor->groupContents()->delete();
            $page_role_councilor->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('role.councilor.page')->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->route('role.councilor.page')->with('error', 'Por favor tente novamente!');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role_councilor = RoleCouncilor::first();
        
        return isset($role_councilor) ? view('panel.roleCouncilor.edit', compact('role_councilor')) : view('panel.roleCouncilor.create');
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

        $validateData['slug'] = RoleCouncilor::uniqSlug($validateData['title']);

        $role_councilor = RoleCouncilor::create($validateData);

        if ($role_councilor) {
            return redirect()->back()->with('success', 'Página Papel do Vereador criada com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro, por favor tente novamente');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $paper = RoleCouncilor::first();
        return view('pages.councilors.paper', compact('paper'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RoleCouncilor $role_councilor)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ],[
            'title.required' => 'O campo título é obrigatório',
            'description.required' => 'O campo Conteúdo é obrigatório',
        ]);

        if ($role_councilor->update($validateData)) {
            return redirect()->back()->with('success', 'Página Papel do Vereador atualizada com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro, por favor tente novamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoleCouncilor $role_councilor)
    {
        if($role_councilor->delete()){
            return redirect()->back()->with('success', 'Página Papel do Vereador excluida com sucesso');
        }
        return redirect()->back()->with('error', 'Por favor tente novamente');
    }
}
