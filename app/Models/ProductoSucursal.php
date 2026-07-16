<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductoSucursal extends Model
{
    use HasFactory;

    protected $table = 'producto_sucursal';

    protected $fillable = [
        'producto_id',
        'sucursal_id',
        'precio',
        'disponible',
        'stock_controlado',
    ];

    protected function casts(): array
    {
        return [
            'precio' => 'decimal:2',
            'disponible' => 'boolean',
            'stock_controlado' => 'boolean',
        ];
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }

    public function sucursal(): BelongsTo
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function historialPrecio(): HasMany
    {
        return $this->hasMany(ProductoHistorialPrecio::class);
    }
}