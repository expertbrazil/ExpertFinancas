<?php

namespace App\Events\Produto;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProdutoPrecoAlterado
{
    use Dispatchable, SerializesModels;

    public $produto;
    public $precoAntigo;
    public $precoNovo;

    public function __construct($produto, $precoAntigo, $precoNovo)
    {
        $this->produto = $produto;
        $this->precoAntigo = $precoAntigo;
        $this->precoNovo = $precoNovo;
    }
}
