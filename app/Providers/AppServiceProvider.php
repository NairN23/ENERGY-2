<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Si las tablas necesarias existen, garantizamos los roles base y un admin activo mínimo.
        if (Schema::hasTable('users') && Schema::hasTable('roles') && Schema::hasColumn('users', 'deleted_at') && Schema::hasColumn('users', 'role_id')) {
            Role::ensureDefaults();

            $adminRoleId = Role::idForSlug(User::ROLE_ADMIN);

            if ($adminRoleId && ! User::where('role_id', $adminRoleId)->exists()) {
                User::firstOrCreate(
                    ['email' => env('ADMIN_EMAIL', 'admin@energy.test')],
                    [
                        'name' => env('ADMIN_NAME', 'ENERGY Admin'),
                        'password' => Hash::make(env('ADMIN_PASSWORD', 'Admin1234')),
                        'role_id' => $adminRoleId,
                    ]
                );
            }
        }
    }
}
