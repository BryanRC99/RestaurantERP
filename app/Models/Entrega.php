<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entrega extends Model
{
    protected $table = 'entregas';

    public $timestamps = false;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'pedido_id',
        'repartidor_id',
        'direccion',
        'estado',
        'hora_asignacion',
        'hora_entrega',
    ];

    protected function casts(): array
    {
        return [
            'hora_asignacion' => 'datetime',
            'hora_entrega' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }

    public function repartidor(): BelongsTo
    {
        return $this->belongsTo(Repartidor::class);
    }

    public function entregada(): bool
    {
        return $this->estado === 'entregado';
    }
}