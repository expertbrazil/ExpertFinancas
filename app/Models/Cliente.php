<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Assinatura;
use App\Models\Ticket;
use App\Models\Documento;
use App\Models\Fatura;
use App\Models\Endereco;
use App\Models\Dominio;
use App\Models\InscricaoEstadual;

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
        'observacoes'
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

    /**
     * Get the addresses for the client.
     */
    public function enderecos()
    {
        return $this->hasMany(Endereco::class);
    }

    /**
     * Get the domains for the client.
     */
    public function dominios()
    {
        return $this->hasMany(Dominio::class);
    }

    /**
     * Get the state registrations for the client.
     */
    public function inscricoesEstaduais()
    {
        return $this->hasMany(InscricaoEstadual::class);
    }

    public function getIsPessoaFisicaAttribute()
    {
        return $this->tipo_pessoa === 'PF';
    }

    public function getIsPessoaJuridicaAttribute()
    {
        return $this->tipo_pessoa === 'PJ';
    }

    public function getDocumentoAttribute()
    {
        return $this->isPessoaFisica ? $this->cpf : $this->cnpj;
    }

    public function getNomeAttribute()
    {
        return $this->isPessoaFisica ? $this->nome_completo : $this->razao_social;
    }
}
