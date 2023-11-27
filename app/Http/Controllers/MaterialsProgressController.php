<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialsProgress;
use App\Models\Session;
use Illuminate\Http\Request;

class MaterialsProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Material $material)
    {
        return view('panel.materials.proceedings.index', compact('material'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Material $material)
    {
        $sessions = Session::with('proceedings', 'proceedings.category')->get();
        return view('panel.materials.proceedings.create', compact('material', 'sessions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MaterialsProgress $materialsProgress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaterialsProgress $materialsProgress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MaterialsProgress $materialsProgress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaterialsProgress $materialsProgress)
    {
        //
    }
}
