<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Carrito;
use App\Models\Producto;

class LoginController extends Controller
{
    // Muestra tu vista de login hecha con Bootstrap
    public function showLoginForm()
    {
        return view('login'); 
    }

    // Procesa los datos contra la base de datos MariaDB
    public function login(Request $request)
    {
        // Validaciones básicas del lado del servidor
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'El email es obligatorio para ingresar.',
            'email.email' => 'El formato del email no es válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        $remember = $request->has('remember');

        // Intento de inicio de sesión real
        if (Auth::attempt($credentials, $remember)) {
            // Si es correcto, regenera la sesión por seguridad
            $request->session()->regenerate();
            
            // MODIFICADO: Redirecciona directo a la pestaña principal de ENERGY
            return redirect('/');
        }

        // Si los datos no coinciden en la BD, regresa con el error para Bootstrap
        return back()->withErrors([
            'auth_failed' => 'Las credenciales no coinciden con nuestro sistema de ENERGY.',
        ])->withInput($request->only('email'));
    }

    // Cierra la sesión de ENERGY, invalida el token y destruye cookies residuales
    public function logout(Request $request)
    {
        // PERSISTENCIA: Si venían suplementos desde el localStorage de la Navbar
        if ($request->has('carrito_data') && Auth::check()) {
            $user = Auth::user();
            
            // CORREGIDO: Decodificamos el JSON directamente a un array nativo de PHP
            $productosArray = json_decode($request->input('carrito_data'), true);

            if (is_array($productosArray)) {
                // Limpiamos los registros previos en MariaDB para evitar duplicados del mismo usuario
                if (method_exists($user, 'carritos')) {
                    $user->carritos()->delete();
                } else {
                    Carrito::where('user_id', $user->id)->delete();
                }

                // Agrupamos por producto_id para evitar duplicados y consolidar cantidades en MariaDB
                $aggregatedItems = [];
                foreach ($productosArray as $item) {
                    $producto = null;
                    if (isset($item['id'])) {
                        $producto = Producto::find($item['id']);
                    }
                    if (!$producto) {
                        $producto = Producto::where('nombre', $item['name'] ?? '')->first();
                    }

                    if ($producto) {
                        $id = $producto->id;
                        $cantidad = intval($item['cantidad'] ?? 1);
                        if (isset($aggregatedItems[$id])) {
                            $aggregatedItems[$id]['cantidad'] += $cantidad;
                        } else {
                            $aggregatedItems[$id] = [
                                'producto_id' => $id,
                                'cantidad'    => $cantidad,
                            ];
                        }
                    }
                }

                // Barremos cada ítem unificado para registrarlo en la tabla
                foreach ($aggregatedItems as $aggItem) {
                    Carrito::create([
                        'user_id'     => $user->id,
                        'producto_id' => $aggItem['producto_id'],
                        'cantidad'    => $aggItem['cantidad'],
                    ]);
                }
            }
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // MODIFICADO: Nos aseguramos de que al salir también vaya derecho a la principal
        return redirect('/');
    }
}