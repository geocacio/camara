<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Services\GeneralCrudSErvice;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OfficeController extends Controller
{
    private $crud;

    public function __construct(GeneralCrudSErvice $crud)
    {
        $this->crud = $crud;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offices = Office::all();
        return view('panel.employees.offices.index', compact('offices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.employees.offices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'office' => 'required',
            'description' => 'nullable',
        ]);
        $validatedData['slug'] = Str::slug($request->office);
        unset($validatedData['file']);

        $redirect = ['route' => 'offices.index'];
        return $this->crud->initCrud('create', 'Office', $validatedData, $request, $redirect);
    }

    /**
     * Display the specified resource.
     */
    public function show(Office $office)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Office $office)
    {
        return view('panel.employees.offices.edit', compact('office'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Office $office)
    {
        $validatedData = $request->validate([
            'office' => 'required',
            'description' => 'nullable',
        ]);
        unset($validatedData['file']);

        $redirect = ['route' => 'offices.index'];
        return $this->crud->initCrud('update', 'Office', $validatedData, $request, $redirect, $office);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Office $office)
    {
        $office->delete();
        return redirect()->route('offices.index')->with('success', 'Cargo excluído com sucesso!');
    }
}
