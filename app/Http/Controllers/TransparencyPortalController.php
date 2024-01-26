<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\ShortcutTransparency;
use App\Models\TransparencyGroup;
use App\Models\TransparencyPortal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransparencyPortalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transparencyPortal = Page::where('name', 'Home')->first();
        // dd($transparencyPortal);
        return view('panel.transparency.page.edit', compact('transparencyPortal'));
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $transparencyPortal = TransparencyPortal::first();
        $transparencyPage = Page::where('name', 'Transparência')->first();
        $transparencyGroups = TransparencyGroup::with('contents.pageable')->get();
        $atriconsId = ShortcutTransparency::where('type', 'atricon')->get();
        $pagefromAtricon = Page::whereIn('id', $atriconsId->pluck('page_id'))->where('visibility', 'enabled')->get();

        return view('pages.transparency.index', compact('transparencyPortal', 'transparencyGroups', 'pagefromAtricon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
        ], [
            'title.required' => 'O campo título é obrigatório'
        ]);
        
        $transparencyPortal = Page::where('name', 'Home')->first();

        if ($transparencyPortal->update($validateData)) {
            return redirect()->route('transparency.index')->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->route('transparency.index')->with('error', 'Por favor tente novamente!');
    }
}
