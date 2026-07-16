<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DireccionCliente extends Model
{
    use HasFactory;

    protected $table = 'direcciones_cliente';

    protected $fillable = [
        'cliente_id',
        'nombre_referencia',
        'direccion',
        'referencia',
        'ciudad',
        'latitud',
        'longitud',
        'principal',
    ];

    protected function casts(): array
    {
        return [
            'latitud' => 'decimal:7',
            'longitud' => 'decimal:7',
            'principal' => 'boolean',
        ];
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }
}