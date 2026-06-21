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
     * Método auxiliar para obtener el valor del contenido de la página o devolver una cadena por defecto si no existe.
     */
    public static function getValor($clave, $default = '')
    {
        $contenido = self::where('clave', $clave)->first();
        return $contenido ? $contenido->valor : $default;
    }
}
