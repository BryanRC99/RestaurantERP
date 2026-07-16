<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromocionesSeeder extends Seeder
{
    public function run(): void
    {
        $promoId = DB::table('promociones')->insertGetId([
            'empresa_id' => 1,
            'nombre' => 'Descuento Bebidas 10%',
            'descripcion' => 'Descuento en toda la categoria Bebidas',
            'tipo_promocion' => 'descuento_categoria',
            'valor' => 10,
            'porcentaje' => true,
            'fecha_inicio' => now()->toDateString(),
            'fecha_fin' => now()->addMonths(2)->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Categoria 3 = Bebidas (ver CategoriasSeeder del bloque 3)
        DB::table('promocion_categoria')->insert([
            'promocion_id' => $promoId,
            'categoria_id' => 3,
            'created_at' => now(),
        ]);
    }
}