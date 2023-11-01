<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\GeneralProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AgreementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $agreements = Agreement::all();
        // return view('panel.agreement.index', compact('agreements'));

        $search = $request->query('search');
        $perPage = $request->query('perPage', 10);
        $query = Agreement::query(); //select * from `laws`
        if ($search) {
            $query->with('exercicy');
            $query->where('number', $search); //"select * from `laws` where `number` LIKE ?"
            $query->orWhere('description', 'LIKE', '%' . $search . '%'); //"select * from `laws` where `number` LIKE ? or `description` LIKE ?" 
            $query->orWhereHas('exercicy', function ($query) use ($search) {
                $query->where('name', $search);
            }); //"select * from `laws` where `number` LIKE ? or `description` LIKE ? or exists (select * from `categories` where `laws`.`exercicy_id` = `categories`.`id` and `name` = ?)
        }

        $agreements = $query->paginate($perPage)->appends(['search' => $search, 'perPage' => $perPage]);
        return view('panel.agreement.index', compact('agreements', 'search', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.agreement.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'sphere' => 'required',
            'validity' => 'required',
            'celebration' => 'required',
            'bank_account' => 'nullable',
            'instrument_number' => 'nullable',
            'object' => 'nullable',
            'counterpart' => 'required',
            'transfer' => 'required',
            'agreed' => 'required',
            'grantor' => 'required',
            'grantor_responsible' => 'required',
            'convenent' => 'required',
            'convenent_responsible' => 'required',
            'justification' => 'nullable',
            'goals' => 'nullable',
        ], [
            'sphere.required' => 'O campo título esfera é obrigatório',
            'validity.required' => 'O campo vigência é obrigatório!',
            'celebration.required' => 'O campo celebração é obrigatório',

            'counterpart.required' => 'O campo contrapartisa é obrigatório',
            'transfer.required' => 'O campo transferencia é obrigatório',
            'agreed.required' => 'O campo pactuada é obrigatório',
            'grantor.required' => 'O campo concedente é obrigatório',
            'grantor_responsible.required' => 'O campo concedente responsável é obrigatório',
            'convenent.required' => 'O campo convenente é obrigatório',
            'convenent_responsible.required' => 'O campo convenente responsável é obrigatório',
        ]);
        $validateData['counterpart'] = str_replace(['R$', '.', ','], ['', '', '.'], $validateData['counterpart']);
        $validateData['transfer'] = str_replace(['R$', '.', ','], ['', '', '.'], $validateData['transfer']);
        $validateData['agreed'] = str_replace(['R$', '.', ','], ['', '', '.'], $validateData['agreed']);
        $validateData['slug'] = Agreement::uniqSlugByYearId();

        $agreement = Agreement::create($validateData);

        if ($agreement) {
            $agreement->generalProgress()->create(['date' => now(), 'situation' => 'Aguardando']);
            return redirect()->route('agreements.index')->with('success', 'Convênio cadastrado com sucesso!');
        }
        return redirect()->back()->with('error', 'Error, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Agreement $agreement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agreement $agreement)
    {
        return view('panel.agreement.edit', compact('agreement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agreement $agreement)
    {
        $validateData = $request->validate([
            'sphere' => 'required',
            'validity' => 'required',
            'celebration' => 'required',
            'bank_account' => 'nullable',
            'instrument_number' => 'nullable',
            'object' => 'nullable',
            'counterpart' => 'required',
            'transfer' => 'required',
            'agreed' => 'required',
            'grantor' => 'required',
            'grantor_responsible' => 'required',
            'convenent' => 'required',
            'convenent_responsible' => 'required',
            'justification' => 'nullable',
            'goals' => 'nullable',
        ], [
            'sphere.required' => 'O campo título esfera é obrigatório',
            'validity.required' => 'O campo vigência é obrigatório!',
            'celebration.required' => 'O campo celebração é obrigatório',

            'counterpart.required' => 'O campo contrapartisa é obrigatório',
            'transfer.required' => 'O campo transferencia é obrigatório',
            'agreed.required' => 'O campo pactuada é obrigatório',
            'grantor.required' => 'O campo concedente é obrigatório',
            'grantor_responsible.required' => 'O campo concedente responsável é obrigatório',
            'convenent.required' => 'O campo convenente é obrigatório',
            'convenent_responsible.required' => 'O campo convenente responsável é obrigatório',
        ]);
        $validateData['counterpart'] = str_replace(['R$', '.', ','], ['', '', '.'], $validateData['counterpart']);
        $validateData['transfer'] = str_replace(['R$', '.', ','], ['', '', '.'], $validateData['transfer']);
        $validateData['agreed'] = str_replace(['R$', '.', ','], ['', '', '.'], $validateData['agreed']);

        if ($agreement->update($validateData)) {
            return redirect()->route('agreements.index')->with('success', 'Convênio atualizado com sucesso!');
        }
        return redirect()->back()->with('error', 'Error, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agreement $agreement)
    {
        //
    }

    public function situations(Agreement $agreement)
    {
        return view('panel.agreement.situation.index', compact('agreement'));
    }

    public function sitCreate(Agreement $agreement)
    {
        return view('panel.agreement.situation.create', compact('agreement'));
    }

    public function sitStore(Request $request, Agreement $agreement)
    {
        $validateData = $request->validate(
            [
                'date' => 'required',
                'situation' => 'required',
            ],
            [
                'date.required' => 'O campo data é obrigatório',
                'situation.required' => 'O campo situação é obrigatório',
            ]
        );

        if($agreement->generalProgress()->create($validateData)){
            return redirect()->route('agreements.situations', $agreement->slug)->with('success', 'Progresso cadastrado com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro, por favor tente novamente!');
    }
    
    public function sitEdit(Agreement $agreement, GeneralProgress $general_progress)
    {
        return view('panel.agreement.situation.edit', compact('general_progress', 'agreement'));
    }

    public function sitUpdate(Request $request, Agreement $agreement, GeneralProgress $general_progress)
    {
        $validateData = $request->validate(
            [
                'date' => 'required',
                'situation' => 'required',
            ],
            [
                'date.required' => 'O campo data é obrigatório',
                'situation.required' => 'O campo situação é obrigatório',
            ]
        );

        if($general_progress->update($validateData)){
            return redirect()->route('agreements.situations', $agreement->slug)->with('success', 'Progresso atualizado com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro, por favor tente novamente!');
    }

    public function sitDestroy(Agreement $agreement, GeneralProgress $general_progress)
    {
        if($general_progress->delete()){
            return redirect()->route('agreements.situations', $agreement->slug)->with('success', 'Progresso removido com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro, por favor tente novamente!');
    }
}
