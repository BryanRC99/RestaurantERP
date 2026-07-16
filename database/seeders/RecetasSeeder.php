<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecetasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('recetas')->insert([
            // Seco de Pollo (producto_id 1) usa 0.3 kg de pollo
            ['producto_id' => 1, 'ingrediente_id' => 1, 'cantidad' => 0.3, 'unidad_medida_id' => 1, 'factor_conversion' => 1, 'created_at' => now(), 'updated_at' => now()],
            // Churrasco (producto_id 2) usa 0.25 kg de carne de res
            ['producto_id' => 2, 'ingrediente_id' => 2, 'cantidad' => 0.25, 'unidad_medida_id' => 1, 'factor_conversion' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}