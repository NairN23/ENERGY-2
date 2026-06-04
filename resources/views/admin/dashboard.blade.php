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
                    <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 12px;">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    </div>
                @endif

                @if(session('generated_password'))
                    <div class="alert alert-warning border-0 shadow-sm mb-4" style="border-radius: 12px;">
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
                            <a href="{{ route('productos.create') }}" class="btn btn-danger rounded-pill px-4 fw-bold text-uppercase shadow-sm">
                                <i class="bi bi-plus-lg me-1"></i> Cargar Producto
                            </a>
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
                                            <th>Destacado</th>
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
                                                    @if($prod->destacado)
                                                        <span class="badge bg-warning text-dark">Destacado</span>
                                                    @else
                                                        <span class="text-muted small">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    <div class="d-inline-flex gap-2">
                                                        <a href="{{ route('productos.edit', $prod->id) }}" class="btn btn-sm btn-outline-dark px-3" style="border-radius: 8px;">Editar</a>
                                                        <form action="{{ route('productos.destroy', $prod->id) }}" method="POST" onsubmit="return confirm('¿Seguro querés eliminar este producto?');" style="display:inline;">
                                                            @csrf 
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash3-fill"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
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
                                                <td class="fw-bold" style="font-size: 0.85rem;">{{ $pedido->user->name ?? 'Usuario' }}</td>
                                                <td class="small text-muted">{{ $pedido->user->email ?? 'S/D' }}</td>
                                                <td class="fw-bold text-dark">${{ number_format($pedido->total, 2) }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $pedido->estado === 'entregado' ? 'success' : ($pedido->estado === 'cancelado' ? 'danger' : 'warning') }} text-uppercase" style="font-size: 0.65rem;">
                                                        {{ $pedido->estado }}
                                                    </span>
                                                </td>
                                                <td class="small">{{ $pedido->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    <a href="{{ route('admin.pedidos.show', $pedido->id) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="7" class="text-center py-4 text-muted small">No hay órdenes de compra registradas.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
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
                                                        <a href="https://wa.me/54{{ substr($msj->telefono, -10) }}" target="_blank" class="btn btn-sm btn-success">
                                                            <i class="bi bi-whatsapp"></i>
                                                        </a>
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
                                                    @if(!$msj->leido)
                                                        <form action="{{ route('admin.mensajes.leer', $msj->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-sm btn-outline-info" title="Marcar como leído">
                                                                <i class="bi bi-check2"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
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
                                    <button type="submit" class="btn btn-outline-dark rounded-pill px-3">Filtrar</button>
                                </form>
                                <button class="btn btn-danger rounded-pill px-4" type="button" data-bs-toggle="collapse" data-bs-target="#crearUsuarioForm" aria-expanded="false" aria-controls="crearUsuarioForm">
                                    Crear Usuario
                                </button>
                            </div>
                        </div>

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

                        <div class="collapse mb-4 {{ $activeTab === 'usuarios' && $errors->any() ? 'show' : '' }}" id="crearUsuarioForm">
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
                                                    @if($user->id === auth()->id())
                                                        <span class="badge bg-dark-subtle text-dark">Tu cuenta</span>
                                                    @else
                                                        <span class="badge bg-success-subtle text-success">Activo</span>
                                                    @endif
                                                </td>
                                                <td class="small">{{ $user->created_at->format('d/m/Y') }}</td>
                                                <td class="text-end">
                                                    @if($user->isAdmin())
                                                        <div class="d-inline-flex flex-wrap justify-content-end gap-2">
                                                            <button type="button" class="btn btn-sm btn-outline-dark px-3" style="border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal{{ $user->id }}">
                                                                Editar
                                                            </button>
                                                            <form action="{{ route('admin.usuarios.reset-password', ['usuario' => $user->id, 'tab' => 'usuarios', 'rol' => $roleFilter]) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                <input type="hidden" name="role_filter" value="{{ $roleFilter }}">
                                                                <button type="submit" class="btn btn-sm btn-outline-warning" style="border-radius: 8px;" onclick="return confirm('¿Generar una nueva contraseña temporal para {{ $user->name }}?');">
                                                                    Resetear clave
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('admin.usuarios.destroy', ['usuario' => $user->id, 'tab' => 'usuarios', 'rol' => $roleFilter]) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Seguro querés eliminar a este usuario?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden" name="role_filter" value="{{ $roleFilter }}">
                                                                <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 8px;" {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                                                    Eliminar
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @else
                                                        <span class="text-muted small italic"><i class="bi bi-shield-lock me-1"></i>Sin acciones</span>
                                                    @endif
                                                </td>
                                            </tr>

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
                userRoleFilterSelect.addEventListener('change', () => {
                    currentRoleFilter = getSelectedRoleFilter();
                    syncUserActionFilters();
                });

                userRoleFilterForm.addEventListener('submit', (event) => {
                    event.preventDefault();
                    currentRoleFilter = getSelectedRoleFilter();
                    syncUserActionFilters();

                    const url = new URL(userRoleFilterForm.action, window.location.origin);
                    url.searchParams.set('tab', 'usuarios');
                    url.searchParams.set('rol', getSelectedRoleFilter());

                    window.location.assign(url.toString());
                });
            }

            userActionForms.forEach((form) => {
                form.addEventListener('submit', () => {
                    syncUserActionFilters();
                });
            });

            document.querySelectorAll('#adminTab button[data-bs-toggle="tab"]').forEach((button) => {
                button.addEventListener('shown.bs.tab', (event) => {
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
    </script>
</body>
</html>