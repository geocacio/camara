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
        $this->maxSize = 51200;
    }
    
    public function getMaxSize()
    {
        return $this->maxSize;
    }

    public function upload($file, $destination)
    {
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $destination . '/' . $fileName;
        Storage::disk('public')->put($filePath, file_get_contents($file));

        return $filePath;
    }

    public function deleteFile($id)
    {
        $file = File::find($id);        
        Storage::disk('public')->delete($file->url);
        $file->fileContents()->delete();
        return $file->delete();
    }
}
