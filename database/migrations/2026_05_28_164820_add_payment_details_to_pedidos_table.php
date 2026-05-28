<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->string('metodo_pago')->nullable()->after('estado');
            $table->string('comprobante')->nullable()->after('metodo_pago');
            $table->string('mp_payment_id')->nullable()->after('comprobante');
        });
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn(['metodo_pago', 'comprobante', 'mp_payment_id']);
        });
    }
};
