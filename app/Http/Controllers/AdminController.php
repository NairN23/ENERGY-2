<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\User;
use App\Models\Role;
use App\Models\Mensaje;
use App\Models\Pedido;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Carga la pantalla principal del Dashboard con todas las tablas unificadas
     */
    public function dashboard(Request $request)
    {
        $roles = Role::options();
        $roleIds = Role::slugIdMap();
        $roleFilter = $request->string('rol', 'todos')->toString();
        $filtrosPermitidos = array_merge(['todos'], array_keys($roles));

        if (! in_array($roleFilter, $filtrosPermitidos, true)) {
            $roleFilter = 'todos';
        }

        // 1. Traemos los suplementos con su categoría de MariaDB
        $productos = Producto::with('categoria')->get();
        $categorias = Categoria::all();

        // 2. Traemos las compras/pedidos
        $pedidos = Pedido::with('user')->latest()->get();

        // 3. Traemos los usuarios activos y opcionalmente filtrados por rol.
        $usuariosQuery = User::query()->with('roleRelation')->latest();

        if ($roleFilter !== 'todos') {
            $roleId = $roleIds[$roleFilter] ?? null;

            if ($roleId) {
                $usuariosQuery->where('role_id', $roleId);
            } else {
                $usuariosQuery->whereRaw('1 = 0');
            }
        }

        $usuarios = $usuariosQuery->get();

        // 4. Traemos los mensajes de contacto
        $mensajes = Mensaje::latest()->get();

        // 5. Traemos los contenidos de las páginas
        $paginaContenidos = \App\Models\PaginaContenido::all()->groupBy('pagina');

        // Estadísticas
        $totales = [
            'productos' => Producto::count(),
            'categorias' => Categoria::count(),
            'usuarios' => User::count(),
            'usuarios_admin' => isset($roleIds[User::ROLE_ADMIN]) ? User::where('role_id', $roleIds[User::ROLE_ADMIN])->count() : 0,
            'usuarios_cliente' => isset($roleIds[User::ROLE_CLIENTE]) ? User::where('role_id', $roleIds[User::ROLE_CLIENTE])->count() : 0,
            'pedidos' => Pedido::count(),
            'mensajes_sin_leer' => Mensaje::where('leido', false)->count(),
        ];

        $welcomeSlides = \App\Models\WelcomeSlide::orderBy('orden', 'asc')->get();
        $activeTab = $this->resolveAdminTab($request->query('tab'));

        // Enviamos todos los datos juntos en un combo a la vista del panel
        return view('admin.dashboard', compact('productos', 'categorias', 'pedidos', 'usuarios', 'mensajes', 'totales', 'paginaContenidos', 'welcomeSlides', 'roles', 'roleFilter', 'activeTab'));
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
     * Permite al admin actualizar textos de las páginas informativas en caliente
     */
    public function editarPagina(Request $request)
    {
        $request->validate([
            'pagina' => 'required|string',
        ]);

        foreach ($request->except(['_token', 'pagina']) as $clave => $valor) {
            $request->validate([
                $clave => 'nullable|string|max:1000'
            ]);
        }

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
     * Permite al admin crear nuevos usuarios desde el panel.
     */
    public function storeUsuario(Request $request)
    {
        $validated = $this->validateUsuario($request);

        User::create($this->buildUsuarioPayload($validated));

        return redirect()->route('admin.index', $this->dashboardRedirectParams($request))
            ->with('success', 'Usuario creado correctamente desde el panel.');
    }

    /**
     * Actualiza los datos básicos o la contraseña de un usuario.
     */
    public function updateUsuario(Request $request, User $usuario)
    {
        $validated = $this->validateUsuario($request, $usuario);

        if ($usuario->is(auth()->user()) && $validated['role'] !== User::ROLE_ADMIN) {
            return redirect()->route('admin.index', $this->dashboardRedirectParams($request))
                ->withErrors(['role' => 'No podés quitarte el rol de administrador desde esta pantalla.']);
        }

        if ($this->wouldRemoveLastAdmin($usuario, $validated['role'])) {
            return redirect()->route('admin.index', $this->dashboardRedirectParams($request))
                ->withErrors(['role' => 'Debe existir al menos un administrador activo en el sistema.']);
        }

        $usuario->update($this->buildUsuarioPayload($validated));

        return redirect()->route('admin.index', $this->dashboardRedirectParams($request))
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Genera una contraseña temporal para un usuario concreto.
     */
    public function resetPasswordUsuario(Request $request, User $usuario)
    {
        $passwordTemporal = Str::random(12);

        $usuario->update([
            'password' => $passwordTemporal,
        ]);

        return redirect()->route('admin.index', $this->dashboardRedirectParams($request))
            ->with('success', 'Contraseña reseteada correctamente.')
            ->with('generated_password', [
                'name' => $usuario->name,
                'email' => $usuario->email,
                'password' => $passwordTemporal,
            ]);
    }

    /**
     * Elimina usuarios por soft delete desde el panel.
     */
    public function destroyUsuario(Request $request, User $usuario)
    {
        if ($usuario->is(auth()->user())) {
            return redirect()->route('admin.index', $this->dashboardRedirectParams($request))
                ->withErrors(['delete' => 'No podés eliminar tu propio usuario desde el panel.']);
        }

        if ($this->wouldRemoveLastAdmin($usuario)) {
            return redirect()->route('admin.index', $this->dashboardRedirectParams($request))
                ->withErrors(['delete' => 'Debe existir al menos un administrador activo en el sistema.']);
        }

        DB::transaction(function () use ($usuario) {
            $usuario->preserveEmailForSoftDelete();
            $usuario->delete();
        });

        return redirect()->route('admin.index', $this->dashboardRedirectParams($request))
            ->with('success', 'Usuario eliminado correctamente.');
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
     * Incrementar o decrementar stock de un producto directamente
     */
    public function updateStock(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $action = $request->input('action');
        if ($action === 'increment') {
            $producto->increment('stock', 1);
        } elseif ($action === 'decrement' && $producto->stock > 0) {
            $producto->decrement('stock', 1);
        }
        return redirect()->back()->with('success', "Stock de '{$producto->nombre}' actualizado con éxito.");
    }

    /**
     * Guarda o edita un slide del carrusel de inicio
     */
    public function storeSlide(Request $request)
    {
        $request->validate([
            'imagen_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'imagen_url' => 'nullable|url|max:500',
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

    private function validateUsuario(Request $request, ?User $usuario = null): array
    {
        $passwordRules = $usuario
            ? ['nullable', 'string', 'min:8', 'confirmed']
            : ['required', 'string', 'min:8', 'confirmed'];

        return $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => [
                'required',
                'string',
                'email:rfc,dns',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($usuario?->id)
                    ->where(fn ($query) => $query->whereNull('deleted_at')),
            ],
            'role' => ['required', Rule::in(array_keys(Role::options()))],
            'password' => $passwordRules,
        ]);
    }

    private function buildUsuarioPayload(array $validated): array
    {
        $payload = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        if (! empty($validated['password'])) {
            $payload['password'] = $validated['password'];
        }

        return $payload;
    }

    private function dashboardRedirectParams(Request $request): array
    {
        $params = ['tab' => 'usuarios'];
        $roleFilter = $request->input('role_filter', $request->query('rol', 'todos'));
        $filtrosPermitidos = array_merge(['todos'], array_keys(Role::options()));

        if (in_array($roleFilter, $filtrosPermitidos, true)) {
            $params['rol'] = $roleFilter;
        }

        return $params;
    }

    private function wouldRemoveLastAdmin(User $usuario, ?string $newRole = null): bool
    {
        if (! $usuario->isAdmin()) {
            return false;
        }

        if ($newRole === User::ROLE_ADMIN) {
            return false;
        }

        $adminRoleId = Role::idForSlug(User::ROLE_ADMIN);

        if (! $adminRoleId) {
            return false;
        }

        return User::where('role_id', $adminRoleId)->count() <= 1;
    }

    private function resolveAdminTab(?string $tab): string
    {
        $tabs = ['productos', 'compras', 'mensajes', 'usuarios', 'paginas', 'carrusel'];

        return in_array($tab, $tabs, true) ? $tab : 'productos';
    }
}