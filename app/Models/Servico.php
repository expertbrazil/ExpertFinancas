<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Servico extends Model
{
    use HasFactory;

    protected $table = 'servicos';
    
    protected $fillable = [
        'nome',
        'descricao',
        'valor',
        'ativo',
        'tipo_cobranca'
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'ativo' => 'boolean'
    ];

    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'cliente_servico')
            ->withPivot('data_inicio', 'data_fim', 'valor_contratado')
            ->withTimestamps();
    }
}
