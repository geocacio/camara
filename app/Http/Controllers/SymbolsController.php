<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Page;
use App\Models\Symbols;
use App\Models\TransparencyGroup;
use Illuminate\Http\Request;
use App\Services\FileUploadService;

class SymbolsController extends Controller
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
        $symbol = Symbols::first();
        $pageSymbol = Page::where('name', 'Símbolos')->first();
        $groups = TransparencyGroup::all();
        
        if ($symbol) {
            $coatArms = '';
            $flag = '';
            if ($symbol->files->count() > 0) {
                foreach ($symbol->files as $files) {
                    if ($files->file->name == 'Brasão') {
                        $coatArms = $files->file;
                    }
                    if ($files->file->name == 'Bandeira') {
                        $flag = $files->file;
                    }
                }
            }
            return view('panel.symbols.edit', compact('symbol', 'coatArms', 'flag', 'pageSymbol', 'groups'));
        }

        return view('panel.symbols.create', compact('pageSymbol', 'groups'));
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

        $pageSymbol = Page::where('name', 'Símbolos')->first();

        if ($pageSymbol->update($validateData)) {
            $pageSymbol->groupContents()->delete();
            $pageSymbol->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return true;
        }
        return false;
    }

    public function page(){
        $symbol = Symbols::first();
        $pageSymbol = Page::where('name', 'Símbolos')->first();
        return view('pages.symbols.index', compact('symbol', 'pageSymbol'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $page = $this->pageUpdate($request);

        if (!$page) {
            return redirect()->route('symbols.index')->with('errer', 'Por favor, tente novamente!');
        }
    
        $validateData = $request->validate([
            'himn' => 'nullable',
            'himn_url' => 'nullable',
            'coat_of_arms' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
            'flag' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
        ]);
    
        $symbol = Symbols::create($validateData);

        if($symbol){

            if ($request->hasFile('coat_of_arms')) {
                $url = $this->fileUploadService->upload($request->file('coat_of_arms'), 'symbols');
                $file = File::create(['name' => 'Brasão', 'url' => $url]);
                $symbol->files()->create(['file_id' => $file->id]);
            }
            if ($request->hasFile('flag')) {
                $url = $this->fileUploadService->upload($request->file('flag'), 'symbols');
                $file = File::create(['name' => 'Bandeira', 'url' => $url]);
                $symbol->files()->create(['file_id' => $file->id]);
            }

            return redirect()->route('symbols.index')->with('success', 'Símbolo criados com sucesso!');
        }
        return redirect()->route('symbols.index')->with('errer', 'Por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Symbols $symbol)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Symbols $symbol)
    {
        if(!$this->pageUpdate($request)){
            return redirect()->route('symbols.index')->with('errer', 'Por favor tente novamente!');
        }
        
        $validateData = $request->validate([
            'himn' => 'nullable',
            'himn_url' => 'nullable',
            'coat_of_arms' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
            'flag' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
        ]);

        if($symbol->update($validateData)){if ($request->hasFile('coat_of_arms')) {

            foreach ($symbol->files as $fileRelation) {
                if ($fileRelation->file->name === 'Brasão') {
                    $this->fileUploadService->deleteFile($fileRelation->file->id);
                    break;
                }
            }

            $url = $this->fileUploadService->upload($request->file('coat_of_arms'), 'symbols');
            $file = File::create(['name' => 'Brasão', 'url' => $url]);
            $symbol->files()->create(['file_id' => $file->id]);
        }
        if ($request->hasFile('flag')) {
            foreach ($symbol->files as $fileRelation) {
                if ($fileRelation->file->name === 'Bandeira') {
                    $this->fileUploadService->deleteFile($fileRelation->file->id);
                    break;
                }
            }
            $url = $this->fileUploadService->upload($request->file('flag'), 'symbols');
            $file = File::create(['name' => 'Bandeira', 'url' => $url]);
            $symbol->files()->create(['file_id' => $file->id]);
        }
            return redirect()->route('symbols.index')->with('success', 'Símbolos atualizados com sucesso!');
        }
        return redirect()->route('symbols.index')->with('errer', 'Por favor tente novamente!');
    }
}
