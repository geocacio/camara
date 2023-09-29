<?php

namespace App\Http\Controllers;

use App\Models\Construction;
use App\Models\GeneralContract;
use App\Models\Type;
use App\Models\TypeContent;
use Illuminate\Http\Request;

class ConstructionContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Construction $construction)
    {
        return view('panel.construction.contracts.index', compact('construction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Construction $construction)
    {
        $types = Type::where('slug', 'contracts')->first()->children;
        return view('panel.construction.contracts.create', compact('construction', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Construction $construction, Request $request)
    {
        $validateData = $request->validate([
            'type' => 'required',
            'parent_id' => 'nullable',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
            'total_value' => 'nullable',
            'description' => 'nullable',
        ], [
            'type.required' => 'O campo tipo é obrigatório',
        ]);

        $validateData['total_value'] = $request->total_value ? str_replace(['R$', '.', ','], ['', '', '.'], $request->total_value) : null;
        $validateData['number'] = GeneralContract::generateContractNumber();
        $validateData['slug'] = $validateData['number'];
        $contract = $construction->generalContracts()->create($validateData);

        if ($contract) {
            TypeContent::create([
                'type_id' => $validateData['type'],
                'typeable_id' => $contract->id,
                'typeable_type' => 'GeneralContract',
            ]);
            return redirect()->route('constructions.contracts.index', $construction->slug)->with('success', 'Contrato cadastrado com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Construction $construction, GeneralContract $contract)
    {
        $types = Type::where('slug', 'contracts')->first()->children;
        return view('panel.construction.contracts.edit', compact('construction', 'types', 'contract'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Construction $construction, GeneralContract $contract)
    {
        $validateData = $request->validate([
            'type' => 'required',
            'parent_id' => 'nullable',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
            'total_value' => 'nullable',
            'description' => 'nullable',
        ], [
            'type.required' => 'O campo tipo é obrigatório',
        ]);
        if (strpos($request->total_value, 'R$') !== false) {
            $validateData['total_value'] = $request->total_value ? str_replace(['R$', '.', ','], ['', '', '.'], $request->total_value) : null;
        }
        if ($contract->update($validateData)) {
            $typeContent = TypeContent::where('typeable_id', $contract->id)->where('typeable_type', 'GeneralContract')->first();

            $typeContent->update(['type_id' => $validateData['type']]);

            return redirect()->route('constructions.contracts.index', $construction->slug)->with('success', 'Contrato atualizado com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Construction $construction, GeneralContract $contract)
    {
        $typeContent = TypeContent::where('typeable_id', $contract->id)->where('typeable_type', 'GeneralContract')->first();

        if ($typeContent) {
            $typeContent->delete();
        }

        $contract->delete();

        return redirect()->back()->with('success', 'Contrato excluido com sucesso!');
    }
}
