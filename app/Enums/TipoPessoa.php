<?php

namespace App\Enums;

enum TipoPessoa: string
{
    case FISICA = 'F';
    case JURIDICA = 'J';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function getDescriptions(): array
    {
        return [
            self::FISICA->value => 'Pessoa Física',
            self::JURIDICA->value => 'Pessoa Jurídica'
        ];
    }

    public static function getDocumentLabel($tipo): string
    {
        return match ($tipo) {
            self::FISICA->value => 'CPF',
            self::JURIDICA->value => 'CNPJ',
            default => 'Documento'
        };
    }
}
