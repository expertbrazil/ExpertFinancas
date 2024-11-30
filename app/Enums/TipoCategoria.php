<?php

namespace App\Enums;

enum TipoCategoria: string
{
    case PRODUTO = 'produto';
    case SERVICO = 'servico';
    case FINANCEIRO = 'financeiro';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function getDescriptions(): array
    {
        return [
            self::PRODUTO->value => 'Categoria de Produtos',
            self::SERVICO->value => 'Categoria de Serviços',
            self::FINANCEIRO->value => 'Categoria Financeira',
        ];
    }
}
