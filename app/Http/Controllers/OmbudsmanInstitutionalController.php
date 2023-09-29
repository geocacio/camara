<?php

namespace App\Http\Controllers;

use App\Models\OmbudsmanInstitutional;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OmbudsmanInstitutionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ombudsman_institutional = OmbudsmanInstitutional::first();
        if($ombudsman_institutional){
            return view('panel.transparency.ombudsman.institutional.edit', compact('ombudsman_institutional'));
        }else{
            return view('panel.transparency.ombudsman.institutional.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'main_title' => 'required',
            'title' => 'required',
            'descriptions' => 'required',
        ],[
            'main_title.required' => 'O campo título principal é obrigatório',
            'title.required' => 'O campo título é obrigatório',
            'descriptions.required' => 'Insira pelomenos uma descrição',
        ]);
        $validatedData['slug'] = Str::slug($request->main_title);

        $ombudsman_institutional = OmbudsmanInstitutional::create($validatedData);

        if($ombudsman_institutional){
            return redirect()->route('ombudsman-institutional.index')->with('success', 'Página criada com sucesso!');
        }
        return redirect()->route('ombudsman-institutional.index')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(OmbudsmanInstitutional $ombudsman_institutional)
    {
        $ombudsman_institutional = OmbudsmanInstitutional::first();
        return view('pages.ombudsman.institutional', compact('ombudsman_institutional'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OmbudsmanInstitutional $ombudsman_institutional)
    {
        $validatedData = $request->validate([
            'main_title' => 'required',
            'title' => 'required',
            'descriptions' => 'required',
        ],[
            'main_title.required' => 'O campo título principal é obrigatório',
            'title.required' => 'O campo título é obrigatório',
            'descriptions.required' => 'Insira pelomenos uma descrição',
        ]);

        if($ombudsman_institutional->update($validatedData)){
            return redirect()->route('ombudsman-institutional.index')->with('success', 'Página criada com sucesso!');
        }
        return redirect()->route('ombudsman-institutional.index')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OmbudsmanInstitutional $ombudsman_institutional)
    {
        //
    }
}
