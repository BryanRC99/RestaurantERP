<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSucursalSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('producto_sucursal')->insert([
            ['producto_id' => 1, 'sucursal_id' => 1, 'precio' => 6.50, 'created_at' => now(), 'updated_at' => now()],
            ['producto_id' => 2, 'sucursal_id' => 1, 'precio' => 8.00, 'created_at' => now(), 'updated_at' => now()],
            ['producto_id' => 3, 'sucursal_id' => 1, 'precio' => 2.00, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}