<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Pedido;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function resumen(Request $request)
    {
        $sucursalId = $request->attributes->get('sucursal_activa')->sucursal_id;

        $pedidosHoy = Pedido::where('sucursal_id', $sucursalId)
            ->whereDate('fecha_pedido', now()->toDateString())
            ->get();

        $pedidosPendientesPago = Pedido::where('sucursal_id', $sucursalId)
            ->where('estado', '!=', 'pagado')
            ->with('pagos')
            ->get()
            ->filter(fn (Pedido $pedido) => $pedido->saldoPendiente() > 0.01)
            ->values();

        $stockBajo = Inventario::where('sucursal_id', $sucursalId)
            ->with('ingrediente.unidadMedida')
            ->get()
            ->filter(fn (Inventario $inv) => $inv->bajoMinimo())
            ->values();

        $pedidosRecientes = Pedido::where('sucursal_id', $sucursalId)
            ->with(['mesa', 'cliente'])
            ->latest('fecha_pedido')
            ->limit(5)
            ->get();

        return response()->json([
            'ventas_hoy' => [
                'total' => round($pedidosHoy->sum('total'), 2),
                'cantidad_pedidos' => $pedidosHoy->count(),
            ],
            'pedidos_pendientes_pago' => [
                'cantidad' => $pedidosPendientesPago->count(),
                'monto_total' => round($pedidosPendientesPago->sum(fn (Pedido $p) => $p->saldoPendiente()), 2),
            ],
            'stock_bajo' => $stockBajo->map(fn (Inventario $inv) => [
                'ingrediente' => $inv->ingrediente->nombre,
                'stock_actual' => $inv->stock_actual,
                'stock_minimo' => $inv->stock_minimo,
                'unidad' => $inv->ingrediente->unidadMedida->abreviatura,
            ]),
            'pedidos_recientes' => $pedidosRecientes->map(fn (Pedido $p) => [
                'id' => $p->id,
                'tipo_pedido' => $p->tipo_pedido,
                'estado' => $p->estado,
                'mesa' => $p->mesa?->numero,
                'cliente' => $p->cliente?->nombreCompleto(),
                'total' => $p->total,
                'fecha_pedido' => $p->fecha_pedido,
            ]),
        ]);
    }
}