<?php

namespace App\Http\Controllers;

use App\Models\Construction;
use Illuminate\Http\Request;
use App\Models\File;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Storage;

class ConstructionFileController extends Controller
{
    private $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Construction $construction)
    {
        return view('panel.construction.files.index', compact('construction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Construction $construction)
    {
        return view('panel.construction.files.create', compact('construction'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Construction $construction)
    {
        $validateData = $request->validate([
            "name" => "nullable",
            "description" => "nullable",
            'file' => "required|file|max:{$this->fileUploadService->getMaxSize()}",
        ], [
            'file.required' => 'O campo arquivo é obrigatório'
        ]);
        unset($validateData['file']);

        $file = $request->file('file');
        $validateData['url'] = $this->fileUploadService->upload($file, 'constructions');
        $newFile = File::create($validateData);
        if(!$newFile){
            return redirect()->back()->with('error', 'Error, Por favor tente novamente!');
        }

        if($construction->files()->create(['file_id' => $newFile->id])){
            return redirect()->route('constructions.file.index', $construction->slug)->with('success', 'Arquivo cadastrado com sucesso!');
        }
        
        return redirect()->back()->with('error', 'Error, Por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Construction $construction, File $file)
    {
        return view('panel.construction.files.edit', compact('construction', 'file'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Construction $construction, File $file)
    {
        $validateData = $request->validate([
            "name" => "nullable",
            "description" => "nullable",
            'file' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
        ]);
        unset($validateData['file']);
        if ($request->hasFile('file')) {
            if (Storage::disk('public')->exists($file->url)) {
                Storage::disk('public')->delete($file->url);
            }
            
            $new = $request->file('file');
            $validateData['url'] = $this->fileUploadService->upload($new, 'constructions');
        }

        if($file->update($validateData)){
            return redirect()->route('constructions.file.index', $construction->slug)->with('success', 'Arquivo cadastrado com sucesso!');
        }
        return redirect()->back()->with('error', 'Error, Por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Construction $construction, File $file)
    {
        if($this->fileUploadService->deleteFile($file->id)){
            return redirect()->back()->with('success', 'Arquivo removido com sucesso!');
        }
        return redirect()->back()->with('error', 'Error, Por favor tente novamente!');
    }
}
