<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    // Indicale a Laravel cómo se llama tu tabla exacta en MariaDB si no es el plural automático
    protected $table = 'carritos'; 

    // Campos que se pueden llenar en lote
    protected $fillable = ['user_id', 'producto_id', 'cantidad'];

    /**
     * RELACIÓN: Cada registro del carrito pertenece a un producto del catálogo
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}