<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Recipient;
use Illuminate\Http\Request;

class RecipientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Material $material)
    {
        return view('panel.materials.recipients.index', compact('material'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Material $material)
    {
        return view('panel.materials.recipients.create', compact('material'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Material $material)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'position' => 'required',
            'organization' => 'required',
        ],[
            'name.required' => 'O campo Nome é obrigatório',
            'position.required' => 'O campo Posição é obrigatório',
            'organization.required' => 'O campo Organização é obrigatório',
        ]);

        $validateData['slug'] = Recipient::uniqSlug($validateData['name']);

        $recipient = $material->recipients()->create($validateData);

        if($recipient){
            return redirect()->route('recipients.index', $material->slug)->with('success', 'Destinatário cadastrado com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipient $recipient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material, Recipient $recipient)
    {
        return view('panel.materials.recipients.edit', compact('material', 'recipient'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material, Recipient $recipient)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'position' => 'required',
            'organization' => 'required',
        ],[
            'name.required' => 'O campo Nome é obrigatório',
            'position.required' => 'O campo Posição é obrigatório',
            'organization.required' => 'O campo Organização é obrigatório',
        ]);

        $recipient = $material->recipients()->update($validateData);

        if($recipient){
            return redirect()->route('recipients.index', $material->slug)->with('success', 'Destinatário atualizado com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material, Recipient $recipient)
    {
        if($recipient->delete()){
            return redirect()->route('recipients.index', $material->slug)->with('success', 'Destinatário removido com sucesso!');
        }
        return redirect()->route('recipients.index', $material->slug)->with('error', 'Erro, por favor tente novamente!');
    }
}
