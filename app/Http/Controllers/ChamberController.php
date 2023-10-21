<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\Councilor;
use App\Models\Legislature;
use App\Models\Secretary;
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
        
        $chamber['institutional'] = Secretary::first();
        $chamber['institutional']['icon'] = 'fa-solid fa-building-columns';
        if ($currentLegislature) {
            $chamber['boards']['councilors'] = Councilor::whereHas('legislatureRelations', function ($query) use ($currentLegislature) {
                $query->where('legislature_id', $currentLegislature->id)
                      ->where('bond_id', 19); // Substitua 'office_id' pelo nome da nova coluna, se necessário.
            })->get();
        } else {
            $chamber['boards']['councilors'] = [];
        }
        // dd($chamber['boards']['councilors']);
        // if($currentLegislature){
        //     $chamber['boards']['councilors'] = Councilor::whereHas('legislatureRelations', function ($query) use ($currentLegislature) {
        //         $query->where('legislature_id', $currentLegislature->id);
        //     })->where('bond_id', 19)->get();
        // }else{
        //     $chamber['boards']['councilors'] = [];
        // }
        $chamber['boards']['icon'] = "fa-solid fa-users";
        $chamber['legislature']['councilors'] = $currentLegislature ? $currentLegislature->legislatureRelations : [];
        $chamber['legislature']['icon'] = "fa-solid fa-user-tie";
        $chamber['commissions']['items'] = Commission::select(['id', 'description as Descrição'])->get();
        $chamber['commissions']['icon'] = "fa-solid fa-newspaper";
        
        $chamber['sectors']['items'] = $chamber['institutional']->sectors;
        $chamber['sectors']['icon'] = "fa-solid fa-building";

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
