<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Producto extends Model
{
    use SoftDeletes;
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
        'es_combo',
        'destacado',
        'productos_combo',
    ];

    protected $casts = [
        'es_combo' => 'boolean',
        'destacado' => 'boolean',
        'productos_combo' => 'array',
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

    /**
     * Obtiene los productos que componen este combo.
     */
    public function getProductosComboCollectionAttribute()
    {
        if (!$this->es_combo || empty($this->productos_combo)) {
            return collect();
        }
        return self::whereIn('id', $this->productos_combo)->get();
    }

    protected static function booted()
    {
        static::creating(function ($producto) {
            if (empty($producto->slug) && ! empty($producto->nombre)) {
                $base = Str::slug($producto->nombre);
                $slug = $base;
                $i = 1;
                while (self::where('slug', $slug)->exists()) {
                    $slug = $base . '-' . $i++;
                }
                $producto->slug = $slug;
            }
        });
    }
}
