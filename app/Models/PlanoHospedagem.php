<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlanoHospedagem extends Model
{
    use HasFactory;

    protected $table = 'planos_hospedagem';
    
    protected $fillable = [
        'nome',
        'descricao',
        'valor',
        'periodo',
        'espaco_disco',
        'largura_banda',
        'contas_email',
        'bancos_dados',
        'ssl_gratuito',
        'backup_diario',
        'ativo'
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'espaco_disco' => 'integer',
        'largura_banda' => 'integer',
        'contas_email' => 'integer',
        'bancos_dados' => 'integer',
        'ssl_gratuito' => 'boolean',
        'backup_diario' => 'boolean',
        'ativo' => 'boolean'
    ];

    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }
}
