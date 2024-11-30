<?php

namespace App\Enums;

enum StatusGeral: string
{
    case ATIVO = 'ativo';
    case INATIVO = 'inativo';
    case BLOQUEADO = 'bloqueado';
    case PENDENTE = 'pendente';
    case EXCLUIDO = 'excluido';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function getDescriptions(): array
    {
        return [
            self::ATIVO->value => 'Ativo',
            self::INATIVO->value => 'Inativo',
            self::BLOQUEADO->value => 'Bloqueado',
            self::PENDENTE->value => 'Pendente',
            self::EXCLUIDO->value => 'Excluído'
        ];
    }
}
