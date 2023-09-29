<?php

namespace App\Http\Controllers;

use App\Models\PageServiceLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageServiceLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageServiceLetter = PageServiceLetter::first();
        if ($pageServiceLetter) {
            return view('panel.service-letters.page.edit', compact('pageServiceLetter'));
        }
        return view('panel.service-letters.page.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
        ], [
            'title.required' => 'O campo título é obrigatório'
        ]);
        $validateData['slug'] = Str::slug($request->title);

        $pageServiceLetter = PageServiceLetter::create($validateData);
        if ($pageServiceLetter) {
            return redirect()->route('pageServiceLetter.index')->with('success', 'Cadastro realizado com sucesso!');
        }
        return redirect()->route('pageServiceLetter.index')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PageServiceLetter $pageServiceLetter)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
        ], [
            'title.required' => 'O campo título é obrigatório'
        ]);

        if ($pageServiceLetter->update($validateData)) {
            return redirect()->route('pageServiceLetter.index')->with('success', 'Cadastro atualizado com sucesso!');
        }
        return redirect()->route('pageServiceLetter.index')->with('error', 'Por favor tente novamente!');
    }
}
