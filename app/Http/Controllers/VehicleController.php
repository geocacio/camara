<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = Vehicle::all();
        return view('panel.vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.vehicles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validateData = $request->validate([
            'secretary_id' => 'required',
            'situation' => 'required',
            'model' => 'required',
            'brand' => 'required',
            'plate' => 'required',
            'year' => 'required',
            'donation' => 'required',
            'type' => 'required',
            'purpose_vehicle' => 'required',
        ]);

        $validateData['slug'] = Vehicle::uniqSlug($validateData['model'], $validateData['brand'], $validateData['year']);

        if($vehicle = Vehicle::create($validateData)){
            return redirect()->route('veiculos.index')->with('success', 'Veículo cadastrado com sucesso!');
        }else {
            return redirect()->back()->with('error', 'Falha ao cadastrar veículo!');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        return view('page.vehicles.index', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($vehicle)
    {
        $vehicle = Vehicle::where( 'slug',$vehicle)->first();

        return view('panel.vehicles.edit', compact('vehicle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $validateData = $request->validate([
            'secretary_id' => 'required',
            'situation' => 'required',
            'model' => 'required',
            'brand' => 'required',
            'plate' => 'required',
            'year' => 'required',
            'donation' => 'required',
            'type' => 'required',
            'purpose_vehicle' => 'required',
        ]);

        if($vehicle->update($validateData)){
            return redirect()->route('veiculos.index')->with('success', 'Veículo atualizado com sucesso!');
        }else {
            return redirect()->back()->with('error', 'Falha ao tentar atualizar veículo!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($vehicle)
    {
        $vehicle = Vehicle::where('slug', $vehicle)->first();

        if($vehicle->delete()){
            return redirect()->route('veiculos.index')->with('success', 'Veículo excluído com sucesso!');
        }else {
            return redirect()->back()->with('error', 'Falha ao tentar excluir veículo!');
        }
    }
}
