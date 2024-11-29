<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';
    
    protected $fillable = [
        'nome',
        'tipo', // receita, despesa
        'descricao',
        'cor',
        'icone'
    ];

    public function contasReceber()
    {
        return $this->hasMany(ContaReceber::class);
    }

    public function contasPagar()
    {
        return $this->hasMany(ContaPagar::class);
    }
}
