<?php

namespace App\Enums;

enum StatusPedido: string
{
    case RASCUNHO = 'rascunho';
    case AGUARDANDO_PAGAMENTO = 'aguardando_pagamento';
    case PAGO = 'pago';
    case EM_PROCESSAMENTO = 'em_processamento';
    case CONCLUIDO = 'concluido';
    case CANCELADO = 'cancelado';
    case REEMBOLSADO = 'reembolsado';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function getDescriptions(): array
    {
        return [
            self::RASCUNHO->value => 'Rascunho',
            self::AGUARDANDO_PAGAMENTO->value => 'Aguardando Pagamento',
            self::PAGO->value => 'Pago',
            self::EM_PROCESSAMENTO->value => 'Em Processamento',
            self::CONCLUIDO->value => 'Concluído',
            self::CANCELADO->value => 'Cancelado',
            self::REEMBOLSADO->value => 'Reembolsado'
        ];
    }

    public static function getAllowedTransitions(): array
    {
        return [
            self::RASCUNHO->value => [
                self::AGUARDANDO_PAGAMENTO->value,
                self::CANCELADO->value
            ],
            self::AGUARDANDO_PAGAMENTO->value => [
                self::PAGO->value,
                self::CANCELADO->value
            ],
            self::PAGO->value => [
                self::EM_PROCESSAMENTO->value,
                self::REEMBOLSADO->value
            ],
            self::EM_PROCESSAMENTO->value => [
                self::CONCLUIDO->value,
                self::CANCELADO->value
            ],
            self::CONCLUIDO->value => [
                self::REEMBOLSADO->value
            ],
            self::CANCELADO->value => [],
            self::REEMBOLSADO->value => []
        ];
    }

    public static function canTransitionTo(string $currentStatus, string $newStatus): bool
    {
        $transitions = self::getAllowedTransitions();
        return in_array($newStatus, $transitions[$currentStatus] ?? []);
    }
}
