<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auditoria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('tabla_afectada', 100);
            $table->unsignedBigInteger('registro_id')->nullable();
            $table->string('accion', 50)->comment('create | update | delete');
            $table->json('datos_anteriores')->nullable();
            $table->json('datos_nuevos')->nullable();
            $table->string('ip', 45)->nullable();
            $table->timestamp('fecha')->useCurrent();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['tabla_afectada', 'registro_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auditoria');
    }
};