<?php

namespace App\Actions;

use App\Models\DetallePedido;
use App\Models\Inventario;
use App\Models\MovimientoInventario;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\ProductoSucursal;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use RuntimeException;

class RegistrarPedidoAction
{
    /**
     * Se agrega el constructor para inyectar AplicarCuponAction.
     */
    public function __construct(
        private AplicarCuponAction $aplicarCuponAction,
    ) {}

    /**
     * @param  array{producto_id:int, cantidad:int, observacion?:string}[]  $items
     */
    public function ejecutar(
        int $sucursalId,
        int $usuarioId,
        string $tipoPedido,
        ?int $clienteId,
        ?int $mesaId,
        array $items,
        ?string $direccionDelivery = null,
        ?string $cuponCodigo = null, // <- Nuevo parámetro opcional integrado
    ): Pedido {
        if (empty($items)) {
            throw new InvalidArgumentException('El pedido debe tener al menos un producto.');
        }

        // Pasamos $cuponCodigo al closure de la transacción
        return DB::transaction(function () use ($sucursalId, $usuarioId, $tipoPedido, $clienteId, $mesaId, $items, $direccionDelivery, $cuponCodigo) {
            $pedido = Pedido::create([
                'sucursal_id' => $sucursalId,
                'cliente_id' => $clienteId,
                'mesa_id' => $mesaId,
                'usuario_id' => $usuarioId,
                'tipo_pedido' => $tipoPedido,
                'estado' => 'pendiente',
                'subtotal' => 0,
                'descuento' => 0,
                'impuesto' => 0,
                'total' => 0,
                'fecha_pedido' => now(),
            ]);

            $subtotal = 0;

            foreach ($items as $item) {
                $productoSucursal = ProductoSucursal::where('producto_id', $item['producto_id'])
                    ->where('sucursal_id', $sucursalId)
                    ->where('disponible', true)
                    ->first();

                if (! $productoSucursal) {
                    throw new InvalidArgumentException(
                        "El producto {$item['producto_id']} no esta disponible en esta sucursal."
                    );
                }

                $cantidad = $item['cantidad'];
                $precioUnitario = (float) $productoSucursal->precio;
                $lineaSubtotal = round($precioUnitario * $cantidad, 2);

                DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $item['producto_id'],
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precioUnitario,
                    'descuento' => 0,
                    'subtotal' => $lineaSubtotal,
                    'observacion' => $item['observacion'] ?? null,
                ]);

                if ($productoSucursal->stock_controlado) {
                    $this->descontarInventarioPorReceta(
                        producto: $productoSucursal->producto,
                        sucursalId: $sucursalId,
                        cantidadVendida: $cantidad,
                        usuarioId: $usuarioId,
                        pedidoId: $pedido->id,
                    );
                }

                $subtotal += $lineaSubtotal;
            }

            // --- Lógica del Cupón de Descuento ---
            $descuento = 0;
            if ($cuponCodigo) {
                try {
                    $descuento = $this->aplicarCuponAction->ejecutar(
                        $pedido->fresh('detalle.producto'), 
                        $cuponCodigo, 
                        $clienteId
                    );
                } catch (RuntimeException $e) {
                    throw $e; // Se propaga para que el PedidoController la capture
                }
            }

            // Se reemplaza el update viejo por este único update que ya considera el descuento
            $pedido->update([
                'subtotal' => $subtotal,
                'descuento' => $descuento,
                'total' => $subtotal - $descuento,
            ]);

            if ($tipoPedido === 'delivery') {
                \App\Models\Entrega::create([
                    'pedido_id' => $pedido->id,
                    'direccion' => $direccionDelivery,
                    'estado' => 'pendiente',
                ]);
            }

            return $pedido->fresh(['detalle.producto', 'mesa', 'cliente', 'entrega']);
        });
    }

    private function descontarInventarioPorReceta(
        Producto $producto,
        int $sucursalId,
        int $cantidadVendida,
        int $usuarioId,
        int $pedidoId,
    ): void {
        $receta = $producto->recetas()->with('ingrediente')->get();

        foreach ($receta as $linea) {
            $inventario = Inventario::where('sucursal_id', $sucursalId)
                ->where('ingrediente_id', $linea->ingrediente_id)
                ->lockForUpdate()
                ->first();

            if (! $inventario) {
                throw new RuntimeException(
                    "No hay inventario configurado para el ingrediente {$linea->ingrediente->nombre} en esta sucursal."
                );
            }

            $cantidadADescontar = $linea->cantidadEnUnidadBase() * $cantidadVendida;

            if ($inventario->stock_actual < $cantidadADescontar) {
                throw new RuntimeException(
                    "Stock insuficiente de {$linea->ingrediente->nombre} para completar el pedido."
                );
            }

            $inventario->decrement('stock_actual', $cantidadADescontar);

            MovimientoInventario::create([
                'inventario_id' => $inventario->id,
                'tipo' => 'salida',
                'cantidad' => $cantidadADescontar,
                'motivo' => 'Venta - receta de producto',
                'referencia_tipo' => 'pedido',
                'referencia_id' => $pedidoId,
                'usuario_id' => $usuarioId,
                'fecha_movimiento' => now(),
            ]);
        }
    }
}