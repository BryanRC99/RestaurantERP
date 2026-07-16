<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MovimientoInventario extends Model
{
    protected $table = 'movimientos_inventario';

    public $timestamps = false;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'inventario_id',
        'tipo',
        'cantidad',
        'motivo',
        'referencia_tipo',
        'referencia_id',
        'usuario_id',
        'fecha_movimiento',
    ];

    protected function casts(): array
    {
        return [
            'cantidad' => 'decimal:3',
            'fecha_movimiento' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    public function inventario(): BelongsTo
    {
        return $this->belongsTo(Inventario::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Acceso generico al registro de origen (Compra, Pedido, etc.) usando
     * referencia_tipo + referencia_id. No es un morphTo estandar de Laravel
     * (esos esperan una columna con el nombre completo de la clase), asi que
     * lo resolvemos a mano segun el valor guardado en referencia_tipo.
     */
    public function referencia(): ?Model
    {
        return match ($this->referencia_tipo) {
            'compra' => Compra::find($this->referencia_id),
            'pedido' => Pedido::find($this->referencia_id),
            default => null,
        };
    }

    public function esEntrada(): bool
    {
        return $this->tipo === 'entrada';
    }

    public function esSalida(): bool
    {
        return $this->tipo === 'salida';
    }
}