<?php

namespace App\Http\Controllers;

use App\Models\OmbudsmanFeedback;
use App\Models\Page;
use App\Models\Secretary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OmbudsmanFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $ombudsmanFeedback = OmbudsmanFeedback::orderBy('status', 'asc')->get();
        return view('panel.transparency.ombudsman.manifestation.index', compact('ombudsmanFeedback', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $secretaries = Secretary::all();
        $ombudsman = Page::where('name', 'Ouvidoria')->first();
        return view('pages.ombudsman.manifestation', compact('ombudsman', 'secretaries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => $request->anonymous == "on" ? 'nullable' : 'required',
            'cpf' => $request->anonymous == "on" ? 'nullable' : 'required',
            'date_of_birth' => $request->anonymous == "on" ? 'nullable' : 'required',
            'sex' => $request->anonymous == "on" ? 'nullable' : 'required',
            'level_education' => $request->anonymous == "on" ? 'nullable' : 'required',
            'email' => $request->anonymous == "on" ? 'nullable' : 'required',
            'phone_type' => $request->anonymous == "on" ? 'nullable' : 'required',
            'phone' => $request->anonymous == "on" ? 'nullable' : 'required',
            'subject' => 'nullable',
            'nature' => 'nullable',
            'message' => 'nullable',
            'answer' => 'nullable',
        ], [
            'secretary_id.required' => 'O campo secretaria é obrigatório',
            'name' => 'O campo nome é obrigatório',
            'cpf' => 'O campo cpf é obrigatório',
            'date_of_birth' => 'O campo data de nascimento é obrigatório',
            'sex' => 'O campo sexo é obrigatório',
            'level_education' => 'O campo grau de instrução é obrigatório',
            'email' => 'O campo email é obrigatório',
            'phone_type' => 'O campo tipo de telefone é obrigatório',
            'phone' => 'O campo telefone é obrigatório',
        ]);
        $validatedData['protocol'] = date('Ymd') . str_pad(OmbudsmanFeedback::count() + 1, 4, '0', STR_PAD_LEFT);
        $validatedData['deadline'] = Carbon::now()->addDays(31);
        $validatedData['anonymous'] = $request->anonymous == 'on' ? 'sim' : 'não';

        $ombudsmanFeedback = OmbudsmanFeedback::create($validatedData);

        if($ombudsmanFeedback){
            return redirect()->route('manifestacao.show')->with('feedback-success', 'Manifestação enviada com sucesso! <strong>Número do Protocolo: ' .$ombudsmanFeedback->protocol . '</strong>');
        }
        
        return redirect()->back()->withErrors('Por favor tente novamente!')->withInput();
    }
    
    public function searchManifestation(Request $request)
    {
        $validatedData = $request->validate(
            [
                'protocol' => $request->cpf != '' ? 'nullable' : 'required',
                'cpf' => $request->protocol != '' ? 'nullable' : 'required',
            ],
            [
                'protocol.required' => 'Você precisa inserir o número de Protocolo ou CPF.',
                'cpf.required' => 'Você precisa inserir o número de Protocolo ou CPF.',
            ]
        );

        $result = OmbudsmanFeedback::where(function ($query) use ($request) {
            if ($request->protocol) {
                $query->where('protocol', $request->protocol);
            }
        
            if ($request->cpf) {
                $query->orWhere('cpf', $request->cpf);
            }
        })->get();
        
        return view('pages.ombudsman.searchResultManifestation', compact('result'));
    }
    
    public function seekManifestation()
    {
        return view('pages.ombudsman.searchManifestation');
    }

    /**
     * Display the specified resource.
     */
    public function show(OmbudsmanFeedback $ombudsmanFeedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OmbudsmanFeedback $ombudsmanFeedback)
    {
        return view('panel.transparency.ombudsman.manifestation.edit', compact('ombudsmanFeedback'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OmbudsmanFeedback $ombudsmanFeedback)
    {
        $request->validate(['answer' => 'required']);
        if($ombudsmanFeedback->update(['answer' => $request->answer, 'status' => 'Finalizado'])){
            return redirect()->route('ombudsman-feedback.index')->with('success', 'Resposta enviada com sucesso!');
        }
        return redirect()->back()->with('error', 'Por favor tente novamente!');
    }

    public function deadline(Request $request, OmbudsmanFeedback $ombudsmanFeedback)
    {
        $request->validate(['new_deadline' => 'required']);
        if($ombudsmanFeedback->update(['new_deadline' => $request->new_deadline])){
            return redirect()->route('ombudsman-feedback.index')->with('success', 'Prazo atualizado com sucesso!');
        }
        return redirect()->back()->with('error', 'Por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OmbudsmanFeedback $ombudsmanFeedback)
    {
        if($ombudsmanFeedback->delete()){
            return redirect()->route('ombudsman-feedback.index')->with('success', 'Manifestação apagada com sucesso!');
        }
        return redirect()->route('ombudsman-feedback.index')->with('error', 'Por favor tente novamente!');
    }
}
