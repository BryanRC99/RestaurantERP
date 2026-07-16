<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductoHistorialPrecio extends Model
{
    protected $table = 'producto_historial_precio';

    public $timestamps = false;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'producto_sucursal_id',
        'precio_anterior',
        'precio_nuevo',
        'motivo',
        'fecha_cambio',
    ];

    protected function casts(): array
    {
        return [
            'precio_anterior' => 'decimal:2',
            'precio_nuevo' => 'decimal:2',
            'fecha_cambio' => 'date',
            'created_at' => 'datetime',
        ];
    }

    public function productoSucursal(): BelongsTo
    {
        return $this->belongsTo(ProductoSucursal::class);
    }
}