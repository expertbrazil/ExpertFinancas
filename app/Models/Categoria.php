<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'nome',
        'descricao',
        'tipo',
        'categoria_pai_id',
        'nivel',
        'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'nivel' => 'integer'
    ];

    /**
     * Obtém a categoria pai
     */
    public function categoriaPai()
    {
        return $this->belongsTo(Categoria::class, 'categoria_pai_id');
    }

    /**
     * Obtém as subcategorias
     */
    public function subcategorias()
    {
        return $this->hasMany(Categoria::class, 'categoria_pai_id');
    }

    /**
     * Obtém todas as subcategorias recursivamente
     */
    public function todasSubcategorias()
    {
        return $this->subcategorias()->with('todasSubcategorias');
    }

    /**
     * Obtém as contas a pagar desta categoria
     */
    public function contasPagar()
    {
        return $this->hasMany(ContaPagar::class);
    }

    /**
     * Obtém as contas a receber desta categoria
     */
    public function contasReceber()
    {
        return $this->hasMany(ContaReceber::class);
    }

    /**
     * Verifica se a categoria tem subcategorias
     */
    public function temSubcategorias()
    {
        return $this->subcategorias()->count() > 0;
    }

    /**
     * Obtém o caminho completo da categoria (código + nome)
     */
    public function getCaminhoCompletoAttribute()
    {
        return $this->codigo . ' - ' . $this->nome;
    }

    /**
     * Obtém o caminho hierárquico completo da categoria
     */
    public function getCaminhoHierarquicoAttribute()
    {
        $caminho = [$this->caminho_completo];
        $categoria = $this;
        
        while ($categoria->categoriaPai) {
            $categoria = $categoria->categoriaPai;
            array_unshift($caminho, $categoria->caminho_completo);
        }
        
        return implode(' > ', $caminho);
    }
}
