<?php

namespace App\Http\Controllers;

use App\Models\Councilor;
use App\Models\Legislature;
use App\Models\Session;
use App\Models\Setting;
use Illuminate\Http\Request;

class ChamberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $legislature = new Legislature();
        $currentLegislature = $legislature->getCurrentLegislature();
        
        $chamber['institutional'] = Setting::first();
        $chamber['institutional']['icon'] = 'fa-solid fa-building-columns';
        $chamber['legislature']['councilors'] = $currentLegislature ? $currentLegislature->legislatureRelations : [];
        $chamber['legislature']['icon'] = "fa-solid fa-users";
        $chamber['sessions'] = Session::all();
        $chamber['sessions']['icon'] = "fa-solid fa-newspaper";

        // dd($legislatureAtual->legislatureRelations[0]->legislatureable);
        return view('pages.chamber.index', compact('chamber'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
