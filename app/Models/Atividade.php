<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Atividade extends Model
{
    use HasFactory;

    protected $table = 'atividades';
    
    protected $fillable = [
        'descricao',
        'detalhes',
        'tipo',
        'usuario_id',
        'entidade_tipo',
        'entidade_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function entidade()
    {
        return $this->morphTo();
    }
}
