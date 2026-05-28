<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->boolean('es_combo')->default(false)->after('activo');
            $table->boolean('destacado')->default(false)->after('es_combo');
            $table->text('productos_combo')->nullable()->comment('JSON array de IDs de productos')->after('destacado');
        });
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn(['es_combo', 'destacado', 'productos_combo']);
        });
    }
};
