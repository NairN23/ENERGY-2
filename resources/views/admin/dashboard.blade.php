<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENERGY - Panel de Control Integral</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #fcfaf8; font-family: sans-serif; }
        .sidebar { min-height: 100vh; background: #000; color: #fff; }
        .sidebar .nav-link { color: #aaa; font-weight: 600; font-size: 0.88rem; letter-spacing: 0.03em; border-radius: 10px; transition: 0.2s; padding: 12px 15px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #fff; background: #ff0000; }
        .dashboard-card { background: white; border-radius: 20px; border: 1px solid #eee; padding: 25px; }
        .product-thumb { width: 45px; height: 45px; object-fit: contain; background: #f4f4f4; border-radius: 8px; }

        /* En móvil (cuando el sidebar va arriba), menú en 2 columnas */
        @media (max-width: 767.98px) {
            .sidebar {
                min-height: auto;
            }

            .sidebar #adminTab {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 0.5rem;
            }

            .sidebar #adminTab .nav-item {
                width: 100%;
                margin-top: 0 !important;
            }

            .sidebar #adminTab .nav-item .nav-link {
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center !important;
                padding: 10px 12px;
                font-size: 0.8rem;
            }

            .sidebar #adminTab .nav-item.mt-4 {
                grid-column: 1 / -1;
            }
        }

        /* En móviles muy angostos, una sola columna para evitar cortes */
        @media (max-width: 575.98px) {
            .sidebar #adminTab {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="row">
            
            <!-- BARRA LATERAL (SIDEBAR) -->
            <div class="col-md-3 col-lg-2 p-3 sidebar d-flex flex-column gap-4">
                <div class="px-2">
                    <h4 class="fw-bold text-white m-0">ENERGY</h4>
                    <span class="text-danger fw-bold text-uppercase" style="font-size: 0.65rem; letter-spacing: 2px;">Control Panel</span>
                </div>
                <hr class="text-muted my-0">
                
                <ul class="nav nav-pills flex-column gap-2" id="adminTab" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link w-100 text-start text-uppercase active" id="productos-tab" data-bs-toggle="tab" data-bs-target="#productos-pane" type="button" role="tab">
                            <i class="bi bi-box-sealer me-2"></i> Productos
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link w-100 text-start text-uppercase" id="compras-tab" data-bs-toggle="tab" data-bs-target="#compras-pane" type="button" role="tab">
                            <i class="bi bi-receipt me-2"></i> Ver Compras
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link w-100 text-start text-uppercase" id="mensajes-tab" data-bs-toggle="tab" data-bs-target="#mensajes-pane" type="button" role="tab">
                            <i class="bi bi-envelope-paper me-2"></i> Mensajes
                            @if($totales['mensajes_sin_leer'] > 0)
                                <span class="badge bg-warning text-dark ms-2">{{ $totales['mensajes_sin_leer'] }}</span>
                            @endif
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link w-100 text-start text-uppercase" id="usuarios-tab" data-bs-toggle="tab" data-bs-target="#usuarios-pane" type="button" role="tab">
                            <i class="bi bi-people me-2"></i> Usuarios
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link w-100 text-start text-uppercase" id="paginas-tab" data-bs-toggle="tab" data-bs-target="#paginas-pane" type="button" role="tab">
                            <i class="bi bi-pencil-square me-2"></i> Páginas Web
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link w-100 text-start text-uppercase" id="carrusel-tab" data-bs-toggle="tab" data-bs-target="#carrusel-pane" type="button" role="tab">
                            <i class="bi bi-images me-2"></i> Carrusel Inicio
                        </button>
                    </li>
                    <li class="nav-item mt-4">
                        <a href="/" class="nav-link w-100 text-start text-uppercase bg-secondary text-white">
                            <i class="bi bi-house me-2"></i> Volver a la Web
                        </a>
                    </li>
                </ul>
            </div>

            <!-- CONTENEDOR DE PANELES DINÁMICOS -->
            <div class="col-md-9 col-lg-10 p-4 p-md-5">
                
                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm mb-4 dashboard-flash-alert" style="border-radius: 12px;">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger border-0 shadow-sm mb-4 dashboard-flash-alert" style="border-radius: 12px;">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    </div>
                @endif

                @if(session('generated_password'))
                    <div class="alert alert-warning border-0 shadow-sm mb-4 dashboard-flash-alert" style="border-radius: 12px;">
                        <div class="fw-bold mb-1"><i class="bi bi-key-fill me-2"></i> Contraseña temporal generada</div>
                        <div class="small text-dark">
                            Usuario: {{ session('generated_password.name') }} ({{ session('generated_password.email') }})<br>
                            Nueva clave: <span class="fw-bold">{{ session('generated_password.password') }}</span>
                        </div>
                    </div>
                @endif

                <div class="tab-content" id="adminTabContent">
                    
                    <!-- PESTAÑA 1: GESTIÓN DE PRODUCTOS (CRUD) -->
                    <div class="tab-pane fade show active" id="productos-pane" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="fw-bold text-uppercase m-0">Gestión de <span class="text-danger">Productos</span></h3>
                            <button type="button" class="btn btn-danger rounded-pill px-4 fw-bold text-uppercase shadow-sm" data-bs-toggle="modal" data-bs-target="#crearProductoModal">
                                <i class="bi bi-plus-lg me-1"></i> Cargar Producto
                            </button>
                        </div>

                        <!-- Modal de creación de producto -->
                        <div class="modal fade" id="crearProductoModal" tabindex="-1" aria-labelledby="crearProductoModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content border-0" style="border-radius: 20px; overflow: hidden;">
                                    <div class="modal-header bg-dark text-white border-0">
                                        <div>
                                            <h5 class="modal-title fw-bold text-uppercase" id="crearProductoModalLabel">Cargar Nuevo Producto</h5>
                                            <span class="small text-white-50">Completá los datos del nuevo suplemento para darlo de alta en la tienda.</span>
                                        </div>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf

                                            <div class="mb-3">
                                                <label for="modal_nombre" class="form-label fw-bold small text-uppercase text-muted">Nombre del Suplemento</label>
                                                <input type="text" name="nombre" id="modal_nombre" class="form-control" style="border-radius: 10px;" value="{{ old('nombre') }}" required placeholder="Ej: Creatina Monohidrato 300g">
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="modal_categoria_id" class="form-label fw-bold small text-uppercase text-muted">Categoría</label>
                                                    <select name="categoria_id" id="modal_categoria_id" class="form-select" style="border-radius: 10px;" required onchange="toggleModalNuevaCategoriaInput()">
                                                        <option value="" disabled selected>Seleccionar...</option>
                                                        @foreach($categorias as $cat)
                                                            <option value="{{ $cat->id }}" {{ old('categoria_id') == $cat->id ? 'selected' : '' }}>
                                                                {{ $cat->nombre }}
                                                            </option>
                                                        @endforeach
                                                        <option value="nueva" class="text-danger fw-bold">+ Agregar otra distinta...</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="modal_precio" class="form-label fw-bold small text-uppercase text-muted">Precio ($ ARS)</label>
                                                    <input type="number" step="0.01" name="precio" id="modal_precio" class="form-control" style="border-radius: 10px;" value="{{ old('precio') }}" required placeholder="Ej: 25000">
                                                </div>
                                            </div>

                                            <div class="mb-3 d-none" id="modal_contenedor_nueva_categoria">
                                                <label for="modal_nueva_categoria" class="form-label fw-bold small text-uppercase text-danger">Nombre de la nueva categoría</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-danger text-white border-0" style="border-radius: 10px 0 0 10px;"><i class="bi bi-tag-fill"></i></span>
                                                    <input type="text" name="nueva_categoria" id="modal_nueva_categoria" class="form-control" style="border-radius: 0 10px 10px 0;" placeholder="Ej: Aminoácidos">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="modal_descripcion" class="form-label fw-bold small text-uppercase text-muted">Descripción</label>
                                                <textarea name="descripcion" id="modal_descripcion" rows="3" class="form-control" style="border-radius: 10px;" placeholder="Detalles del producto...">{{ old('descripcion') }}</textarea>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <label for="modal_stock" class="form-label fw-bold small text-uppercase text-muted">Stock Disponible</label>
                                                    <input type="number" name="stock" id="modal_stock" class="form-control" style="border-radius: 10px;" value="{{ old('stock', 0) }}" min="0" required>
                                                </div>

                                                <div class="col-md-3 mb-3 d-flex align-items-end">
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="es_combo" id="modal_es_combo" value="1" {{ old('es_combo') ? 'checked' : '' }} onchange="toggleModalComboProductsInput()">
                                                        <label class="form-check-label fw-bold small text-uppercase text-muted" for="modal_es_combo">
                                                            ¿Es un Combo?
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mb-3 d-flex align-items-end">
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="activo" id="modal_activo" value="1" {{ old('activo', true) ? 'checked' : '' }}>
                                                        <label class="form-check-label fw-bold small text-uppercase text-muted" for="modal_activo">
                                                            ¿Activo?
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3 d-none" id="modal_contenedor_productos_combo">
                                                <label class="form-label fw-bold small text-uppercase text-danger">Productos incluidos en el Combo</label>
                                                <div class="border p-3 rounded-3 bg-light" style="max-height: 200px; overflow-y: auto; border-radius: 10px;">
                                                    @forelse($productos as $p)
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" name="productos_combo[]" value="{{ $p->id }}" id="modal_p_combo_{{ $p->id }}">
                                                            <label class="form-check-label small" for="modal_p_combo_{{ $p->id }}">
                                                                {{ $p->nombre }} - ${{ number_format($p->precio, 0, ',', '.') }}
                                                            </label>
                                                        </div>
                                                    @empty
                                                        <p class="text-muted small mb-0">No hay otros productos para asociar al combo.</p>
                                                    @endforelse
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <label for="modal_imagen" class="form-label fw-bold small text-uppercase text-muted">Imagen del Producto (.png, .jpg, .webp)</label>
                                                <input type="file" name="imagen" id="modal_imagen" class="form-control" style="border-radius: 10px;">
                                            </div>

                                            <div class="d-flex justify-content-end gap-2">
                                                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold text-uppercase shadow-sm">Registrar Alta</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="dashboard-card shadow-sm">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle m-0">
                                    <thead class="table-light">
                                        <tr class="text-uppercase text-muted" style="font-size: 0.72rem;">
                                            <th>Foto</th>
                                            <th>Nombre</th>
                                            <th>Categoría</th>
                                            <th>Precio</th>
                                            <th>Stock</th>
                                            <th>Combo</th>
                                            <th>Activo</th>
                                            <th class="text-end">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($productos as $prod)
                                            <tr>
                                                <td><img src="{{ $prod->imagen }}" class="product-thumb" alt="Supp"></td>
                                                <td class="fw-bold text-dark" style="font-size: 0.88rem;">{{ $prod->nombre }}</td>
                                                <td><span class="badge bg-light text-danger border text-uppercase" style="font-size: 0.65rem;">{{ $prod->categoria->nombre ?? 'General' }}</span></td>
                                                <td class="fw-bold">${{ number_format($prod->precio, 0, ',', '.') }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <form action="{{ route('admin.productos.stock', $prod->id) }}" method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="action" value="decrement">
                                                            <button type="submit" class="btn btn-xs btn-outline-secondary p-0" style="width: 20px; height: 20px; font-size: 0.72rem; line-height: 1; border-radius: 4px;" {{ $prod->stock <= 0 ? 'disabled' : '' }}>-</button>
                                                        </form>
                                                        <span class="fw-bold text-dark" style="min-width: 24px; text-align: center; font-size: 0.85rem;">{{ $prod->stock }}</span>
                                                        <form action="{{ route('admin.productos.stock', $prod->id) }}" method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="action" value="increment">
                                                            <button type="submit" class="btn btn-xs btn-outline-secondary p-0" style="width: 20px; height: 20px; font-size: 0.72rem; line-height: 1; border-radius: 4px;">+</button>
                                                        </form>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($prod->es_combo)
                                                        <span class="badge bg-info">Sí</span>
                                                    @else
                                                        <span class="text-muted small">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($prod->activo)
                                                        <span class="badge bg-success">Sí</span>
                                                    @else
                                                        <span class="badge bg-danger">No</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    <div class="d-inline-flex gap-2">
                                                        <button
                                                            type="button"
                                                            class="btn btn-sm btn-outline-dark px-3"
                                                            style="border-radius: 8px;"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editarProductoModal{{ $prod->id }}"
                                                        >
                                                            Editar
                                                        </button>
                                                        <form action="{{ route('productos.destroy', $prod->id) }}" method="POST" onsubmit="return confirm('¿Seguro querés eliminar este producto?');" style="display:inline;">
                                                            @csrf 
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash3-fill"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="editarProductoModal{{ $prod->id }}" tabindex="-1" aria-labelledby="editarProductoModalLabel{{ $prod->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                                    <div class="modal-content border-0" style="border-radius: 20px; overflow: hidden;">
                                                        <div class="modal-header bg-dark text-white border-0">
                                                            <div>
                                                                <h5 class="modal-title fw-bold text-uppercase" id="editarProductoModalLabel{{ $prod->id }}">Editar Producto</h5>
                                                                <span class="small text-white-50">Actualizá los datos de {{ $prod->nombre }} sin salir del panel.</span>
                                                            </div>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-4">
                                                            <form action="{{ route('productos.update', $prod->id) }}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')

                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold small text-uppercase text-muted">Nombre del Suplemento</label>
                                                                    <input type="text" name="nombre" class="form-control" style="border-radius: 10px;" value="{{ $prod->nombre }}" required>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label class="form-label fw-bold small text-uppercase text-muted">Categoría</label>
                                                                        <select name="categoria_id" id="edit_categoria_id_{{ $prod->id }}" class="form-select" style="border-radius: 10px;" required onchange="toggleEditNuevaCategoriaInput({{ $prod->id }})">
                                                                            @foreach($categorias as $cat)
                                                                                <option value="{{ $cat->id }}" {{ $prod->categoria_id == $cat->id ? 'selected' : '' }}>
                                                                                    {{ $cat->nombre }}
                                                                                </option>
                                                                            @endforeach
                                                                            <option value="nueva" class="text-danger fw-bold">+ Agregar otra distinta...</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 mb-3">
                                                                        <label class="form-label fw-bold small text-uppercase text-muted">Precio ($ ARS)</label>
                                                                        <input type="number" step="0.01" name="precio" class="form-control" style="border-radius: 10px;" value="{{ $prod->precio }}" required>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-3 d-none" id="edit_contenedor_nueva_categoria_{{ $prod->id }}">
                                                                    <label class="form-label fw-bold small text-uppercase text-danger">Nombre de la nueva categoría</label>
                                                                    <input type="text" name="nueva_categoria" id="edit_nueva_categoria_{{ $prod->id }}" class="form-control" style="border-radius: 10px;" placeholder="Ej: Aminoácidos">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold small text-uppercase text-muted">Descripción</label>
                                                                    <textarea name="descripcion" rows="3" class="form-control" style="border-radius: 10px;">{{ $prod->descripcion }}</textarea>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-3 mb-3">
                                                                        <label class="form-label fw-bold small text-uppercase text-muted">Stock Disponible</label>
                                                                        <input type="number" name="stock" class="form-control" style="border-radius: 10px;" value="{{ $prod->stock }}" min="0" required>
                                                                    </div>

                                                                    <div class="col-md-3 mb-3 d-flex align-items-end">
                                                                        <div class="form-check mb-2">
                                                                            <input class="form-check-input" type="checkbox" name="es_combo" id="edit_es_combo_{{ $prod->id }}" value="1" {{ $prod->es_combo ? 'checked' : '' }} onchange="toggleEditComboProductsInput({{ $prod->id }})">
                                                                            <label class="form-check-label fw-bold small text-uppercase text-muted" for="edit_es_combo_{{ $prod->id }}">¿Es un Combo?</label>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-3 mb-3 d-flex align-items-end">
                                                                        <div class="form-check mb-2">
                                                                            <input class="form-check-input" type="checkbox" name="activo" id="edit_activo_{{ $prod->id }}" value="1" {{ $prod->activo ? 'checked' : '' }}>
                                                                            <label class="form-check-label fw-bold small text-uppercase text-muted" for="edit_activo_{{ $prod->id }}">¿Activo?</label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-3 d-none" id="edit_contenedor_productos_combo_{{ $prod->id }}">
                                                                    <label class="form-label fw-bold small text-uppercase text-danger">Productos incluidos en el Combo</label>
                                                                    <div class="border p-3 rounded-3 bg-light" style="max-height: 200px; overflow-y: auto; border-radius: 10px;">
                                                                        @foreach($productos as $p)
                                                                            @if($p->id !== $prod->id)
                                                                                <div class="form-check mb-2">
                                                                                    <input class="form-check-input" type="checkbox" name="productos_combo[]" value="{{ $p->id }}" id="edit_p_combo_{{ $prod->id }}_{{ $p->id }}" {{ is_array($prod->productos_combo) && in_array($p->id, $prod->productos_combo) ? 'checked' : '' }}>
                                                                                    <label class="form-check-label small" for="edit_p_combo_{{ $prod->id }}_{{ $p->id }}">
                                                                                        {{ $p->nombre }} - ${{ number_format($p->precio, 0, ',', '.') }}
                                                                                    </label>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                </div>

                                                                <div class="mb-4">
                                                                    <label class="form-label fw-bold small text-uppercase text-muted">Imagen del Producto (.png, .jpg, .webp)</label>
                                                                    <input type="file" name="imagen" class="form-control" style="border-radius: 10px;">
                                                                    @if($prod->imagen)
                                                                        <div class="mt-2 small text-muted">
                                                                            Imagen actual: <a href="{{ $prod->imagen }}" target="_blank" class="text-danger fw-bold">Ver archivo cargado</a>
                                                                        </div>
                                                                    @endif
                                                                </div>

                                                                <div class="d-flex justify-content-end gap-2">
                                                                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                                                                    <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold text-uppercase shadow-sm">Guardar cambios</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <tr><td colspan="7" class="text-center py-4 text-muted small">No hay suplementos registrados.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- PESTAÑA 2: HISTORIAL DE COMPRAS -->
                    <div class="tab-pane fade" id="compras-pane" role="tabpanel">
                        <h3 class="fw-bold text-uppercase mb-4">Historial de <span class="text-danger">Compras</span></h3>
                        <div class="dashboard-card shadow-sm">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle m-0">
                                    <thead class="table-light">
                                        <tr class="text-uppercase text-muted" style="font-size: 0.72rem;">
                                            <th>ID Pedido</th>
                                            <th>Cliente</th>
                                            <th>Email</th>
                                            <th>Total</th>
                                            <th>Estado</th>
                                            <th>Fecha</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($pedidos as $pedido)
                                            <tr>
                                                <td class="fw-bold text-danger">#{{ $pedido->id }}</td>
                                                <td class="fw-bold" style="font-size: 0.85rem;">{{ $pedido->cliente_nombre ?? ($pedido->user->name ?? 'Usuario') }}</td>
                                                <td class="small text-muted">{{ $pedido->cliente_email ?? ($pedido->user->email ?? 'S/D') }}</td>
                                                <td class="fw-bold text-dark">${{ number_format($pedido->total, 2) }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $pedido->estado === 'entregado' ? 'success' : ($pedido->estado === 'cancelado' ? 'danger' : 'warning') }} text-uppercase" style="font-size: 0.65rem;">
                                                        {{ $pedido->estado }}
                                                    </span>
                                                </td>
                                                <td class="small">{{ $pedido->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-outline-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#pedidoDetalleModal{{ $pedido->id }}"
                                                    >
                                                        Ver
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="7" class="text-center py-4 text-muted small">No hay órdenes de compra registradas.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @foreach($pedidos as $pedido)
                                <div class="modal fade" id="pedidoDetalleModal{{ $pedido->id }}" tabindex="-1" aria-labelledby="pedidoDetalleModalLabel{{ $pedido->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content border-0" style="border-radius: 18px; overflow: hidden;">
                                            <div class="modal-header bg-dark text-white border-0">
                                                <div>
                                                    <h5 class="modal-title fw-bold text-uppercase" id="pedidoDetalleModalLabel{{ $pedido->id }}">Detalle Pedido #{{ $pedido->id }}</h5>
                                                    <span class="small text-white-50">{{ $pedido->created_at->format('d/m/Y H:i') }}</span>
                                                </div>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="row g-4">
                                                    <div class="col-lg-8">
                                                        <h6 class="fw-bold text-uppercase text-muted small mb-3">Productos solicitados</h6>
                                                        <div class="table-responsive">
                                                            <table class="table table-sm align-middle">
                                                                <thead>
                                                                    <tr class="text-uppercase text-muted" style="font-size: 0.68rem;">
                                                                        <th>Producto</th>
                                                                        <th class="text-center">Cant</th>
                                                                        <th class="text-end">P. Unitario</th>
                                                                        <th class="text-end">Subtotal</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @forelse($pedido->detalles as $detalle)
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center gap-2">
                                                                                    <img
                                                                                        src="{{ $detalle->producto->imagen ?? '/images/productos/default.png' }}"
                                                                                        alt="{{ $detalle->producto->nombre ?? 'Producto' }}"
                                                                                        style="width: 38px; height: 38px; object-fit: contain; background: #f8f9fa; border-radius: 6px;"
                                                                                    >
                                                                                    <div>
                                                                                        <span class="fw-bold d-block" style="font-size: 0.82rem;">{{ $detalle->producto->nombre ?? 'Producto descatalogado' }}</span>
                                                                                        <span class="text-muted small">{{ $detalle->producto->categoria->nombre ?? 'Suplemento' }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td class="text-center fw-bold">{{ $detalle->cantidad }}</td>
                                                                            <td class="text-end">${{ number_format($detalle->precio_unitario, 2, ',', '.') }}</td>
                                                                            <td class="text-end fw-bold text-danger">${{ number_format($detalle->subtotal, 2, ',', '.') }}</td>
                                                                        </tr>
                                                                    @empty
                                                                        <tr>
                                                                            <td colspan="4" class="text-center text-muted small py-3">Este pedido no tiene detalles disponibles.</td>
                                                                        </tr>
                                                                    @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 border-start">
                                                        <div class="ps-lg-3">
                                                            <h6 class="fw-bold text-uppercase text-muted small mb-3">Datos del cliente</h6>
                                                            <p class="small mb-1"><strong>Nombre:</strong> {{ $pedido->cliente_nombre ?? ($pedido->user->name ?? 'Invitado') }}</p>
                                                            <p class="small mb-1"><strong>Teléfono:</strong> {{ $pedido->cliente_telefono ?? 'Sin registrar' }}</p>
                                                            <p class="small mb-1"><strong>Email:</strong> {{ $pedido->cliente_email ?? ($pedido->user->email ?? 'Sin registrar') }}</p>
                                                            <p class="small mb-3"><strong>Dirección:</strong> {{ $pedido->direccion_entrega ?? 'Sin registrar' }}</p>

                                                            <h6 class="fw-bold text-uppercase text-muted small mb-2">Método de pago</h6>
                                                            <p class="small mb-3">
                                                                @if($pedido->metodo_pago === 'mercado_pago')
                                                                    <span class="badge bg-info text-white">Mercado Pago</span>
                                                                @elseif($pedido->metodo_pago === 'whatsapp')
                                                                    <span class="badge bg-success text-white">WhatsApp</span>
                                                                @else
                                                                    <span class="badge bg-primary text-white">Transferencia</span>
                                                                @endif
                                                            </p>

                                                            @if($pedido->comprobante)
                                                                <a href="{{ $pedido->comprobante }}" target="_blank" class="btn btn-sm btn-outline-danger rounded-pill mb-3">
                                                                    Ver / Descargar comprobante
                                                                </a>
                                                            @endif

                                                            <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded-3 mb-3">
                                                                <span class="small text-uppercase text-muted fw-bold">Total</span>
                                                                <h5 class="m-0 fw-bold">${{ number_format($pedido->total, 2, ',', '.') }}</h5>
                                                            </div>

                                                            <form action="{{ route('admin.pedidos.estado', $pedido->id) }}" method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="mb-2">
                                                                    <label class="form-label small text-uppercase text-muted fw-bold">Estado del pedido</label>
                                                                    <select name="estado" class="form-select form-select-sm" style="border-radius: 10px;">
                                                                        <option value="pendiente" {{ $pedido->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                                                        <option value="confirmado" {{ $pedido->estado === 'confirmado' ? 'selected' : '' }}>Confirmado / Pagado</option>
                                                                        <option value="enviado" {{ $pedido->estado === 'enviado' ? 'selected' : '' }}>Enviado</option>
                                                                        <option value="entregado" {{ $pedido->estado === 'entregado' ? 'selected' : '' }}>Entregado</option>
                                                                        <option value="cancelado" {{ $pedido->estado === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                                                    </select>
                                                                </div>
                                                                <button type="submit" class="btn btn-danger w-100 rounded-pill">Guardar estado</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- PESTAÑA 3: BANDEJA DE MENSAJES -->
                    <div class="tab-pane fade" id="mensajes-pane" role="tabpanel">
                        <h3 class="fw-bold text-uppercase mb-4">Bandeja de <span class="text-danger">Mensajes</span></h3>
                        <div class="dashboard-card shadow-sm">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle m-0">
                                    <thead class="table-light">
                                        <tr class="text-uppercase text-muted" style="font-size: 0.72rem;">
                                            <th>Remitente</th>
                                            <th>Email</th>
                                            <th>Teléfono</th>
                                            <th>Asunto</th>
                                            <th>Mensaje</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($mensajes as $msj)
                                            <tr class="{{ !$msj->leido ? 'table-light fw-bold' : '' }}">
                                                <td style="font-size: 0.85rem;">{{ $msj->nombre }}</td>
                                                <td class="small"><a href="mailto:{{ $msj->email }}">{{ $msj->email }}</a></td>
                                                <td class="small">
                                                    @if($msj->telefono)
                                                        <span class="fw-semibold text-dark">{{ $msj->telefono }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="small text-dark">{{ Str::limit($msj->asunto, 25) }}</td>
                                                <td class="text-muted small">{{ Str::limit($msj->contenido, 40) }}</td>
                                                <td>
                                                    @if(!$msj->leido)
                                                        <span class="badge bg-warning text-dark">Sin leer</span>
                                                    @else
                                                        <span class="badge bg-success">Leído</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-inline-flex align-items-center gap-2">
                                                        <button
                                                            type="button"
                                                            class="btn btn-sm btn-outline-dark"
                                                            title="Ver detalle"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#mensajeDetalleModal{{ $msj->id }}"
                                                        >
                                                            <i class="bi bi-eye"></i>
                                                        </button>

                                                        @if(!$msj->leido)
                                                            <form action="{{ route('admin.mensajes.leer', $msj->id) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="btn btn-sm btn-outline-info" title="Marcar como leído">
                                                                    <i class="bi bi-check2"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="mensajeDetalleModal{{ $msj->id }}" tabindex="-1" aria-labelledby="mensajeDetalleModalLabel{{ $msj->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content border-0" style="border-radius: 18px; overflow: hidden;">
                                                        <div class="modal-header bg-dark text-white border-0">
                                                            <div>
                                                                <h5 class="modal-title fw-bold text-uppercase" id="mensajeDetalleModalLabel{{ $msj->id }}">Detalle del Mensaje</h5>
                                                                <span class="small text-white-50">Consulta recibida desde el formulario de contacto.</span>
                                                            </div>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-4">
                                                            <div class="row g-3 mb-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label small text-uppercase text-muted fw-bold">Remitente</label>
                                                                    <div class="form-control bg-light">{{ $msj->nombre }}</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label small text-uppercase text-muted fw-bold">Email</label>
                                                                    <div class="form-control bg-light">{{ $msj->email }}</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label small text-uppercase text-muted fw-bold">Teléfono</label>
                                                                    <div class="form-control bg-light">{{ $msj->telefono ?: '-' }}</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label small text-uppercase text-muted fw-bold">Estado</label>
                                                                    <div class="form-control bg-light">
                                                                        {{ $msj->leido ? 'Leído' : 'Sin leer' }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <label class="form-label small text-uppercase text-muted fw-bold">Asunto</label>
                                                                    <div class="form-control bg-light">{{ $msj->asunto }}</div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <label class="form-label small text-uppercase text-muted fw-bold">Mensaje</label>
                                                                    <textarea class="form-control bg-light" rows="6" readonly>{{ $msj->contenido }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-0 pt-0 px-4 pb-4 d-flex justify-content-end gap-2">
                                                            @if(!$msj->leido)
                                                                <form action="{{ route('admin.mensajes.leer', $msj->id) }}" method="POST" class="m-0">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <button type="submit" class="btn btn-outline-info rounded-pill px-4">
                                                                        Marcar como leído
                                                                    </button>
                                                                </form>
                                                            @endif
                                                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cerrar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <tr><td colspan="7" class="text-center py-4 text-muted small">No recibiste consultas de contacto por el momento.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- PESTAÑA 4: GESTIÓN DE USUARIOS -->
                    <div class="tab-pane fade" id="usuarios-pane" role="tabpanel">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                            <div>
                                <h3 class="fw-bold text-uppercase m-0">Gestión de <span class="text-danger">Usuarios</span></h3>
                                <p class="text-muted small mb-0">Administradores: {{ $totales['usuarios_admin'] }} | Clientes: {{ $totales['usuarios_cliente'] }} | Total: {{ $totales['usuarios'] }}</p>
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                                <form action="{{ route('admin.index') }}" method="GET" class="d-flex gap-2 align-items-center" id="usuariosRoleFilterForm" autocomplete="off">
                                    <input type="hidden" name="tab" value="usuarios">
                                    <select name="rol" id="usuariosRoleFilter" class="form-select form-select-sm" style="min-width: 180px; border-radius: 999px;">
                                        <option value="todos" {{ $roleFilter === 'todos' ? 'selected' : '' }}>Todos los roles</option>
                                        @foreach($roles as $roleValue => $roleLabel)
                                            <option value="{{ $roleValue }}" {{ $roleFilter === $roleValue ? 'selected' : '' }}>{{ $roleLabel }}</option>
                                        @endforeach
                                    </select>
                                </form>
                                <button class="btn btn-danger rounded-pill px-4" type="button" data-bs-toggle="collapse" data-bs-target="#crearUsuarioForm" aria-expanded="false" aria-controls="crearUsuarioForm">
                                    Crear Usuario
                                </button>
                            </div>
                        </div>

                        @if($errors->createUser->any())
                            <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 12px;">
                                <p class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i> No se pudo crear el usuario:</p>
                                <ul class="mb-0 small ps-3">
                                    @foreach($errors->createUser->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if($errors->updateUser->any())
                            <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 12px;">
                                <p class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i> No se pudo actualizar el usuario:</p>
                                <ul class="mb-0 small ps-3">
                                    @foreach($errors->updateUser->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 12px;">
                                <p class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i> No se pudo completar la operación sobre usuarios:</p>
                                <ul class="mb-0 small ps-3">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="collapse mb-4 {{ $activeTab === 'usuarios' && $errors->createUser->any() ? 'show' : '' }}" id="crearUsuarioForm">
                            <div class="dashboard-card shadow-sm">
                                <form action="{{ route('admin.usuarios.store', ['tab' => 'usuarios', 'rol' => $roleFilter]) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="role_filter" value="{{ $roleFilter }}">
                                    <div class="row g-3">
                                        <div class="col-lg-3 col-md-6">
                                            <label class="form-label small text-uppercase text-muted">Nombre</label>
                                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" minlength="3" maxlength="255" required>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <label class="form-label small text-uppercase text-muted">Email</label>
                                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" maxlength="255" required>
                                        </div>
                                        <div class="col-lg-2 col-md-6">
                                            <label class="form-label small text-uppercase text-muted">Rol</label>
                                            <select name="role" class="form-select" required>
                                                @foreach($roles as $roleValue => $roleLabel)
                                                    <option value="{{ $roleValue }}" {{ old('role', \App\Models\User::ROLE_CLIENTE) === $roleValue ? 'selected' : '' }}>{{ $roleLabel }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-2 col-md-6">
                                            <label class="form-label small text-uppercase text-muted">Contraseña</label>
                                            <input type="password" name="password" class="form-control" minlength="8" autocomplete="new-password" required>
                                            <span class="text-muted small d-block mt-1">Mínimo 8 caracteres.</span>
                                        </div>
                                        <div class="col-lg-2 col-md-6">
                                            <label class="form-label small text-uppercase text-muted">Confirmar clave</label>
                                            <input type="password" name="password_confirmation" class="form-control" minlength="8" autocomplete="new-password" required>
                                        </div>
                                        <div class="col-12 text-end">
                                            <button type="submit" class="btn btn-success rounded-pill px-4">Guardar usuario</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="dashboard-card shadow-sm">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle m-0">
                                    <thead class="table-light">
                                        <tr class="text-uppercase text-muted" style="font-size: 0.72rem;">
                                            <th>Nombre completo</th>
                                            <th>Correo Electrónico</th>
                                            <th>Rol</th>
                                            <th>Estado</th>
                                            <th>Registrado</th>
                                            <th class="text-end">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($usuarios as $user)
                                            <tr>
                                                <td class="fw-bold" style="font-size: 0.85rem;">
                                                    <i class="bi bi-person-circle me-2 text-secondary"></i>{{ $user->name }}
                                                </td>
                                                <td class="small text-muted">{{ $user->email }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $user->isAdmin() ? 'danger' : 'primary' }} text-uppercase" style="font-size: 0.65rem;">
                                                        {{ $user->role_label }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($user->trashed())
                                                        <span class="badge bg-danger-subtle text-danger">Inactivo</span>
                                                    @elseif($user->id === auth()->id())
                                                        <span class="badge bg-dark-subtle text-dark">Tu cuenta</span>
                                                    @else
                                                        <span class="badge bg-success-subtle text-success">Activo</span>
                                                    @endif
                                                </td>
                                                <td class="small">{{ $user->created_at->format('d/m/Y') }}</td>
                                                <td class="text-end">
                                                    @if($user->isAdmin())
                                                        <div class="d-inline-flex flex-wrap justify-content-end gap-2">
                                                            @if($user->trashed())
                                                                <form action="{{ route('admin.usuarios.restore', ['usuario' => $user->id, 'tab' => 'usuarios', 'rol' => $roleFilter]) }}" method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="role_filter" value="{{ $roleFilter }}">
                                                                    <button type="submit" class="btn btn-sm btn-outline-success" style="border-radius: 8px;">
                                                                        Activar
                                                                    </button>
                                                                </form>
                                                            @else
                                                                {{-- Acciones del administrador: Editar (que incluye cambio de clave) y Eliminar --}}
                                                                <button type="button" class="btn btn-sm btn-outline-dark px-3" style="border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal{{ $user->id }}">
                                                                    Editar
                                                                </button>
                                                                <form action="{{ route('admin.usuarios.destroy', ['usuario' => $user->id, 'tab' => 'usuarios', 'rol' => $roleFilter]) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Seguro querés eliminar a este usuario?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="role_filter" value="{{ $roleFilter }}">
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 8px;" {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                                                        Eliminar
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <span class="text-muted small italic"><i class="bi bi-shield-lock me-1"></i>Sin acciones</span>
                                                    @endif
                                                </td>
                                            </tr>

                                            @if($user->isAdmin() && ! $user->trashed())
                                            <div class="modal fade" id="editarUsuarioModal{{ $user->id }}" tabindex="-1" aria-labelledby="editarUsuarioModalLabel{{ $user->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content border-0" style="border-radius: 20px; overflow: hidden;">
                                                        <div class="modal-header bg-dark text-white border-0">
                                                            <div>
                                                                <h5 class="modal-title fw-bold text-uppercase" id="editarUsuarioModalLabel{{ $user->id }}">Editar usuario</h5>
                                                                <span class="small text-white-50">Podés actualizar sus datos, rol o establecer una nueva contraseña manual.</span>
                                                            </div>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-4">
                                                            <form action="{{ route('admin.usuarios.update', ['usuario' => $user->id, 'tab' => 'usuarios', 'rol' => $roleFilter]) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="role_filter" value="{{ $roleFilter }}">
                                                                <div class="row g-3">
                                                                    <div class="col-md-6">
                                                                        <label class="form-label small text-uppercase text-muted">Nombre</label>
                                                                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" minlength="3" maxlength="255" required>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label small text-uppercase text-muted">Email</label>
                                                                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" maxlength="255" required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label class="form-label small text-uppercase text-muted">Rol</label>
                                                                        <select name="role" class="form-select" required>
                                                                            @foreach($roles as $roleValue => $roleLabel)
                                                                                <option value="{{ $roleValue }}" {{ $user->role === $roleValue ? 'selected' : '' }}>{{ $roleLabel }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label class="form-label small text-uppercase text-muted">Nueva contraseña</label>
                                                                        <input type="password" name="password" class="form-control" placeholder="Opcional" minlength="8" autocomplete="new-password">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label class="form-label small text-uppercase text-muted">Confirmar nueva contraseña</label>
                                                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Opcional" minlength="8" autocomplete="new-password">
                                                                    </div>
                                                                    <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                                                                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                                                                        <button type="submit" class="btn btn-danger rounded-pill px-4">Guardar cambios</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        @empty
                                            <tr><td colspan="6" class="text-center py-4 text-muted small">No hay usuarios activos para el filtro seleccionado.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- PESTAÑA 5: GESTIÓN DE CONTENIDO DE PÁGINAS -->
                    <div class="tab-pane fade" id="paginas-pane" role="tabpanel">
                        <h3 class="fw-bold text-uppercase mb-4">Editar Contenido de las <span class="text-danger">Páginas</span></h3>
                        
                        <div class="row g-4">
                            <div class="col-md-3">
                                <div class="list-group shadow-sm" id="paginasListGroup" role="tablist" style="border-radius: 12px; overflow: hidden; border: 1px solid #eee;">
                                    <button class="list-group-item list-group-item-action active text-uppercase fw-bold p-3 border-0" id="list-quienes-list" data-bs-toggle="list" href="#list-quienes" role="tab">
                                        <i class="bi bi-people-fill me-2"></i> Quiénes Somos
                                    </button>
                                    <button class="list-group-item list-group-item-action text-uppercase fw-bold p-3 border-0" id="list-comercio-list" data-bs-toggle="list" href="#list-comercio" role="tab">
                                        <i class="bi bi-truck me-2"></i> Cómo Comprar
                                    </button>
                                    <button class="list-group-item list-group-item-action text-uppercase fw-bold p-3 border-0" id="list-logo-list" data-bs-toggle="list" href="#list-logo" role="tab">
                                        <i class="bi bi-image me-2"></i> Logo de la Marca
                                    </button>
                                    <button class="list-group-item list-group-item-action text-uppercase fw-bold p-3 border-0" id="list-contacto-list" data-bs-toggle="list" href="#list-contacto" role="tab">
                                        <i class="bi bi-envelope-fill me-2"></i> Contacto
                                    </button>
                                </div>
                            </div>
                            
                            <div class="col-md-9">
                                <div class="tab-content" id="nav-tabContent">
                                    
                                    <!-- Editar Quiénes Somos -->
                                    <div class="tab-pane fade show active" id="list-quienes" role="tabpanel">
                                        <div class="dashboard-card shadow-sm">
                                            <h5 class="fw-bold mb-3 text-uppercase border-bottom pb-2">Contenido de Quiénes Somos</h5>
                                            <form action="/admin/paginas/guardar" method="POST">
                                                @csrf
                                                <input type="hidden" name="pagina" value="quienes_somos">
                                                
                                                @foreach($paginaContenidos->get('quienes_somos', []) as $cont)
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold text-uppercase text-muted">{{ $cont->titulo }}</label>
                                                        @if(strlen($cont->valor) > 100)
                                                            <textarea name="{{ $cont->clave }}" class="form-control" rows="4" style="border-radius: 10px;" maxlength="1000" required>{{ $cont->valor }}</textarea>
                                                        @else
                                                            <input type="text" name="{{ $cont->clave }}" class="form-control" value="{{ $cont->valor }}" style="border-radius: 10px;" maxlength="1000" required>
                                                        @endif
                                                    </div>
                                                @endforeach
                                                
                                                <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold text-uppercase mt-2">
                                                    Guardar Cambios Quiénes Somos
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <!-- Editar Comercialización -->
                                    <div class="tab-pane fade" id="list-comercio" role="tabpanel">
                                        <div class="dashboard-card shadow-sm">
                                            <h5 class="fw-bold mb-3 text-uppercase border-bottom pb-2">Contenido de Cómo Comprar</h5>
                                            <form action="/admin/paginas/guardar" method="POST">
                                                @csrf
                                                <input type="hidden" name="pagina" value="comercializacion">
                                                
                                                @foreach($paginaContenidos->get('comercializacion', []) as $cont)
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold text-uppercase text-muted">{{ $cont->titulo }}</label>
                                                        @if(strlen($cont->valor) > 100)
                                                            <textarea name="{{ $cont->clave }}" class="form-control" rows="3" style="border-radius: 10px;" maxlength="1000" required>{{ $cont->valor }}</textarea>
                                                        @else
                                                            <input type="text" name="{{ $cont->clave }}" class="form-control" value="{{ $cont->valor }}" style="border-radius: 10px;" maxlength="1000" required>
                                                        @endif
                                                    </div>
                                                @endforeach
                                                
                                                <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold text-uppercase mt-2">
                                                    Guardar Cambios Cómo Comprar
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Editar Logo de la Marca -->
                                    <div class="tab-pane fade" id="list-logo" role="tabpanel">
                                        <div class="dashboard-card shadow-sm">
                                            <h5 class="fw-bold mb-3 text-uppercase border-bottom pb-2">Logo Oficial de la Tienda</h5>
                                            
                                            <div class="row g-4 align-items-center">
                                                <div class="col-md-6 text-center border-end">
                                                    <span class="d-block small fw-bold text-uppercase text-muted mb-3">Logo Activo Actual</span>
                                                    
                                                    @if(file_exists(public_path('images/logo.png')))
                                                        <div class="p-3 bg-light rounded-4 d-inline-block border shadow-sm">
                                                            <img src="/images/logo.png?v={{ filemtime(public_path('images/logo.png')) }}" alt="Logo ENERGY" style="max-height: 80px; width: auto;">
                                                        </div>
                                                        <form action="{{ route('admin.logo.delete') }}" method="POST" class="mt-3" onsubmit="return confirm('¿Estás seguro de que deseas eliminar el logo subido y restaurar el texto por defecto?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                                                <i class="bi bi-trash-fill"></i> Restaurar Logo Textual
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div class="p-4 rounded-4 text-center border border-dashed bg-light text-muted" style="border-style: dashed !important; border-width: 2px !important;">
                                                            <span class="fs-4 fw-bold text-dark d-block">ENERGY</span>
                                                            <span class="small text-uppercase tracking-wider">Sports Nutrition</span>
                                                            <span class="d-block mt-2 small text-danger fw-bold">(Logo de texto por defecto)</span>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="col-md-6">
                                                    <span class="d-block small fw-bold text-uppercase text-muted mb-3">Subir Nuevo Logo</span>
                                                    
                                                    <form action="{{ route('admin.logo.upload') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        
                                                        <div class="mb-3">
                                                            <label for="logo_file" class="form-label small fw-bold text-uppercase text-muted">Seleccionar Imagen</label>
                                                            <input type="file" name="logo_file" id="logo_file" class="form-control" accept="image/*" style="border-radius: 10px;" required>
                                                            <span class="text-muted small d-block mt-1" style="font-size: 0.7rem;">Soporta formatos PNG, JPG, WEBP. Se recomienda fondo transparente (PNG).</span>
                                                        </div>

                                                        <button type="submit" class="btn btn-danger rounded-pill px-4 py-2 fw-bold text-uppercase w-100">
                                                            <i class="bi bi-cloud-arrow-up-fill me-2"></i> Subir y Aplicar Logo
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Editar Contacto -->
                                    {{-- Sección para que el Administrador edite los textos y configuraciones de la página de contacto --}}
                                    <div class="tab-pane fade" id="list-contacto" role="tabpanel">
                                        <div class="dashboard-card shadow-sm">
                                            <h5 class="fw-bold mb-3 text-uppercase border-bottom pb-2">Contenido de la Página de Contacto</h5>
                                            <form action="/admin/paginas/guardar" method="POST">
                                                @csrf
                                                <input type="hidden" name="pagina" value="contacto">
                                                
                                                @foreach($paginaContenidos->get('contacto', []) as $cont)
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold text-uppercase text-muted">{{ $cont->titulo }}</label>
                                                        @if(strlen($cont->valor) > 100)
                                                            <textarea name="{{ $cont->clave }}" class="form-control" rows="3" style="border-radius: 10px;" maxlength="1000" required>{{ $cont->valor }}</textarea>
                                                        @else
                                                            <input type="text" name="{{ $cont->clave }}" class="form-control" value="{{ $cont->valor }}" style="border-radius: 10px;" maxlength="1000" required>
                                                        @endif
                                                    </div>
                                                @endforeach
                                                
                                                <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold text-uppercase mt-2">
                                                    Guardar Cambios Contacto
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PESTAÑA 6: GESTIÓN DE CARRUSEL DE INICIO -->
                    <div class="tab-pane fade" id="carrusel-pane" role="tabpanel">
                        <h3 class="fw-bold text-uppercase mb-4">Carrusel de la <span class="text-danger">Página de Inicio</span></h3>
                        
                        <div class="row g-4">
                            <!-- Formulario para agregar -->
                            <div class="col-lg-5">
                                <div class="dashboard-card shadow-sm">
                                    <h5 class="fw-bold mb-3 text-uppercase border-bottom pb-2">Agregar Nuevo Slide</h5>
                                    
                                    <form action="{{ route('admin.carrusel.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        
                                        <div class="mb-3">
                                            <label for="imagen_file" class="form-label small fw-bold text-uppercase text-muted">Subir Imagen desde PC</label>
                                            <input type="file" name="imagen_file" id="imagen_file" class="form-control" accept="image/*" style="border-radius: 10px;">
                                            <span class="text-muted small d-block mt-1" style="font-size: 0.7rem;">Dimensiones recomendadas: 2000 x 680 px para visualización horizontal premium.</span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="imagen_url" class="form-label small fw-bold text-uppercase text-muted">Ó pegar URL de Imagen Externa</label>
                                            <input type="url" name="imagen_url" id="imagen_url" class="form-control" placeholder="https://ejemplo.com/gym-banner.jpg" style="border-radius: 10px;" maxlength="500">
                                        </div>

                                        <div class="mb-3">
                                            <label for="titulo_blanco" class="form-label small fw-bold text-uppercase text-muted">Título Parte 1 (Blanco / Principal)</label>
                                            <input type="text" name="titulo_blanco" id="titulo_blanco" class="form-control" placeholder="Ej: Potenciá" style="border-radius: 10px;" required minlength="3" maxlength="255">
                                        </div>

                                        <div class="mb-3">
                                            <label for="titulo_rojo" class="form-label small fw-bold text-uppercase text-muted">Título Parte 2 (Rojo / Acento)</label>
                                            <input type="text" name="titulo_rojo" id="titulo_rojo" class="form-control" placeholder="Ej: tu mejor versión" style="border-radius: 10px;" required minlength="3" maxlength="255">
                                        </div>

                                        <div class="mb-3">
                                            <label for="orden" class="form-label small fw-bold text-uppercase text-muted">Orden de Aparición</label>
                                            <input type="number" name="orden" id="orden" class="form-control" value="{{ ($welcomeSlides->max('orden') ?? 0) + 1 }}" style="border-radius: 10px;" required min="1" step="1">
                                        </div>

                                        <button type="submit" class="btn btn-danger rounded-pill w-100 py-2.5 fw-bold text-uppercase mt-2 shadow-sm">
                                            <i class="bi bi-plus-circle me-2"></i> Añadir Slide al Carrusel
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Listado de Slides actuales -->
                            <div class="col-lg-7">
                                <div class="dashboard-card shadow-sm">
                                    <h5 class="fw-bold mb-3 text-uppercase border-bottom pb-2">Slides Configurados</h5>
                                    
                                    @if(isset($welcomeSlides) && $welcomeSlides->count() > 0)
                                        <div class="row row-cols-1 g-3">
                                            @foreach($welcomeSlides as $slide)
                                                <div class="col">
                                                    <div class="card bg-dark text-white border-0 shadow-sm overflow-hidden position-relative" style="height: 120px; border-radius: 12px;">
                                                        <img src="{{ $slide->imagen }}" class="w-100 h-100" style="object-fit: cover; opacity: 0.45; position: absolute; top:0; left:0; z-index: 1;" alt="Slide Preview">
                                                        
                                                        <div class="card-body d-flex justify-content-between align-items-center position-relative h-100 p-3" style="z-index: 2;">
                                                            <div>
                                                                <span class="badge bg-danger mb-2">Orden #{{ $slide->orden }}</span>
                                                                <h6 class="fw-bold text-uppercase mb-0" style="font-size: 0.85rem; letter-spacing: 0.5px;">
                                                                    {{ $slide->titulo_blanco }} 
                                                                    <span class="text-danger fw-extrabold">{{ $slide->titulo_rojo }}</span>
                                                                </h6>
                                                                <span class="text-white-50 d-block mt-1" style="font-size: 0.65rem; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                                    {{ $slide->imagen }}
                                                                </span>
                                                            </div>
                                                            
                                                            <div>
                                                                <form action="{{ route('admin.carrusel.delete', $slide->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este slide del carrusel?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-danger border-0 p-2" style="border-radius: 8px;">
                                                                        <i class="bi bi-trash-fill fs-6"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted small py-4 text-center">No hay slides dinámicos configurados. El carrusel usará el banner por defecto.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const activeTab = @json($activeTab);
            let currentRoleFilter = @json($roleFilter);
            const userRoleFilterForm = document.getElementById('usuariosRoleFilterForm');
            const userRoleFilterSelect = document.getElementById('usuariosRoleFilter');
            const userActionForms = Array.from(document.querySelectorAll('#usuarios-pane form')).filter((form) => {
                return form.querySelector('input[name="role_filter"]');
            });

            const closeDashboardFlashAlerts = () => {
                document.querySelectorAll('.dashboard-flash-alert').forEach((alertEl) => {
                    alertEl.remove();
                });
            };

            const getSelectedRoleFilter = () => {
                if (!userRoleFilterSelect || !userRoleFilterSelect.value) {
                    return currentRoleFilter || 'todos';
                }

                return userRoleFilterSelect.value;
            };

            const syncUserActionFilters = () => {
                const selectedRoleFilter = getSelectedRoleFilter();

                userActionForms.forEach((form) => {
                    const roleFilterInput = form.querySelector('input[name="role_filter"]');

                    if (roleFilterInput) {
                        roleFilterInput.value = selectedRoleFilter;
                    }
                });
            };

            const syncUserRoleFilter = () => {
                if (!userRoleFilterSelect) {
                    return;
                }

                userRoleFilterSelect.value = currentRoleFilter;

                Array.from(userRoleFilterSelect.options).forEach((option) => {
                    option.selected = option.value === currentRoleFilter;
                });

                syncUserActionFilters();
            };

            syncUserRoleFilter();

            window.addEventListener('pageshow', syncUserRoleFilter);

            if (activeTab !== 'productos') {
                const trigger = document.getElementById(`${activeTab}-tab`);

                if (trigger) {
                    bootstrap.Tab.getOrCreateInstance(trigger).show();
                }
            }

            if (activeTab === 'usuarios') {
                const url = new URL(window.location.href);

                if (!url.searchParams.get('rol')) {
                    url.searchParams.set('rol', currentRoleFilter);
                    url.searchParams.set('tab', 'usuarios');
                    window.history.replaceState({}, '', url);
                }
            }

            if (userRoleFilterForm && userRoleFilterSelect) {
                const applyUserRoleFilter = () => {
                    const url = new URL(userRoleFilterForm.action, window.location.origin);
                    url.searchParams.set('tab', 'usuarios');
                    url.searchParams.set('rol', getSelectedRoleFilter());

                    window.location.assign(url.toString());
                };

                userRoleFilterSelect.addEventListener('change', () => {
                    currentRoleFilter = getSelectedRoleFilter();
                    syncUserActionFilters();
                    applyUserRoleFilter();
                });

                userRoleFilterForm.addEventListener('submit', (event) => {
                    event.preventDefault();
                    currentRoleFilter = getSelectedRoleFilter();
                    syncUserActionFilters();
                    applyUserRoleFilter();
                });
            }

            userActionForms.forEach((form) => {
                form.addEventListener('submit', () => {
                    syncUserActionFilters();
                });
            });

            document.querySelectorAll('#adminTab button[data-bs-toggle="tab"]').forEach((button) => {
                button.addEventListener('shown.bs.tab', (event) => {
                    closeDashboardFlashAlerts();

                    const tabId = event.target.id.replace('-tab', '');
                    const url = new URL(window.location.href);

                    if (tabId === 'productos') {
                        url.searchParams.delete('tab');
                    } else {
                        url.searchParams.set('tab', tabId);
                    }

                    if (tabId === 'usuarios') {
                        if (!url.searchParams.get('rol')) {
                            url.searchParams.set('rol', currentRoleFilter);
                        }
                    } else {
                        url.searchParams.delete('rol');
                    }

                    window.history.replaceState({}, '', url);
                });
            });

            // Validaciones de contraseñas coincidentes en los formularios de usuarios
            const userForms = document.querySelectorAll('form');
            userForms.forEach((form) => {
                const passwordInput = form.querySelector('input[name="password"]');
                const confirmInput = form.querySelector('input[name="password_confirmation"]');
                if (passwordInput && confirmInput) {
                    const validatePassword = () => {
                        if (passwordInput.value !== confirmInput.value) {
                            confirmInput.setCustomValidity('Las contraseñas no coinciden.');
                        } else {
                            confirmInput.setCustomValidity('');
                        }
                    };
                    passwordInput.addEventListener('change', validatePassword);
                    confirmInput.addEventListener('keyup', validatePassword);
                }
            });
        });

        // Funciones para el Modal de Producto
        function toggleModalNuevaCategoriaInput() {
            const select = document.getElementById('modal_categoria_id');
            const contenedor = document.getElementById('modal_contenedor_nueva_categoria');
            const input = document.getElementById('modal_nueva_categoria');

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

        function toggleModalComboProductsInput() {
            const esCombo = document.getElementById('modal_es_combo');
            const contenedor = document.getElementById('modal_contenedor_productos_combo');

            if (esCombo && esCombo.checked) {
                contenedor.classList.remove('d-none');
            } else if (contenedor) {
                contenedor.classList.add('d-none');
                const checkboxes = contenedor.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(cb => cb.checked = false);
            }
        }

        function toggleEditNuevaCategoriaInput(productId) {
            const select = document.getElementById(`edit_categoria_id_${productId}`);
            const contenedor = document.getElementById(`edit_contenedor_nueva_categoria_${productId}`);
            const input = document.getElementById(`edit_nueva_categoria_${productId}`);

            if (!select || !contenedor || !input) {
                return;
            }

            if (select.value === 'nueva') {
                contenedor.classList.remove('d-none');
                input.required = true;
                input.focus();
            } else {
                contenedor.classList.add('d-none');
                input.required = false;
                input.value = '';
            }
        }

        function toggleEditComboProductsInput(productId) {
            const esCombo = document.getElementById(`edit_es_combo_${productId}`);
            const contenedor = document.getElementById(`edit_contenedor_productos_combo_${productId}`);

            if (!esCombo || !contenedor) {
                return;
            }

            if (esCombo.checked) {
                contenedor.classList.remove('d-none');
            } else {
                contenedor.classList.add('d-none');
                const checkboxes = contenedor.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(cb => cb.checked = false);
            }
        }

        // Inicializar el estado de los inputs dinámicos en el modal cuando se muestra
        document.getElementById('crearProductoModal')?.addEventListener('show.bs.modal', function () {
            toggleModalNuevaCategoriaInput();
            toggleModalComboProductsInput();
        });

        // Inicializar estado de campos dinámicos al abrir cada modal de edición
        document.querySelectorAll('[id^="editarProductoModal"]').forEach((modalEl) => {
            modalEl.addEventListener('show.bs.modal', function () {
                const productId = modalEl.id.replace('editarProductoModal', '');
                toggleEditNuevaCategoriaInput(productId);
                toggleEditComboProductsInput(productId);
            });
        });
    </script>
</body>
</html>