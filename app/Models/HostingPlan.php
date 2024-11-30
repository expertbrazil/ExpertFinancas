<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HostingPlan extends Model
{
    use HasFactory;

    protected $table = 'planos';

    protected $fillable = [
        'name',
        'image',
        'description',
        'monthly_price',
        'semiannual_price',
        'annual_price',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
        'monthly_price' => 'decimal:2',
        'semiannual_price' => 'decimal:2',
        'annual_price' => 'decimal:2',
    ];
}
