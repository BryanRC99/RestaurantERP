<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asistencia extends Model
{
    protected $table = 'asistencias';

    public $timestamps = false;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'empleado_sucursal_id',
        'fecha',
        'hora_entrada',
        'hora_salida',
        'estado',
        'observacion',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'hora_entrada' => 'datetime:H:i:s',
            'hora_salida' => 'datetime:H:i:s',
            'created_at' => 'datetime',
        ];
    }

    public function empleadoSucursal(): BelongsTo
    {
        return $this->belongsTo(EmpleadoSucursal::class);
    }
}