<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';
    
    protected $fillable = [
        'tipo_pessoa',
        'status',
        'nome_completo',
        'cpf',
        'data_nascimento',
        'razao_social',
        'cnpj',
        'data_fundacao',
        'email',
        'telefone',
        'celular',
        'cep',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'uf'
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'data_fundacao' => 'date',
        'status' => 'boolean'
    ];

    public function getIsJuridicoAttribute()
    {
        return $this->tipo_pessoa === 'PJ';
    }

    public function getIsFisicoAttribute()
    {
        return $this->tipo_pessoa === 'PF';
    }
}
