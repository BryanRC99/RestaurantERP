<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistorialSalario extends Model
{
    protected $table = 'historial_salarios';

    public $timestamps = false;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'empleado_sucursal_id',
        'salario_anterior',
        'salario_nuevo',
        'motivo',
        'fecha_cambio',
    ];

    protected function casts(): array
    {
        return [
            'salario_anterior' => 'decimal:2',
            'salario_nuevo' => 'decimal:2',
            'fecha_cambio' => 'date',
            'created_at' => 'datetime',
        ];
    }

    public function empleadoSucursal(): BelongsTo
    {
        return $this->belongsTo(EmpleadoSucursal::class);
    }
}