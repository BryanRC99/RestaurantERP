<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventarioSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('inventario')->insert([
            ['sucursal_id' => 1, 'ingrediente_id' => 1, 'stock_actual' => 20, 'stock_minimo' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['sucursal_id' => 1, 'ingrediente_id' => 2, 'stock_actual' => 15, 'stock_minimo' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['sucursal_id' => 1, 'ingrediente_id' => 3, 'stock_actual' => 10, 'stock_minimo' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}