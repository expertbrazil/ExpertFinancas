<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dominio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dominios';

    protected $fillable = [
        'cliente_id',
        'nome_dominio',
        'data_registro',
        'data_vencimento',
        'registrador',
        'observacoes',
        'ativo'
    ];

    protected $casts = [
        'data_registro' => 'date',
        'data_vencimento' => 'date',
        'ativo' => 'boolean'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
