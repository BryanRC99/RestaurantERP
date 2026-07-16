<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notificacion extends Model
{
    protected $table = 'notificaciones';

    public $timestamps = false;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'usuario_id',
        'titulo',
        'mensaje',
        'leida',
        'fecha',
    ];

    protected function casts(): array
    {
        return [
            'leida' => 'boolean',
            'fecha' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function marcarLeida(): void
    {
        $this->update(['leida' => true]);
    }
}