<?php

namespace App\Http\Controllers;

use App\Models\RoleCouncilor;
use Illuminate\Http\Request;

class RoleCouncilorController extends Controller
{
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
    public function show(RoleCouncilor $roleCouncilor)
    {
        //
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
