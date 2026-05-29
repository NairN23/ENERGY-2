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
        $request->validate([
            'cliente_nombre' => 'required|string|max:255',
            'cliente_telefono' => 'required|string|max:50',
            'cliente_email' => 'required|email|max:255',
            'direccion_entrega' => 'required|string',
            'metodo_pago' => 'required|in:transferencia,mercado_pago',
            'comprobante' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:4096',
            'carrito_data' => 'required|json',
            'mp_payment_id' => 'nullable|string|max:100',
        ]);

        $cart = json_decode($request->carrito_data, true);
        if (empty($cart)) {
            return back()->withErrors(['carrito' => 'El carrito está vacío.'])->withInput();
        }

        // 1. Calculamos el total seguro a nivel servidor
        $subtotal = 0;
        $detallesAGuardar = [];

        foreach ($cart as $item) {
            $producto = \App\Models\Producto::where('nombre', $item['name'])->first();
            if ($producto) {
                $subtotal += $producto->precio;
                $detallesAGuardar[] = [
                    'producto' => $producto,
                    'precio_unitario' => $producto->precio,
                ];
            }
        }

        if (empty($detallesAGuardar)) {
            return back()->withErrors(['carrito' => 'Los productos en tu carrito ya no están disponibles.'])->withInput();
        }

        $descuento = 0;
        if ($request->metodo_pago === 'transferencia') {
            $descuento = $subtotal * 0.10;
        }
        $total = $subtotal - $descuento;

        // 2. Procesamos el comprobante de transferencia si aplica
        $rutaComprobante = null;
        if ($request->metodo_pago === 'transferencia' && $request->hasFile('comprobante')) {
            $archivo = $request->file('comprobante');
            $nombreArchivo = 'comprobante_' . time() . '_' . uniqid() . '.' . $archivo->getClientOriginalExtension();
            
            // Creamos el directorio si no existe
            if (!file_exists(public_path('uploads/comprobantes'))) {
                mkdir(public_path('uploads/comprobantes'), 0777, true);
            }
            
            $archivo->move(public_path('uploads/comprobantes'), $nombreArchivo);
            $rutaComprobante = '/uploads/comprobantes/' . $nombreArchivo;
        }

        // 3. Creamos el registro del Pedido
        $pedido = \App\Models\Pedido::create([
            'user_id' => auth()->id(),
            'cliente_nombre' => $request->cliente_nombre,
            'cliente_telefono' => $request->cliente_telefono,
            'cliente_email' => $request->cliente_email,
            'direccion_entrega' => $request->direccion_entrega,
            'estado' => $request->metodo_pago === 'mercado_pago' ? 'confirmado' : 'pendiente',
            'total' => $total,
            'metodo_pago' => $request->metodo_pago,
            'comprobante' => $rutaComprobante,
            'mp_payment_id' => $request->mp_payment_id,
        ]);

        // 4. Creamos los detalles del Pedido y restamos Stock
        foreach ($detallesAGuardar as $det) {
            $producto = $det['producto'];
            
            \App\Models\PedidoDetalle::create([
                'pedido_id' => $pedido->id,
                'producto_id' => $producto->id,
                'cantidad' => 1,
                'precio_unitario' => $det['precio_unitario'],
                'subtotal' => $det['precio_unitario'], // subtotal para 1 unidad
            ]);

            // Restamos 1 al stock disponible del producto de forma segura
            if ($producto->stock > 0) {
                $producto->decrement('stock', 1);
            }
        }

        // 5. Vaciamos el carrito de MariaDB si el usuario está autenticado
        if (Auth::check()) {
            $user = Auth::user();
            if (method_exists($user, 'carritos')) {
                $user->carritos()->delete();
            } else {
                \App\Models\Carrito::where('user_id', $user->id)->delete();
            }
        }

        return redirect()->route('mis-compras')->with('success', '¡Pedido registrado con éxito en ENERGY! Tu compra ha sido procesada.');
    }

    /**
     * Muestra el historial de compras realizadas por el cliente autenticado
     */
    public function misCompras()
    {
        // El administrador no debe ver "mis compras", redirige al panel administrativo
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.index')->with('error', 'Los administradores no acceden a la sección de compras de clientes.');
        }

        $pedidos = \App\Models\Pedido::where('user_id', auth()->id())
            ->with(['detalles.producto'])
            ->latest()
            ->get();

        return view('mis-compras', compact('pedidos'));
    }

    /**
     * Persiste de forma inmediata un producto en la base de datos MariaDB (llamado AJAX)
     */
    public function agregarAjax(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
        ]);

        if (Auth::check()) {
            $user = Auth::user();
            
            $item = \App\Models\Carrito::where('user_id', $user->id)
                ->where('producto_id', $request->producto_id)
                ->first();

            if ($item) {
                $item->increment('cantidad', 1);
            } else {
                \App\Models\Carrito::create([
                    'user_id' => $user->id,
                    'producto_id' => $request->producto_id,
                    'cantidad' => 1,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Producto sincronizado con éxito en tu carrito de ENERGY.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Usuario no autenticado.'
        ], 401);
    }
}