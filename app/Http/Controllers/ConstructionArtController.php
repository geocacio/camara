<?php

namespace App\Http\Controllers;

use App\Models\Construction;
use App\Models\ConstructionArt;
use App\Models\Type;
use App\Models\TypeContent;
use Illuminate\Http\Request;

class ConstructionArtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Construction $construction)
    {
        return view('panel.construction.art.index', compact('construction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Construction $construction)
    {
        $types = Type::where('slug', 'constructions-art')->first()->children;
        return view('panel.construction.art.create', compact('construction', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Construction $construction)
    {
        $validateData = $request->validate([
            'responsible' => 'nullable',
            'date' => 'required|date',
            'type_id' => 'required',
        ], [
            'date.required' => 'O campo Data é obrigatório.',
            'date.date' => 'O campo Data deve ser uma data válida.',
            'type_id.required' => 'O campo Tipo é obrigatório.',
            'type_id.exists' => 'O tipo selecionado não é válido.',
        ]);
        $art = new ConstructionArt;
        $validateData['number'] = $art->generateRegistrationNumber();
        $validateData['slug'] = $validateData['number'];
        
        $result = $construction->arts()->create($validateData);
        if ($result) {
            TypeContent::create([
                'type_id' => $validateData['type_id'],
                'typeable_id' => $result->id,
                'typeable_type' => 'ConstructionArt',
            ]);
            return redirect()->route('art.index', ['construction' => $construction->slug, 'art' => $result->slug])->with('success', 'ART cadastrada com sucesso.');
        }
        return redirect()->back()->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ConstructionArt $art)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Construction $construction, ConstructionArt $art)
    {
        $types = Type::where('slug', 'constructions-art')->first()->children;
        return view('panel.construction.art.edit', compact('construction', 'art', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Construction $construction, ConstructionArt $art)
    {
        $validateData = $request->validate([
            'responsible' => 'nullable',
            'date' => 'required|date',
            'type_id' => 'required',
        ], [
            'date.required' => 'O campo Data é obrigatório.',
            'date.date' => 'O campo Data deve ser uma data válida.',
            'type_id.required' => 'O campo Tipo é obrigatório.',
            'type_id.exists' => 'O tipo selecionado não é válido.',
        ]);
        unset($validateData['type_id']);
        if ($construction->arts()->update($validateData)) {
            
            $typeContent = TypeContent::where('typeable_id', $art->id)->where('typeable_type', 'ConstructionArt')->first();
            $typeContent->update(['type_id' => $request->type_id]);
            return redirect()->route('art.index', ['construction' => $construction->slug, 'art' => $art->slug])->with('success', 'ART cadastrada com sucesso.');
        }
        return redirect()->back()->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Construction $construction, ConstructionArt $art)
    {
        $typeContent = TypeContent::where('typeable_id', $art->id)->where('typeable_type', 'ConstructionArt')->first();

        if ($typeContent) {
            $typeContent->delete();
        }

        $art->delete();

        return redirect()->back()->with('success', 'ART excluido com sucesso!');
    }
}
