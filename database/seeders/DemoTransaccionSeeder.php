<?php

namespace Database\Seeders;

use App\Models\Auditoria;
use App\Models\Cliente;
use App\Models\ClienteCupon;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\DetalleFactura;
use App\Models\DetallePedido;
use App\Models\DireccionCliente;
use App\Models\Empleado;
use App\Models\EmpleadoSucursal;
use App\Models\Factura;
use App\Models\Inventario;
use App\Models\MovimientoInventario;
use App\Models\Notificacion;
use App\Models\Pago;
use App\Models\Pedido;
use App\Models\User;
use App\Models\UsuarioSucursal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DemoTransaccionSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            // 1. Usuario del sistema con acceso a la sucursal 1 como Cajero (rol_id 3)
            $user = User::create([
                'name' => 'Ana Cajera',
                'username' => 'acajera',
                'email' => 'ana.cajera@mirestaurante.com',
                'password' => Hash::make('password'),
                'empresa_id' => 1,
                'activo' => true,
            ]);

            UsuarioSucursal::create([
                'user_id' => $user->id,
                'sucursal_id' => 1,
                'rol_id' => 3, // Cajero (ver RolesSeeder)
            ]);

            // 2. Empleado y su relacion laboral en la sucursal
            $empleado = Empleado::create([
                'cedula' => '1712345678',
                'nombre' => 'Ana',
                'apellido' => 'Cajera',
                'fecha_ingreso' => now()->subMonths(6)->toDateString(),
            ]);

            EmpleadoSucursal::create([
                'empleado_id' => $empleado->id,
                'sucursal_id' => 1,
                'cargo_id' => 2, // Cajero (ver CargosSeeder)
                'salario' => 460.00,
                'fecha_inicio' => now()->subMonths(6)->toDateString(),
            ]);

            // 3. Cliente con direccion
            $cliente = Cliente::create([
                'empresa_id' => 1,
                'nombre' => 'Juan',
                'apellido' => 'Perez',
                'telefono' => '0991112233',
            ]);

            DireccionCliente::create([
                'cliente_id' => $cliente->id,
                'direccion' => 'Av. Amazonas y Naciones Unidas',
                'ciudad' => 'Quito',
                'principal' => true,
            ]);

            // 4. Compra de ingrediente (Pollo, id 1) que entra a inventario
            $compra = Compra::create([
                'sucursal_id' => 1,
                'proveedor_id' => 1,
                'usuario_id' => $user->id,
                'fecha_compra' => now()->toDateString(),
                'subtotal' => 35.00,
                'impuesto' => 0,
                'total' => 35.00,
                'estado' => 'recibida',
            ]);

            $detalleCompra = DetalleCompra::create([
                'compra_id' => $compra->id,
                'ingrediente_id' => 1, // Pollo
                'cantidad' => 10,
                'unidad_medida_id' => 1, // kg
                'factor_conversion' => 1,
                'precio_unitario' => 3.50,
                'subtotal' => 35.00,
            ]);

            $inventarioPollo = Inventario::where('sucursal_id', 1)
                ->where('ingrediente_id', 1)
                ->first();

            $inventarioPollo->increment('stock_actual', $detalleCompra->cantidadEnUnidadBase());

            MovimientoInventario::create([
                'inventario_id' => $inventarioPollo->id,
                'tipo' => 'entrada',
                'cantidad' => $detalleCompra->cantidadEnUnidadBase(),
                'motivo' => 'Compra a proveedor',
                'referencia_tipo' => 'compra',
                'referencia_id' => $compra->id,
                'usuario_id' => $user->id,
                'fecha_movimiento' => now(),
            ]);

            // 5. Pedido en salon, mesa 1, producto "Seco de Pollo" (id 1, precio 6.50)
            $pedido = Pedido::create([
                'sucursal_id' => 1,
                'cliente_id' => $cliente->id,
                'mesa_id' => 1,
                'usuario_id' => $user->id,
                'tipo_pedido' => 'salon',
                'estado' => 'entregado',
                'subtotal' => 13.00,
                'descuento' => 0,
                'impuesto' => 0,
                'total' => 13.00,
                'fecha_pedido' => now(),
            ]);

            $detallePedido = DetallePedido::create([
                'pedido_id' => $pedido->id,
                'producto_id' => 1,
                'cantidad' => 2,
                'precio_unitario' => 6.50,
                'descuento' => 0,
                'subtotal' => 13.00,
            ]);

            // La venta descuenta inventario segun la receta del producto (0.3 kg de pollo x 2 unidades = 0.6 kg)
            $cantidadDescontar = 0.3 * 2;
            $inventarioPollo->decrement('stock_actual', $cantidadDescontar);

            MovimientoInventario::create([
                'inventario_id' => $inventarioPollo->id,
                'tipo' => 'salida',
                'cantidad' => $cantidadDescontar,
                'motivo' => 'Venta - receta de producto',
                'referencia_tipo' => 'pedido',
                'referencia_id' => $pedido->id,
                'usuario_id' => $user->id,
                'fecha_movimiento' => now(),
            ]);

            // 6. Pago del pedido
            Pago::create([
                'pedido_id' => $pedido->id,
                'tipo_pago' => 'efectivo',
                'monto' => 13.00,
                'usuario_id' => $user->id,
                'fecha_pago' => now(),
            ]);

            // 7. Factura y su detalle, trazado al detalle_pedido original
            $factura = Factura::create([
                'pedido_id' => $pedido->id,
                'cliente_id' => $cliente->id,
                'numero_factura' => '001-001-000000001',
                'fecha_emision' => now(),
                'subtotal' => 13.00,
                'impuesto' => 0,
                'total' => 13.00,
                'estado' => 'emitida',
            ]);

            DetalleFactura::create([
                'factura_id' => $factura->id,
                'detalle_pedido_id' => $detallePedido->id,
                'producto_id' => 1,
                'cantidad' => 2,
                'precio_unitario' => 6.50,
                'subtotal' => 13.00,
            ]);

            // 8. Cupon disponible para el cliente (aun no usado)
            ClienteCupon::create([
                'cliente_id' => $cliente->id,
                'cupon_id' => 1, // BEBIDA10
                'usado' => false,
            ]);

            // 9. Notificacion y registro de auditoria
            Notificacion::create([
                'usuario_id' => $user->id,
                'titulo' => 'Nuevo pedido registrado',
                'mensaje' => "Pedido #{$pedido->id} por \$13.00 registrado y pagado.",
                'fecha' => now(),
            ]);

            Auditoria::create([
                'usuario_id' => $user->id,
                'tabla_afectada' => 'pedidos',
                'registro_id' => $pedido->id,
                'accion' => 'create',
                'datos_nuevos' => $pedido->toArray(),
                'fecha' => now(),
            ]);
        });
    }
}