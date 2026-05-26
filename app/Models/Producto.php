<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    // Forzamos el nombre de la tabla en MariaDB
    protected $table = 'productos';

    protected $fillable = [
        'categoria_id',
        'nombre',
        'slug',
        'descripcion',
        'imagen',
        'precio',
        'stock',
        'activo',
    ];

    /**
     * RELACIÓN: El producto pertenece a una categoría.
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    /**
     * RELACIÓN: El producto puede aparecer en muchos registros de carrito.
     */
    public function carritos(): HasMany
    {
        return $this->hasMany(Carrito::class, 'producto_id');
    }
}
