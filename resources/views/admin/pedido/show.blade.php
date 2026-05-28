@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Detalles del Pedido #{{ $pedido->id }}</h5>
                </div>
                <div class="card-body">
                    <!-- Información General -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase small">Cuenta Registrada</h6>
                            <p class="fw-bold m-0">{{ $pedido->user->name }}</p>
                            <p class="text-muted small">{{ $pedido->user->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase small">Fecha del Pedido</h6>
                            <p class="fw-bold">{{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <!-- Datos de Entrega y Pago -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase small text-danger fw-bold">Detalles de Envío</h6>
                            <p class="mb-1"><strong>Destinatario:</strong> {{ $pedido->cliente_nombre ?? $pedido->user->name }}</p>
                            <p class="mb-1"><strong>Teléfono:</strong> {{ $pedido->cliente_telefono ?? 'Sin Registrar' }}</p>
                            <p class="mb-1"><strong>Email Envío:</strong> {{ $pedido->cliente_email ?? $pedido->user->email }}</p>
                            <p class="mb-0"><strong>Dirección:</strong> {{ $pedido->direccion_entrega ?? 'Sin Registrar' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase small text-danger fw-bold">Método y Prueba de Pago</h6>
                            <p class="mb-1"><strong>Método:</strong> 
                                @if($pedido->metodo_pago === 'mercado_pago')
                                    <span class="badge bg-info text-white">Mercado Pago</span>
                                @else
                                    <span class="badge bg-primary text-white">Transferencia Bancaria</span>
                                @endif
                            </p>
                            @if($pedido->metodo_pago === 'mercado_pago')
                                <p class="small text-muted mb-0"><strong>ID Pago MP:</strong> {{ $pedido->mp_payment_id }}</p>
                            @endif
                            @if($pedido->comprobante)
                                <div class="mt-2">
                                    <a href="{{ $pedido->comprobante }}" target="_blank" class="btn btn-xs btn-outline-danger d-inline-flex align-items-center gap-1 py-1 px-2 fw-bold" style="font-size: 0.72rem; border-radius: 8px;">
                                        <i class="bi bi-file-earmark-image"></i> Ver Comprobante
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Estado del Pedido -->
                    <div class="mb-4">
                        <h6 class="text-muted text-uppercase small">Estado Actual</h6>
                        <form action="{{ route('admin.pedidos.estado', $pedido->id) }}" method="POST" class="d-flex gap-2">
                            @csrf
                            @method('PATCH')
                            <select name="estado" class="form-select form-select-sm w-auto">
                                <option value="pendiente" {{ $pedido->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="confirmado" {{ $pedido->estado === 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                                <option value="enviado" {{ $pedido->estado === 'enviado' ? 'selected' : '' }}>Enviado</option>
                                <option value="entregado" {{ $pedido->estado === 'entregado' ? 'selected' : '' }}>Entregado</option>
                                <option value="cancelado" {{ $pedido->estado === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-danger">Actualizar</button>
                        </form>
                    </div>

                    <!-- Productos del Pedido -->
                    <h6 class="text-muted text-uppercase small mb-3">Productos</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pedido->detalles as $detalle)
                                    <tr>
                                        <td>{{ $detalle->producto->nombre }}</td>
                                        <td>{{ $detalle->cantidad }}</td>
                                        <td>${{ number_format($detalle->precio_unitario, 2) }}</td>
                                        <td class="fw-bold">${{ number_format($detalle->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Total -->
                    <div class="row mt-4">
                        <div class="col-md-6 ms-auto">
                            <div class="card bg-light border-0">
                                <div class="card-body d-flex justify-content-between">
                                    <strong>Total del Pedido:</strong>
                                    <strong class="text-danger" style="font-size: 1.3em;">${{ number_format($pedido->total, 2) }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Descripción -->
                    @if($pedido->descripcion)
                        <div class="mt-4">
                            <h6 class="text-muted text-uppercase small">Observaciones</h6>
                            <p class="text-muted">{{ $pedido->descripcion }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <a href="{{ route('admin.index') }}" class="btn btn-outline-danger w-100">
                        <i class="bi bi-arrow-left"></i> Volver al Panel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
