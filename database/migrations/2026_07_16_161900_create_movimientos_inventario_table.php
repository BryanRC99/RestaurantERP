<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientos_inventario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventario_id')->constrained('inventario')->cascadeOnDelete();
            $table->string('tipo', 20)->comment('entrada | salida');
            $table->decimal('cantidad', 10, 3);
            $table->string('motivo', 255)->nullable();
            // A que tabla/proceso pertenece este movimiento (compra, pedido,
            // ajuste, merma), junto con referencia_id, para no dejar el
            // origen del movimiento ambiguo.
            $table->string('referencia_tipo', 50)->nullable();
            $table->unsignedBigInteger('referencia_id')->nullable();
            $table->foreignId('usuario_id')->constrained('users');
            $table->timestamp('fecha_movimiento')->useCurrent();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['referencia_tipo', 'referencia_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos_inventario');
    }
};