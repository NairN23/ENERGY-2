<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // Procesa el formulario de registro y lo guarda en MariaDB
    public function register(Request $request)
    {
        // 1. Validamos que todos los campos cumplan con lo necesario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 2. Creamos el usuario cliente en MariaDB
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encriptamos la clave por seguridad
            'role' => 'client',
        ]);

        // MODIFICADO: En vez de loguearlo automáticamente acá, lo redireccionamos al Login con un mensaje de éxito
        return redirect()->route('login')->with('success', '¡Registro completado con éxito! Iniciá sesión con tus datos.');
    }
}