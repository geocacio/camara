<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\Type;
use App\Models\TypeContent;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commissions = Commission::all();
        return view('panel.commission.index', compact('commissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $getType = Type::where('slug', 'commissions')->first();
        $types = $getType ? $getType->children : [];
        
        return view('panel.commission.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'description' => 'required',
            'type_id' => 'required',
            'information' => 'nullable',
        ],[
            'description.required' => 'O campo descrição é obrigatório',
            'type_id.required' => 'O campo tipo é obrigatório',
        ]);
        $validateData['slug'] = Commission::uniqSlug($validateData['description']);

        $commission = Commission::create($validateData);

        if ($commission){
            TypeContent::create([
                'type_id' => $validateData['type_id'],
                'typeable_id' => $commission->id,
                'typeable_type' => 'Commission',
            ]);

            return redirect()->route('commissions.index')->with('success', 'Comissão cadastrada com sucesso!');
        }
        return redirect()->back()->with('error', 'Error, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Commission $commission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commission $commission)
    {
        $getType = Type::where('slug', 'commissions')->first();
        $types = $getType ? $getType->children : [];
        return view('panel.commission.edit', compact('commission', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Commission $commission)
    {
        $validateData = $request->validate([
            'description' => 'required',
            'type_id' => 'required',
            'information' => 'nullable',
        ],[
            'description.required' => 'O campo descrição é obrigatório',
            'type_id.required' => 'O campo tipo é obrigatório',
        ]);

        if ($commission->update($validateData)){
            $typeContent = TypeContent::where('typeable_id', $commission->id)->where('typeable_type', 'Commission')->first();
            $typeContent->update(['type_id' => $validateData['type_id']]);

            return redirect()->route('commissions.index')->with('success', 'Comissão atualizada com sucesso!');
        }
        return redirect()->back()->with('error', 'Error, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commission $commission)
    {
        $typeContent = TypeContent::where('typeable_id', $commission->id)->where('typeable_type', 'Commission')->first();
        if ($typeContent) {
            $typeContent->delete();
        }

        if ($commission->delete()){
            return redirect()->route('commissions.index')->with('success', 'Comissão removida com sucesso!');
        }
        return redirect()->back()->with('error', 'Error, por favor tente novamente!');
    }
}
