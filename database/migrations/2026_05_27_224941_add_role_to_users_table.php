<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Aquí definimos qué columna se agrega a la base de datos.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // AGREGADO: Crea la columna 'role' tipo string, por defecto es 'client'
            // 'after' hace que en la tabla de MariaDB quede ordenada justo después de la contraseña
            $table->string('role')->default('client')->after('password');
        });
    }

    /**
     * Reverse the migrations.
     * Aquí definimos qué pasa si tiramos marcha atrás la migración (rollback).
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // AGREGADO: Si se revierte la migración, borra la columna de raíz
            $table->dropColumn('role');
        });
    }
};