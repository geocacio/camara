<?php

namespace App\Http\Controllers;

use App\Models\Lai;
use Illuminate\Http\Request;

class LaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lai = Lai::first();

        return isset($lai) ? view('panel.lai.edit', compact('lai')) : view('panel.lai.create');
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
        ], [
           'title.required' => 'O campo titulo é obrigatorio', 
           'description.required' => 'O campo descrição é obrigatorio' 
        ]);

        $validateData['slug'] = Lai::uniqSlug($validateData['title']);

        $lai = Lai::create($validateData);

        if($lai){
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
    public function update(Request $request, Lai $lai)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'icon' => 'nullable',
        ], [
           'title.required' => 'O campo titulo é obrigatorio', 
           'description.required' => 'O campo descrição é obrigatorio' 
        ]);

        if($lai->update($validateData)){
            return redirect()->route('lai.index')->with('success', 'Lai atualizada com sucesso!');
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
