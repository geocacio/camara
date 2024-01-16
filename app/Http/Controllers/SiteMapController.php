<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\TransparencyGroup;
use Illuminate\Http\Request;

class SiteMapController extends Controller
{
    public function page(){
        $pageMapa = Page::where('name', 'Mapa do site')->first();

        return view('pages.site-map.index', compact('pageMapa'));
    }

    public function pageShow()
    {
        $pageMapa = Page::where('name', 'Mapa do site')->first();
        $groups = TransparencyGroup::all();
        return view('panel.mapa-site-page.edit', compact('pageMapa', 'groups'));
    }

    
    public function pageUpdate(Request $request)
    {
        $validateData = $request->validate([
            'transparency_group_id' => 'required',
            'main_title' => 'required',
            'title' => 'required',
            'icon' => 'nullable',
            'description' => 'nullable',
        ], [
            'main_title.required' => 'O campo título principal é obrigatório',
            'transparency_group_id.required' => 'O campo Grupo é obrigatório!',
            'title.required' => 'O campo título é obrigatório'
        ]);
        $validateData['visibility'] = $request->visibility ? $request->visibility : 'disabled';

        $pageMap = Page::where('name', 'Mapa do site')->first();

        if ($pageMap->update($validateData)) {
            $pageMap->groupContents()->delete();
            $pageMap->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('mapa.page.show')->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->route('mapa.page.show')->with('error', 'Por favor tente novamente!');
    }
}
