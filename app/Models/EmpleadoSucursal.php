<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmpleadoSucursal extends Model
{
    use HasFactory;

    protected $table = 'empleado_sucursal';

    protected $fillable = [
        'empleado_id',
        'sucursal_id',
        'cargo_id',
        'salario',
        'fecha_inicio',
        'fecha_fin',
        'activo',
        'observacion',
    ];

    protected function casts(): array
    {
        return [
            'salario' => 'decimal:2',
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
            'activo' => 'boolean',
        ];
    }

    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Empleado::class);
    }

    public function sucursal(): BelongsTo
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function cargo(): BelongsTo
    {
        return $this->belongsTo(Cargo::class);
    }

    public function historialSalarios(): HasMany
    {
        return $this->hasMany(HistorialSalario::class);
    }

    public function horariosEmpleado(): HasMany
    {
        return $this->hasMany(HorarioEmpleado::class);
    }

    public function asistencias(): HasMany
    {
        return $this->hasMany(Asistencia::class);
    }
}