<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::with('sections', 'sections.styles')->get();
        return view('panel.configurations.pages.index', compact('pages'));
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
    public function show(Page $page)
    {
        $sections = $page->sections->sortBy('position');
        $page->sections = $sections;
        return view('panel.configurations.pages.reorder', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $positions = $request->input('positions', []);
        
        foreach ($positions as $position) {
            $section = $page->sections->find($position['sectionId']);
            
            if ($section) {
                if(!$section->update(['position' => $position['position']])){
                    session()->flash('error', 'Erro, por favor tente novamente!');
                    return response()->json(['error' => true, 'message' => 'Erro, por favor tente novamente!']);
                }
            }
        }

        session()->flash('success', 'Ordem das seções atualizada com sucesso!');
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        //
    }
}
