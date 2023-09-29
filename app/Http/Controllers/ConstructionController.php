<?php

namespace App\Http\Controllers;

use App\Models\Construction;
use App\Models\Secretary;
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
            return redirect()->route('events.index')->with('success', 'Obra cadastrada com sucesso.');
        }
        return redirect()->back()->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Construction $construction)
    {
        //
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
        //
    }
}
