<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("roles")->insert([
            [
                'nombre' => 'Administrador',
                'descripcion' => 'Control total del sistema',
            ],
            [
                'nombre'=> 'Gerente',
                'descripcion'=> 'Administrador de sucursales',
            ],
            [
                'nombre'=> 'Cajero',
                'descripcion'=> 'Gestion de cobros',
            ],
            [
                'nombre'=> 'Mesero',
                'descripcion'=> 'Gestion de pedidos',
            ],
            [
                'nombre'=> 'Cocinero',
                'descripcion'=> 'Preparacion de productos',
            ],
            [
                'nombre'=> 'Bodega',
                'descripcion' => 'Control de inventario',
            ],
            [
                'nombre'=> 'Repartidor',
                'descripcion' => 'Entrega de pedidos',
            ],   
        ]);
    }
}
