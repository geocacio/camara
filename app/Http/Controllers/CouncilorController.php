<?php

namespace App\Http\Controllers;

use App\Models\Councilor;
use Illuminate\Http\Request;

class CouncilorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('panel.councilor.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.councilor.create');
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
    public function show(Councilor $councilor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Councilor $councilor)
    {
        return view('panel.councilor.edit');
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
