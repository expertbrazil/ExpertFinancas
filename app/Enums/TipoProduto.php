<?php

namespace App\Enums;

enum TipoProduto: string
{
    case PRODUTO_FISICO = 'produto_fisico';
    case PRODUTO_DIGITAL = 'produto_digital';
    case SERVICO = 'servico';
    case ASSINATURA = 'assinatura';
    case KIT = 'kit';
    case COMBO = 'combo';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function getDescriptions(): array
    {
        return [
            self::PRODUTO_FISICO->value => 'Produto Físico',
            self::PRODUTO_DIGITAL->value => 'Produto Digital',
            self::SERVICO->value => 'Serviço',
            self::ASSINATURA->value => 'Assinatura',
            self::KIT->value => 'Kit',
            self::COMBO->value => 'Combo'
        ];
    }

    public static function requiresEstoque(string $tipo): bool
    {
        return in_array($tipo, [
            self::PRODUTO_FISICO->value,
            self::KIT->value,
            self::COMBO->value
        ]);
    }

    public static function requiresEntrega(string $tipo): bool
    {
        return in_array($tipo, [
            self::PRODUTO_FISICO->value,
            self::KIT->value,
            self::COMBO->value
        ]);
    }

    public static function isRecorrente(string $tipo): bool
    {
        return in_array($tipo, [
            self::ASSINATURA->value
        ]);
    }

    public static function isDigital(string $tipo): bool
    {
        return in_array($tipo, [
            self::PRODUTO_DIGITAL->value,
            self::SERVICO->value,
            self::ASSINATURA->value
        ]);
    }

    public static function getValidationRules(string $tipo): array
    {
        $rules = [
            'nome' => 'required|max:255',
            'codigo' => 'required|unique:produtos,codigo',
            'descricao' => 'nullable',
            'preco_venda' => 'required|numeric|min:0',
            'status' => 'required|in:' . implode(',', StatusGeral::getValues())
        ];

        if (self::requiresEstoque($tipo)) {
            $rules = array_merge($rules, [
                'estoque' => 'required|integer|min:0',
                'estoque_minimo' => 'required|integer|min:0',
                'peso' => 'required|numeric|min:0',
                'dimensoes' => 'required|json',
                'localizacao_estoque' => 'required|string|max:50'
            ]);
        }

        if (self::isDigital($tipo)) {
            $rules = array_merge($rules, [
                'url_download' => 'required_if:tipo,' . self::PRODUTO_DIGITAL->value,
                'instrucoes_acesso' => 'required'
            ]);
        }

        if ($tipo === self::ASSINATURA->value) {
            $rules = array_merge($rules, [
                'periodicidade' => 'required|in:mensal,trimestral,semestral,anual',
                'duracao_contrato' => 'required|integer|min:1'
            ]);
        }

        if (in_array($tipo, [self::KIT->value, self::COMBO->value])) {
            $rules = array_merge($rules, [
                'produtos.*' => 'required|exists:produtos,id',
                'quantidades.*' => 'required|integer|min:1'
            ]);
        }

        return $rules;
    }
}
