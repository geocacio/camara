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
        $files = File::where('id', $fileID->file_id)->first();

        return isset($lai) ? view('panel.lai.edit', compact('lai', 'groups', 'laiInfo', 'files')) : view('panel.lai.create', compact('groups'));
    }

    public function pageShow(){
        
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
           'title.required' => 'O campo titulo é obrigatorio', 
           'transparency_group_id.required' => 'O campo Grupo é obrigatório!',
           'main_title.required' => 'O campo titulo principal é obrigatório!',
        ]);

        $lai = Page::where('name', 'Regulamentação da Lai')->first();

        $validateDataLai = $request->validate([
            'file' => 'required',
            'state_lai' => 'required|url',
            'federal_lai' => 'required|url',
            'description_lai' => 'required',
        ], [
            'file.required' => 'O campo file é obrigatório', 
            'state_lai.required' => 'O campo state_lai é obrigatório!',
            'federal_lai.required' => 'O campo federal_lai é obrigatório!',
        ]);
        
        $laiInfo = Lai::firstOrNew([
            'description' => $validateDataLai['description_lai'],
            'state_lai' => $validateDataLai['state_lai'],
            'federal_lai' => $validateDataLai['federal_lai'],
        ]);

        if ($request->hasFile('file')) {
            $url = $this->fileUploadService->upload($request->file('file'), 'lai');
            $newFile = File::create(['url' => $url]);
            $laiInfo->files()->create(['file_id' => $newFile->id]);
        }        

        $laiInfo->save();
    
        if ($lai->update($validateData)) {
            $lai->groupContents()->delete();
            $lai->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('lai.index')->with('success', 'Informações atualizadas com sucesso!');
        }

        return redirect()->back()->with('error', 'Por favor tente novamente!');
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
