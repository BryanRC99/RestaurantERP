<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Empleado extends Model
{
    use HasFactory;
    protected $table = 'empleados';

    protected $fillable = [
        'cedula',
        'nombre',
        'apellido',
        'telefono',
        'direccion',
        'fecha_nacimiento',
        'fecha_ingreso',
        'email',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'fecha_nacimiento' => 'date',
            'fecha_ingreso' => 'date',
            'activo' => 'boolean',
        ];
    }

    public function empleadoSucursal(): HasMany
    {
        return $this->hasMany(EmpleadoSucursal::class);
    }

    public function empleadoSucursalActivo(): HasOne
    {
        return $this->hasOne(EmpleadoSucursal::class)->where('activo', true);
    }

    public function usuario(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function repartidores(): HasMany
    {
        return $this->hasMany(Repartidor::class);
    }

    public function nombreCompleto(): string
    {
        return "{$this->nombre} {$this->apellido}";
    }
}