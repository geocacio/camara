<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Employee;
use App\Models\File;
use App\Models\Office;
use App\Models\Organ;
use App\Models\Progress;
use App\Models\Secretary;
use App\Models\SecretaryPublication;
use App\Models\Sector;
use Illuminate\Support\Facades\Storage;

class GeneralCrudSErvice
{

    private $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    private function resolveContent($currentModel, $request) : void
    {
        if(method_exists($currentModel, 'contentRelation')) {
            list($content, $contentIdentifier) = $currentModel->contentRelation();
            $currentModel->{$content}()->delete();
            $currentModel->{$content}()->create([$contentIdentifier => $request->input($contentIdentifier)]);
        }
    }

    public function initCrud($action, $model, $dataRequest, $request, $redirect, $data = null, $type = 'store')
    {
        switch ($model) {
            case 'Organ':
                $currentModel = $action == 'create' ? new Organ : $data;
                break;
            case 'Department':
                $currentModel = $action == 'create' ? new Department : $data;
                break;
            case 'Sector':
                $currentModel = $action == 'create' ? new Sector : $data;
                break;
            case 'Secretary':
                $currentModel = $action == 'create' ? new Secretary : $data;
                break;
            case 'Employee':
                $currentModel = $action == 'create' ? new Employee : $data;
                break;
            case 'Office':
                $currentModel = $action == 'create' ? new Office : $data;
                break;
            case 'Progress':
                $currentModel = $action == 'create' ? new Progress : $data;
                break;
            case 'SecretaryPublication':
                $currentModel = $action == 'create' ? new SecretaryPublication : $data;
                break;
        }

        $folder = strtolower($model);

        if ($action == 'create') {
            $entry = $this->create($dataRequest, $request, $currentModel, $folder, $redirect, $type);
        } else if ($action == 'update') {
            $entry = $this->update($dataRequest, $request, $currentModel, $folder, $redirect);
        }

        if(!$entry) {
            return redirect()->back()->withErrors(['error' => 'Deu ruim']);
        }
        $this->resolveContent($entry, $request);
        return redirect()->route($redirect['route'], $redirect['params'] ?? [])->with('success', 'Atualização realizada com sucesso!');
    }

    protected function create($data, $request, $currentModel, $folder, $redirect, $type = 'store')
    {
        if ($result = $currentModel->create($data)) {

            if ($request->hasFile('file')) {
                $url = $this->fileUploadService->upload($request->file('file'), $folder);
                $file = File::create(['url' => $url]);
                $result->files()->create(['file_id' => $file->id]);
            }
        }
        return $result;
    }

    protected function update($data, $request, $currentModel, $folder, $redirect)
    {
        if ($request->hasFile('file')) {
            $files = $currentModel->files;
            if ($files->count() > 0) {
                foreach ($files as $currentFile) {
                    Storage::delete('public/' . $currentFile->file->url);
                    $this->fileUploadService->deleteFile($currentFile->file->id);
                }
            }

            $url = $this->fileUploadService->upload($request->file('file'), $folder);
            $file = File::create(['url' => $url]);
            $currentModel->files()->create(['file_id' => $file->id]);
        }

        if($currentModel->update($data)) {
            return $currentModel->fresh();
        }
        return false;
    }
}
