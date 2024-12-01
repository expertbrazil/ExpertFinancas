<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Documento extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'tipo', // 'contrato', 'termo', 'outros'
        'titulo',
        'descricao',
        'arquivo_path',
        'data_upload',
        'status'
    ];

    protected $casts = [
        'data_upload' => 'datetime',
        'status' => 'boolean'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
