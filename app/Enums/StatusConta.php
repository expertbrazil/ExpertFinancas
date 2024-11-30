<?php

namespace App\Enums;

enum StatusConta: string
{
    case PENDENTE = 'pendente';
    case PAGO = 'pago';
    case CANCELADO = 'cancelado';
    case ATRASADO = 'atrasado';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function getDescriptions(): array
    {
        return [
            self::PENDENTE->value => 'Pendente',
            self::PAGO->value => 'Pago',
            self::CANCELADO->value => 'Cancelado',
            self::ATRASADO->value => 'Atrasado',
        ];
    }
}
