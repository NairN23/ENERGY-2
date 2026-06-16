<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('users')
            ->whereNull('telefono')
            ->orderBy('id')
            ->chunkById(200, function ($users): void {
                foreach ($users as $user) {
                    $telefono = DB::table('direcciones')
                        ->where('user_id', $user->id)
                        ->whereNotNull('cliente_telefono')
                        ->where('cliente_telefono', '!=', '')
                        ->orderByDesc('id')
                        ->value('cliente_telefono');

                    if ($telefono) {
                        DB::table('users')
                            ->where('id', $user->id)
                            ->update(['telefono' => $telefono]);
                    }
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op: no se revierte para no perder datos de teléfono.
    }
};
