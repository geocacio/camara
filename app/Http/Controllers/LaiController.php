<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\FileContent;
use App\Models\Lai;
use App\Models\Page;
use App\Models\TransparencyGroup;
use App\Services\FileUploadService;
use Illuminate\Http\Request;

class LaiController extends Controller
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
        $lai = Page::where('name', 'Regulamentação da Lai')->first();

        $groups = TransparencyGroup::all();

        $laiInfo = Lai::first();
        $fileID = FileContent::where('fileable_type', 'lai')->first();

        if($fileID){
            $files = File::where('id', $fileID->file_id)->first();
        }

        return isset($laiInfo) ? view('panel.lai.edit', compact('lai', 'groups', 'laiInfo', 'files')) : view('panel.lai.create', compact('groups', 'lai'));
    }

    public function pageShow(){
        $lai_page = Page::where('name', 'Regulamentação da Lai')->first();
        $laiInfo = Lai::first();
        return view('pages.lai.index', compact('laiInfo', 'lai_page'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'icon' => 'nullable',
            'transparency_group_id' => 'required',
            'main_title' => 'required',
        ], [
           'title.required' => 'O campo titulo é obrigatorio', 
           'transparency_group_id.required' => 'O campo Grupo é obrigatório!',
           'main_title.required' => 'O campo titulo principal é obrigatório!',
        ]);

        $lai = Page::create($validateData);

        if ($lai) {
            $lai->groupContents()->delete();
            $lai->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('lai.index')->with('success', 'Lai cadastrada com sucesso!');
        }

        return redirect()->back()->with('error', 'Por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lai $lai)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'icon' => 'nullable',
            'transparency_group_id' => 'required',
            'main_title' => 'required',
            'description' => 'nullable',
        ], [
           'title.required' => 'O campo título é obrigatório', 
           'transparency_group_id.required' => 'O campo Grupo é obrigatório!',
           'main_title.required' => 'O campo título principal é obrigatório!',
        ]);
    
        $lai = Page::where('name', 'Regulamentação da Lai')->first();
    
        $validateDataLai = $request->validate([
            'state_lai' => 'required|url',
            'federal_lai' => 'required|url',
            'description_lai' => 'required',
        ], [
            'state_lai.required' => 'O campo state_lai é obrigatório!',
            'federal_lai.required' => 'O campo federal_lai é obrigatório!',
        ]);
    
        $laiInfo = Lai::firstOrNew([
            'description' => $validateDataLai['description_lai'],
            'state_lai' => $validateDataLai['state_lai'],
            'federal_lai' => $validateDataLai['federal_lai'],
        ]);
    
        if (!$laiInfo->files->isEmpty()) {
            // Se já existir um arquivo associado à LAI, o campo 'file' não é obrigatório
            $request->validate([
                'file' => 'nullable',
            ]);
        } else {
            // Se não houver um arquivo associado à LAI, o campo 'file' é obrigatório
            $request->validate([
                'file' => 'required',
            ]);
        }
    
        if ($request->hasFile('file')) {
            $url = $this->fileUploadService->upload($request->file('file'), 'lai');
        
            $newFile = File::create(['url' => $url]);
        
            // Certifique-se de que $laiInfo esteja salvo no banco de dados antes de criar o relacionamento
            $laiInfo->save();
        
            // Associe o arquivo a lai_info na tabela associativa
            $laiInfo->files()->create(['file_id' => $newFile->id, 'fileable_id' => $laiInfo->id, 'fileable_type' => get_class($laiInfo)]);
        }
           
    
        $laiInfo->save();
    
        if ($lai->update($validateData)) {
            $lai->groupContents()->delete();
            $lai->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('lai.index')->with('success', 'Informações atualizadas com sucesso!');
        }
    
        return redirect()->back()->with('error', 'Por favor, tente novamente!');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lai $lai)
    {
        if($lai->delete()){
            return redirect()->route('lai.show')->with('success', 'Lai excluida com sucesso');
        }
        return redirect()->route('lai.show')->with('error', 'Por favor tente novamente');
    }
}
