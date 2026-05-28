<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaginaContenido extends Model
{
    protected $table = 'pagina_contenidos';

    protected $fillable = [
        'pagina',
        'clave',
        'titulo',
        'valor',
    ];

    /**
     * Helper to get page content value or return a default string if it doesn't exist yet.
     */
    public static function getValor($clave, $default = '')
    {
        $contenido = self::where('clave', $clave)->first();
        return $contenido ? $contenido->valor : $default;
    }
}
