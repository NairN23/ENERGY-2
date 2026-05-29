<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('nombre');
                $table->string('slug')->unique();
                $table->timestamps();
            });
        }

        $now = now();

        DB::table('roles')->upsert([
            [
                'nombre' => 'Administrador',
                'slug' => 'admin',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nombre' => 'Cliente',
                'slug' => 'cliente',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ], ['slug'], ['nombre', 'updated_at']);

        if (! Schema::hasColumn('users', 'role_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('role_id')->nullable()->after('password')->constrained('roles');
            });
        }

        $roleIds = DB::table('roles')->pluck('id', 'slug');
        $clienteRoleId = $roleIds['cliente'] ?? null;

        if (Schema::hasColumn('users', 'role')) {
            DB::table('users')
                ->whereNull('role')
                ->orWhere('role', 'client')
                ->update(['role' => 'cliente']);

            foreach ($roleIds as $slug => $roleId) {
                DB::table('users')
                    ->where('role', $slug)
                    ->update(['role_id' => $roleId]);
            }
        }

        if ($clienteRoleId) {
            DB::table('users')
                ->whereNull('role_id')
                ->update(['role_id' => $clienteRoleId]);
        }

        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        if (! Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('cliente')->after('password');
            });
        }

        if (Schema::hasTable('roles') && Schema::hasColumn('users', 'role_id')) {
            $roleSlugs = DB::table('roles')->pluck('slug', 'id');

            foreach ($roleSlugs as $roleId => $slug) {
                DB::table('users')
                    ->where('role_id', $roleId)
                    ->update(['role' => $slug]);
            }
        }

        DB::table('users')
            ->whereNull('role')
            ->update(['role' => 'cliente']);

        if (Schema::hasColumn('users', 'role_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropConstrainedForeignId('role_id');
            });
        }

        Schema::dropIfExists('roles');
    }
};