<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait UploadTrait
{
    public function uploadFile(UploadedFile $file, $folder = null, $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(25);
        $extension = $file->getClientOriginalExtension();
        
        $folder = $folder ? $folder : 'uploads';
        $path = storage_path("app/public/{$folder}");
        
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $file->storeAs("public/{$folder}", "{$name}.{$extension}");

        return "{$folder}/{$name}.{$extension}";
    }

    public function deleteFile($path)
    {
        if (file_exists(storage_path("app/public/{$path}"))) {
            unlink(storage_path("app/public/{$path}"));
        }
    }
}
