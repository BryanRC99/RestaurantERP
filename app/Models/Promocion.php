<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Promocion extends Model
{
    use HasFactory;

    protected $table = 'promociones';

    protected $fillable = [
        'empresa_id',
        'nombre',
        'descripcion',
        'tipo_promocion',
        'valor',
        'porcentaje',
        'fecha_inicio',
        'fecha_fin',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'valor' => 'decimal:2',
            'porcentaje' => 'boolean',
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
            'activo' => 'boolean',
        ];
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(Producto::class, 'promocion_producto')
            ->withTimestamps();
    }

    public function categorias(): BelongsToMany
    {
        return $this->belongsToMany(Categoria::class, 'promocion_categoria')
            ->withTimestamps();
    }

    public function cupones(): HasMany
    {
        return $this->hasMany(Cupon::class);
    }

    public function pedidoPromocion(): HasMany
    {
        return $this->hasMany(PedidoPromocion::class);
    }

    public function vigente(): bool
    {
        $hoy = now()->toDateString();

        return $this->activo
            && $this->fecha_inicio <= $hoy
            && $this->fecha_fin >= $hoy;
    }
}