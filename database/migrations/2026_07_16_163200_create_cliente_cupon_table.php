<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cliente_cupon', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->cascadeOnDelete();
            $table->foreignId('cupon_id')->constrained('cupones')->cascadeOnDelete();
            // A que pedido quedo aplicado este uso del cupon (trazabilidad
            // completa: que cliente, que codigo, en que pedido).
            $table->foreignId('pedido_id')->nullable()->constrained('pedidos')->nullOnDelete();
            $table->boolean('usado')->default(false);
            $table->timestamp('fecha_uso')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cliente_cupon');
    }
};