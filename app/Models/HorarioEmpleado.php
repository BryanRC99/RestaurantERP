<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HorarioEmpleado extends Model
{
    use HasFactory;

    protected $table = 'horarios_empleado';

    protected $fillable = [
        'empleado_sucursal_id',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }

    public function empleadoSucursal(): BelongsTo
    {
        return $this->belongsTo(EmpleadoSucursal::class);
    }
}