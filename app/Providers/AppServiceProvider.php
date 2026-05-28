<?php

namespace App\Providers;

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
        // Si la tabla 'users' y la columna 'deleted_at' existen, creamos un admin si hace falta.
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'deleted_at')) {
            if (! User::where('role', 'admin')->exists()) {
                User::firstOrCreate(
                    ['email' => env('ADMIN_EMAIL', 'admin@energy.test')],
                    [
                        'name' => env('ADMIN_NAME', 'ENERGY Admin'),
                        'password' => Hash::make(env('ADMIN_PASSWORD', 'Admin1234')),
                        'role' => 'admin',
                    ]
                );
            }
        }
    }
}
