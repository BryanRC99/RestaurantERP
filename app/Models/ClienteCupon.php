<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClienteCupon extends Model
{
    protected $table = 'cliente_cupon';

    public $timestamps = false;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'cliente_id',
        'cupon_id',
        'pedido_id',
        'usado',
        'fecha_uso',
    ];

    protected function casts(): array
    {
        return [
            'usado' => 'boolean',
            'fecha_uso' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function cupon(): BelongsTo
    {
        return $this->belongsTo(Cupon::class);
    }

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }
}