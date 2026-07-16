<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entregas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->cascadeOnDelete();
            // Nullable: al crearse el pedido delivery aun no hay repartidor asignado.
            $table->foreignId('repartidor_id')->nullable()->constrained('repartidores')->nullOnDelete();
            // Snapshot de la direccion al momento del pedido (igual que el
            // precio en detalle_pedido), no se ata directo a direcciones_cliente
            // porque el cliente puede editar/borrar esa direccion despues.
            $table->text('direccion')->nullable();
            $table->string('estado', 50)->default('pendiente');
            $table->timestamp('hora_asignacion')->nullable();
            $table->timestamp('hora_entrega')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entregas');
    }
};