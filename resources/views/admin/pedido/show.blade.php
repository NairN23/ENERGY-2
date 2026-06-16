<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENERGY - Detalle del Pedido #{{ $pedido->id }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #fcfaf8; font-family: sans-serif; }
        .detail-card { background: white; border-radius: 16px; border: 1px solid #eee; padding: 25px; margin-bottom: 25px; transition: 0.3s; }
        .status-badge { font-size: 0.72rem; font-weight: 800; text-transform: uppercase; padding: 6px 12px; border-radius: 20px; }
        .bg-pending { background-color: #ffe8cc; color: #d97706; }
        .bg-confirmed { background-color: #dcfce7; color: #15803d; }
        .bg-enviado { background-color: #dbeafe; color: #1d4ed8; }
        .bg-entregado { background-color: #f3e8ff; color: #6b21a8; }
        .bg-cancelado { background-color: #fee2e2; color: #b91c1c; }
        .product-thumb { width: 50px; height: 50px; object-fit: contain; background: #f8f9fa; border-radius: 8px; padding: 4px; }
    </style>
</head>
<body>

    @include('partials.navbar')

    <div class="container py-5" style="min-height: 70vh;">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-uppercase italic m-0">Detalle del <span class="text-danger">Pedido</span></h2>
            <a href="{{ route('admin.index') }}" class="btn btn-outline-dark rounded-pill fw-bold px-4 small text-uppercase">
                <i class="bi bi-arrow-left me-2"></i> Volver al Panel
            </a>
        </div>

        <div class="detail-card shadow-sm">
            <div class="row align-items-center border-bottom pb-3 mb-4">
                <div class="col-md-6 col-12 mb-2 mb-md-0">
                    <span class="text-muted small text-uppercase">Pedido Administrativo</span>
                    <h5 class="fw-bold mb-0">#{{ $pedido->id }} <span class="text-muted" style="font-size: 0.8rem; font-weight: normal;">- {{ $pedido->created_at->format('d/m/Y H:i') }}</span></h5>
                </div>
                <div class="col-md-6 col-12 text-md-end">
                    @php
                        $badgeClass = 'bg-pending';
                        $statusLabel = 'Pendiente';
                        if ($pedido->estado === 'confirmado') {
                            $badgeClass = 'bg-confirmed';
                            $statusLabel = 'Confirmado / Pagado';
                        } elseif ($pedido->estado === 'enviado') {
                            $badgeClass = 'bg-enviado';
                            $statusLabel = 'Enviado';
                        } elseif ($pedido->estado === 'entregado') {
                            $badgeClass = 'bg-entregado';
                            $statusLabel = 'Entregado';
                        } elseif ($pedido->estado === 'cancelado') {
                            $badgeClass = 'bg-cancelado';
                            $statusLabel = 'Cancelado';
                        }
                    @endphp
                    <span class="status-badge {{ $badgeClass }}">
                        <i class="bi bi-info-circle-fill me-1"></i>
                        {{ $statusLabel }}
                    </span>
                </div>
            </div>

            <div class="row g-4">
                <!-- Productos e Info del Pedido -->
                <div class="col-lg-8">
                    <h6 class="fw-bold text-uppercase text-muted small mb-3">Productos Solicitados</h6>
                    
                    <div class="table-responsive mb-4">
                        <table class="table table-borderless align-middle mb-0">
                            <thead>
                                <tr class="text-muted small border-bottom" style="font-size: 0.72rem;">
                                    <th>Producto</th>
                                    <th class="text-center">Cant</th>
                                    <th class="text-end">Precio Unitario</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pedido->detalles as $detalle)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ $detalle->producto->imagen ?? '/images/productos/default.png' }}" class="product-thumb" alt="{{ $detalle->producto->nombre ?? 'Producto' }}">
                                                <div>
                                                    <span class="fw-bold d-block text-uppercase" style="font-size: 0.8rem;">{{ $detalle->producto->nombre ?? 'Producto Descatalogado' }}</span>
                                                    <span class="text-muted small" style="font-size: 0.72rem;">{{ $detalle->producto->categoria->nombre ?? 'Suplemento' }}</span>
                                                    @if($detalle->producto && $detalle->producto->es_combo && $detalle->producto->productos_combo_collection->count() > 0)
                                                        <div class="mt-1" style="font-size: 0.68rem; line-height: 1.2;">
                                                            <span class="text-danger fw-bold text-uppercase" style="font-size: 0.62rem;">Incluye:</span>
                                                            @foreach($detalle->producto->productos_combo_collection as $comp)
                                                                    <div class="text-muted"><i class="bi bi-caret-right text-danger"></i> {{ $comp->nombre }}</div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center fw-bold small">{{ $detalle->cantidad }}</td>
                                        <td class="text-end fw-bold small">${{ number_format($detalle->precio_unitario, 2, ',', '.') }}</td>
                                        <td class="text-end fw-bold text-danger small">${{ number_format($detalle->subtotal, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($pedido->descripcion)
                        <div class="p-3 bg-light rounded-3 mb-4">
                            <h6 class="fw-bold text-uppercase text-muted small mb-2">Observaciones del Pedido</h6>
                            <p class="text-muted mb-0 small">{{ $pedido->descripcion }}</p>
                        </div>
                    @endif
                </div>

                <!-- Datos de Cliente, Pago y Cambiar Estado -->
                <div class="col-lg-4 border-start">
                    <div class="ps-lg-3">
                        <h6 class="fw-bold text-uppercase text-muted small mb-3">Datos del Cliente</h6>
                        <p class="small text-dark mb-1"><strong>Nombre:</strong> {{ $pedido->cliente_nombre ?? ($pedido->user->name ?? 'Invitado') }}</p>
                        <p class="small text-dark mb-1"><strong>Teléfono:</strong> {{ $pedido->cliente_telefono ?? 'Sin Registrar' }}</p>
                        <p class="small text-dark mb-1"><strong>Email:</strong> {{ $pedido->cliente_email ?? ($pedido->user->email ?? 'Sin Registrar') }}</p>
                        <p class="small text-dark mb-3"><strong>Dirección:</strong> {{ $pedido->direccion_entrega }}</p>
                        
                        @if($pedido->user)
                            <span class="text-muted d-block small" style="font-size: 0.7rem;">Cuenta de Usuario: {{ $pedido->user->name }} ({{ $pedido->user->email }})</span>
                        @endif

                        <hr class="my-3">

                        <h6 class="fw-bold text-uppercase text-muted small mb-2">Método de Pago</h6>
                        <p class="small text-dark mb-2">
                            @if($pedido->metodo_pago === 'mercado_pago')
                                <span class="badge bg-info text-white">Mercado Pago</span>
                                <span class="d-block text-muted small mt-1" style="font-size: 0.65rem;">Ref MP: #{{ $pedido->mp_payment_id }}</span>
                            @elseif($pedido->metodo_pago === 'whatsapp')
                                <span class="badge bg-success text-white"><i class="bi bi-whatsapp me-1"></i> Finalizado por WhatsApp</span>
                            @else
                                <span class="badge bg-primary text-white">Transferencia Bancaria</span>
                                @if($pedido->comprobante)
                                    <a href="{{ $pedido->comprobante }}" target="_blank" class="d-block text-danger fw-bold small mt-2">
                                        <i class="bi bi-file-earmark-image me-1"></i> Ver Comprobante Subido
                                    </a>
                                @else
                                    <span class="d-block text-muted small mt-1">Comprobante no subido.</span>
                                @endif
                            @endif
                        </p>

                        <div class="d-flex justify-content-between align-items-center mt-3 p-3 bg-light rounded-3 mb-4">
                            <span class="fw-bold text-uppercase small text-muted">Total del Pedido</span>
                            <h4 class="fw-bold text-dark m-0">${{ number_format($pedido->total, 2, ',', '.') }}</h4>
                        </div>

                        <hr class="my-3">

                        <h6 class="fw-bold text-uppercase text-muted small mb-3">Cambiar Estado del Pedido</h6>
                        <form action="{{ route('admin.pedidos.estado', $pedido->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <select name="estado" class="form-select form-select-sm" style="border-radius: 10px;">
                                    <option value="pendiente" {{ $pedido->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="confirmado" {{ $pedido->estado === 'confirmado' ? 'selected' : '' }}>Confirmado / Pagado</option>
                                    <option value="enviado" {{ $pedido->estado === 'enviado' ? 'selected' : '' }}>Enviado</option>
                                    <option value="entregado" {{ $pedido->estado === 'entregado' ? 'selected' : '' }}>Entregado</option>
                                    <option value="cancelado" {{ $pedido->estado === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-sm btn-danger w-100 fw-bold text-uppercase rounded-pill py-2">
                                <i class="bi bi-save me-1"></i> Guardar Estado
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
