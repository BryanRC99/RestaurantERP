<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ingrediente extends Model
{
    use HasFactory;

    protected $table = 'ingredientes';

    protected $fillable = [
        'empresa_id',
        'unidad_medida_id',
        'nombre',
        'descripcion',
        'controla_inventario',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'controla_inventario' => 'boolean',
            'activo' => 'boolean',
        ];
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function unidadMedida(): BelongsTo
    {
        return $this->belongsTo(UnidadMedida::class);
    }

    public function recetas(): HasMany
    {
        return $this->hasMany(Receta::class);
    }

    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(Producto::class, 'recetas')
            ->withPivot(['cantidad', 'unidad_medida_id', 'factor_conversion'])
            ->withTimestamps();
    }

    public function inventario(): HasMany
    {
        return $this->hasMany(Inventario::class);
    }

    public function detalleCompra(): HasMany
    {
        return $this->hasMany(DetalleCompra::class);
    }
}