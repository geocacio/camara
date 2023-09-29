<?php

namespace App\Http\Controllers;

use App\Models\Bidding;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Bidding $bidding)
    {
        return view('panel.companies.index', compact('bidding'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Bidding $bidding)
    {
        return view('panel.companies.create', compact('bidding'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Bidding $bidding)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'cnpj' => 'required',
            'address' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'country' => 'nullable',
        ]);
        $validatedData['slug'] = Str::slug($request->name);

        $company = $bidding->company()->create($validatedData);
        
        if ($company) {
            return redirect()->route('biddings.index')->with('success', 'Empresa cadastrada com sucesso!');
        }

        return redirect()->route('biddings.index')->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return view('panel.companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'cnpj' => 'required',
            'address' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'country' => 'nullable',
        ]);

        $company->update($validatedData);
        if ($company) {
            return redirect()->route('companies.index')->with('success', 'Empresa atualizada com sucesso!');
        }

        return redirect()->route('companies.index')->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('companies.index')->with('success', 'Empresa Excluída com sucesso!');
    }
}
