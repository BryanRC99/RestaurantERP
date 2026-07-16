<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'sucursal_id',
        'cliente_id',
        'mesa_id',
        'usuario_id',
        'tipo_pedido',
        'estado',
        'subtotal',
        'descuento',
        'impuesto',
        'total',
        'fecha_pedido',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'descuento' => 'decimal:2',
            'impuesto' => 'decimal:2',
            'total' => 'decimal:2',
            'fecha_pedido' => 'datetime',
        ];
    }

    public function sucursal(): BelongsTo
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function mesa(): BelongsTo
    {
        return $this->belongsTo(Mesa::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function detalle(): HasMany
    {
        return $this->hasMany(DetallePedido::class);
    }

    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class);
    }

    public function factura(): HasOne
    {
        return $this->hasOne(Factura::class);
    }

    public function entrega(): HasOne
    {
        return $this->hasOne(Entrega::class);
    }

    public function pedidoPromocion(): HasMany
    {
        return $this->hasMany(PedidoPromocion::class);
    }

    public function promociones(): BelongsToMany
    {
        return $this->belongsToMany(Promocion::class, 'pedido_promocion')
            ->withPivot(['cupon_id', 'descuento_aplicado'])
            ->withTimestamps();
    }

    public function clienteCupon(): HasMany
    {
        return $this->hasMany(ClienteCupon::class);
    }

    public function esDelivery(): bool
    {
        return $this->tipo_pedido === 'delivery';
    }

    public function totalPagado(): float
    {
        return (float) $this->pagos()->sum('monto');
    }

    public function saldoPendiente(): float
    {
        return (float) $this->total - $this->totalPagado();
    }
}