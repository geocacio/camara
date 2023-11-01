<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Page;
use App\Models\Session;
use App\Models\TransparencyGroup;
use App\Models\Type;
use App\Models\TypeContent;
use Illuminate\Http\Request;

class SessionController extends Controller
{

    public function page()
    {
        $page_session = Page::where('name', 'Sessões')->first();
        $groups = TransparencyGroup::all();
        return view('panel.sessions.page.edit', compact('page_session', 'groups'));
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

        $page_session = Page::where('name', 'Sessões')->first();

        if ($page_session->update($validateData)) {
            $page_session->groupContents()->delete();
            $page_session->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('sessions.page')->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->route('sessions.page')->with('error', 'Por favor tente novamente!');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $sessions = Session::all();
        return view('panel.sessions.index', compact('sessions'));
    }

    public function allSessions(Request $request){

        $getType = Type::where('slug', 'materials')->first();
        $types = $getType ? $getType->children : [];
        $category = Category::where('slug', 'status')->with('children')->get();
        $situations = $category[0]->children;

        $page_session = Page::where('name', 'Sessões')->first();
        $query = Session::query();

        if($request->filled('type_id')){
            $query->where('type_id', $request->input('type_id'));
        }
        
        if($request->filled('status_id')){
            $query->where('status_id', $request->input('status_id'));
        }
        
        if($request->filled('number')){
            $query->where('number', $request->input('number'));
        }

        if($request->filled('description')){
            $query->where('description', 'LIKE', '%' . $request->input('description') . '%');
        }
        
        $sessions = $query->paginate(10);
        // dd($sessions);
        $searchData = $request->only(['type_id', 'status_id', 'description']);
        return view('pages.sessions.index', compact('sessions', 'page_session', 'searchData', 'types', 'situations'));

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
        // dd($session->sessionAttendance[0]);
        return view('pages.sessions.show', compact('session'));
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

        if ($session->delete()){
            return redirect()->route('sessions.index')->with('success', 'Sessão removida com sucesso!');
        }
        return redirect()->back()->with('error', 'Error, por favor tente novamente!');
    }
}
