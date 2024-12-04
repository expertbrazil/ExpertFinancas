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
        'nome_fantasia',
        'cnpj',
        'email',
        'telefone',
        'celular',
        'cep',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'uf',
        'observacoes'
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'status' => 'boolean'
    ];

    protected $attributes = [
        'status' => true
    ];

    /**
     * Get the users associated with the client.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the assinaturas associated with the client.
     */
    public function assinaturas()
    {
        return $this->hasMany(Assinatura::class);
    }

    /**
     * Get the tickets associated with the client.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Get the documentos associated with the client.
     */
    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }

    /**
     * Get the faturas associated with the client.
     */
    public function faturas()
    {
        return $this->hasMany(Fatura::class);
    }

    /**
     * Get the dominios associated with the client.
     */
    public function dominios()
    {
        return $this->hasMany(Dominio::class);
    }

    /**
     * Get the inscricoes estaduais associated with the client.
     */
    public function inscricoesEstaduais()
    {
        return $this->hasMany(InscricaoEstadual::class);
    }

    /**
     * Scope a query to filter active clients.
     */
    public function scopeAtivos($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope a query to filter by tipo_pessoa.
     */
    public function scopeTipoPessoa($query, $tipo)
    {
        return $query->where('tipo_pessoa', $tipo);
    }

    /**
     * Get the display name based on tipo_pessoa.
     */
    public function getNomeAttribute()
    {
        return $this->tipo_pessoa === 'PF' ? $this->nome_completo : $this->razao_social;
    }

    /**
     * Get the document number based on tipo_pessoa.
     */
    public function getDocumentoAttribute()
    {
        return $this->tipo_pessoa === 'PF' ? $this->cpf : $this->cnpj;
    }
}
