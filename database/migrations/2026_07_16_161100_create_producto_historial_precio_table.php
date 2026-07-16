<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('producto_historial_precio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_sucursal_id')->constrained('producto_sucursal')->cascadeOnDelete();
            $table->decimal('precio_anterior', 10, 2)->nullable();
            $table->decimal('precio_nuevo', 10, 2);
            $table->string('motivo', 255)->nullable();
            $table->date('fecha_cambio');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('producto_historial_precio');
    }
};