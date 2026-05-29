<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    // Procesa el formulario de registro y lo guarda en MariaDB
    public function register(Request $request)
    {
        // 1. Validamos que todos los campos cumplan con lo necesario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->where(fn ($query) => $query->whereNull('deleted_at')),
            ],
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 2. Creamos el usuario cliente en MariaDB
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => User::ROLE_CLIENTE,
        ]);

        // MODIFICADO: En vez de loguearlo automáticamente acá, lo redireccionamos al Login con un mensaje de éxito
        return redirect()->route('login')->with('success', '¡Registro completado con éxito! Iniciá sesión con tus datos.');
    }
}