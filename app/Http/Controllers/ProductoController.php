<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Muestra el formulario para cargar un nuevo producto (ALTA)
     */
    public function index()
    {
        // Traemos todos los productos con su categoría para el catálogo público
        $productos = Producto::with('categoria')->get();
        return view('catalogo', compact('productos'));
    }

    public function create()
    {
        // Traemos las categorías de MariaDB para cargarlas en el select del formulario
        $categorias = Categoria::all();
        $todosProductos = Producto::orderBy('nombre')->get();
        return view('admin.form', compact('categorias', 'todosProductos'));
    }

    /**
     * Guarda el producto recién creado en MariaDB (ALTA)
     */
    public function store(Request $request)
    {
        // Forzamos la validación con los nombres exactos de tus inputs en español
        $request->validate([
            'nombre' => 'required|string|max:255|unique:productos,nombre',
            'categoria_id' => 'required', 
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|max:4096',
            'es_combo' => 'nullable|boolean',
            'destacado' => 'nullable|boolean',
            'stock' => 'nullable|integer|min:0',
        ]);

        if ($request->categoria_id === 'nueva') {
            $request->validate([
                'nueva_categoria' => 'required|string|max:255|unique:categorias,nombre'
            ]);
            $nuevaCat = Categoria::create(['nombre' => trim($request->nueva_categoria)]);
            $categoriaId = $nuevaCat->id;
        } else {
            $request->validate(['categoria_id' => 'exists:categorias,id']);
            $categoriaId = $request->categoria_id;
        }

        // Procesamos el archivo de la imagen
        $rutaImagen = '/images/productos/default.png'; 
        if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
            $nombreImagen = time() . '_' . $request->file('imagen')->getClientOriginalName();
            $request->file('imagen')->move(public_path('images/productos'), $nombreImagen);
            $rutaImagen = '/images/productos/' . $nombreImagen;
        }

        // Guardamos en MariaDB usando los campos en español
        Producto::create([
            'nombre' => $request->nombre,
            'categoria_id' => $categoriaId,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
            'imagen' => $rutaImagen,
            'es_combo' => $request->has('es_combo') ? true : false,
            'destacado' => $request->has('destacado') ? true : false,
            'productos_combo' => $request->has('es_combo') ? $request->productos_combo : null,
            'stock' => $request->stock ?? 0,
            'activo' => true,
        ]);

        return redirect()->route('admin.index')->with('success', '¡Producto cargado con éxito en la base de datos!');
    }

    /**
     * Muestra el formulario con los datos cargados para editarlos (MODIFICACIÓN)
     */
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        $todosProductos = Producto::where('id', '!=', $id)->orderBy('nombre')->get();
        return view('admin.form', compact('producto', 'categorias', 'todosProductos'));
    }

    /**
     * Actualiza los cambios del producto en MariaDB (MODIFICACIÓN)
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255|unique:productos,nombre,' . $id,
            'categoria_id' => 'required',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|max:4096',
            'es_combo' => 'nullable|boolean',
            'destacado' => 'nullable|boolean',
            'stock' => 'nullable|integer|min:0',
        ]);

        if ($request->categoria_id === 'nueva') {
            $request->validate([
                'nueva_categoria' => 'required|string|max:255|unique:categorias,nombre'
            ]);
            $nuevaCat = Categoria::create(['nombre' => trim($request->nueva_categoria)]);
            $categoriaId = $nuevaCat->id;
        } else {
            $request->validate(['categoria_id' => 'exists:categorias,id']);
            $categoriaId = $request->categoria_id;
        }

        $rutaImagen = $producto->imagen;
        if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
            if ($producto->imagen && $producto->imagen !== '/images/productos/default.png') {
                $archivoViejo = public_path($producto->imagen);
                if (file_exists($archivoViejo)) {
                    @unlink($archivoViejo);
                }
            }
            $nombreImagen = time() . '_' . $request->file('imagen')->getClientOriginalName();
            $request->file('imagen')->move(public_path('images/productos'), $nombreImagen);
            $rutaImagen = '/images/productos/' . $nombreImagen;
        }

        // Actualizamos en MariaDB
        $producto->update([
            'nombre' => $request->nombre,
            'categoria_id' => $categoriaId,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
            'imagen' => $rutaImagen,
            'es_combo' => $request->has('es_combo') ? true : false,
            'destacado' => $request->has('destacado') ? true : false,
            'productos_combo' => $request->has('es_combo') ? $request->productos_combo : null,
            'stock' => $request->stock ?? 0,
        ]);

        return redirect()->route('admin.index')->with('success', '¡Producto modificado con éxito!');
    }

    /**
     * Elimina el producto de MariaDB (BAJA)
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        
        // Opcional: Borramos la foto física de la carpeta al eliminar el producto
        if ($producto->imagen && $producto->imagen !== '/images/productos/default.png') {
            $archivo = public_path($producto->imagen);
            if (file_exists($archivo)) {
                @unlink($archivo);
            }
        }

        $producto->delete();

        return redirect()->route('admin.index')->with('success', 'Producto eliminado correctamente.');
    }
}