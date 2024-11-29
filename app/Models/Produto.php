<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';
    
    protected $fillable = [
        'nome',
        'codigo',
        'descricao',
        'preco_custo',
        'preco_venda',
        'estoque',
        'estoque_minimo',
        'ativo'
    ];

    protected $casts = [
        'preco_custo' => 'decimal:2',
        'preco_venda' => 'decimal:2',
        'estoque' => 'integer',
        'estoque_minimo' => 'integer',
        'ativo' => 'boolean'
    ];

    public function getMargemLucroAttribute()
    {
        if ($this->preco_custo > 0) {
            return (($this->preco_venda - $this->preco_custo) / $this->preco_custo) * 100;
        }
        return 0;
    }

    public function getEstoqueBaixoAttribute()
    {
        return $this->estoque <= $this->estoque_minimo;
    }
}
