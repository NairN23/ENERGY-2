<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Carrito; // Asegurate de importar tu modelo de Carrito

class CarritoController extends Controller
{
    /**
     * Desactiva combos activos que tengan al menos un componente sin stock.
     */
    private function desactivarCombosConComponentesSinStock(): void
    {
        $combosActivos = \App\Models\Producto::where('es_combo', true)
            ->where('activo', true)
            ->get();

        foreach ($combosActivos as $combo) {
            $componentes = is_array($combo->productos_combo) ? $combo->productos_combo : [];

            if (empty($componentes)) {
                continue;
            }

            $hayComponenteSinStock = \App\Models\Producto::whereIn('id', $componentes)
                ->where('stock', '<=', 0)
                ->exists();

            if ($hayComponenteSinStock) {
                $combo->update(['activo' => false]);
            }
        }
    }

    /**
     * Reactiva combos inactivos cuando todos sus componentes tienen stock.
     */
    private function reactivarCombosConComponentesConStock(): void
    {
        $combosInactivos = \App\Models\Producto::where('es_combo', true)
            ->where('activo', false)
            ->get();

        foreach ($combosInactivos as $combo) {
            $componentes = is_array($combo->productos_combo) ? $combo->productos_combo : [];

            if (empty($componentes) || $combo->stock <= 0) {
                continue;
            }

            $faltantes = \App\Models\Producto::whereIn('id', $componentes)
                ->where('stock', '<=', 0)
                ->exists();

            if (! $faltantes) {
                $combo->update(['activo' => true]);
            }
        }
    }

    /**
     * Muestra la vista del carrito y pasa los datos de MariaDB
     */
    public function index()
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.index')->with('error', 'Los administradores no tienen un carrito de compras.');
        }

        $carritoFormateado = collect([]);

        // Comprobamos la autenticación de forma segura
        if (Auth::check()) {
            $user = Auth::user(); // Obtenemos la instancia directa del usuario logueado

            // Verificamos si existe el método de la relación para evitar excepciones
            if (method_exists($user, 'carritos')) {
                $itemsEnBaseDeDatos = $user->carritos()->with('producto')->get();

                // Formateamos los datos para la estructura exacta que usa localStorage (id, name, price, cantidad, stock)
                $carritoFormateado = $itemsEnBaseDeDatos->map(function ($item) {
                    if ($item->producto) {
                        return [
                            'id'    => $item->producto->id,
                            'name'  => $item->producto->nombre,
                            'price' => $item->producto->precio,
                            'cantidad' => $item->cantidad,
                            'stock' => $item->producto->stock,
                        ];
                    }
                    return null;
                })->filter()->values();
            } else {
                // Alternativa de respaldo directo por Query Builder si la relación no está declarada
                $itemsEnBaseDeDatos = Carrito::where('user_id', $user->id)->with('producto')->get();
                
                $carritoFormateado = $itemsEnBaseDeDatos->map(function ($item) {
                    if ($item->producto) {
                        return [
                            'id'    => $item->producto->id,
                            'name'  => $item->producto->nombre,
                            'price' => $item->producto->precio,
                            'cantidad' => $item->cantidad,
                            'stock' => $item->producto->stock,
                        ];
                    }
                    return null;
                })->filter()->values();
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
    public function vaciar(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            if (method_exists($user, 'carritos')) {
                $user->carritos()->delete();
            } else {
                Carrito::where('user_id', $user->id)->delete();
            }
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Carrito vaciado correctamente.']);
        }

        return back()->with('success', 'Carrito vaciado correctamente de ENERGY.');
    }

    public function agregar(Request $request, $id)
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return back()->with('error', 'Los administradores no pueden agregar productos al carrito.');
        }
        return back()->with('success', 'Producto agregado al carrito de ENERGY.');
    }

    public function eliminar($id)
    {
        if (Auth::check()) {
            $user = Auth::user();
            Carrito::where('user_id', $user->id)
                ->where('producto_id', $id)
                ->delete();
        }

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Producto eliminado.');
    }

    public function confirmar()
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.index')->with('error', 'Los administradores no pueden realizar compras.');
        }
        return view('compra-confirmar'); 
    }

    public function guardarCompra(Request $request)
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.index')->with('error', 'Los administradores no pueden realizar compras.');
        }

        // Reglas base
        $rules = [
            'cliente_nombre' => 'required|string|max:255',
            'cliente_telefono' => 'required|string|max:50',
            'cliente_email' => 'required|email|max:255',
            'direccion_entrega' => 'required|string',
            'metodo_pago' => 'required|in:transferencia,mercado_pago,whatsapp',
            'carrito_data' => 'required|json',
            'mp_payment_id' => 'nullable|string|max:100',
        ];

        // Solo validar comprobante PDF si el método es transferencia
        if ($request->metodo_pago === 'transferencia') {
            $rules['comprobante'] = 'nullable|file|mimes:pdf|max:4096';
        }

        $request->validate($rules);

        // Si no es transferencia, eliminar cualquier archivo de comprobante que se haya enviado
        if ($request->metodo_pago !== 'transferencia' && $request->hasFile('comprobante')) {
            $request->request->remove('comprobante');
        }

        $cartRaw = json_decode($request->carrito_data, true);
        if (empty($cartRaw)) {
            return back()->withErrors(['carrito' => 'El carrito está vacío.'])->withInput();
        }

        // Agrupación: Agrupar por producto_id para que productos duplicados sumen su cantidad
        $aggregatedCart = [];
        foreach ($cartRaw as $item) {
            $producto = null;
            if (isset($item['id'])) {
                $producto = \App\Models\Producto::find($item['id']);
            }
            if (!$producto) {
                $producto = \App\Models\Producto::where('nombre', $item['name'] ?? '')->first();
            }
            if ($producto) {
                $id = $producto->id;
                $cantidad = intval($item['cantidad'] ?? 1);
                if (isset($aggregatedCart[$id])) {
                    $aggregatedCart[$id]['cantidad'] += $cantidad;
                } else {
                    $aggregatedCart[$id] = [
                        'producto' => $producto,
                        'cantidad' => $cantidad,
                    ];
                }
            }
        }

        // Calcular el requerimiento total de stock para cada producto (incluyendo combos y componentes)
        $requiredStocks = [];
        foreach ($aggregatedCart as $id => $item) {
            $producto = $item['producto'];
            $cantidad = $item['cantidad'];

            // Sumamos al requerimiento del producto principal
            if (isset($requiredStocks[$producto->id])) {
                $requiredStocks[$producto->id] += $cantidad;
            } else {
                $requiredStocks[$producto->id] = $cantidad;
            }

            // Si es un combo, sumamos al requerimiento de sus componentes individuales
            if ($producto->es_combo && is_array($producto->productos_combo)) {
                foreach ($producto->productos_combo as $subId) {
                    if (isset($requiredStocks[$subId])) {
                        $requiredStocks[$subId] += $cantidad;
                    } else {
                        $requiredStocks[$subId] = $cantidad;
                    }
                }
            }
        }

        // Validar stock consolidado de todos los productos involucrados
        foreach ($requiredStocks as $prodId => $reqQty) {
            $p = \App\Models\Producto::find($prodId);
            if (!$p) {
                return back()->withErrors([
                    'carrito' => "El producto con ID {$prodId} no existe en el catálogo."
                ])->withInput();
            }
            if ($p->stock < $reqQty) {
                return back()->withErrors([
                    'carrito' => "No hay suficiente stock disponible para '{$p->nombre}' (Requerido: {$reqQty}, Disponible: {$p->stock})."
                ])->withInput();
            }
        }

        // Calcular el subtotal y el total con posible descuento por transferencia
        $subtotal = 0;
        foreach ($aggregatedCart as $id => $item) {
            $producto = $item['producto'];
            $cantidad = $item['cantidad'];
            $subtotal += $producto->precio * $cantidad;
        }

        $descuento = 0;
        if ($request->metodo_pago === 'transferencia') {
            $descuento = $subtotal * 0.10;
        }
        $total = $subtotal - $descuento;

        // Procesar el comprobante de transferencia si aplica y fue cargado
        $rutaComprobante = null;
        if ($request->metodo_pago === 'transferencia' && $request->hasFile('comprobante')) {
            $archivo = $request->file('comprobante');
            $nombreArchivo = 'comprobante_' . time() . '_' . uniqid() . '.' . $archivo->getClientOriginalExtension();
            
            if (!file_exists(public_path('uploads/comprobantes'))) {
                mkdir(public_path('uploads/comprobantes'), 0777, true);
            }
            
            $archivo->move(public_path('uploads/comprobantes'), $nombreArchivo);
            $rutaComprobante = '/uploads/comprobantes/' . $nombreArchivo;
        }

        // Guardar la dirección en la tabla de direcciones para el usuario si es la primera vez o es nueva
        if (Auth::check()) {
            $user = Auth::user();
            $direccionExistente = \App\Models\Direccion::where('user_id', $user->id)
                ->where('direccion_entrega', $request->direccion_entrega)
                ->first();
                
            if (!$direccionExistente) {
                \App\Models\Direccion::create([
                    'user_id' => $user->id,
                    'cliente_nombre' => $request->cliente_nombre,
                    'cliente_telefono' => $request->cliente_telefono,
                    'cliente_email' => $request->cliente_email,
                    'direccion_entrega' => $request->direccion_entrega,
                ]);
            } else {
                // Si la dirección existe pero no tiene teléfono (ej. creada al registrarse), lo actualizamos
                if (empty($direccionExistente->cliente_telefono) || $direccionExistente->cliente_telefono == '') {
                    $direccionExistente->update([
                        'cliente_telefono' => $request->cliente_telefono
                    ]);
                }
            }
        }

        // Crear el registro de Pedido
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

        // Crear los registros de PedidoDetalle
        foreach ($aggregatedCart as $id => $item) {
            $producto = $item['producto'];
            $cantidad = $item['cantidad'];

            \App\Models\PedidoDetalle::create([
                'pedido_id' => $pedido->id,
                'producto_id' => $producto->id,
                'cantidad' => $cantidad,
                'precio_unitario' => $producto->precio,
                'subtotal' => $producto->precio * $cantidad,
            ]);
        }

        // Decrementar el stock consolidado de los productos
        foreach ($requiredStocks as $prodId => $reqQty) {
            $p = \App\Models\Producto::find($prodId);
            if ($p) {
                $p->decrement('stock', $reqQty);
                $p->refresh();

                if ($p->stock <= 0 && $p->activo) {
                    $p->update(['activo' => false]);
                }
            }
        }

        // Si un componente quedó sin stock, su combo debe quedar inactivo automáticamente.
        $this->desactivarCombosConComponentesSinStock();

        // Vaciar el carrito en MariaDB si el usuario está autenticado
        if (Auth::check()) {
            $user = Auth::user();
            if (method_exists($user, 'carritos')) {
                $user->carritos()->delete();
            } else {
                \App\Models\Carrito::where('user_id', $user->id)->delete();
            }
        }

        return redirect()->route('mis-compras')->with([
            'success' => '¡Pedido registrado con éxito en ENERGY! Tu compra ha sido procesada.',
            'clear_cart' => true
        ]);
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
            'cantidad' => 'nullable|integer|min:1',
        ]);

        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Los administradores no pueden agregar productos al carrito.'
                ], 403);
            }
            $user = Auth::user();
            $cantidad = intval($request->input('cantidad', 1));
            
            $item = \App\Models\Carrito::where('user_id', $user->id)
                ->where('producto_id', $request->producto_id)
                ->first();

            if ($item) {
                $item->increment('cantidad', $cantidad);
            } else {
                \App\Models\Carrito::create([
                    'user_id' => $user->id,
                    'producto_id' => $request->producto_id,
                    'cantidad' => $cantidad,
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

    /**
     * AJAX: Actualiza la cantidad de un producto en el carrito en tiempo real
     */
    public function actualizarCantidadAjax(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Los administradores no pueden modificar el carrito.'
                ], 403);
            }
            $user = Auth::user();
            $producto = \App\Models\Producto::find($request->producto_id);

            // Validar stock
            if ($request->cantidad > $producto->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay suficiente stock disponible. (Máximo: ' . $producto->stock . ')'
                ], 422);
            }

            $item = \App\Models\Carrito::where('user_id', $user->id)
                ->where('producto_id', $request->producto_id)
                ->first();

            if ($item) {
                $item->update(['cantidad' => $request->cantidad]);
                return response()->json([
                    'success' => true,
                    'message' => 'Cantidad actualizada en MariaDB.'
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Usuario no autenticado.'
        ], 401);
    }

    /**
     * AJAX: Elimina una dirección guardada
     */
    public function eliminarDireccion($id)
    {
        if (Auth::check()) {
            $direccion = Auth::user()->direcciones()->find($id);
            if ($direccion) {
                $direccion->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Dirección eliminada correctamente.'
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'No autorizado.'
        ], 403);
    }

    /**
     * Permite al cliente cancelar un pedido pendiente y devuelve el stock
     */
    public function cancelarPedido($id)
    {
        $pedido = \App\Models\Pedido::where('user_id', auth()->id())
            ->where('id', $id)
            ->where('estado', 'pendiente')
            ->firstOrFail();

        // Restauramos el stock
        foreach ($pedido->detalles as $detalle) {
            $producto = $detalle->producto;
            if ($producto) {
                // Devolvemos el stock del producto principal
                $producto->increment('stock', $detalle->cantidad);
                $producto->refresh();
                if ($producto->stock > 0 && ! $producto->activo) {
                    $producto->update(['activo' => true]);
                }

                // Si es un combo, devolvemos el stock de sus componentes
                if ($producto->es_combo && is_array($producto->productos_combo)) {
                    foreach ($producto->productos_combo as $subId) {
                        $subProd = \App\Models\Producto::find($subId);
                        if ($subProd) {
                            $subProd->increment('stock', $detalle->cantidad);
                            $subProd->refresh();
                            if ($subProd->stock > 0 && ! $subProd->activo) {
                                $subProd->update(['activo' => true]);
                            }
                        }
                    }
                }
            }
        }

        // Tras restaurar stock, intentamos reactivar combos que vuelvan a tener todos sus componentes disponibles.
        $this->reactivarCombosConComponentesConStock();

        $pedido->update(['estado' => 'cancelado']);

        return redirect()->back()->with('success', 'Pedido #' . $id . ' cancelado correctamente. El stock ha sido restablecido.');
    }
}