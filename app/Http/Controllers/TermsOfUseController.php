<?php

namespace App\Http\Controllers;

use App\Models\termsOfUse;
use Illuminate\Http\Request;

class TermsOfUseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $term = termsOfUse::first();
        return view('pages.terms.index', compact('term'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $term = termsOfUse::first();
        return view('panel.terms.index', compact('term'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ], [
            'content.required' => 'O campo de conteúdo é obrigatório.',
            'content.string' => 'O campo de conteúdo deve ser uma string.',
        ]);

        TermsOfUse::updateOrCreate([], ['content' => $request->input('content')]);

        return redirect()->route('terms-use.create')->with('success', 'Termos atualizados com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(termsOfUse $termsOfUse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(termsOfUse $termsOfUse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, termsOfUse $termsOfUse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(termsOfUse $termsOfUse)
    {
        //
    }

    public function aceitar(Request $request)
    {
        $aceito = $request->input('aceito');

        if ($aceito) {
            $request->session()->put('termos_aceitos', true);
            return response()->json(['status' => 'success', 'message' => 'Termos aceitos com sucesso']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Termos não aceitos']);
        }
    }
    
}
