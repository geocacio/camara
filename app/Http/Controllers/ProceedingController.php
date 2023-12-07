<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Proceeding;
use App\Models\Session;
use Illuminate\Http\Request;

class ProceedingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Session $session)
    {
        $proceedings = $session->proceedings;
        return view('panel.proceeding.index', compact('proceedings', 'session'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Session $session)
    {
        $types = Category::where('slug', 'expedientes')->with('children')->first();
        return view('panel.proceeding.create', compact('session', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Session $session)
    {
        $validateData = $request->validate([
            'type_id' => 'required',
        ],[
            'type_id.required' => 'O campo tipo é obrigatório'
        ]);

        $proceeding = $session->proceedings()->create($validateData);
        if($proceeding){
            return redirect()->route('proceedings.index', $session->slug)->with('success', 'Expediente cadastrado com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro ao tentar cadastrar expediente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Proceeding $proceeding)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Session $session, Proceeding $proceedings)
    {
        $proceeding = $proceedings;
        $types = Category::where('slug', 'expedientes')->with('children')->first();
        return view('panel.proceeding.edit', compact('session', 'types', 'proceeding'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Session $session, Proceeding $proceedings)
    {
        $validateData = $request->validate([
            'type_id' => 'required',
        ],[
            'type_id.required' => 'O campo tipo é obrigatório'
        ]);

        if($proceedings->update($validateData)){
            return redirect()->route('proceedings.index', $session->slug)->with('success', 'Expediente atualizado com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro ao tentar cadastrar expediente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Session $session, Proceeding $proceedings)
    {
        $proceedings->delete();
        return redirect()->route('proceedings.index', $session->slug)->with('success', 'Expediente removido com sucesso!');
    }
}
