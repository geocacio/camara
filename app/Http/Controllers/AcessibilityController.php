<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class AcessibilityController extends Controller
{
    public function index(){
        $page = Page::where('name', 'Acessibilidade')->first();
        return view('panel.acessibility.edit', compact('page'));
    }

    public function page(){
        $page = Page::where('name', 'Acessibilidade')->first();
        return view('pages.acessibility.index', compact('page'));
    }

    public function update(Request $request, $id){
        $validateData = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ], [
            'title.required' => 'O campo título é obrigatório',
            'transparency_group_id.required' => 'O campo descrição é obrigatório!',
        ]);

        $page = Page::find($id);
        if($page->update($validateData)){
            return redirect()->back()->with('success', 'Página atualizada com sucesso!');
        }
        return redirect()->back()->with('error', 'Por favor tente novamente!');
    }
}
