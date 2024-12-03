<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InscricaoEstadual extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inscricoes_estaduais';

    protected $fillable = [
        'cliente_id',
        'numero_inscricao',
        'uf',
        'ativo',
        'observacoes'
    ];

    protected $casts = [
        'ativo' => 'boolean'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
