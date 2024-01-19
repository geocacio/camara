<?php

namespace App\Http\Controllers;

use App\Models\Lai;
use App\Models\Page;
use App\Models\TransparencyGroup;
use Illuminate\Http\Request;

class LaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lai = Page::where('name', 'Lai')->first();

        $groups = TransparencyGroup::all();

        return isset($lai) ? view('panel.lai.edit', compact('lai', 'groups')) : view('panel.lai.create', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'icon' => 'nullable',
            'transparency_group_id' => 'required',
            'main_title' => 'required',
        ], [
           'title.required' => 'O campo titulo é obrigatorio', 
           'description.required' => 'O campo descrição é obrigatorio',
           'transparency_group_id.required' => 'O campo Grupo é obrigatório!',
           'main_title.required' => 'O campo titulo principal é obrigatório!',
        ]);

        $lai = Page::create($validateData);

        if ($lai) {
            $lai->groupContents()->delete();
            $lai->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('lai.index')->with('success', 'Lai cadastrada com sucesso!');
        }

        return redirect()->back()->with('error', 'Por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lai $lai)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'icon' => 'nullable',
            'transparency_group_id' => 'required',
            'main_title' => 'required',
        ], [
           'title.required' => 'O campo titulo é obrigatorio', 
           'description.required' => 'O campo descrição é obrigatorio',
           'transparency_group_id.required' => 'O campo Grupo é obrigatório!',
           'main_title.required' => 'O campo titulo principal é obrigatório!',
        ]);

        $lai = Page::where('name', 'Lai')->first();

  
        if ($lai->update($validateData)) {
            $lai->groupContents()->delete();
            $lai->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('lai.index')->with('success', 'Informações atualizadas com sucesso!');
        }

        return redirect()->back()->with('error', 'Por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lai $lai)
    {
        if($lai->delete()){
            return redirect()->route('lai.show')->with('success', 'Lai excluida com sucesso');
        }
        return redirect()->route('lai.show')->with('error', 'Por favor tente novamente');
    }
}
