<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'user_id',
        'titulo',
        'descricao',
        'status',
        'prioridade',
        'categoria'
    ];

    protected $casts = [
        'status' => 'string', // 'aberto', 'em_andamento', 'fechado'
        'prioridade' => 'string' // 'baixa', 'media', 'alta'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function respostas()
    {
        return $this->hasMany(TicketResposta::class);
    }
}
