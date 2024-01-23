<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\ShortcutTransparency;
use Illuminate\Http\Request;

class ShortcutTransparencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::where('visibility', 'enabled')->get();        
        return view('panel.transparency-favorite.index', compact('pages'));
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
        $validatedData = $request->validate([
            'page_id' => 'required',
        ]);
    
        // Verifica se já existe um registro com o page_id
        $existingPage = ShortcutTransparency::where('page_id', $validatedData['page_id'])->first();
        $existingPages = ShortcutTransparency::all();
        
        if ($existingPage) {
            // Se existir, deleta o registro existente
            $existingPage->delete();
        } else {
            // Se não existir, cria um novo registro com o page_id
            if(count($existingPages) >= 6){
                return redirect()->back()->with('error', 'Limite de destaques atingido!');
            }else {
                ShortcutTransparency::create(['page_id' => $validatedData['page_id']]);
            }
        }
    
        return redirect()->back()->with('success', 'Destaque atualizado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ShortcutTransparency $shortcutTransparency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShortcutTransparency $shortcutTransparency)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShortcutTransparency $shortcutTransparency)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShortcutTransparency $shortcutTransparency)
    {
        //
    }
}
