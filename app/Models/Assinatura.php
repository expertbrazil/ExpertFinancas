<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assinatura extends Model
{
    use HasFactory;

    protected $table = 'assinaturas';

    protected $fillable = [
        'cliente_id',
        'plano_id',
        'status',
        'data_inicio',
        'data_fim',
        'valor',
        'dia_vencimento'
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim' => 'date',
        'valor' => 'decimal:2',
        'status' => 'boolean'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function plano()
    {
        return $this->belongsTo(Plano::class);
    }

    public function faturas()
    {
        return $this->hasMany(Fatura::class);
    }
}
