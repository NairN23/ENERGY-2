<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CarritoController; 
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MensajeController;

/*
|--------------------------------------------------------------------------
| Rutas Web - Proyecto ENERGY
|--------------------------------------------------------------------------
| Aquí es donde registrás las rutas de tu aplicación. Estas rutas 
| son cargadas por el RouteServiceProvider y todas se asignan al 
| grupo de middleware "web".
|
*/

// --- RUTAS PÚBLICAS (Cualquiera puede entrar sin registrarse) ---

// Ruta para la página de inicio (Sección Hero)
Route::get('/', function () {
    $slides = \App\Models\WelcomeSlide::orderBy('orden', 'asc')->get();
    $destacados = \App\Models\Producto::where('destacado', 1)->with('categoria')->take(4)->get();
    return view('welcome', compact('slides', 'destacados'));
})->name('home'); // MODIFICADO: Le asignamos el nombre 'home' a la raíz para que Laravel redirija acá automáticamente

// Ruta para el catálogo de suplementos
Route::get('/catalogo', [ProductoController::class, 'index'])->name('catalogo');

// Ruta para la sección informativa de la empresa
Route::get('/quienes-somos', function () {
    return view('quienes-somos');
});

// Ruta para explicar los pasos de compra y métodos de pago
Route::get('/comercializacion', function () {
    return view('comercializacion');
});

// Ruta para el formulario de contacto y datos de la tienda
Route::get('/contacto', function () {
    return view('contacto');
})->name('contacto');

// Guardar mensajes de contacto
Route::post('/contacto', [MensajeController::class, 'store'])->name('contacto.store');

// Ruta para los términos de uso y condiciones legales
Route::get('/terminos', function () {
    return view('terminos');
});

// --- AUTENTICACIÓN (LOGIN / LOGOUT) ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// --- AUTENTICACIÓN (REGISTRO) ---
Route::get('/registro', function () {
    return view('registro'); 
})->name('register');

Route::post('/registro', [RegisterController::class, 'register'])->name('register.post');

// --- RUTAS PROTEGIDAS (SÓLO para usuarios logueados) ---
Route::middleware(['auth'])->group(function () {
    // Ver el carrito de compras (pasa por el controlador)
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito');

    // Acciones del carrito (Agregar, Eliminar, Vaciar)
    Route::post('/carrito/agregar/{id}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::post('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::post('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');
    
    // Nueva ruta AJAX para persistencia inmediata en MariaDB desde el catálogo
    Route::post('/carrito/agregar-ajax', [CarritoController::class, 'agregarAjax'])->name('carrito.agregarAjax');

    // Procesos de Compra (Confirmar y guardar en MariaDB)
    Route::get('/compra/confirmar', [CarritoController::class, 'confirmar'])->name('compra.confirmar');
    Route::post('/compra/guardar', [CarritoController::class, 'guardarCompra'])->name('compra.guardar');
    Route::get('/mis-compras', [CarritoController::class, 'misCompras'])->name('mis-compras');

    // ABM de Productos protegido (Agregar, editar o borrar de la tienda, sólo admins)
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.index');
        Route::post('/admin/paginas/guardar', [AdminController::class, 'editarPagina']);
        Route::post('/admin/usuarios/guardar', [AdminController::class, 'storeUsuario'])->name('admin.usuarios.store');
        
        // Rutas para mensajes de contacto
        Route::patch('/admin/mensajes/{id}/leer', [AdminController::class, 'marcarMensajeLeido'])->name('admin.mensajes.leer');
        Route::delete('/admin/mensajes/{id}', [AdminController::class, 'deleteMensaje'])->name('admin.mensajes.delete');
        
        // Rutas para pedidos/compras
        Route::get('/admin/pedidos/{id}', [AdminController::class, 'verPedido'])->name('admin.pedidos.show');
        Route::patch('/admin/pedidos/{id}/estado', [AdminController::class, 'actualizarEstadoPedido'])->name('admin.pedidos.estado');
        
        // Rutas para carrusel de inicio dinámico
        Route::post('/admin/carrusel/guardar', [AdminController::class, 'storeSlide'])->name('admin.carrusel.store');
        Route::delete('/admin/carrusel/{id}', [AdminController::class, 'destroySlide'])->name('admin.carrusel.delete');
        
        // Rutas para cambiar el logo de la tienda
        Route::post('/admin/logo/subir', [AdminController::class, 'uploadLogo'])->name('admin.logo.upload');
        Route::delete('/admin/logo/eliminar', [AdminController::class, 'deleteLogo'])->name('admin.logo.delete');
        
        Route::resource('productos', ProductoController::class)->except(['index', 'show']);
    });
});

// --- RUTAS DE PRODUCTOS PÚBLICAS ---
// Cualquiera puede ver la lista de productos y el detalle sin estar registrado
Route::resource('productos', ProductoController::class)->only(['index', 'show']);