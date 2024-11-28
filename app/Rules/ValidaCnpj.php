<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidaCnpj implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Remove caracteres não numéricos
        $cnpj = preg_replace('/[^0-9]/', '', $value);

        // Verifica se tem 14 dígitos
        if (strlen($cnpj) != 14) {
            return false;
        }

        // Verifica se todos os dígitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        // Calcula o primeiro dígito verificador
        $soma = 0;
        $multiplicadores = [5,4,3,2,9,8,7,6,5,4,3,2];
        for ($i = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $multiplicadores[$i];
        }
        $resto = $soma % 11;
        $digito1 = $resto < 2 ? 0 : 11 - $resto;

        // Verifica o primeiro dígito verificador
        if ($cnpj[12] != $digito1) {
            return false;
        }

        // Calcula o segundo dígito verificador
        $soma = 0;
        $multiplicadores = [6,5,4,3,2,9,8,7,6,5,4,3,2];
        for ($i = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $multiplicadores[$i];
        }
        $resto = $soma % 11;
        $digito2 = $resto < 2 ? 0 : 11 - $resto;

        // Verifica o segundo dígito verificador
        return $cnpj[13] == $digito2;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O CNPJ informado não é válido.';
    }
}
