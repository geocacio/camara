<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\AgreementTransfer;
use Illuminate\Http\Request;

class AgreementTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Agreement $agreement)
    {
        return view('panel.agreement.transfer.index', compact('agreement'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Agreement $agreement)
    {
        return view('panel.agreement.transfer.create', compact('agreement'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Agreement $agreement, Request $request)
    {
        $validateData = $request->validate([
            "date_proponent" => "nullable",
            "value_proponent" => "nullable",
            "date_concedent" => "nullable",
            "value_concedent" => "nullable",
        ]);

        $validateData['value_proponent'] = $request->value_proponent ? str_replace(['R$', '.', ','], ['', '', '.'], $request->value_proponent) : null;
        $validateData['value_concedent'] = $request->value_concedent ? str_replace(['R$', '.', ','], ['', '', '.'], $request->value_concedent) : null;

        $transfer = $agreement->transfers()->create($validateData);

        if ($transfer) {
            return redirect()->route('agreements.transfer.index', $agreement->slug)->with('success', 'Repasse cadastrado com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(AgreementTransfer $transfer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agreement $agreement, AgreementTransfer $transfer)
    {
        return view('panel.agreement.transfer.edit', compact('agreement', 'transfer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Agreement $agreement, Request $request, AgreementTransfer $transfer)
    {
        $validateData = $request->validate([
            "date_proponent" => "nullable",
            "value_proponent" => "nullable",
            "date_concedent" => "nullable",
            "value_concedent" => "nullable",
        ]);


        if (strpos($request->value_proponent, 'R$') !== false) {
            $validateData['value_proponent'] = $request->value_proponent ? str_replace(['R$', '.', ','], ['', '', '.'], $request->value_proponent) : null;
        }

        if (strpos($request->value_concedent, 'R$') !== false) {
            $validateData['value_concedent'] = $request->value_concedent ? str_replace(['R$', '.', ','], ['', '', '.'], $request->value_concedent) : null;
        }

        if ($transfer->update($validateData)) {
            return redirect()->route('agreements.transfer.index', $agreement->slug)->with('success', 'Repasse atualizado com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agreement $agreement, AgreementTransfer $transfer)
    {
        if ($transfer->delete()) {
            return redirect()->back()->with('success', 'Repasse removido com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro, por favor tente novamente!');
    }
}
