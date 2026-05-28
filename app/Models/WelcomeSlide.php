<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WelcomeSlide extends Model
{
    protected $table = 'welcome_slides';

    protected $fillable = [
        'imagen',
        'titulo_blanco',
        'titulo_rojo',
        'orden',
    ];
}
