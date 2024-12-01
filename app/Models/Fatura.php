<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fatura extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'assinatura_id',
        'numero',
        'valor',
        'data_emissao',
        'data_vencimento',
        'data_pagamento',
        'status', // 'pendente', 'pago', 'vencido', 'cancelado'
        'url_boleto',
        'linha_digitavel'
    ];

    protected $casts = [
        'data_emissao' => 'date',
        'data_vencimento' => 'date',
        'data_pagamento' => 'date',
        'valor' => 'decimal:2'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function assinatura()
    {
        return $this->belongsTo(Assinatura::class);
    }
}
