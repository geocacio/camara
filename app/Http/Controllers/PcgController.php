<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\File;
use App\Models\Page;
use App\Models\Pcg;
use App\Models\TransparencyGroup;
use App\Models\Type;
use App\Models\TypeContent;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PcgController extends Controller
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
        $pcgs = Pcg::all();
        return view('panel.pcg.index', compact('pcgs'));
    }

    
    public function page()
    {
        $pcgPage = Page::where('name', 'Prestação de contas de governo')->first();
        $groups = TransparencyGroup::all();

        return view('panel.pcg.page.edit', compact('pcgPage', 'groups'));
    }

    public function pageUpdate(Request $request)
    {
        $validateData = $request->validate([
            'transparency_group_id' => 'required',
            'main_title' => 'required',
            'title' => 'required',
            'icon' => 'nullable',
            'description' => 'nullable',
            'link_type' => 'nullable',
            'url' => 'nullable',
        ], [
            'main_title.required' => 'O campo título principal é obrigatório',
            'transparency_group_id.required' => 'O campo Grupo é obrigatório!',
            'title.required' => 'O campo título é obrigatório'
        ]);
        $validateData['visibility'] = $request->visibility ? $request->visibility : 'disabled';

        $pcgPage = Page::where('name', 'Prestação de contas de governo')->first();

        if ($pcgPage->update($validateData)) {
            $pcgPage->groupContents()->delete();
            $pcgPage->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('pcg.page')->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->route('pcg.page')->with('error', 'Por favor tente novamente!');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::where('slug', 'pcg')->first()->children;
        $exercicies = Category::where('slug', 'exercicios')->with('children')->first();
        return view('panel.pcg.create', compact('types', 'exercicies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'type_id' => 'required',
            'exercicy_id' => 'required',
            'date' => 'required|date',
            'audit_court_situation' => 'nullable',
            'court_accounts_date' => 'nullable',
            'legislative_judgment_situation' => 'nullable',
            'legislative_judgment_date' => 'nullable',
            'file' => "required|file|max:{$this->fileUploadService->getMaxSize()}",
        ], [
            'date.required' => 'O campo Data é obrigatório.',
            'type_id.required' => 'O campo Tipo é obrigatório.',
            'exercicy_id.required' => 'O campo Exercício é obrigatório.',
        ]);

        $validateData['audit_court_situation'] = $validateData['audit_court_situation'] ? $validateData['audit_court_situation'] : 'Aguardando...';
        $validateData['court_accounts_date'] = $validateData['court_accounts_date'] ? $validateData['court_accounts_date'] : 'Aguardando...';
        $validateData['legislative_judgment_situation'] = $validateData['legislative_judgment_situation'] ? $validateData['legislative_judgment_situation'] : 'Aguardando...';
        $validateData['legislative_judgment_date'] = $validateData['legislative_judgment_date'] ? $validateData['legislative_judgment_date'] : 'Aguardando...';

        $validateData['slug'] = Pcg::uniqSlugByYearId();

        if ($pcg = Pcg::create($validateData)) {
            if ($request->hasFile('file')) {
                $url = $this->fileUploadService->upload($request->file('file'), 'pcg');
                $file = File::create(['url' => $url]);
                $pcg->files()->create(['file_id' => $file->id]);
            }

            TypeContent::create([
                'type_id' => $validateData['type_id'],
                'typeable_id' => $pcg->id,
                'typeable_type' => 'Pcg',
            ]);

            return redirect()->route('pcg.index')->with('success', 'Pcg cadastrado com sucesso.');
        }
        return redirect()->back()->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pcg $pcg)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pcg $pcg)
    {
        $types = Type::where('slug', 'pcg')->first()->children;
        $exercicies = Category::where('slug', 'exercicios')->with('children')->first();
        return view('panel.pcg.edit', compact('pcg','types', 'exercicies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pcg $pcg)
    {
        $validateData = $request->validate([
            'type_id' => 'required',
            'exercicy_id' => 'required',
            'date' => 'required|date',
            'audit_court_situation' => 'nullable',
            'court_accounts_date' => 'nullable',
            'legislative_judgment_situation' => 'nullable',
            'legislative_judgment_date' => 'nullable',
            'file' => "nulable|file|max:{$this->fileUploadService->getMaxSize()}",
        ], [
            'date.required' => 'O campo Data é obrigatório.',
            'type_id.required' => 'O campo Tipo é obrigatório.',
            'exercicy_id.required' => 'O campo Exercício é obrigatório.',
        ]);

        $validateData['audit_court_situation'] = $validateData['audit_court_situation'] ? $validateData['audit_court_situation'] : 'Aguardando...';
        $validateData['court_accounts_date'] = $validateData['court_accounts_date'] ? $validateData['court_accounts_date'] : 'Aguardando...';
        $validateData['legislative_judgment_situation'] = $validateData['legislative_judgment_situation'] ? $validateData['legislative_judgment_situation'] : 'Aguardando...';
        $validateData['legislative_judgment_date'] = $validateData['legislative_judgment_date'] ? $validateData['legislative_judgment_date'] : 'Aguardando...';

        if ($pcg->update($validateData)) {
            if ($request->hasFile('file')) {
                if (Storage::disk('public')->exists($pcg->files[0]->file->url)) {
                    Storage::disk('public')->delete($pcg->files[0]->file->url);
                }
                $url = $this->fileUploadService->upload($request->file('file'), 'pcg');
                $file = File::create(['url' => $url]);
                $pcg->files()->create(['file_id' => $file->id]);
            }
            $typeContent = TypeContent::where('typeable_id', $pcg->id)->where('typeable_type', 'Pcg')->first();
            $typeContent->update(['type_id' => $validateData['type_id']]);

            return redirect()->route('pcg.index')->with('success', 'Pcg atualizado com sucesso.');
        }
        return redirect()->back()->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pcg $pcg)
    {
        if (Storage::disk('public')->exists($pcg->files[0]->file->url)) {
            Storage::disk('public')->delete($pcg->files[0]->file->url);
        }

        $typeContent = TypeContent::where('typeable_id', $pcg->id)->where('typeable_type', 'Pcg')->first();
        if ($typeContent) {
            $typeContent->delete();
        }
        
        $pcg->delete();
        return redirect()->back()->with('success', 'PCG excluido com sucesso!');
    }
}
