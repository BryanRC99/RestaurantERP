<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SucursalActivaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\IngredienteController;
use App\Http\Controllers\UnidadMedidaController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\RepartidorController;
use App\Http\Controllers\EntregaController;
use App\Http\Controllers\PromocionController;
use App\Http\Controllers\CuponController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/sucursal-activa', [SucursalActivaController::class, 'store']);

    // Todo lo que dependa de "en que sucursal estoy trabajando" va aqui adentro:
    Route::middleware('sucursal.activa')->group(function () {
        Route::get('/categorias', [CategoriaController::class, 'index']);
        Route::get('/productos', [ProductoController::class, 'index']);
        Route::get('/mesas', [MesaController::class, 'index']);
        Route::get('/pedidos', [PedidoController::class, 'index']);
        Route::get('/pedidos/{pedido}', [PedidoController::class, 'show']);
        Route::post('/pedidos', [PedidoController::class, 'store']);
        Route::post('/pedidos/{pedido}/pagos', [PagoController::class, 'store']);
        Route::get('/inventario', [InventarioController::class, 'index']);
        Route::get('/compras', [CompraController::class, 'index']);
        Route::post('/compras', [CompraController::class, 'store']);
        Route::get('/proveedores', [ProveedorController::class, 'index']);
        Route::get('/ingredientes', [IngredienteController::class, 'index']);
        Route::get('/unidades-medida', [UnidadMedidaController::class, 'index']);
        Route::apiResource('clientes', ClienteController::class)->except(['destroy']);
        Route::delete('/clientes/{cliente}', [ClienteController::class, 'destroy']);
        Route::get('/dashboard/resumen', [DashboardController::class, 'resumen']);
        Route::get('/cargos', [CargoController::class, 'index']);
        Route::post('/cargos', [CargoController::class, 'store']);
        Route::get('/empleados', [EmpleadoController::class, 'index']);
        Route::get('/empleados/{empleado}', [EmpleadoController::class, 'show']);
        Route::post('/empleados', [EmpleadoController::class, 'store']);
        Route::put('/empleados/{empleado}', [EmpleadoController::class, 'update']);
        Route::get('/asistencias', [AsistenciaController::class, 'index']);
        Route::post('/asistencias/entrada', [AsistenciaController::class, 'marcarEntrada']);
        Route::post('/asistencias/salida', [AsistenciaController::class, 'marcarSalida']);
        Route::get('/repartidores', [RepartidorController::class, 'index']);
        Route::post('/repartidores', [RepartidorController::class, 'store']);
        Route::get('/entregas', [EntregaController::class, 'index']);
        Route::post('/entregas/{entrega}/asignar', [EntregaController::class, 'asignar']);
        Route::post('/entregas/{entrega}/entregar', [EntregaController::class, 'entregar']);
        Route::get('/promociones', [PromocionController::class, 'index']);
        Route::post('/promociones', [PromocionController::class, 'store']);
        Route::post('/cupones', [CuponController::class, 'store']);
    });
});
