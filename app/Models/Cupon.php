<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cupon extends Model
{
    use HasFactory;

    protected $table = 'cupones';

    public $timestamps = false;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'promocion_id',
        'codigo',
        'limite_uso',
        'usos_actuales',
        'fecha_inicio',
        'fecha_fin',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
            'activo' => 'boolean',
            'created_at' => 'datetime',
        ];
    }

    public function promocion(): BelongsTo
    {
        return $this->belongsTo(Promocion::class);
    }

    public function clienteCupon(): HasMany
    {
        return $this->hasMany(ClienteCupon::class);
    }

    public function pedidoPromocion(): HasMany
    {
        return $this->hasMany(PedidoPromocion::class);
    }

    public function disponible(): bool
    {
        if (! $this->activo) {
            return false;
        }

        if ($this->limite_uso !== null && $this->usos_actuales >= $this->limite_uso) {
            return false;
        }

        $hoy = now()->toDateString();

        if ($this->fecha_inicio && $this->fecha_inicio > $hoy) {
            return false;
        }

        if ($this->fecha_fin && $this->fecha_fin < $hoy) {
            return false;
        }

        return true;
    }
}