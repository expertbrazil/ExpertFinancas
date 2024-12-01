<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Assinatura;
use App\Models\Ticket;
use App\Models\Documento;
use App\Models\Fatura;

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

    /**
     * Get the users associated with the client.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the subscriptions for the client.
     */
    public function assinaturas()
    {
        return $this->hasMany(Assinatura::class);
    }

    /**
     * Get the tickets for the client.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Get the documents for the client.
     */
    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }

    /**
     * Get the invoices for the client.
     */
    public function faturas()
    {
        return $this->hasMany(Fatura::class);
    }

    public function getIsJuridicoAttribute()
    {
        return $this->tipo_pessoa === 'PJ';
    }

    public function getIsFisicoAttribute()
    {
        return $this->tipo_pessoa === 'PF';
    }
}
