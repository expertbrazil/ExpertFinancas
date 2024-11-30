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
     * Obtém os produtos desta categoria
     */
    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }

    /**
     * Obtém os serviços desta categoria
     */
    public function servicos()
    {
        return $this->hasMany(Servico::class);
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

    /**
     * Verifica se esta categoria pode ser pai de outra
     */
    public function podeSerPaiDe(Categoria $outraCategoria)
    {
        // Não pode ser pai de si mesma
        if ($this->id === $outraCategoria->id) {
            return false;
        }

        // Não pode ser pai de uma categoria de tipo diferente
        if ($this->tipo !== $outraCategoria->tipo) {
            return false;
        }

        // Não pode ser pai se já é descendente da outra categoria
        $categoriaPai = $this->categoriaPai;
        while ($categoriaPai) {
            if ($categoriaPai->id === $outraCategoria->id) {
                return false;
            }
            $categoriaPai = $categoriaPai->categoriaPai;
        }

        return true;
    }

    /**
     * Obtém o nível hierárquico da categoria
     */
    public function getNivelHierarquicoAttribute()
    {
        $nivel = 0;
        $categoria = $this;
        
        while ($categoria->categoriaPai) {
            $nivel++;
            $categoria = $categoria->categoriaPai;
        }
        
        return $nivel;
    }

    /**
     * Obtém todas as categorias ancestrais
     */
    public function getAncestraisAttribute()
    {
        $ancestrais = collect();
        $categoria = $this->categoriaPai;
        
        while ($categoria) {
            $ancestrais->push($categoria);
            $categoria = $categoria->categoriaPai;
        }
        
        return $ancestrais;
    }

    /**
     * Verifica se esta categoria é ancestral de outra
     */
    public function isAncestralDe(Categoria $outraCategoria)
    {
        return $outraCategoria->ancestrais->contains('id', $this->id);
    }

    /**
     * Verifica se esta categoria é descendente de outra
     */
    public function isDescendenteDe(Categoria $outraCategoria)
    {
        return $this->ancestrais->contains('id', $outraCategoria->id);
    }
}
