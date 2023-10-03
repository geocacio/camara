<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Councilor;
use App\Models\Office;
use App\Services\FileUploadService;
use Illuminate\Http\Request;

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
        return view('panel.councilor.index');
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
            'profile_image' => "nullable|image|mimes:jpeg,png,jpg,gif|max:{$this->fileUploadService->getMaxSize()}",
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
            'profile_image.mimes' => "O campo imagem do perfil deve ser um dos tipos: jpeg, png, jpg, gif.",
            'profile_image.max' => "O campo imagem do perfil não pode ter mais de {$this->fileUploadService->getMaxSize()} bytes.",

        ]);

        $validateData['slug'] = Councilor::uniqSlug($validateData['name']);

        if ($request->hasFile('profile_image')) {
            $profileImage = $request->file('profile_image');
            $profileImagePath = $this->fileUploadService->upload($profileImage, 'councilors');
            $validateData['profile_image'] = $profileImagePath;
        }

        $councilor = Councilor::create($validateData);

        if ($councilor) {
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
        return view('panel.councilor.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Councilor $councilor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Councilor $councilor)
    {
        //
    }
}
