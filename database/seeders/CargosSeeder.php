<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CargosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('cargos')->insert([
            ['empresa_id' => 1, 'nombre' => 'Gerente de Sucursal', 'descripcion' => 'Responsable de la sucursal', 'created_at' => now(), 'updated_at' => now()],
            ['empresa_id' => 1, 'nombre' => 'Cajero', 'descripcion' => 'Cobro y cierre de caja', 'created_at' => now(), 'updated_at' => now()],
            ['empresa_id' => 1, 'nombre' => 'Mesero', 'descripcion' => 'Atencion de mesas', 'created_at' => now(), 'updated_at' => now()],
            ['empresa_id' => 1, 'nombre' => 'Cocinero', 'descripcion' => 'Preparacion de alimentos', 'created_at' => now(), 'updated_at' => now()],
            ['empresa_id' => 1, 'nombre' => 'Encargado de Bodega', 'descripcion' => 'Control de inventario', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}