<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'empresa_id',
        'categoria_id',
        'nombre',
        'descripcion',
        'imagen',
        'tiempo_preparacion',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function productoSucursal(): HasMany
    {
        return $this->hasMany(ProductoSucursal::class);
    }

    public function recetas(): HasMany
    {
        return $this->hasMany(Receta::class);
    }

    /**
     * Ingredientes de la receta, con cantidad/unidad/factor_conversion
     * disponibles en la tabla pivote (recetas).
     */
    public function ingredientes(): BelongsToMany
    {
        return $this->belongsToMany(Ingrediente::class, 'recetas')
            ->withPivot(['cantidad', 'unidad_medida_id', 'factor_conversion'])
            ->withTimestamps();
    }

    public function promociones(): BelongsToMany
    {
        return $this->belongsToMany(Promocion::class, 'promocion_producto')
            ->withTimestamps();
    }

    /**
     * Precio/disponibilidad de este producto en una sucursal especifica.
     */
    public function precioEnSucursal(int $sucursalId): ?ProductoSucursal
    {
        return $this->productoSucursal()->where('sucursal_id', $sucursalId)->first();
    }
}