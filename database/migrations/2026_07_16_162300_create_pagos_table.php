<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->cascadeOnDelete();
            $table->string('tipo_pago', 50)->comment('efectivo | tarjeta | transferencia | mixto');
            $table->decimal('monto', 10, 2);
            $table->string('referencia', 100)->nullable()->comment('numero de comprobante/transaccion');
            $table->timestamp('fecha_pago')->useCurrent();
            $table->foreignId('usuario_id')->constrained('users')->comment('quien proceso el cobro');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};