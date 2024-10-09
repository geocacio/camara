<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\FileContent;
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

    public function noInformationstore(Request $request)
    {
        $validateData = $request->validate([
            'description' => 'required',
            'periodo' => 'required',
            'page' => 'required',
        ]);

        $pageID = Page::where('slug', $request->page)->first();

        $validateData['page_id'] = $pageID->id;

        $vehicle = NoInfo::create($validateData);

        if ($request->hasFile('file')) {
            $url = $this->fileUploadService->upload($request->file('file'), $request->page);
            $file = File::create(['url' => $url]);
    
            $vehicle->files()->create(['file_id' => $file->id]);
        }

        return redirect()->back()->with('success', 'Arquivo cadastrado com sucesso!');
    }

    public function noInformationUpdate(Request $request, $id, $slug){
        $validateData = $request->validate([
            'description' => 'required',
            'periodo' => 'required',
        ]);

        $pageID = Page::where('slug', $request->slug)->first();

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

    public function noInfo($id, $slug){
        $page = Page::where('slug', $slug)->first();
        $info = NoInfo::where('id', $id)->first();

        $currentFile = null;

        if($info){
            $fileContent = FileContent::where('fileable_type', 'no-info')->where('fileable_id', $info->id)->first();
    
            $currentFile = File::where('id', $fileContent->file_id)->first();
        }

        return view('panel.no-info.index', compact('info', 'currentFile', 'page'));
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
    
        return redirect()->back()->with('success', 'Registro e arquivos deletados com sucesso!');
    }
}
