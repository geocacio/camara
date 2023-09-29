<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\File;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AgreementFileController extends Controller
{
    private $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Agreement $agreement)
    {
        // dd($agreement->files[0]->file);
        return view('panel.agreement.files.index', compact('agreement'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Agreement $agreement)
    {
        return view('panel.agreement.files.create', compact('agreement'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Agreement $agreement, Request $request)
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
        $validateData['url'] = $this->fileUploadService->upload($file, 'agreements');
        $newFile = File::create($validateData);
        if(!$newFile){
            return redirect()->back()->with('error', 'Error, Por favor tente novamente!');
        }

        if($agreement->files()->create(['file_id' => $newFile->id])){
            return redirect()->route('agreements.file.index', $agreement->slug)->with('success', 'Arquivo cadastrado com sucesso!');
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
    public function edit(Agreement $agreement, File $file)
    {
        return view('panel.agreement.files.edit', compact('agreement', 'file'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Agreement $agreement, Request $request, File $file)
    {
        // dd($file);
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
            $validateData['url'] = $this->fileUploadService->upload($new, 'agreements');
        }

        if($file->update($validateData)){
            return redirect()->route('agreements.file.index', $agreement->slug)->with('success', 'Arquivo cadastrado com sucesso!');
        }
        return redirect()->back()->with('error', 'Error, Por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agreement $agreement, File $file)
    {
        if($this->fileUploadService->deleteFile($file->id)){
            return redirect()->back()->with('success', 'Arquivo removido com sucesso!');
        }
        return redirect()->back()->with('error', 'Error, Por favor tente novamente!');

    }
}
