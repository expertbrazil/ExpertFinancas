<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;

class MediaRule implements Rule
{
    protected $maxSize;
    protected $message;

    /**
     * Create a new rule instance.
     *
     * @param int $maxSizeInMB Tamanho máximo em MB (padrão 2MB)
     */
    public function __construct(int $maxSizeInMB = 2)
    {
        $this->maxSize = $maxSizeInMB * 1024; // Converter para KB
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!$value instanceof UploadedFile) {
            $this->message = 'O arquivo enviado é inválido.';
            return false;
        }

        // Verificar extensão
        $extension = strtolower($value->getClientOriginalExtension());
        $allowedExtensions = ['png', 'jpg', 'jpeg', 'svg', 'webp'];
        
        if (!in_array($extension, $allowedExtensions)) {
            $this->message = 'O arquivo deve ser uma imagem do tipo: ' . implode(', ', $allowedExtensions);
            return false;
        }

        // Verificar tamanho
        if ($value->getSize() > ($this->maxSize * 1024)) { // Converter KB para bytes
            $this->message = "O arquivo não deve ser maior que {$this->maxSize}KB.";
            return false;
        }

        // Verificar se é realmente uma imagem
        if (!in_array($value->getMimeType(), [
            'image/jpeg',
            'image/png',
            'image/svg+xml',
            'image/webp'
        ])) {
            $this->message = 'O arquivo deve ser uma imagem válida.';
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
