<?php

namespace App\Http\Controllers;

use App\Models\Construction;
use App\Models\Page;
use App\Models\Secretary;
use App\Models\TransparencyGroup;
use App\Models\Type;
use App\Models\TypeContent;
use Illuminate\Http\Request;

class ConstructionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $constructions = Construction::all();
        return view('panel.construction.index', compact('constructions'));
    }

    
    public function page()
    {
        $constructionPage = Page::where('name', 'Obras')->first();
        $groups = TransparencyGroup::all();

        return view('panel.construction.page.edit', compact('constructionPage', 'groups'));
    }

    public function pageUpdate(Request $request)
    {
        $validateData = $request->validate([
            'transparency_group_id' => 'required',
            'main_title' => 'required',
            'title' => 'required',
            'icon' => 'nullable',
            'description' => 'nullable',
            'link_type' => 'nullable',
            'url' => 'nullable',
        ], [
            'main_title.required' => 'O campo título principal é obrigatório',
            'transparency_group_id.required' => 'O campo Grupo é obrigatório!',
            'title.required' => 'O campo título é obrigatório'
        ]);
        $validateData['visibility'] = $request->visibility ? $request->visibility : 'disabled';

        $constructionPage = Page::where('name', 'Obras')->first();

        if ($constructionPage->update($validateData)) {
            $constructionPage->groupContents()->delete();
            $constructionPage->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('constructions.page')->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->route('constructions.page')->with('error', 'Por favor tente novamente!');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $secretaries = Secretary::all();
        $types = Type::where('slug', 'constructions')->first()->children;
        return view('panel.construction.create', compact('secretaries', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            "secretary_id" => "required",
            "type_id" => "required",
            "title" => "required",
            "description" => "nullable",
            "date" => "required",
            "local" => "nullable",
            "expected_date" => "nullable",
        ], [
            'secretary_id.required' => 'O campo Secretaria é obrigatório.',
            'type_id.required' => 'O campo Tipo é obrigatório.',
            'title.required' => 'O campo Título é obrigatório.',
            'date.required' => 'O campo Data é obrigatório.',
        ]);

        $validateData['slug'] = Construction::uniqSlug($validateData['title']);

        // Criação de um novo evento no banco de dados
        $construction = Construction::create($validateData);
        if($construction){
            TypeContent::create([
                'type_id' => $validateData['type_id'],
                'typeable_id' => $construction->id,
                'typeable_type' => 'Construction',
            ]);
            return redirect()->route('constructions.index')->with('success', 'Obra cadastrada com sucesso.');
        }
        return redirect()->back()->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        // $construction = Construction::with('generalProgress')->get();
        $query = Construction::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start_date = date("Y-m-d", strtotime($request->input('start_date')));
            $end_date = date("Y-m-d", strtotime($request->input('end_date')));
        
            $query->whereBetween('date', [$start_date, $end_date]);
        } elseif ($request->filled('start_date')) {
            // Se apenas a data inicial estiver definida
            $start_date = date("Y-m-d", strtotime($request->input('start_date')));
            $query->where('date', '>=', $start_date);
        } else if ($request->filled('end_date')) {
            // Se apenas a data final estiver definida
            $end_date = date("Y-m-d", strtotime($request->input('end_date')));
            $query->where('date', '<=', $end_date);
        }
        
        if ($request->filled('description')) {
            $description = $request->input('description');
        
            $query->where(function ($query) use ($description) {
                $query->where('title', 'LIKE', '%' . $description . '%')
                      ->orWhere('description', 'LIKE', '%' . $description . '%');
            });
        }        

        $construction = $query->paginate(10);
        $searchData = $request->only(['start_date', 'end_date', 'description']);

        return view('pages.construction.index', compact('construction', 'searchData'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Construction $construction)
    {
        $secretaries = Secretary::all();
        $types = Type::where('slug', 'constructions')->first()->children;
        return view('panel.construction.edit', compact('construction', 'secretaries', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Construction $construction)
    {
        $validateData = $request->validate([
            "secretary_id" => "required",
            "type_id" => "required",
            "title" => "required",
            "description" => "nullable",
            "date" => "required",
            "local" => "nullable",
            "expected_date" => "nullable",
        ], [
            'secretary_id.required' => 'O campo Secretaria é obrigatório.',
            'type_id.required' => 'O campo Tipo é obrigatório.',
            'title.required' => 'O campo Título é obrigatório.',
            'date.required' => 'O campo Data é obrigatório.',
        ]);

        if($construction->update($validateData)){
            $typeContent = TypeContent::where('typeable_id', $construction->id)->where('typeable_type', 'Construction')->first();
            $typeContent->update(['type_id' => $validateData['type_id']]);

            return redirect()->route('constructions.index')->with('success', 'Obra atualizada com sucesso.');
        }
        return redirect()->back()->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Construction $construction)
    {
        $typeContent = TypeContent::where('typeable_id', $construction->id)->where('typeable_type', 'Construction')->first();
        if ($typeContent) {
            $typeContent->delete();
        }

        if($construction->delete()){
            return redirect()->route('constructions.index')->with('success', 'Obra excluída com sucesso.');
        }

        
        return redirect()->back()->with('error', 'Erro, por favor tente novamente!');
    }
}
