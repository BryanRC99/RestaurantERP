<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleCompra extends Model
{
    protected $table = 'detalle_compra';

    public $timestamps = false;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'compra_id',
        'ingrediente_id',
        'cantidad',
        'unidad_medida_id',
        'factor_conversion',
        'precio_unitario',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'cantidad' => 'decimal:3',
            'factor_conversion' => 'decimal:4',
            'precio_unitario' => 'decimal:2',
            'subtotal' => 'decimal:2',
            'created_at' => 'datetime',
        ];
    }

    public function compra(): BelongsTo
    {
        return $this->belongsTo(Compra::class);
    }

    public function ingrediente(): BelongsTo
    {
        return $this->belongsTo(Ingrediente::class);
    }

    public function unidadMedida(): BelongsTo
    {
        return $this->belongsTo(UnidadMedida::class);
    }

    /**
     * Cuanto suma al stock base del ingrediente (inventario.stock_actual)
     * esta linea de compra.
     */
    public function cantidadEnUnidadBase(): float
    {
        return (float) $this->cantidad * (float) $this->factor_conversion;
    }
}