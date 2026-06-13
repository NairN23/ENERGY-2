<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENERGY - Formulario de Stock</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #fcfaf8; font-family: sans-serif; }
        .form-box { background: white; border-radius: 20px; padding: 30px; border: 1px solid #eee; max-width: 600px; margin: 40px auto; }
    </style>
</head>
<body>

    @include('partials.navbar')

    <div class="container">
        <div class="form-box shadow-sm">
            <h3 class="fw-bold text-uppercase text-center mb-4">
                {{ isset($producto) ? 'Editar' : 'Cargar Nuevo' }} <span class="text-danger">Producto</span>
            </h3>

            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 12px;">
                    <p class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i> No se pudo guardar el producto:</p>
                    <ul class="mb-0 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ isset($producto) ? route('productos.update', $producto->id) : route('productos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($producto))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="nombre" class="form-label fw-bold small text-uppercase text-muted">Nombre del Suplemento</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" style="border-radius: 10px;" value="{{ old('nombre', $producto->nombre ?? '') }}" required placeholder="Ej: Creatina Monohidrato 300g">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="categoria_id" class="form-label fw-bold small text-uppercase text-muted">Categoría</label>
                        <select name="categoria_id" id="categoria_id" class="form-select" style="border-radius: 10px;" required onchange="toggleNuevaCategoriaInput()">
                            <option value="" disabled selected>Seleccionar...</option>
                            @foreach($categorias as $cat)
                                <option value="{{ $cat->id }}" {{ old('categoria_id', $producto->categoria_id ?? '') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nombre }}
                                </option>
                            @endforeach
                            <option value="nueva" class="text-danger fw-bold">+ Agregar otra distinta...</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="precio" class="form-label fw-bold small text-uppercase text-muted">Precio ($ ARS)</label>
                        <input type="number" step="0.01" name="precio" id="precio" class="form-control" style="border-radius: 10px;" value="{{ old('precio', $producto->precio ?? '') }}" required placeholder="Ej: 25000">
                    </div>
                </div>

                <div class="mb-3 d-none" id="contenedor_nueva_categoria">
                    <label for="nueva_categoria" class="form-label fw-bold small text-uppercase text-danger">Nombre de la nueva categoría</label>
                    <div class="input-group">
                        <span class="input-group-text bg-danger text-white border-0" style="border-radius: 10px 0 0 10px;"><i class="bi bi-tag-fill"></i></span>
                        <input type="text" name="nueva_categoria" id="nueva_categoria" class="form-control" style="border-radius: 0 10px 10px 0;" placeholder="Ej: Aminoácidos">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label fw-bold small text-uppercase text-muted">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="3" class="form-control" style="border-radius: 10px;" placeholder="Detalles del producto...">{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="stock" class="form-label fw-bold small text-uppercase text-muted">Stock Disponible</label>
                        <input type="number" name="stock" id="stock" class="form-control" style="border-radius: 10px;" value="{{ old('stock', $producto->stock ?? 0) }}" min="0" required>
                    </div>

                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="es_combo" id="es_combo" value="1" {{ old('es_combo', $producto->es_combo ?? false) ? 'checked' : '' }} onchange="toggleComboProductsInput()">
                            <label class="form-check-label fw-bold small text-uppercase text-muted" for="es_combo">
                                ¿Es un Combo?
                            </label>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="activo" id="activo" value="1" {{ old('activo', $producto->activo ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold small text-uppercase text-muted" for="activo">
                                ¿Activo?
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-3 d-none" id="contenedor_productos_combo">
                    <label class="form-label fw-bold small text-uppercase text-danger">Productos incluidos en el Combo</label>
                    <div class="border p-3 rounded-3 bg-light" style="max-height: 200px; overflow-y: auto; border-radius: 10px;">
                        @forelse($todosProductos as $p)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="productos_combo[]" value="{{ $p->id }}" id="p_combo_{{ $p->id }}"
                                    {{ is_array(old('productos_combo', $producto->productos_combo ?? null)) && in_array($p->id, old('productos_combo', $producto->productos_combo ?? [])) ? 'checked' : '' }}>
                                <label class="form-check-label small" for="p_combo_{{ $p->id }}">
                                    {{ $p->nombre }} - ${{ number_format($p->precio, 0, ',', '.') }}
                                </label>
                            </div>
                        @empty
                            <p class="text-muted small mb-0">No hay otros productos para asociar al combo.</p>
                        @endforelse
                    </div>
                </div>

                <div class="mb-4">
                    <label for="imagen" class="form-label fw-bold small text-uppercase text-muted">Imagen del Producto (.png, .jpg, .webp)</label>
                    <input type="file" name="imagen" id="imagen" class="form-control" style="border-radius: 10px;">
                    
                    @if(isset($producto) && $producto->imagen)
                        <div class="mt-2 small text-muted">
                            Imagen actual: <a href="{{ $producto->imagen }}" target="_blank" class="text-danger fw-bold">Ver archivo cargado</a>
                        </div>
                    @endif
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary w-50 fw-bold text-uppercase" style="border-radius: 10px; padding: 12px 0;">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-danger w-50 fw-bold text-uppercase shadow-sm" style="border-radius: 10px; padding: 12px 0;">
                        {{ isset($producto) ? 'Guardar Cambios' : 'Registrar Alta' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleNuevaCategoriaInput() {
            const select = document.getElementById('categoria_id');
            const contenedor = document.getElementById('contenedor_nueva_categoria');
            const input = document.getElementById('nueva_categoria');

            if (select && select.value === 'nueva') {
                contenedor.classList.remove('d-none');
                input.required = true;
                input.focus();
            } else if (contenedor && input) {
                contenedor.classList.add('d-none');
                input.required = false;
                input.value = '';
            }
        }

        function toggleComboProductsInput() {
            const esCombo = document.getElementById('es_combo');
            const contenedor = document.getElementById('contenedor_productos_combo');

            if (esCombo && esCombo.checked) {
                contenedor.classList.remove('d-none');
            } else if (contenedor) {
                contenedor.classList.add('d-none');
                const checkboxes = contenedor.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(cb => cb.checked = false);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            toggleNuevaCategoriaInput();
            toggleComboProductsInput();
        });
    </script>
</body>
</html>