<?php

namespace App\Http\Controllers;

use App\Models\ChamberFinancial;
use App\Models\File;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ChamberFinancialController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function index()
    {
        $chambersFinancial = ChamberFinancial::all();

        return view('panel.chamber-financials.index', compact('chambersFinancial'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.chamber-financials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'status' => 'nullable|string',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($chamberFinancial = ChamberFinancial::create($validated)) {
            if ($request->hasfile('files')) {
                $url = $this->fileUploadService->upload($request->file('files'), 'chambers-finance');
                $file = File::create(['url' => $url]);
                $chamberFinancial->files()->create(['file_id' => $file->id]);
            }

            return redirect()->route('chambers-financials.index')->with('success', 'Balancete cadastrado com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro ao tentar cadastrar balancete!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ChamberFinancial $chambers_financial)
    {
        return view('panel.chamber-financials.show', compact('chamberFinancial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChamberFinancial $chambers_financial)
    {
        return view('panel.chamber-financials.edit', compact('chambers_financial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChamberFinancial $chambers_financial)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'status' => 'nullable|string',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        if($chambers_financial->update($validated)){

            if($request->hasfile('files')){
                $url = $this->fileUploadService->upload($request->file('files'), 'chambers-finance');
                $file = File::create(['url' => $url]);
                $chambers_financial->files()->create(['file_id' => $file->id]);
            }

            return redirect()->route('chambers-financials.index')->with('success', 'Balancete atualizado com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro ao tentar atualizar balancete!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChamberFinancial $chambers_financial)
    {

        if($chambers_financial->files){
            if($chambers_financial->files->count() > 0){
                Storage::disk('public')->delete($chambers_financial->files[0]->file->url);
            }
        }

        if($chambers_financial->delete()){
            return redirect()->route('chambers-financials.index')->with('success', 'Balancete excluido com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro ao tentar excluir balancete!');
    }
}
