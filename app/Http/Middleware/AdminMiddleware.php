<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Si está logueado y su rol es 'admin', lo deja pasar dinámicamente
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $next($request);
        }

        // Si es un cliente común, lo rebota al inicio con un cartel de error
        return redirect('/')->with('error', 'Acceso denegado. Zona exclusiva para administradores.');
    }
}