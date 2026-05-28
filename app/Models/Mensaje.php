<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mensaje extends Model
{
    use SoftDeletes;

    protected $table = 'mensajes';

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'asunto',
        'contenido',
        'leido',
        'user_id',
    ];

    protected $casts = [
        'leido' => 'boolean',
    ];

    /**
     * RELACIÓN: El mensaje pertenece a un usuario (si es registrado).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
