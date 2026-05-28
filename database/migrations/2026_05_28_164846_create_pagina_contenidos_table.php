<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagina_contenidos', function (Blueprint $table) {
            $table->id();
            $table->string('pagina'); // e.g. 'quienes_somos', 'comercializacion', 'welcome', 'contacto'
            $table->string('clave')->unique(); // e.g. 'quienes_somos_principal_titulo'
            $table->string('titulo'); // Human-readable description (e.g. 'Título Principal')
            $table->text('valor'); // The actual text content
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagina_contenidos');
    }
};
