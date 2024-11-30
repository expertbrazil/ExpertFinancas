<?php

namespace App\Listeners\Produto;

use App\Events\Produto\ProdutoEstoqueBaixo;
use App\Traits\NotificationTrait;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificarEstoqueBaixo implements ShouldQueue
{
    use NotificationTrait;

    public function handle(ProdutoEstoqueBaixo $event)
    {
        $produto = $event->produto;
        $quantidadeAtual = $event->quantidadeAtual;
        $estoqueMinimo = $event->estoqueMinimo;

        $mensagem = "O produto {$produto->nome} está com estoque baixo.\n";
        $mensagem .= "Quantidade atual: {$quantidadeAtual}\n";
        $mensagem .= "Estoque mínimo: {$estoqueMinimo}";

        $this->enviarNotificacaoEmail(
            'Alerta de Estoque Baixo',
            $mensagem,
            config('notifications.estoque.emails')
        );

        $this->registrarAlerta(
            'estoque_baixo',
            $produto->id,
            $mensagem,
            'warning'
        );
    }
}
