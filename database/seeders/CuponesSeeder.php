<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CuponesSeeder extends Seeder
{
    public function run(): void
    {
        $promoId = DB::table('promociones')->where('nombre', 'Descuento Bebidas 10%')->value('id');

        if ($promoId) {
            DB::table('cupones')->insert([
                'promocion_id' => $promoId,
                'codigo' => 'BEBIDA10',
                'limite_uso' => 100,
                'fecha_inicio' => now()->toDateString(),
                'fecha_fin' => now()->addMonths(2)->toDateString(),
                'created_at' => now(),
            ]);
        }
    }
}