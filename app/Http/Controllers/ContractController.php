<?php

namespace App\Http\Controllers;

use App\Models\Bidding;
use App\Models\Company;
use App\Models\Contract;
use App\Models\File;
use App\Models\Inspector;
use App\Models\InspectorContract;
use App\Models\Type;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContractController extends Controller
{
    private $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Bidding $bidding)
    {
        $contracts = $bidding->company->contracts;
        return view('panel.contracts.index', compact('contracts', 'bidding'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Contract $contract, Bidding $bidding)
    {
        $companies = Company::all();
        $inspectors = Inspector::all();
        $types = Type::where('slug', 'contracts')->first()->children;
        return view('panel.contracts.create', compact('companies', 'bidding', 'contract', 'types', 'inspectors'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Bidding $bidding)
    {
        $validatedData = $request->validate([
            'number' => 'required',
            'company_id' => 'required',
            'type' => 'required',
            'parent_id' => 'nullable',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
            'total_value' => 'nullable',
            'description' => 'nullable',
            'file' => 'required',
            'inspector_id' => 'required',
        ]);

        $validatedData['slug'] = Str::slug($request->number);
        unset($validatedData['type']);
        $validatedData['total_value'] = $request->total_value ? str_replace(['R$', '.', ','], ['', '', '.'], $request->total_value) : null;
        $contract = $bidding->company->contracts()->create($validatedData);
        if($contract){
            InspectorContract::create([
                'inspector_id' => $request->inspector_id,
                'contract_id' => $contract->id,
            ]);

            if ($request->hasFile('file')) {
                $url = $this->fileUploadService->upload($request->file('file'), 'contracts');
                $file = File::create(['url' => $url]);
                $contract->files()->create(['file_id' => $file->id]);
            }
        }

        if ($contract) {
            $contract->types()->attach($request->type);

            return redirect()->route('biddings.company.contracts.index', $bidding->slug)->with('success', 'Contrato cadastrado com sucesso!');
        }

        return redirect()->route('biddings.company.contracts.index', $bidding->slug)->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        return view('panel.contracts.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bidding $bidding, $id)
    {
        $companies = Company::all();
        $types = Type::where('slug', 'contracts')->first()->children;
        $contract = Contract::find($id);
        $inspectors = Inspector::all();
        $files = $contract->files;
        return view('panel.contracts.edit', compact('contract', 'companies', 'types', 'bidding', 'files', 'inspectors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bidding $bidding, $id)
    {
        $contract = Contract::find($id);
        $validatedData = $request->validate([
            'number' => 'required',
            'parent_id' => 'nullable',
            'company_id' => 'required',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
            'total_value' => 'nullable',
            'description' => 'nullable',
        ]);
        $validatedData['total_value'] = $request->total_value ? str_replace(['R$', '.', ','], ['', '', '.'], $request->total_value) : null;
    
        if ($contract) {
            // Apagar o InspectorContract associado ao inspector_id e contract_id
            InspectorContract::where('inspector_id', $request->inspector_id)
                ->where('contract_id', $contract->id)
                ->delete();
    
            // Atualizar os dados do contrato
            $contract->update($validatedData);

            InspectorContract::create([
                'inspector_id' => $request->inspector_id,
                'contract_id' => $contract->id,
            ]);
    
            // Attach dos tipos de contrato
            $contract->types()->detach();
            $contract->types()->attach($request->type);
    
            return redirect()->route('biddings.company.contracts.index', $bidding->slug)->with('success', 'Contrato atualizado com sucesso!');
        }
    
        return redirect()->route('biddings.company.contracts.index', $bidding->slug)->with('error', 'Erro, por favor, tente novamente!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bidding $bidding, $id)
    {
        
        $contract = Contract::find($id);
        $contract->inspectorContracts()->delete();
        $contract->types()->detach();
        $contract->children()->delete();
        $contract->delete();
        return redirect()->route('biddings.company.contracts.index', $bidding->slug)->with('success', 'Contrato Excluído com sucesso!');
    }
}
