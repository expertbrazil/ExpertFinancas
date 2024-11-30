<?php

namespace App\Events\Produto;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProdutoEstoqueBaixo
{
    use Dispatchable, SerializesModels;

    public $produto;
    public $quantidadeAtual;
    public $estoqueMinimo;

    public function __construct($produto, $quantidadeAtual, $estoqueMinimo)
    {
        $this->produto = $produto;
        $this->quantidadeAtual = $quantidadeAtual;
        $this->estoqueMinimo = $estoqueMinimo;
    }
}
