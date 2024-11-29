<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContaReceber extends Model
{
    use HasFactory;

    protected $table = 'contas_receber';
    
    protected $fillable = [
        'descricao',
        'valor',
        'data_vencimento',
        'data_recebimento',
        'status',
        'cliente_id',
        'categoria_id',
        'forma_recebimento',
        'observacao'
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'data_vencimento' => 'date',
        'data_recebimento' => 'date'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
