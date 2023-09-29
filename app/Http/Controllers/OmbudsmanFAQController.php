<?php

namespace App\Http\Controllers;

use App\Models\OmbudsmanFAQ;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OmbudsmanFAQController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ombudsman_faqs = OmbudsmanFAQ::all();
        return view('panel.transparency.ombudsman.faq.index', compact('ombudsman_faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.transparency.ombudsman.faq.create');
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

        $ombudsman_faq = OmbudsmanFAQ::create($validatedData);

        if($ombudsman_faq){
            return redirect()->route('ombudsman-faq.index')->with('success', 'Pergunta cadastrada com sucesso!');
        }
        return redirect()->route('ombudsman-faq.index')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(OmbudsmanFAQ $ombudsman_faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OmbudsmanFAQ $ombudsman_faq)
    {
        return view('panel.transparency.ombudsman.faq.edit', compact('ombudsman_faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OmbudsmanFAQ $ombudsman_faq)
    {
        $validatedData = $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ],[
            'question.required' => 'O campo pergunta é obrigatório',
            'answer.required' => 'O campo resposta é obrigatório',
        ]);

        if($ombudsman_faq->update($validatedData)){
            return redirect()->route('ombudsman-faq.index')->with('success', 'Pergunta atualizada com sucesso!');
        }
        return redirect()->route('ombudsman-faq.index')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OmbudsmanFAQ $ombudsman_faq)
    {
        $ombudsman_faq->delete();
        return redirect()->route('ombudsman-faq.index')->with('success', 'Pergunta apagada com sucesso!');
    }
}
