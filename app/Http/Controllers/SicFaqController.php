<?php

namespace App\Http\Controllers;

use App\Models\SicFaq;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SicFaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqs = SicFaq::all();
        
        return view('panel.sic.faq.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.sic.faq.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ],[
            'question.required' => 'O campo pergunta é obrigatório',
            'answer.required' => 'O campo resposta é obrigatório',
        ]);
        $validatedData['slug'] = Str::slug($request->question);

        $faq = SicFaq::create($validatedData);

        if($faq){
            return redirect()->route('sic-faq.index')->with('success', 'Pergunta cadastrada com sucesso!');
        }
        return redirect()->route('sic-faq.index')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SicFaq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SicFaq $faq)
    {
        return view('panel.sic.faq.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SicFaq $faq)
    {
        $validatedData = $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ],[
            'question.required' => 'O campo pergunta é obrigatório',
            'answer.required' => 'O campo resposta é obrigatório',
        ]);

        if($faq->update($validatedData)){
            return redirect()->route('sic.faq.index')->with('success', 'Pergunta atualizada com sucesso!');
        }
        return redirect()->route('sic.faq.index')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SicFaq $faq)
    {
        $faq->delete();
        return redirect()->route('sic.faq.index')->with('success', 'Pergunta apagada com sucesso!');
    }
}
