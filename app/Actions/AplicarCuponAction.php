<?php

namespace App\Actions;

use App\Models\ClienteCupon;
use App\Models\Cupon;
use App\Models\Pedido;
use App\Models\PedidoPromocion;
use App\Models\Promocion;
use Illuminate\Support\Collection;
use RuntimeException;

class AplicarCuponAction
{
    public function ejecutar(Pedido $pedido, string $codigo, ?int $clienteId): float
    {
        $cupon = Cupon::where('codigo', strtoupper($codigo))->with('promocion')->first();

        if (! $cupon || ! $cupon->disponible()) {
            throw new RuntimeException('El cupón no es válido o ya no está disponible.');
        }

        $promocion = $cupon->promocion;

        if (! $promocion->vigente()) {
            throw new RuntimeException('La promoción asociada a este cupón no está vigente.');
        }

        $itemsAplicables = $this->itemsAplicables($pedido, $promocion);

        if ($itemsAplicables->isEmpty()) {
            throw new RuntimeException('Este cupón no aplica a ningún producto de tu pedido.');
        }

        $baseCalculo = (float) $itemsAplicables->sum('subtotal');
        $descuento = $promocion->porcentaje
            ? round($baseCalculo * ((float) $promocion->valor / 100), 2)
            : min((float) $promocion->valor, $baseCalculo);

        PedidoPromocion::create([
            'pedido_id' => $pedido->id,
            'promocion_id' => $promocion->id,
            'cupon_id' => $cupon->id,
            'descuento_aplicado' => $descuento,
        ]);

        $cupon->increment('usos_actuales');

        if ($clienteId) {
            ClienteCupon::updateOrCreate(
                ['cliente_id' => $clienteId, 'cupon_id' => $cupon->id],
                ['pedido_id' => $pedido->id, 'usado' => true, 'fecha_uso' => now()]
            );
        }

        return $descuento;
    }

    private function itemsAplicables(Pedido $pedido, Promocion $promocion): Collection
    {
        $productoIds = $promocion->productos()->pluck('productos.id');
        $categoriaIds = $promocion->categorias()->pluck('categorias.id');

        // Sin productos/categorias asociadas = aplica a todo el pedido.
        if ($productoIds->isEmpty() && $categoriaIds->isEmpty()) {
            return $pedido->detalle;
        }

        return $pedido->detalle->filter(
            fn ($linea) => $productoIds->contains($linea->producto_id)
                || $categoriaIds->contains($linea->producto->categoria_id)
        );
    }
}