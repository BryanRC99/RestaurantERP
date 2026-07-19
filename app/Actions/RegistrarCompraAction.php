<?php

namespace App\Actions;

use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Inventario;
use App\Models\MovimientoInventario;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class RegistrarCompraAction
{
    /**
     * @param  array{ingrediente_id:int, cantidad:float, unidad_medida_id:int, factor_conversion:float, precio_unitario:float}[]  $items
     */
    public function ejecutar(
        int $sucursalId,
        int $proveedorId,
        int $usuarioId,
        array $items,
    ): Compra {
        if (empty($items)) {
            throw new InvalidArgumentException('La compra debe tener al menos un ingrediente.');
        }

        return DB::transaction(function () use ($sucursalId, $proveedorId, $usuarioId, $items) {
            $compra = Compra::create([
                'sucursal_id' => $sucursalId,
                'proveedor_id' => $proveedorId,
                'usuario_id' => $usuarioId,
                'fecha_compra' => now()->toDateString(),
                'subtotal' => 0,
                'impuesto' => 0,
                'total' => 0,
                'estado' => 'recibida',
            ]);

            $subtotal = 0;

            foreach ($items as $item) {
                $lineaSubtotal = round($item['cantidad'] * $item['precio_unitario'], 2);

                $detalle = DetalleCompra::create([
                    'compra_id' => $compra->id,
                    'ingrediente_id' => $item['ingrediente_id'],
                    'cantidad' => $item['cantidad'],
                    'unidad_medida_id' => $item['unidad_medida_id'],
                    'factor_conversion' => $item['factor_conversion'],
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal' => $lineaSubtotal,
                ]);

                $inventario = Inventario::firstOrCreate(
                    ['sucursal_id' => $sucursalId, 'ingrediente_id' => $item['ingrediente_id']],
                    ['stock_actual' => 0, 'stock_minimo' => 0]
                );

                $cantidadBase = $detalle->cantidadEnUnidadBase();
                $inventario->increment('stock_actual', $cantidadBase);

                MovimientoInventario::create([
                    'inventario_id' => $inventario->id,
                    'tipo' => 'entrada',
                    'cantidad' => $cantidadBase,
                    'motivo' => 'Compra a proveedor',
                    'referencia_tipo' => 'compra',
                    'referencia_id' => $compra->id,
                    'usuario_id' => $usuarioId,
                    'fecha_movimiento' => now(),
                ]);

                $subtotal += $lineaSubtotal;
            }

            $compra->update([
                'subtotal' => $subtotal,
                'total' => $subtotal,
            ]);

            return $compra->fresh(['detalle.ingrediente', 'proveedor']);
        });
    }
}