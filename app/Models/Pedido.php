<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedido extends Model
{
    use SoftDeletes;

    protected $table = 'pedidos';

    protected $fillable = [
        'user_id',
        'cliente_nombre',
        'cliente_telefono',
        'cliente_email',
        'direccion_entrega',
        'estado',
        'total',
        'metodo_pago',
        'comprobante',
        'mp_payment_id',
        'descripcion',
    ];

    /**
     * RELACIÓN: El pedido pertenece a un usuario.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * RELACIÓN: El pedido tiene muchos detalles.
     */
    public function detalles(): HasMany
    {
        return $this->hasMany(PedidoDetalle::class, 'pedido_id');
    }
}
