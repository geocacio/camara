<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\CommissionMaterial;
use App\Models\Material;
use Illuminate\Http\Request;

class CommissionMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Material $material)
    {
        $commissions = $material->commission;
        return view('panel.materials.commission.index', compact('material', 'commissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Material $material)
    {
        $commissions = Commission::all();
        return view('panel.materials.commission.create', compact('material', 'commissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Material $material)
    {
        $validateData = $request->validate([
            'commission_id' => 'required',
        ], [
            'commission_id.required' => 'O campo Comissão é obrigatório',
        ]);

        $validateData['material_id'] = $material->id;

        $commissionMaterial = CommissionMaterial::create($validateData);

        if ($commissionMaterial) {
            return redirect()->route('material-commissions.index', $material->slug)->with('success', 'Comissão adicionada com sucesso');
        }

        return redirect()->back()->with('error', 'Falha ao adicionar comissão');
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
    public function edit(Material $material, CommissionMaterial $material_commission)
    {
        $commissions = Commission::all();
        return view('panel.materials.commission.edit', compact('material', 'material_commission', 'commissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material, CommissionMaterial $material_commission)
    {
        
        $validateData = $request->validate([
            'commission_id' => 'required',
        ], [
            'commission_id.required' => 'O campo Comissão é obrigatório',
        ]);

        $validateData['material_id'] = $material->id;

        if ($material_commission->update($validateData)) {
            return redirect()->route('material-commissions.index', $material->slug)->with('success', 'Comissão atualizada com sucesso');
        }

        return redirect()->back()->with('error', 'Falha ao atualizar comissão');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material, CommissionMaterial $material_commission)
    {
        if ($material_commission->delete()) {
            return redirect()->route('material-commissions.index', $material->slug)->with('success', 'Comissão removida com sucesso');
        }

        return redirect()->back()->with('error', 'Falha ao remover comissão');
    }
}
