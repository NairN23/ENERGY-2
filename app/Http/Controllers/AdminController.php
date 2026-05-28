<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\User;
use App\Models\Mensaje;
use App\Models\Pedido;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    /**
     * Carga la pantalla principal del Dashboard con todas las tablas unificadas
     */
    public function dashboard()
    {
        // 1. Traemos los suplementos con su categoría de MariaDB
        $productos = Producto::with('categoria')->get();
        $categorias = Categoria::all();

        // 2. Traemos las compras/pedidos
        $pedidos = Pedido::with('user')->latest()->get();

        // 3. Traemos todos los usuarios registrados (menos vos que estás logueada administrando)
        $usuarios = User::where('id', '!=', auth()->id())->latest()->get();

        // 4. Traemos los mensajes de contacto
        $mensajes = Mensaje::latest()->get();

        // 5. Traemos los contenidos de las páginas
        $paginaContenidos = \App\Models\PaginaContenido::all()->groupBy('pagina');

        // Estadísticas
        $totales = [
            'productos' => Producto::count(),
            'categorias' => Categoria::count(),
            'usuarios' => User::count(),
            'pedidos' => Pedido::count(),
            'mensajes_sin_leer' => Mensaje::where('leido', false)->count(),
        ];

        $welcomeSlides = \App\Models\WelcomeSlide::orderBy('orden', 'asc')->get();

        // Enviamos todos los datos juntos en un combo a la vista del panel
        return view('admin.dashboard', compact('productos', 'categorias', 'pedidos', 'usuarios', 'mensajes', 'totales', 'paginaContenidos', 'welcomeSlides'));
    }

    /**
     * Marcar mensaje como leído
     */
    public function marcarMensajeLeido($id)
    {
        $mensaje = Mensaje::findOrFail($id);
        $mensaje->update(['leido' => true]);

        return redirect()->back()->with('success', 'Mensaje marcado como leído.');
    }

    /**
     * Eliminar un mensaje
     */
    public function deleteMensaje($id)
    {
        $mensaje = Mensaje::findOrFail($id);
        $mensaje->delete();

        return redirect()->back()->with('success', 'Mensaje eliminado correctamente.');
    }

    /**
     * Permite al admin actualizar textos de las páginas informativas en caliente
     */
    public function editarPagina(Request $request)
    {
        $request->validate([
            'pagina' => 'required|string',
        ]);

        foreach ($request->except(['_token', 'pagina']) as $clave => $valor) {
            \App\Models\PaginaContenido::updateOrCreate(
                ['clave' => $clave],
                [
                    'pagina' => $request->pagina,
                    'titulo' => ucwords(str_replace('_', ' ', $clave)),
                    'valor' => $valor ?? ''
                ]
            );
        }

        return redirect()->back()->with('success', '¡El contenido de la página ' . strtoupper($request->pagina) . ' se actualizó correctamente!');
    }

    /**
     * Permite al admin crear nuevos usuarios cliente desde el panel.
     */
    public function storeUsuario(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'client',
        ]);

        return redirect()->route('admin.index')->with('success', 'Cliente creado correctamente desde el panel.');
    }

    /**
     * Ver detalles de un pedido
     */
    public function verPedido($id)
    {
        $pedido = Pedido::with(['user', 'detalles.producto'])->findOrFail($id);
        return view('admin.pedido.show', compact('pedido'));
    }

    /**
     * Actualizar estado de un pedido
     */
    public function actualizarEstadoPedido(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|string|in:pendiente,confirmado,enviado,entregado,cancelado',
        ]);

        $pedido = Pedido::findOrFail($id);
        $pedido->update(['estado' => $request->estado]);

        return redirect()->back()->with('success', 'Estado del pedido actualizado correctamente.');
    }

    /**
     * Guarda o edita un slide del carrusel de inicio
     */
    public function storeSlide(Request $request)
    {
        $request->validate([
            'imagen_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'imagen_url' => 'nullable|string|max:500',
            'titulo_blanco' => 'required|string|max:255',
            'titulo_rojo' => 'required|string|max:255',
            'orden' => 'required|integer',
        ]);

        $rutaImagen = null;

        if ($request->hasFile('imagen_file')) {
            $archivo = $request->file('imagen_file');
            $nombreArchivo = 'slide_' . time() . '_' . uniqid() . '.' . $archivo->getClientOriginalExtension();
            
            if (!file_exists(public_path('uploads/carousel'))) {
                mkdir(public_path('uploads/carousel'), 0777, true);
            }
            
            $archivo->move(public_path('uploads/carousel'), $nombreArchivo);
            $rutaImagen = '/uploads/carousel/' . $nombreArchivo;
        } elseif ($request->imagen_url) {
            $rutaImagen = $request->imagen_url;
        } else {
            return redirect()->back()->withErrors(['imagen' => 'Debes seleccionar una imagen para subir o ingresar una URL de imagen.'])->withInput();
        }

        \App\Models\WelcomeSlide::create([
            'imagen' => $rutaImagen,
            'titulo_blanco' => $request->titulo_blanco,
            'titulo_rojo' => $request->titulo_rojo,
            'orden' => $request->orden,
        ]);

        return redirect()->back()->with('success', '¡Slide agregado correctamente al carrusel!');
    }

    /**
     * Elimina un slide del carrusel
     */
    public function destroySlide($id)
    {
        $slide = \App\Models\WelcomeSlide::findOrFail($id);
        
        if (strpos($slide->imagen, '/uploads/carousel/') === 0) {
            $filePath = public_path($slide->imagen);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $slide->delete();

        return redirect()->back()->with('success', '¡Slide eliminado correctamente del carrusel!');
    }

    /**
     * Sube y aplica un nuevo logo para la tienda
     */
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo_file' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);

        if ($request->hasFile('logo_file')) {
            $logo = $request->file('logo_file');
            
            // Creamos el directorio /images/ si no existe
            $destinationPath = public_path('images');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Para evitar problemas de caché o formato, guardamos como logo.png reemplazando el anterior
            $logoName = 'logo.png';
            $logo->move($destinationPath, $logoName);

            return redirect()->back()->with('success', '¡Logo de la marca actualizado con éxito!');
        }

        return redirect()->back()->withErrors(['logo_file' => 'Error al subir el archivo de logo.']);
    }

    /**
     * Elimina el logo personalizado de la tienda
     */
    public function deleteLogo()
    {
        $logoPath = public_path('images/logo.png');
        if (file_exists($logoPath)) {
            unlink($logoPath);
            return redirect()->back()->with('success', 'Logo personalizado eliminado. Restaurado el logo de texto original.');
        }

        return redirect()->back()->with('success', 'El logo ya está en su modo por defecto.');
    }
}