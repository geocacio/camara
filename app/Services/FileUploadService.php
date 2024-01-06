<?php

namespace App\Services;

use App\Models\File;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    private $maxSize;

    public function __construct()
    {
        $this->maxSize = 1073741824;
    }
    
    public function getMaxSize()
    {
        return $this->maxSize;
    }

    public function upload($file, $destination)
    {
        try {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $destination . '/' . $fileName;
            Storage::disk('public')->put($filePath, file_get_contents($file));
    
            return $filePath;
        } catch (\Exception $e) {
            // Log ou imprima mensagens de erro para depuração
            dd($e->getMessage());
            return null;
        }
    }

    public function deleteFile($id)
    {
        $file = File::find($id);        
        Storage::disk('public')->delete($file->url);
        $file->fileContents()->delete();
        return $file->delete();
    }
}
