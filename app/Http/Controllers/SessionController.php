<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Session;
use App\Models\Type;
use App\Models\TypeContent;
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
            'type_id' => 'required',
            'exercicy_id' => 'required',
            'description' => 'nullable',
        ],[
            'date.required' => 'O campo data é obrigatório',
            'type_id.required' => 'O campo tipo é obrigatório',
            'status_id.required' => 'O campo status é obrigatório',
            'exercicy_id.required' => 'O campo exercício é obrigatório',
        ]);
        $validateData['slug'] = Session::uniqSlug();

        $session = Session::create($validateData);

        if ($session){
            TypeContent::create([
                'type_id' => $validateData['type_id'],
                'typeable_id' => $session->id,
                'typeable_type' => 'Session',
            ]);

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
        $types = Type::where('slug', 'sessions')->first();
        $status = Category::where('slug', 'status')->with('children')->first();
        $exercicies = Category::where('slug', 'exercicios')->with('children')->first();
        return view('panel.sessions.edit', compact('session', 'types', 'exercicies', 'status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Session $session)
    {
        $validateData = $request->validate([
            'date' => 'required|date',
            'status_id' => 'required',
            'type_id' => 'required',
            'exercicy_id' => 'required',
            'description' => 'nullable',
        ],[
            'date.required' => 'O campo data é obrigatório',
            'type_id.required' => 'O campo tipo é obrigatório',
            'status_id.required' => 'O campo status é obrigatório',
            'exercicy_id.required' => 'O campo exercício é obrigatório',
        ]);

        if ($session->update($validateData)){
            $typeContent = TypeContent::where('typeable_id', $session->id)->where('typeable_type', 'Session')->first();
            $typeContent->update(['type_id' => $validateData['type_id']]);

            return redirect()->route('sessions.index')->with('success', 'Sessão atualizada com sucesso!');
        }
        return redirect()->back()->with('error', 'Error, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Session $session)
    {
        $typeContent = TypeContent::where('typeable_id', $session->id)->where('typeable_type', 'Session')->first();
        if ($typeContent) {
            $typeContent->delete();
        }

        if ($session->udelete()){
            return redirect()->route('sessions.index')->with('success', 'Sessão removida com sucesso!');
        }
        return redirect()->back()->with('error', 'Error, por favor tente novamente!');
    }
}
