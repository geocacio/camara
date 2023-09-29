<?php

namespace App\Http\Controllers;

use App\Models\HomePage;
use App\Models\Page;
use App\Models\Section;
use App\Models\Service;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();
        $page = Page::where('name', 'Home')->with('sections', 'sections.styles')->first();
        $sections = [];
        foreach ($page->sections as $section) {
            $sections[$section->component] = $section;
        }
        
        return view('panel.homepage.index', compact('services', 'page', 'sections'));
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
    public function show(HomePage $homePage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HomePage $homePage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HomePage $homePage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HomePage $homePage)
    {
        //
    }
}
