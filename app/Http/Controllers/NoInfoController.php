<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\NoInfo;
use App\Models\Page;
use App\Services\FileUploadService;
use Illuminate\Http\Request;

class NoInfoController extends Controller
{
    private $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function destroy($id)
    {
        $vehicle = NoInfo::findOrFail($id);
    
        if ($vehicle->files) {
            foreach ($vehicle->files as $file) {
                $this->fileUploadService->deleteFile($file->file->id);
    
                $file->delete();
            }
        }
    
        $vehicle->delete();
    
        return redirect()->route('veiculos.index')->with('success', 'Registro e arquivos deletados com sucesso!');
    }

    public function noInformationstore(Request $request)
    {
        $validateData = $request->validate([
            'description' => 'required',
            'periodo' => 'required',
            'page' => 'required',
        ]);

        $pageID = Page::where('name', $request->page)->first();

        $validateData['page_id'] = $pageID->id;

        $vehicle = NoInfo::create($validateData);

        if ($request->hasFile('file')) {
            $url = $this->fileUploadService->upload($request->file('file'), $request->page);
            $file = File::create(['url' => $url]);
    
            $vehicle->files()->create(['file_id' => $file->id]);
        }

        return redirect()->back()->with('success', 'Arquivo cadastrado com sucesso!');
    }

    public function noInformationUpdate(Request $request, $id){
        $validateData = $request->validate([
            'description' => 'required',
            'periodo' => 'required',
            'page' => 'required',
        ]);

        $pageID = Page::where('name', $request->page)->first();

        $validateData['page_id'] = $pageID->id;
        
        $existingVehicle = NoInfo::where('id', $id)->first();
    
        if ($existingVehicle) {
            $existingVehicle->update($validateData);
    
            if ($request->hasFile('file')) {
                $existingFile = $existingVehicle->files->first();
                if ($existingFile) {
                    $existingFile->delete();
                }
    
                $url = $this->fileUploadService->upload($request->file('file'), $request->page);
                $file = File::create(['url' => $url]);

                $existingVehicle->files()->create(['file_id' => $file->id]);
            }
    
            return redirect()->back()->with('success', 'Arquivo atualizado com sucesso!');
        } else {
            if($vehicle = NoInfo::create($validateData)){
                if ($request->hasFile('file')) {
                    $url = $this->fileUploadService->upload($request->file('file'), 'no-vehicles');
                    $file = File::create(['url' => $url]);
                    $vehicle->files()->create(['file_id' => $file->id]);
                }
                return redirect()->back()->with('success', 'Arquivo cadastrado com sucesso!');
            } else {
                return redirect()->back()->with('error', 'Falha ao cadastrar arquivo!');
            }
        }
    }
}
