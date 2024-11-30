<?php

namespace App\Traits;

trait MoneyTrait
{
    public function formatMoneyToDatabase($value)
    {
        if (empty($value)) return null;
        
        // Remove o símbolo da moeda e espaços
        $value = trim(str_replace('R$', '', $value));
        
        // Substitui vírgula por ponto
        $value = str_replace(',', '.', str_replace('.', '', $value));
        
        return (float) $value;
    }

    public function formatMoneyToView($value)
    {
        if (empty($value)) return null;
        
        return number_format($value, 2, ',', '.');
    }

    public function sumMoneyValues(array $values)
    {
        return array_sum(array_map(function($value) {
            return $this->formatMoneyToDatabase($value);
        }, $values));
    }
}
