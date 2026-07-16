<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_factura', function (Blueprint $table) {
            $table->id();
            $table->foreignId('factura_id')->constrained('facturas')->cascadeOnDelete();
            // Traza a la linea original del pedido que se esta facturando.
            // Nullable porque permite facturar parcial o reagrupar lineas
            // (ej: dos porciones del mismo producto en una sola linea de factura).
            $table->foreignId('detalle_pedido_id')->nullable()->constrained('detalle_pedido')->nullOnDelete();
            $table->foreignId('producto_id')->constrained('productos');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_factura');
    }
};