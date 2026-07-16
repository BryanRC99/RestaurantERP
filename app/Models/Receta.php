<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Receta extends Model
{
    use HasFactory;

    protected $table = 'recetas';

    protected $fillable = [
        'producto_id',
        'ingrediente_id',
        'cantidad',
        'unidad_medida_id',
        'factor_conversion',
    ];

    protected function casts(): array
    {
        return [
            'cantidad' => 'decimal:3',
            'factor_conversion' => 'decimal:4',
        ];
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
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
     * Cuanto se debe descontar del stock base del ingrediente
     * (en la unidad en que se controla inventario) por 1 unidad de producto vendida.
     */
    public function cantidadEnUnidadBase(): float
    {
        return (float) $this->cantidad * (float) $this->factor_conversion;
    }
}