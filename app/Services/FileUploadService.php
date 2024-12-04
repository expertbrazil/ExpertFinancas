<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    const MAX_FILE_SIZE = 5120; // 5MB em kilobytes
    
    /**
     * Upload de arquivo PDF
     */
    public function uploadPdf(UploadedFile $file, string $folder = 'anexos'): string|false
    {
        if (!$this->validatePdf($file)) {
            return false;
        }

        $filename = $this->generateFileName($file, 'pdf');
        return $this->storeFile($file, $folder, $filename);
    }

    /**
     * Upload de imagem
     */
    public function uploadImage(UploadedFile $file, string $folder = 'imagens'): string|false
    {
        if (!$this->validateImage($file)) {
            return false;
        }

        $filename = $this->generateFileName($file, $file->getClientOriginalExtension());
        return $this->storeFile($file, $folder, $filename);
    }

    /**
     * Validação de arquivo PDF
     */
    private function validatePdf(UploadedFile $file): bool
    {
        return $file->getClientMimeType() === 'application/pdf' 
            && $file->getSize() <= (self::MAX_FILE_SIZE * 1024);
    }

    /**
     * Validação de imagem
     */
    private function validateImage(UploadedFile $file): bool
    {
        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif'];
        return in_array($file->getClientMimeType(), $allowedMimes) 
            && $file->getSize() <= (self::MAX_FILE_SIZE * 1024);
    }

    /**
     * Gera nome único para o arquivo
     */
    private function generateFileName(UploadedFile $file, string $extension): string
    {
        return Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) 
            . '_' 
            . time() 
            . '.' 
            . $extension;
    }

    /**
     * Armazena o arquivo no disco
     */
    private function storeFile(UploadedFile $file, string $folder, string $filename): string
    {
        $path = $file->storeAs("public/{$folder}", $filename);
        return Storage::url($path);
    }
}
