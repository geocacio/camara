<?php

namespace App\Http\Controllers;

use App\Models\Mandate;
use Illuminate\Http\Request;

class MandateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('panel.councilor.mandate.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.councilor.mandate.create');
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
    public function show(Mandate $mandate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mandate $mandate)
    {
        return view('panel.councilor.mandate.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mandate $mandate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mandate $mandate)
    {
        //
    }
}
