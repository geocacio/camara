<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Councilor;
use App\Models\File;
use App\Models\Legislature;
use App\Models\LegislatureRelation;
use App\Models\Office;
use App\Models\Page;
use App\Models\PartyAffiliation;
use App\Models\TransparencyGroup;
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

    public function page()
    {
        $page_councilor = Page::where('name', 'Vereadores')->first();
        $groups = TransparencyGroup::all();
        return view('panel.councilor.page.edit', compact('page_councilor', 'groups'));
    }

    public function boardOfDirectors()
    {
        $page_councilor = Page::where('name', 'Mesa Diretora')->first();
        $groups = TransparencyGroup::all();
        return view('panel.councilor.page.board.edit', compact('page_councilor', 'groups'));
    }

    public function pageUpdate(Request $request)
    {
        $validateData = $request->validate([
            'transparency_group_id' => 'required',
            'main_title' => 'required',
            'title' => 'required',
            'icon' => 'nullable',
            'description' => 'nullable',
        ], [
            'main_title.required' => 'O campo título principal é obrigatório',
            'transparency_group_id.required' => 'O campo Grupo é obrigatório!',
            'title.required' => 'O campo título é obrigatório'
        ]);
        $validateData['visibility'] = $request->visibility ? $request->visibility : 'disabled';

        $page_councilor = Page::where('name', 'Vereadores')->first();

        if ($page_councilor->update($validateData)) {
            $page_councilor->groupContents()->delete();
            $page_councilor->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('councilors.page')->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->route('councilors.page')->with('error', 'Por favor tente novamente!');
    }

    public function boardOfDirectorsUpdate(Request $request)
    {
        $validateData = $request->validate([
            'transparency_group_id' => 'required',
            'main_title' => 'required',
            'title' => 'required',
            'icon' => 'nullable',
            'description' => 'nullable',
        ], [
            'main_title.required' => 'O campo título principal é obrigatório',
            'transparency_group_id.required' => 'O campo Grupo é obrigatório!',
            'title.required' => 'O campo título é obrigatório'
        ]);
        $validateData['visibility'] = $request->visibility ? $request->visibility : 'disabled';

        $page_councilor = Page::where('name', 'Mesa Diretora')->first();

        if ($page_councilor->update($validateData)) {
            $page_councilor->groupContents()->delete();
            $page_councilor->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('councilors.page')->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->route('councilors.page')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $councilors = Councilor::all();
        return view('panel.councilor.index', compact('councilors'));
    }

    public function allcouncilors(Request $request, Legislature $legislature = null){
        $allLegislatures = Legislature::all();
        
        $legislature = !$legislature ? (new Legislature)->getCurrentLegislature() : $legislature;

        $page_councilor = Page::where('name', 'Vereadores')->first();
        $query = Legislature::query();

        if($request->filled('legislature_id')){
            $query->where('id', $request->input('legislature_id'));
            $legislature = $query->first();
        }

        // Encontrar a posição da legislatura atual
        $currentLegislaturePosition = $legislature ? $legislature->fresh()->getOriginal('created_at') : null;
        $currentLegislaturePosition = $currentLegislaturePosition ? Legislature::where('created_at', '<=', $currentLegislaturePosition)->count() : null;

        $searchData = $request->only(['legislature_id']);
        return view('pages.councilors.index', compact('legislature', 'allLegislatures', 'searchData', 'currentLegislaturePosition'));
    }

    public function showBoard(Request $request, Legislature $legislature = null){
        $allLegislatures = Legislature::all();

        $legislature = !$legislature ? (new Legislature)->getCurrentLegislature() : $legislature;

        $page_councilor = Page::where('name', 'Mesa Diretora')->first();
        $query = Legislature::query();

        $cargo = [1, 2, 3, 4];
        $getcouncilorID = LegislatureRelation::whereIn('office_id', $cargo)->get();
        $councilors = Councilor::whereIn('id', $getcouncilorID->pluck('legislatureable_id'))->get();
        if($request->filled('legislature_id')){
            $query->where('id', $request->input('legislature_id'));
            $legislature = $query->first();
        }

        // Encontrar a posição da legislatura atual
        $currentLegislaturePosition = $legislature ? $legislature->fresh()->getOriginal('created_at') : null;
        $currentLegislaturePosition = $currentLegislaturePosition ? Legislature::where('created_at', '<=', $currentLegislaturePosition)->count() : null;

        $searchData = $request->only(['legislature_id']);
        return view('pages.councilors.board.index', compact('legislature', 'allLegislatures', 'searchData', 'currentLegislaturePosition', 'councilors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bonds = Category::where('slug', 'vinculo')->with('children')->first();
        $offices = Office::all();
        $affiliations = PartyAffiliation::all();
        return view('panel.councilor.create', compact('bonds', 'offices', 'affiliations'));
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
            'party_affiliation_id' => 'required',
            'affiliation_date' => 'required',
            'birth_date' => 'required|date',
            'biography' => 'nullable',
            'naturalness' => 'required',
            'file' => "nullable|image|mimes:jpeg,png,jpg,gif|max:{$this->fileUploadService->getMaxSize()}",
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'surname.required' => 'O campo sobrenome é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo email deve ser um endereço de email válido.',
            'phone.required' => 'O campo telefone é obrigatório.',
            'party_affiliation_id.required' => 'O campo filiação partidária é obrigatório.',
            'affiliation_date.required' => 'O campo data da filiação é obrigatório.',
            'birth_date.required' => 'O campo data de nascimento é obrigatório.',
            'naturalness.required' => 'O campo naturalidade é obrigatório.',
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
        return view('pages.councilors.single', compact('councilor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Councilor $councilor)
    {
        $bonds = Category::where('slug', 'vinculo')->with('children')->first();
        $offices = Office::all();
        $affiliations = PartyAffiliation::all();
        return view('panel.councilor.edit', compact('councilor', 'bonds', 'offices', 'affiliations'));
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
            'party_affiliation_id' => 'required',
            'affiliation_date' => 'required',
            'birth_date' => 'required|date',
            'naturalness' => 'required',
            'biography' => 'nullable',
            'file' => "nullable|image|mimes:jpeg,png,jpg,gif|max:{$this->fileUploadService->getMaxSize()}",
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'surname.required' => 'O campo sobrenome é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo email deve ser um endereço de email válido.',
            'phone.required' => 'O campo telefone é obrigatório.',
            'party_affiliation_id.required' => 'O campo filiação partidária é obrigatório.',
            'affiliation_date.required' => 'O campo data da filiação é obrigatório.',
            'birth_date.required' => 'O campo data de nascimento é obrigatório.',
            'naturalness.required' => 'O campo naturalidade é obrigatório.',
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
