<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    protected $table = 'direcciones';

    protected $fillable = [
        'user_id',
        'cliente_nombre',
        'cliente_telefono',
        'cliente_email',
        'direccion_entrega',
    ];

    /**
     * RELACIÓN: La dirección pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
