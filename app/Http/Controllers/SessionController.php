<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Session;
use App\Models\Type;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $sessions = Session::all();
        return view('panel.sessions.index', compact('sessions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::where('slug', 'sessions')->first();
        $status = Category::where('slug', 'status')->with('children')->first();
        $exercicies = Category::where('slug', 'exercicios')->with('children')->first();
        return view('panel.sessions.create', compact('types', 'exercicies', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'date' => 'required|date',
            'status_id' => 'required',
            'exercicy_id' => 'required',
            'description' => 'nullable',
        ],[
            'date.required' => 'O campo data é obrigatório',
            'date.status_id' => 'O campo status é obrigatório',
            'date.exercicy_id' => 'O campo exercício é obrigatório',
        ]);
        $validateData['slug'] = Session::uniqSlug();

        $session = Session::create($validateData);

        if ($session){
            return redirect()->route('sessions.index')->with('success', 'Sessão cadastrada com sucesso!');
        }
        return redirect()->back()->with('error', 'Error, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Session $session)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Session $session)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Session $session)
    {
        $validateData = $request->validate([
            'date' => 'required|date',
            'status_id' => 'required',
            'exercicy_id' => 'required',
            'description' => 'nullable',
        ],[
            'date.required' => 'O campo data é obrigatório',
            'date.status_id' => 'O campo status é obrigatório',
            'date.exercicy_id' => 'O campo exercício é obrigatório',
        ]);

        if ($session->update($validateData)){
            return redirect()->route('sessions.index')->with('success', 'Sessão atualizada com sucesso!');
        }
        return redirect()->back()->with('error', 'Error, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Session $session)
    {
        if ($session->udelete()){
            return redirect()->route('sessions.index')->with('success', 'Sessão removida com sucesso!');
        }
        return redirect()->back()->with('error', 'Error, por favor tente novamente!');
    }
}
