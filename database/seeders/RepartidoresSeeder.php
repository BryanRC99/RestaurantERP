<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RepartidoresSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('repartidores')->insert([
            ['empleado_id' => null, 'nombre' => 'Carlos Andino', 'telefono' => '0991234567', 'created_at' => now()],
            ['empleado_id' => null, 'nombre' => 'Mario Reyes', 'telefono' => '0997654321', 'created_at' => now()],
        ]);
    }
}