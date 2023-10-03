<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Councilor;
use App\Models\File;
use App\Models\Office;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CouncilorController extends Controller
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
        $councilors = Councilor::all();
        return view('panel.councilor.index', compact('councilors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bonds = Category::where('slug', 'vinculo')->with('children')->first();
        $offices = Office::all();
        return view('panel.councilor.create', compact('bonds', 'offices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'office_id' => 'required',
            'bond_id' => 'required',
            'start_bond' => 'required',
            'birth_date' => 'required|date',
            'biography' => 'nullable',
            'file' => "nullable|image|mimes:jpeg,png,jpg,gif|max:{$this->fileUploadService->getMaxSize()}",
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'surname.required' => 'O campo sobrenome é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo email deve ser um endereço de email válido.',
            'phone.required' => 'O campo telefone é obrigatório.',
            'office_id.required' => 'O campo cargo atual é obrigatório.',
            'bond_id.required' => 'O campo vínculo atual é obrigatório.',
            'start_bond.required' => 'O campo data de início do vínculo é obrigatório.',
            'birth_date.required' => 'O campo data de nascimento é obrigatório.',
            'file.mimes' => "O campo imagem do perfil deve ser um dos tipos: jpeg, png, jpg, gif.",
            'file.max' => "O campo imagem do perfil não pode ter mais de {$this->fileUploadService->getMaxSize()} bytes.",

        ]);

        $validateData['slug'] = Councilor::uniqSlug($validateData['name']);

        $councilor = Councilor::create($validateData);

        if ($councilor) {
            if ($request->hasFile('file')) {
                $url = $this->fileUploadService->upload($request->file('file'), 'councilors');
                $file = File::create(['url' => $url]);
                $councilor->files()->create(['file_id' => $file->id]);
            }

            return redirect()->route('councilors.index')->with('success', 'Verador cadastrado com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro ao cadastrar Verador. Por favor, tente novamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Councilor $councilor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Councilor $councilor)
    {
        $bonds = Category::where('slug', 'vinculo')->with('children')->first();
        $offices = Office::all();
        return view('panel.councilor.edit', compact('councilor', 'bonds', 'offices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Councilor $councilor)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'office_id' => 'required',
            'bond_id' => 'required',
            'start_bond' => 'required',
            'birth_date' => 'required|date',
            'biography' => 'nullable',
            'file' => "nullable|image|mimes:jpeg,png,jpg,gif|max:{$this->fileUploadService->getMaxSize()}",
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'surname.required' => 'O campo sobrenome é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo email deve ser um endereço de email válido.',
            'phone.required' => 'O campo telefone é obrigatório.',
            'office_id.required' => 'O campo cargo atual é obrigatório.',
            'bond_id.required' => 'O campo vínculo atual é obrigatório.',
            'start_bond.required' => 'O campo data de início do vínculo é obrigatório.',
            'birth_date.required' => 'O campo data de nascimento é obrigatório.',
            'file.mimes' => "O campo imagem do perfil deve ser um dos tipos: jpeg, png, jpg, gif.",
            'file.max' => "O campo imagem do perfil não pode ter mais de {$this->fileUploadService->getMaxSize()} bytes.",

        ]);
        
        if ($councilor->update($validateData)) {
            if ($request->hasFile('file')) {
                if ($councilor->files->count() > 0) {
                    $this->fileUploadService->deleteFile($councilor->files[0]->file->id);
                }

                $url = $this->fileUploadService->upload($request->file('file'), 'councilors');
                $file = File::create(['url' => $url]);
                $councilor->files()->create(['file_id' => $file->id]);
            }

            return redirect()->route('councilors.index')->with('success', 'Verador cadastrado com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro ao cadastrar Verador. Por favor, tente novamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Councilor $councilor)
    {
        if ($councilor->files->count() > 0) {
            Storage::disk('public')->delete($councilor->files[0]->file->url);
        }

        if ($councilor->delete()) {
            return redirect()->back()->with('success', 'Vereador removido com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro ao remover Verador, Por favor tente novamente!');
    }
}
