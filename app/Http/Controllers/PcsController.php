<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\File;
use App\Models\Pcs;
use App\Models\Type;
use App\Models\TypeContent;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PcsController extends Controller
{
    private $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pcss = Pcs::all();
        return view('panel.pcs.index', compact('pcss'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::where('slug', 'pcg')->first()->children;
        $exercicies = Category::where('slug', 'exercicios')->with('children')->first();
        return view('panel.pcs.create', compact('types', 'exercicies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'type_id' => 'required',
            'exercicy_id' => 'required',
            'manager' => 'required',
            'date' => 'required|date',
            'audit_court_situation' => 'nullable',
            'court_accounts_date' => 'nullable',
            'file' => "required|file|max:{$this->fileUploadService->getMaxSize()}",
        ], [
            'date.required' => 'O campo Data é obrigatório.',
            'type_id.required' => 'O campo Tipo é obrigatório.',
            'exercicy_id.required' => 'O campo Exercício é obrigatório.',
            'manager.required' => 'O campo Gestor é obrigatório.',
        ]);

        $validateData['audit_court_situation'] = $validateData['audit_court_situation'] ? $validateData['audit_court_situation'] : 'Aguardando...';
        $validateData['court_accounts_date'] = $validateData['court_accounts_date'] ? $validateData['court_accounts_date'] : 'Aguardando...';

        $validateData['slug'] = Pcs::uniqSlugByYearId();

        if ($pcs = Pcs::create($validateData)) {
            if ($request->hasFile('file')) {
                $url = $this->fileUploadService->upload($request->file('file'), 'pcs');
                $file = File::create(['url' => $url]);
                $pcs->files()->create(['file_id' => $file->id]);
            }

            TypeContent::create([
                'type_id' => $validateData['type_id'],
                'typeable_id' => $pcs->id,
                'typeable_type' => 'Pcs',
            ]);

            return redirect()->route('pcs.index')->with('success', 'Pcs cadastrado com sucesso.');
        }
        return redirect()->back()->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pcs $pcs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pcs $pc)
    {
        $types = Type::where('slug', 'pcg')->first()->children;
        $exercicies = Category::where('slug', 'exercicios')->with('children')->first();
        return view('panel.pcs.edit', compact('pc','types', 'exercicies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pcs $pc)
    {
        $validateData = $request->validate([
            'type_id' => 'required',
            'exercicy_id' => 'required',
            'manager' => 'required',
            'date' => 'required|date',
            'audit_court_situation' => 'nullable',
            'court_accounts_date' => 'nullable',
            'file' => "nulable|file|max:{$this->fileUploadService->getMaxSize()}",
        ], [
            'date.required' => 'O campo Data é obrigatório.',
            'type_id.required' => 'O campo Tipo é obrigatório.',
            'exercicy_id.required' => 'O campo Exercício é obrigatório.',
            'manager.required' => 'O campo Gestor é obrigatório.',
        ]);

        $validateData['audit_court_situation'] = $validateData['audit_court_situation'] ? $validateData['audit_court_situation'] : 'Aguardando...';
        $validateData['court_accounts_date'] = $validateData['court_accounts_date'] ? $validateData['court_accounts_date'] : 'Aguardando...';

        if ($pc->update($validateData)) {
            if ($request->hasFile('file')) {
                if (Storage::disk('public')->exists($pc->files[0]->file->url)) {
                    Storage::disk('public')->delete($pc->files[0]->file->url);
                }
                $url = $this->fileUploadService->upload($request->file('file'), 'pcs');
                $file = File::create(['url' => $url]);
                $pc->files()->create(['file_id' => $file->id]);
            }
            $typeContent = TypeContent::where('typeable_id', $pc->id)->where('typeable_type', 'Pcs')->first();
            $typeContent->update(['type_id' => $validateData['type_id']]);

            return redirect()->route('pcs.index')->with('success', 'PCS atualizado com sucesso.');
        }
        return redirect()->back()->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pcs $pc)
    {
        if (Storage::disk('public')->exists($pc->files[0]->file->url)) {
            Storage::disk('public')->delete($pc->files[0]->file->url);
        }

        $typeContent = TypeContent::where('typeable_id', $pc->id)->where('typeable_type', 'Pcs')->first();
        if ($typeContent) {
            $typeContent->delete();
        }
        
        $pc->delete();
        return redirect()->back()->with('success', 'PCS excluido com sucesso!');
    }
}
