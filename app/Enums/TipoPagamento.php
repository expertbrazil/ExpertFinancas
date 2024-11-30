<?php

namespace App\Enums;

enum TipoPagamento: string
{
    case DINHEIRO = 'dinheiro';
    case CARTAO_CREDITO = 'cartao_credito';
    case CARTAO_DEBITO = 'cartao_debito';
    case BOLETO = 'boleto';
    case PIX = 'pix';
    case TRANSFERENCIA = 'transferencia';
    case OUTROS = 'outros';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function getDescriptions(): array
    {
        return [
            self::DINHEIRO->value => 'Dinheiro',
            self::CARTAO_CREDITO->value => 'Cartão de Crédito',
            self::CARTAO_DEBITO->value => 'Cartão de Débito',
            self::BOLETO->value => 'Boleto',
            self::PIX->value => 'PIX',
            self::TRANSFERENCIA->value => 'Transferência',
            self::OUTROS->value => 'Outros'
        ];
    }

    public static function requiresDocument($tipo): bool
    {
        return in_array($tipo, [
            self::BOLETO->value,
            self::PIX->value,
            self::TRANSFERENCIA->value
        ]);
    }
}
