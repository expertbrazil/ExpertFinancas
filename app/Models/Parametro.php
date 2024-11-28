<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Parametro extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_sistema',
        'logo_path',
        'cor_primaria',
        'cor_secundaria',
        'cor_fundo',
        'cor_texto',
        'cor_navbar',
        'cor_footer',
        'email_contato',
        'telefone_contato',
        'texto_rodape',
    ];

    /**
     * Obtém a configuração ativa do sistema
     */
    public static function getAtivo()
    {
        return static::firstOrCreate(
            [],
            [
                'nome_sistema' => 'Expert Finanças',
                'cor_primaria' => '#0d6efd',
                'cor_secundaria' => '#6c757d',
                'cor_fundo' => '#ffffff',
                'cor_texto' => '#212529',
                'cor_navbar' => '#212529',
                'cor_footer' => '#212529'
            ]
        );
    }

    /**
     * Obtém a URL da logo
     */
    public function getLogoUrlAttribute()
    {
        if ($this->logo_path) {
            return Storage::url($this->logo_path);
        }
        return null;
    }

    /**
     * Gera o CSS dinâmico baseado nas cores configuradas
     */
    public function generateCss()
    {
        return "
            :root {
                --primary-color: {$this->cor_primaria};
                --secondary-color: {$this->cor_secundaria};
                --background-color: {$this->cor_fundo};
                --text-color: {$this->cor_texto};
                --navbar-color: {$this->cor_navbar};
                --footer-color: {$this->cor_footer};
            }

            body {
                background-color: var(--background-color);
                color: var(--text-color);
            }

            .navbar {
                background-color: var(--navbar-color) !important;
            }

            .footer {
                background-color: var(--footer-color) !important;
            }

            .btn-primary {
                background-color: var(--primary-color);
                border-color: var(--primary-color);
            }

            .btn-secondary {
                background-color: var(--secondary-color);
                border-color: var(--secondary-color);
            }
        ";
    }
}
