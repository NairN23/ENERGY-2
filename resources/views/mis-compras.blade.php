<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENERGY - Mis Compras</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #fcfaf8; font-family: sans-serif; }
        .order-card { background: white; border-radius: 16px; border: 1px solid #eee; padding: 25px; margin-bottom: 25px; transition: 0.3s; }
        .order-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        .status-badge { font-size: 0.72rem; font-weight: 800; text-transform: uppercase; padding: 6px 12px; border-radius: 20px; }
        .bg-pending { background-color: #ffe8cc; color: #d97706; }
        .bg-confirmed { background-color: #dcfce7; color: #15803d; }
        .product-thumb { width: 50px; height: 50px; object-fit: contain; background: #f8f9fa; border-radius: 8px; padding: 4px; }
    </style>
</head>
<body>

    @include('partials.navbar')

    <div class="container py-5" style="min-height: 70vh;">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-uppercase italic m-0">Mis <span class="text-danger">Compras</span></h2>
            <a href="{{ route('catalogo') }}" class="btn btn-outline-dark rounded-pill fw-bold px-4 small text-uppercase">
                <i class="bi bi-arrow-left me-2"></i> Seguir Comprando
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 p-3" role="alert" style="border-radius: 12px;">
                <i class="bi bi-check-circle-fill me-2"></i> <strong>{{ session('success') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @forelse($pedidos as $pedido)
            <div class="order-card shadow-sm">
                <div class="row align-items-center border-bottom pb-3 mb-3">
                    <div class="col-md-6 col-12 mb-2 mb-md-0">
                        <span class="text-muted small text-uppercase">Pedido</span>
                        <h5 class="fw-bold mb-0">#{{ $pedido->id }} <span class="text-muted" style="font-size: 0.8rem; font-weight: normal;">- {{ $pedido->created_at->format('d/m/Y H:i') }}</span></h5>
                    </div>
                    <div class="col-md-6 col-12 text-md-end">
                        <span class="status-badge {{ $pedido->estado === 'confirmado' ? 'bg-confirmed' : 'bg-pending' }}">
                            <i class="bi {{ $pedido->estado === 'confirmado' ? 'bi-check-circle-fill' : 'bi-clock-fill' }} me-1"></i>
                            {{ $pedido->estado === 'confirmado' ? 'Pago Aprobado' : 'Pendiente de Aprobación' }}
                        </span>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Productos e Info -->
                    <div class="col-lg-8">
                        <h6 class="fw-bold text-uppercase text-muted small mb-3">Productos Adquiridos</h6>
                        
                        <div class="table-responsive">
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
                    </div>

                    <!-- Datos y Totales -->
                    <div class="col-lg-4 border-start">
                        <div class="ps-lg-3">
                            <h6 class="fw-bold text-uppercase text-muted small mb-3">Detalles de Entrega</h6>
                            
                            <p class="small text-dark mb-1"><strong>Destinatario:</strong> {{ $pedido->cliente_nombre }}</p>
                            <p class="small text-dark mb-1"><strong>Teléfono:</strong> {{ $pedido->cliente_telefono }}</p>
                            <p class="small text-dark mb-3"><strong>Dirección:</strong> {{ $pedido->direccion_entrega }}</p>
                            
                            <hr class="my-3">
                            
                            <p class="small text-dark mb-2"><strong>Método de Pago:</strong> 
                                @if($pedido->metodo_pago === 'mercado_pago')
                                    <span class="badge bg-info text-white">Mercado Pago</span>
                                    <span class="d-block text-muted small mt-1" style="font-size: 0.65rem;">Ref: #{{ $pedido->mp_payment_id }}</span>
                                @else
                                    <span class="badge bg-primary text-white">Transferencia Bancaria</span>
                                    @if($pedido->comprobante)
                                        <a href="{{ $pedido->comprobante }}" target="_blank" class="d-block text-danger fw-bold small mt-2">
                                            <i class="bi bi-file-earmark-image me-1"></i> Ver comprobante subido
                                        </a>
                                    @endif
                                @endif
                            </p>
                            
                            <div class="d-flex justify-content-between align-items-center mt-4 p-3 bg-light rounded-3">
                                <span class="fw-bold text-uppercase small text-muted">Total Abonado</span>
                                <h4 class="fw-bold text-dark m-0">${{ number_format($pedido->total, 2, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5 shadow-sm bg-white rounded-4 border">
                <i class="bi bi-receipt-cutoff text-muted" style="font-size: 4rem;"></i>
                <h5 class="fw-bold mt-3">No tienes compras registradas</h5>
                <p class="text-muted">Explora nuestro catálogo para encontrar tus suplementos preferidos y comenzar a entrenar fuerte.</p>
                <a href="{{ route('catalogo') }}" class="btn btn-danger rounded-pill fw-bold px-4 text-uppercase mt-2 shadow-sm">
                    Ir al Catálogo
                </a>
            </div>
        @endforelse
    </div>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
