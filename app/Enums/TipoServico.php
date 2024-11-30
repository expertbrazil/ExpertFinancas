<?php

namespace App\Enums;

enum TipoServico: string
{
    case CONSULTORIA = 'consultoria';
    case DESENVOLVIMENTO = 'desenvolvimento';
    case MANUTENCAO = 'manutencao';
    case SUPORTE = 'suporte';
    case TREINAMENTO = 'treinamento';
    case HOSPEDAGEM = 'hospedagem';
    case OUTROS = 'outros';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function getDescriptions(): array
    {
        return [
            self::CONSULTORIA->value => 'Consultoria',
            self::DESENVOLVIMENTO->value => 'Desenvolvimento',
            self::MANUTENCAO->value => 'Manutenção',
            self::SUPORTE->value => 'Suporte',
            self::TREINAMENTO->value => 'Treinamento',
            self::HOSPEDAGEM->value => 'Hospedagem',
            self::OUTROS->value => 'Outros'
        ];
    }

    public static function requiresContrato(string $tipo): bool
    {
        return in_array($tipo, [
            self::CONSULTORIA->value,
            self::DESENVOLVIMENTO->value,
            self::MANUTENCAO->value,
            self::HOSPEDAGEM->value
        ]);
    }

    public static function getRecorrencia(string $tipo): string
    {
        return match ($tipo) {
            self::HOSPEDAGEM->value => 'mensal',
            self::MANUTENCAO->value => 'mensal',
            self::SUPORTE->value => 'mensal',
            default => 'avulso'
        };
    }
}
