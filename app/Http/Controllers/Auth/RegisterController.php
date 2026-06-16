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
            'telefono' => 'required|string|regex:/^[0-9]+$/|min:8|max:15',
            'direccion' => 'required|string|max:255',
            'departamento' => 'required|string|regex:/^[\pL\s]+$/u|max:100',
            'provincia' => 'required|string|max:100',
            'cp' => 'required|string|regex:/^[0-9]+$/|max:10',
        ], [
            'email.unique' => 'Ese correo ya está registrado por un usuario.',
            'telefono.regex' => 'El teléfono solo puede contener números.',
            'departamento.regex' => 'El departamento solo puede contener letras.',
            'cp.regex' => 'El código postal solo puede contener números.',
        ]);

        // 2. Creamos el usuario cliente en MariaDB
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'password' => $request->password,
            'role' => User::ROLE_CLIENTE,
        ]);

        // 3. Guardamos la dirección del registro en la tabla de direcciones
        $direccionCompleta = $request->direccion;
        if ($request->departamento) {
            $direccionCompleta .= ', ' . $request->departamento;
        }
        if ($request->provincia) {
            $direccionCompleta .= ', ' . $request->provincia;
        }
        if ($request->cp) {
            $direccionCompleta .= ' (CP: ' . $request->cp . ')';
        }

        \App\Models\Direccion::create([
            'user_id' => $user->id,
            'cliente_nombre' => $user->name,
            'cliente_telefono' => $request->telefono,
            'cliente_email' => $user->email,
            'direccion_entrega' => $direccionCompleta,
        ]);

        // MODIFICADO: En vez de loguearlo automáticamente acá, lo redireccionamos al Login con un mensaje de éxito
        return redirect()->route('login')->with('success', '¡Registro completado con éxito! Iniciá sesión con tus datos.');
    }

    // Verifica si un email ya existe en la base de datos (para validación en tiempo real)
    public function verificarEmail(Request $request)
    {
        $email = $request->input('email');

        // Buscar el email en usuarios no eliminados
        $existe = User::where('email', $email)
            ->whereNull('deleted_at')
            ->exists();

        return response()->json([
            'existe' => $existe,
            'mensaje' => $existe ? 'Este correo ya está registrado por otro usuario.' : ''
        ]);
    }
}