<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('configuracion_empresa', function (Blueprint $table) {
            $table->id();

            $table->string('nombre_comercial',150);

            $table->string('razon_social', 200)
              ->nullable();

            $table->string('ruc', 20)
              ->nullable();

            $table->string('telefono', 30)
              ->nullable();

            $table->string('email', 150)
              ->nullable();

            $table->text('direccion')
              ->nullable();

            $table->text('logo')
              ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracion_empresa');
    }
};
