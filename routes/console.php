<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Mostrar una frase inspiradora');

Artisan::command('users:fill-missing-phone {phone=0000000000}', function (string $phone) {
    if (! preg_match('/^[0-9]{8,15}$/', $phone)) {
        $this->error('El teléfono debe tener entre 8 y 15 dígitos numéricos.');
        return self::FAILURE;
    }

    $updated = DB::table('users')
        ->whereNull('telefono')
        ->orWhere('telefono', '')
        ->update(['telefono' => $phone]);

    $this->info("Usuarios actualizados: {$updated}");

    return self::SUCCESS;
})->purpose('Completa usuarios sin teléfono con un valor por defecto.');
