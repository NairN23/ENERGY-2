<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('cliente_nombre');
            $table->string('cliente_telefono', 30);
            $table->string('cliente_email')->nullable();
            $table->text('direccion_entrega')->nullable();
            $table->string('estado')->default('pendiente');
            $table->decimal('total', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};