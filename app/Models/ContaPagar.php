<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContaPagar extends Model
{
    use HasFactory;

    protected $table = 'contas_pagar';
    
    protected $fillable = [
        'descricao',
        'valor',
        'data_vencimento',
        'data_pagamento',
        'status',
        'fornecedor_id',
        'categoria_id',
        'forma_pagamento',
        'observacao'
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'data_vencimento' => 'date',
        'data_pagamento' => 'date'
    ];

    public function fornecedor()
    {
        return $this->belongsTo(Cliente::class, 'fornecedor_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
