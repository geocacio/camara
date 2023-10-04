<?php

namespace App\Http\Controllers;

use App\Models\Councilor;
use App\Models\Legislature;
use Illuminate\Http\Request;

class CouncilorLegislatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Councilor $councilor)
    {
        return view('panel.councilor.legislature.index', compact('councilor'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Councilor $councilor)
    {
        $legislatures = Legislature::All();
        return view('panel.councilor.legislature.create', compact('councilor', 'legislatures'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Councilor $councilor)
    {
        //
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
    public function destroy(Councilor $councilor)
    {
        //
    }
}
