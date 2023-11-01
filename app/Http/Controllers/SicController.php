<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Secretary;
use App\Models\Sic;
use App\Models\TransparencyGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $esicPage = Page::where('name', 'eSIC')->first();
        $sic = Sic::first();
        $groups = TransparencyGroup::all();

        return view('panel.sic.page.edit', compact('sic', 'esicPage', 'groups'));
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
    public function show()
    {
        $esicPage = Page::where('name', 'eSIC')->first();
        $sic = Sic::first();
        return view('pages.sic.index', compact('sic', 'esicPage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        $validatedSic = $request->validate(
            [
                'manager' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'cep' => 'nullable',
                'street' => 'nullable',
                'number' => 'nullable',
                'complement' => 'nullable',
                'neighborhood' => 'nullable',
                'opening_hours' => 'nullable',
            ],
            [
                'manager.required' => 'O campo Gestor é obrigatório',
                'phone.required' => 'O campo Telefone é obrigatório',
                'email.required' => 'O campo E-mail é obrigatório',
            ]
        );

        $validatedESicPage = $request->validate([
            'transparency_group_id' => 'required',
            'main_title' => 'required',
            'title' => 'required',
            'icon' => 'nullable',
            'description' => 'nullable',
            'visibility' => 'nullable',
        ], [
            'transparency_group_id.required' => 'O campo Grupo é obrigatório!',
            'main_title.required' => 'O campo Título principal é obrigatório!',
            'transparency_group_id.required' => 'O campo Grupo é obrigatório!',
            'title.required' => 'O campo Título é obrigatório!'
        ]);

        $esicPage = Page::where('name', 'eSIC')->first();
        if (!$esicPage->update($validatedESicPage)) {
            return redirect()->route('esic.index')->with('error', 'Por favor tente novamente!');
        }
        
        $esicPage->groupContents()->delete();
        $esicPage->groupContents()->create(['transparency_group_id' => $validatedESicPage['transparency_group_id']]);

        $sic = Sic::first();
        if ($sic) {
            $sic->update($validatedSic);
        } else {
            $sic = Sic::create($validatedSic);
        }
        if ($sic) {
            return redirect()->route('esic.index')->with('success', 'Página atualizada com sucesso!');
        }

        return redirect()->route('esic.index')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sic $sic)
    {
        //
    }

    public function login()
    {
        return view('pages.sic.panel.login');
    }

    public function register()
    {
        return view('pages.sic.panel.register');
    }

    public function panel()
    {
        return view('pages.sic.panel.panel');
    }

    public function solicitations()
    {
        return view('pages.sic.panel.solicitations.index');
    }

    public function solicitationCreate()
    {
        $secretaries = Secretary::all();
        return view('pages.sic.panel.solicitations.create', compact('secretaries'));
    }

    public function solicitationEdit()
    {
        return view('pages.sic.panel.solicitations.edit');
    }
}
