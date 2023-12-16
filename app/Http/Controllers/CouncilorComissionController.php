<?php

namespace App\Http\Controllers;

use App\Models\CommissionCouncilor;
use App\Models\Commission;
use App\Models\Councilor;
use App\Models\Legislature;
use Illuminate\Http\Request;

class CouncilorComissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Councilor $councilor)
    {
        return view('panel.councilor.commission.index', compact('councilor'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Councilor $councilor)
    {
        $commissions = Commission::all();
        $legislatures = Legislature::all();
        return view('panel.councilor.commission.create', compact('councilor', 'commissions', 'legislatures'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Councilor $councilor)
    {
        $validatedData = $request->validate([
            'commission_id' => 'required',
            'legislature_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
        ],[
            'commission_id.required' => 'O campo comissão é obrigatório',
            'start_date.required' => 'O campo data de início é obrigatório',
        ]);
        $validatedData['councilor_id'] = $councilor->id;
        
        $commission = Commission::find($validatedData['commission_id']);
        if(!$commission){
            return redirect()->back()->with('error', 'Comissão não encontrada, por favor tente novamente');
        }
        
        $result = CommissionCouncilor::create($validatedData);

        if($result){
            return redirect()->route('councilor-commissions.index', $councilor->slug)->with('success', 'Comissão cadastrada com sucesso!');
        }
        return redirect()->back()->with('error', 'Comissão não encontrada, por favor tente novamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Councilor $councilor, CommissionCouncilor $councilor_commission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Councilor $councilor, CommissionCouncilor $councilor_commission)
    {
        $commissions = Commission::all();
        $legislatures = Legislature::all();

        return view('panel.councilor.commission.edit', compact('councilor', 'commissions', 'councilor_commission', 'legislatures'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Councilor $councilor, CommissionCouncilor $councilor_commission)
    {
        $validatedData = $request->validate([
            'commission_id' => 'required',
            'legislature_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
        ],[
            'commission_id.required' => 'O campo comissão é obrigatório',
            'start_date.required' => 'O campo data de início é obrigatório',
        ]);
        $commission = Commission::find($validatedData['commission_id']);
        if(!$commission){
            return redirect()->back()->with('error', 'Comissão não encontrada, por favor tente novamente');
        }

        $result = $councilor_commission->update($validatedData);

        if($result){
            return redirect()->route('councilor-commissions.index', $councilor->slug)->with('success', 'Comissão atualizada com sucesso!');
        }
        return redirect()->back()->with('error', 'Comissão não encontrada, por favor tente novamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Councilor $councilor, CommissionCouncilor $councilor_commission)
    {
        if($councilor_commission->delete()){
            return redirect()->back()->with('success', 'Comissão removida com sucesso!');
        }
        return redirect()->back()->with('error', 'Error, por favor tente novamente');
    }
}
