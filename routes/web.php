<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas Web - Proyecto ENERGY
|--------------------------------------------------------------------------
| Aquí es donde registrás las rutas de tu aplicación. Estas rutas 
| son cargadas por el RouteServiceProvider y todas se asignan al 
| grupo de middleware "web".
|
*/

// Ruta para la página de inicio (Sección Hero)
Route::get('/', function () {
    return view('welcome');
});

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

// Ruta para la pantalla de acceso de usuarios
Route::get('/login', function () {
    return view('login');
});

Route::get('/carrito', function () {
    return view('carrito');
});