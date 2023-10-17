<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\CommissionLink;
use App\Models\Councilor;
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
        return view('panel.councilor.commission.create', compact('councilor', 'commissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Councilor $councilor)
    {
        $validatedData = $request->validate([
            'commission_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ],[
            'commission_id.required' => 'O campo comissão é obrigatório',
            'start_date.required' => 'O campo data de início é obrigatório',
            'end_date.required' => 'O campo data de fim é obrigatório',
        ]);
        $commission = Commission::find($validatedData['commission_id']);
        if(!$commission){
            return redirect()->back()->with('error', 'Comissão não encontrada, por favor tente novamente');
        }

        $result = $councilor->commissionLinks()->create($validatedData);

        if($result){
            return redirect()->route('councilor.commissions.index', $councilor->slug)->with('success', 'Comissão cadastrada com sucesso!');
        }
        return redirect()->back()->with('error', 'Comissão não encontrada, por favor tente novamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Councilor $councilor, CommissionLink $commission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Councilor $councilor, CommissionLink $commission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Councilor $councilor, CommissionLink $commission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Councilor $councilor, CommissionLink $commission)
    {
        //
    }
}
