<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Councilor;
use App\Models\Legislature;
use App\Models\Office;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouncilorLegislatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Councilor $councilor)
    {
        // dd($councilor->legislatureRelations[0]->legislature);
        // $legislatures = $councilor->legislatureRelations
        return view('panel.councilor.legislature.index', compact('councilor'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Councilor $councilor)
    {
        $currentDate = Carbon::now();
        $legislatures = Legislature::where('start_date', '<', $currentDate)->get();
        $bonds = Category::where('slug', 'vinculo')->with('children')->first();
        $offices = Office::all();
        return view('panel.councilor.legislature.create', compact('councilor', 'legislatures', 'bonds', 'offices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Councilor $councilor)
    {
        $validateData = $request->validate([
            'legislature_id' => 'required',
            'office_id' => 'required',
            'bond_id' => 'required',
            'first_period' => 'required',
            'final_period' => 'required',
        ], [
            'legislature_id.required' => 'O campo legislatura é obrigatório',
            'office_id.required' => 'O campo cargo atual é obrigatório',
            'bond_id.required' => 'O campo vínculo atual é obrigatório',
            'first_period.required' => 'O campo período inicial é obrigatório',
            'final_period.required' => 'O campo período final é obrigatório',
        ]);

        if ($councilor->legislatureRelations()->where('legislature_id', $validateData['legislature_id'])->exists()) {
            return redirect()->route('councilor.legislature.index', $councilor->slug)->with('error', 'Error, este vereador já está cadastrado nesta legislatura!');
        }

        if ($councilor->legislatureRelations()->create($validateData)) {
            return redirect()->route('councilor.legislature.index', $councilor->slug)->with('success', 'Legislatura craiada com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro ao tentar criar Legislatura, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Councilor $councilor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Councilor $councilor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Councilor $councilor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Councilor $councilor, $id)
    {
        $relation = $councilor->legislatureRelations()->find($id);

        if ($relation) {
            $relation->delete();

            return redirect()->route('councilor.legislature.index', $councilor->slug)->with('success', 'Legislatura excluída com sucesso!');
        }

        return redirect()->back()->with('error', 'Relação não encontrada.');
    }
}
