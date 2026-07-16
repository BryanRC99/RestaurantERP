<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historial_salarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_sucursal_id')->constrained('empleado_sucursal')->cascadeOnDelete();
            $table->decimal('salario_anterior', 10, 2)->nullable();
            $table->decimal('salario_nuevo', 10, 2);
            $table->string('motivo', 255)->nullable();
            $table->date('fecha_cambio');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historial_salarios');
    }
};