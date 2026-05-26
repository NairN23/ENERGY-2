<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Carrito; // Asegurate de importar tu modelo de Carrito

class CarritoController extends Controller
{
    /**
     * Muestra la vista del carrito y pasa los datos de MariaDB
     */
    public function index()
    {
        $carritoFormateado = collect([]);

        // Comprobamos la autenticación de forma segura
        if (Auth::check()) {
            $user = Auth::user(); // Obtenemos la instancia directa del usuario logueado

            // Verificamos si existe el método de la relación para evitar excepciones
            if (method_exists($user, 'carritos')) {
                $itemsEnBaseDeDatos = $user->carritos()->with('producto')->get();

                // Formateamos los datos para la estructura exacta que usa localStorage (name y price)
                $carritoFormateado = $itemsEnBaseDeDatos->map(function ($item) {
                    return [
                        'id'    => $item->producto->id,
                        'name'  => $item->producto->nombre,
                        'price' => $item->producto->precio,
                    ];
                });
            } else {
                // Alternativa de respaldo directo por Query Builder si la relación no está declarada
                $itemsEnBaseDeDatos = Carrito::where('user_id', $user->id)->with('producto')->get();
                
                $carritoFormateado = $itemsEnBaseDeDatos->map(function ($item) {
                    return [
                        'id'    => $item->producto->id,
                        'name'  => $item->producto->nombre,
                        'price' => $item->producto->precio,
                    ];
                });
            }
        }

        // Pasamos la colección formateada como JSON a la vista del carrito
        return view('carrito', [
            'carritoBD' => $carritoFormateado->toJson()
        ]);
    }

    /**
     * Vacía por completo el carrito (En LocalStorage y en MariaDB)
     */
    public function vaciar()
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            if (method_exists($user, 'carritos')) {
                $user->carritos()->delete();
            } else {
                Carrito::where('user_id', $user->id)->delete();
            }
        }

        return back()->with('success', 'Carrito vaciado correctamente de ENERGY.');
    }

    public function agregar(Request $request, $id)
    {
        return back()->with('success', 'Producto agregado al carrito de ENERGY.');
    }

    public function eliminar($id)
    {
        return back()->with('success', 'Producto eliminado.');
    }

    public function confirmar()
    {
        return view('compra-confirmar'); 
    }

    public function guardarCompra(Request $request)
    {
        return redirect()->route('home')->with('success', '¡Compra guardada con éxito!');
    }
}