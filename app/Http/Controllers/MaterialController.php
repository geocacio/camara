<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Councilor;
use App\Models\Material;
use App\Models\Legislature;
use App\Models\Session;
use App\Models\Type;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = Material::all();
        return view('panel.materials.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $getType = Type::where('slug', 'materials')->first();
        $types = $getType ? $getType->children : [];
        $category = Category::where('slug', 'status')->with('children')->get();
        $situations = $category[0]->children;
        $sessions = Session::all();

        $legislature = new Legislature;
        $currentLegislature = $legislature->getCurrentLegislature();
        if($currentLegislature){
            $councilors = Councilor::whereHas('legislatureRelations', function ($query) use ($currentLegislature) {
                $query->where('legislature_id', $currentLegislature->id);
            })->where('bond_id', 19)->get();
        }else{
            $councilors = [];
        }
        
        return view('panel.materials.create', compact('types', 'situations', 'sessions', 'councilors'));
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
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        //
    }
}
