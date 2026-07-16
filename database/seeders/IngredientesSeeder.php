<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('ingredientes')->insert([
            ['empresa_id' => 1, 'unidad_medida_id' => 1, 'nombre' => 'Pollo', 'created_at' => now(), 'updated_at' => now()],
            ['empresa_id' => 1, 'unidad_medida_id' => 1, 'nombre' => 'Carne de Res', 'created_at' => now(), 'updated_at' => now()],
            ['empresa_id' => 1, 'unidad_medida_id' => 3, 'nombre' => 'Aceite', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}