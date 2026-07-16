<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsuarioSucursal extends Model
{
    use HasFactory;

    protected $table = 'usuario_sucursal';

    protected $fillable = [
        'user_id',
        'sucursal_id',
        'rol_id',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sucursal(): BelongsTo
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class);
    }
}