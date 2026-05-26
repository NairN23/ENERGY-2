<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CarritoController; 

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
    return view('welcome');
})->name('home'); // MODIFICADO: Le asignamos el nombre 'home' a la raíz para que Laravel redirija acá automáticamente

// Ruta para el catálogo de suplementos
Route::get('/catalogo', function () {
    return view('catalogo'); 
});

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
});

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

    // Procesos de Compra (Confirmar y guardar en MariaDB)
    Route::get('/compra/confirmar', [CarritoController::class, 'confirmar'])->name('compra.confirmar');
    Route::post('/compra/guardar', [CarritoController::class, 'guardarCompra'])->name('compra.guardar');

    // ABM de Productos protegido (Agregar, editar o borrar de la tienda)
    Route::resource('productos', ProductoController::class)->except(['index', 'show']);
});

// --- RUTAS DE PRODUCTOS PÚBLICAS ---
// Cualquiera puede ver la lista de productos y el detalle sin estar registrado
Route::resource('productos', ProductoController::class)->only(['index', 'show']);