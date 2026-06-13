<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENERGY - Confirmar Compra</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #fcfaf8; font-family: sans-serif; }
        .checkout-box { background: white; border-radius: 20px; padding: 30px; border: 1px solid #eee; }
        .summary-box { background: #000; color: #fff; border-radius: 20px; padding: 25px; }
        .product-item { border-bottom: 1px solid #333; padding: 12px 0; }
        .product-item:last-child { border-bottom: none; }
        .bank-details { background: #f8f9fa; border: 1px dashed #ccc; border-radius: 12px; padding: 15px; display: none; }
        .mp-details { display: none; }
        .btn-mp { background-color: #009ee3; color: white; border: none; font-weight: bold; border-radius: 8px; transition: 0.3s; }
        .btn-mp:hover { background-color: #007eb5; }
        /* Toast de notificación personalizado */
        .energy-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 320px;
            max-width: 420px;
            padding: 16px 20px;
            border-radius: 14px;
            color: #fff;
            font-size: 0.88rem;
            font-weight: 600;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transform: translateX(120%);
            transition: transform 0.4s cubic-bezier(0.22, 1, 0.36, 1), opacity 0.4s ease;
            opacity: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .energy-toast.show { transform: translateX(0); opacity: 1; }
        .energy-toast.success { background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border-left: 4px solid #28a745; }
        .energy-toast.error { background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border-left: 4px solid #ff0000; }
        .energy-toast .toast-icon { font-size: 1.3rem; flex-shrink: 0; }
        .energy-toast .toast-close { margin-left: auto; background: none; border: none; color: rgba(255,255,255,0.6); font-size: 1.1rem; cursor: pointer; padding: 0 0 0 10px; flex-shrink: 0; }
        .energy-toast .toast-close:hover { color: #fff; }
    </style>
</head>
<body>

    <!-- Toast de notificación personalizado -->
    <div id="energyToast" class="energy-toast">
        <span class="toast-icon" id="toastIcon"></span>
        <span id="toastMessage"></span>
        <button class="toast-close" onclick="cerrarToast()">&times;</button>
    </div>

    @include('partials.navbar')

    <div class="container py-5">
        <h2 class="fw-bold text-uppercase mb-4 italic"><i class="bi bi-credit-card me-2 text-danger"></i>Finalizar <span class="text-danger">Compra</span></h2>

        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <p class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i> Por favor corrige los siguientes errores:</p>
                <ul class="mb-0 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-4">
            <!-- COLUMNA IZQUIERDA: FORMULARIO -->
            <div class="col-lg-7">
                <div class="checkout-box shadow-sm">
                    <form action="{{ route('compra.guardar') }}" method="POST" enctype="multipart/form-data" id="checkoutForm">
                        @csrf
                        
                        <!-- Datos de Envío -->
                        <h5 class="fw-bold mb-3 text-uppercase"><i class="bi bi-geo-alt me-2 text-danger"></i>Datos de Envío</h5>
                        
                        @auth
                            @php
                                $direccionesGuardadas = auth()->user()->direcciones ?? collect();
                            @endphp
                            @if($direccionesGuardadas->count() > 0)
                                <div class="mb-3 p-3 bg-light rounded-3 border">
                                    <label for="direccion_guardada_id" class="form-label small fw-bold text-muted text-uppercase">Direcciones Guardadas</label>
                                    <div class="d-flex gap-2">
                                        <select id="direccion_guardada_id" class="form-select form-select-sm" style="border-radius: 10px;" onchange="cargarDireccionGuardada()">
                                            <option value="">-- Seleccionar una dirección guardada --</option>
                                            @foreach($direccionesGuardadas as $dir)
                                                <option value="{{ $dir->id }}" 
                                                        data-nombre="{{ $dir->cliente_nombre }}" 
                                                        data-telefono="{{ $dir->cliente_telefono }}" 
                                                        data-email="{{ $dir->cliente_email }}" 
                                                        data-direccion="{{ $dir->direccion_entrega }}">
                                                    {{ $dir->direccion_entrega }} (Tel: {{ $dir->cliente_telefono }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="eliminarDireccionGuardada()" title="Eliminar dirección" style="border-radius: 10px;">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        @endauth

                        @auth
                            @php
                                $ultimaDireccion = auth()->user()->direcciones()->latest()->first();
                            @endphp
                        @endauth

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cliente_nombre" class="form-label small fw-bold text-muted">Nombre Completo</label>
                                <input type="text" name="cliente_nombre" id="cliente_nombre" class="form-control" style="border-radius: 10px;" value="{{ old('cliente_nombre', auth()->user()->name ?? '') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cliente_telefono" class="form-label small fw-bold text-muted">Teléfono de Contacto</label>
                                <input type="text" name="cliente_telefono" id="cliente_telefono" class="form-control" style="border-radius: 10px;" placeholder="Ej: 3794123456" value="{{ old('cliente_telefono', $ultimaDireccion->cliente_telefono ?? '') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="cliente_email" class="form-label small fw-bold text-muted">Correo Electrónico</label>
                            <input type="email" name="cliente_email" id="cliente_email" class="form-control" style="border-radius: 10px;" value="{{ old('cliente_email', auth()->user()->email ?? '') }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="direccion_entrega" class="form-label small fw-bold text-muted">Dirección de Entrega</label>
                            <textarea name="direccion_entrega" id="direccion_entrega" rows="2" class="form-control" style="border-radius: 10px;" placeholder="Calle, número, barrio y localidad" required>{{ old('direccion_entrega', $ultimaDireccion->direccion_entrega ?? '') }}</textarea>
                        </div>

                        <hr class="my-4">

                        <!-- Forma de Pago -->
                        <h5 class="fw-bold mb-3 text-uppercase"><i class="bi bi-wallet2 me-2 text-danger"></i>Forma de Pago</h5>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted d-block">Seleccioná cómo deseas pagar</label>
                            
                            <div class="form-check form-check-inline p-3 border rounded-3 w-100 mb-2" style="cursor: pointer;" onclick="seleccionarMetodo('transferencia')">
                                <input class="form-check-input ms-1" type="radio" name="metodo_pago" id="pago_transferencia" value="transferencia" required>
                                <label class="form-check-label fw-bold ms-2" for="pago_transferencia">
                                    <i class="bi bi-bank text-primary me-2"></i> Transferencia Bancaria (Descuento 10%)
                                </label>
                            </div>
                            
                            <div class="form-check form-check-inline p-3 border rounded-3 w-100 mb-2" style="cursor: pointer;" onclick="seleccionarMetodo('mercado_pago')">
                                <input class="form-check-input ms-1" type="radio" name="metodo_pago" id="pago_mp" value="mercado_pago">
                                <label class="form-check-label fw-bold ms-2" for="pago_mp">
                                    <i class="bi bi-wallet-fill text-info me-2"></i> Mercado Pago (Pago inmediato)
                                </label>
                            </div>

                            <div class="form-check form-check-inline p-3 border rounded-3 w-100" style="cursor: pointer;" onclick="seleccionarMetodo('whatsapp')">
                                <input class="form-check-input ms-1" type="radio" name="metodo_pago" id="pago_whatsapp" value="whatsapp">
                                <label class="form-check-label fw-bold ms-2" for="pago_whatsapp">
                                    <i class="bi bi-whatsapp text-success me-2"></i> Finalizar por WhatsApp (Coordinar envío)
                                </label>
                            </div>
                        </div>

                        <!-- Detalles Transferencia -->
                        <div class="bank-details mb-4 mt-3" id="bankDetailsBox">
                            <p class="small mb-2 fw-bold text-dark">Detalles para realizar la transferencia:</p>
                            <div class="small text-muted mb-3">
                                <strong>Banco:</strong> Galicia<br>
                                <strong>CBU:</strong> 0070089020000012345678<br>
                                <strong>Alias:</strong> ENERGY.NUTRICION.MP<br>
                                <strong>Titular:</strong> ENERGY SRL
                            </div>
                            
                            <label for="comprobante" class="form-label text-danger small fw-bold" style="letter-spacing: 0.05em;">
                                <i class="bi bi-upload me-1"></i> Subir Comprobante de Pago (Únicamente PDF)
                            </label>
                            <input class="form-control mb-2" type="file" name="comprobante" id="comprobante" accept=".pdf">
                            <small class="text-muted" style="font-size: 0.7rem;">Sube el archivo PDF del comprobante para agilizar la aprobación del pedido.</small>
                            <div id="comprobanteError" class="text-danger small fw-bold mt-1" style="display: none;">
                                <i class="bi bi-exclamation-circle me-1"></i> El archivo debe ser en formato PDF únicamente. Por favor seleccioná otro archivo.
                            </div>
                        </div>

                        <!-- Detalles Mercado Pago -->
                        <div class="mp-details mb-4 mt-3 text-center" id="mpDetailsBox">
                            <div class="alert alert-info border-0 py-3" style="border-radius: 10px;">
                                <i class="bi bi-lightning-charge-fill me-1 text-warning animate-bounce"></i> Pagando con Mercado Pago tu compra impacta instantáneamente en nuestro sistema.
                            </div>
                            <button type="button" class="btn btn-mp w-100 py-3 text-uppercase shadow-sm" onclick="simularPagoMercadoPago()">
                                <i class="bi bi-credit-card-2-back me-2"></i> Pagar con Mercado Pago
                            </button>
                            <div id="mpSuccessMsg" class="mt-3 text-success fw-bold d-none">
                                <i class="bi bi-check-circle-fill me-1"></i> Pago aprobado por Mercado Pago. Ref: #<span id="mpRefId"></span>
                            </div>
                        </div>

                        <!-- Detalles WhatsApp -->
                        <div class="alert alert-success border-0 py-3 mb-4 mt-3" id="whatsappDetailsBox" style="border-radius: 10px; display: none;">
                            <i class="bi bi-whatsapp me-2 fs-5"></i> Al finalizar el pedido, serás redirigido a WhatsApp para enviar el comprobante y coordinar de forma personalizada.
                        </div>

                        <!-- Datos Ocultos del Carrito -->
                        <input type="hidden" name="carrito_data" id="carrito_data">
                        <input type="hidden" name="mp_payment_id" id="mp_payment_id">

                        <button type="submit" class="btn btn-danger w-100 py-3 fw-bold text-uppercase rounded-pill shadow mt-2" id="btnSubmitForm">
                            Confirmar Compra
                        </button>
                    </form>
                </div>
            </div>

            <!-- COLUMNA DERECHA: RESUMEN DEL CARRITO -->
            <div class="col-lg-5">
                <div class="summary-box shadow">
                    <h5 class="fw-bold mb-4 text-uppercase border-bottom pb-2" style="font-size: 0.9rem; letter-spacing: 1px;">Detalle de Compra</h5>
                    
                    <div id="checkout-items-list" class="mb-4"></div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span style="color: #b0b0b0; font-weight: 600;">Subtotal</span>
                        <span id="checkout-subtotal" class="fw-bold">$0</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span style="color: #b0b0b0; font-weight: 600;">Descuento</span>
                        <span id="checkout-discount" class="fw-bold" style="color: #ffc107;">$0</span>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span style="color: #b0b0b0; font-weight: 600;">Envío</span>
                        <span class="fw-bold" style="color: #28a745;">Gratis</span>
                    </div>
                    <hr class="border-secondary">
                    
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold fs-5">Total a Pagar</span>
                        <span class="fw-bold fs-5 text-danger" id="checkout-total">$0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DE SIMULACIÓN MERCADO PAGO -->
    <div class="modal fade" id="mpSimulationModal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none;">
                <div class="modal-header text-white border-0" style="background-color: #009ee3;">
                    <h6 class="modal-title fw-bold text-uppercase m-0"><i class="bi bi-wallet2 me-2"></i>Mercado Pago Sandbox</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <img src="https://logodownload.org/wp-content/uploads/2019/06/mercado-pago-logo.png" class="mb-4" height="40" alt="Mercado Pago">
                    
                    <h5 class="fw-bold mb-3">ENERGY - Sports Nutrition</h5>
                    <p class="text-muted small">Monto a abonar: <span class="fw-bold text-dark fs-5" id="mpModalMonto"></span></p>
                    
                    <div class="card p-3 mb-4 bg-light border-0" style="border-radius: 12px;">
                        <div class="text-start mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase mb-1">Número de Tarjeta</label>
                            <input type="text" class="form-control form-control-sm" placeholder="4509 9500 1234 5678" value="4509 9500 1234 5678" disabled>
                        </div>
                        <div class="row">
                            <div class="col-6 text-start">
                                <label class="form-label small fw-bold text-muted text-uppercase mb-1">Vencimiento</label>
                                <input type="text" class="form-control form-control-sm" value="12/29" disabled>
                            </div>
                            <div class="col-6 text-start">
                                <label class="form-label small fw-bold text-muted text-uppercase mb-1">CVV</label>
                                <input type="text" class="form-control form-control-sm" value="123" disabled>
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" class="btn btn-mp w-100 py-3 rounded-pill text-uppercase shadow" onclick="confirmarPagoSimulado()">
                        Pagar de forma segura
                    </button>
                    <p class="text-muted small mt-2" style="font-size: 0.65rem;">Esta es una pasarela de pago segura de prueba.</p>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let cartTotal = 0;

        function cargarDireccionGuardada() {
            const select = document.getElementById('direccion_guardada_id');
            if (!select) return;
            const option = select.options[select.selectedIndex];
            if (!option || !option.value) return;

            document.getElementById('cliente_nombre').value = option.getAttribute('data-nombre') || '';
            document.getElementById('cliente_telefono').value = option.getAttribute('data-telefono') || '';
            document.getElementById('cliente_email').value = option.getAttribute('data-email') || '';
            document.getElementById('direccion_entrega').value = option.getAttribute('data-direccion') || '';
        }

        function eliminarDireccionGuardada() {
            const select = document.getElementById('direccion_guardada_id');
            if (!select) return;
            const id = select.value;
            if (!id) {
                mostrarToastCheckout('Por favor seleccioná una dirección guardada para eliminar.', 'error');
                return;
            }

            if (confirm('¿Seguro deseas eliminar esta dirección guardada?')) {
                fetch(`/direcciones/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        mostrarToastCheckout(data.message || 'Dirección eliminada correctamente.', 'success');
                        location.reload();
                    } else {
                        mostrarToastCheckout('Error al eliminar la dirección.', 'error');
                    }
                })
                .catch(err => {
                    console.error(err);
                    mostrarToastCheckout('Error en la solicitud.', 'error');
                });
            }
        }

        function renderCheckoutCart() {
            const cart = JSON.parse(localStorage.getItem('energy_cart')) || [];
            const container = document.getElementById('checkout-items-list');
            const subtotalEl = document.getElementById('checkout-subtotal');
            const totalEl = document.getElementById('checkout-total');
            const discountEl = document.getElementById('checkout-discount');

            if (cart.length === 0) {
                container.innerHTML = '<p class="small text-muted py-3">Tu carrito está vacío.</p>';
                return;
            }

            // Guardamos el JSON stringificado del carrito en el input oculto
            document.getElementById('carrito_data').value = JSON.stringify(cart);

            let html = '';
            cartTotal = 0;

            cart.forEach(item => {
                const price = parseFloat(item.price);
                const qty = parseInt(item.cantidad || 1);
                const itemSubtotal = price * qty;
                cartTotal += itemSubtotal;
                html += `
                <div class="product-item d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0 fw-bold text-uppercase" style="font-size: 0.8rem;">${item.name}</h6>
                        <span class="text-white-50" style="font-size: 0.72rem;">${qty} x $${price.toLocaleString()}</span>
                    </div>
                    <span class="fw-bold">$${itemSubtotal.toLocaleString()}</span>
                </div>
                `;
            });

            container.innerHTML = html;
            subtotalEl.innerText = `$${cartTotal.toLocaleString()}`;

            // Calculamos descuento si es transferencia
            const isTransfer = document.getElementById('pago_transferencia').checked;
            let discount = 0;
            if (isTransfer) {
                discount = cartTotal * 0.10;
            }
            discountEl.innerText = discount > 0 ? `-$${discount.toLocaleString()}` : '$0';
            
            const finalTotal = cartTotal - discount;
            totalEl.innerText = `$${finalTotal.toLocaleString()}`;
        }

        function seleccionarMetodo(metodo) {
            const radioTransfer = document.getElementById('pago_transferencia');
            const radioMP = document.getElementById('pago_mp');
            const radioWA = document.getElementById('pago_whatsapp');
            
            const bankBox = document.getElementById('bankDetailsBox');
            const mpBox = document.getElementById('mpDetailsBox');
            const waBox = document.getElementById('whatsappDetailsBox');
            const inputComprobante = document.getElementById('comprobante');

            if (metodo === 'transferencia') {
                radioTransfer.checked = true;
                if(radioMP) radioMP.checked = false;
                if(radioWA) radioWA.checked = false;
                bankBox.style.display = 'block';
                mpBox.style.display = 'none';
                if(waBox) waBox.style.display = 'none';
                inputComprobante.required = true;
                document.getElementById('btnSubmitForm').style.display = 'block';
            } else if (metodo === 'mercado_pago') {
                if(radioTransfer) radioTransfer.checked = false;
                radioMP.checked = true;
                if(radioWA) radioWA.checked = false;
                bankBox.style.display = 'none';
                mpBox.style.display = 'block';
                if(waBox) waBox.style.display = 'none';
                inputComprobante.required = false;
                inputComprobante.value = ''; // Limpiar archivo cacheado
                document.getElementById('comprobanteError').style.display = 'none';
                // Ocultamos el botón principal porque el usuario debe hacer click en Pagar con Mercado Pago primero
                document.getElementById('btnSubmitForm').style.display = 'none';
                // Aseguramos que el botón de MP esté visible si cambió de opinión antes
                const btnMP = document.querySelector('#mpDetailsBox .btn-mp');
                if (btnMP) btnMP.style.display = 'block';
            } else if (metodo === 'whatsapp') {
                if(radioTransfer) radioTransfer.checked = false;
                if(radioMP) radioMP.checked = false;
                radioWA.checked = true;
                bankBox.style.display = 'none';
                mpBox.style.display = 'none';
                if(waBox) waBox.style.display = 'block';
                inputComprobante.required = false;
                inputComprobante.value = ''; // Limpiar archivo cacheado
                document.getElementById('comprobanteError').style.display = 'none';
                document.getElementById('btnSubmitForm').style.display = 'block';
            }

            renderCheckoutCart();
        }

        // Simulación Mercado Pago
        let mpModal;
        function simularPagoMercadoPago() {
            const form = document.getElementById('checkoutForm');
            // Validar que los campos obligatorios estén llenos antes de simular el pago
            if (!form.reportValidity()) {
                return;
            }
            
            document.getElementById('mpModalMonto').innerText = `$${cartTotal.toLocaleString()}`;
            mpModal = new bootstrap.Modal(document.getElementById('mpSimulationModal'));
            mpModal.show();
        }

        function confirmarPagoSimulado() {
            mpModal.hide();
            const paymentId = 'MP-' + Math.floor(Math.random() * 10000000);
            document.getElementById('mp_payment_id').value = paymentId;
            
            const msgEl = document.getElementById('mpSuccessMsg');
            document.getElementById('mpRefId').innerText = paymentId;
            msgEl.classList.remove('d-none');

            // Ocultar el botón de Pagar con MP ya que se realizó el pago
            const btnMP = document.querySelector('#mpDetailsBox .btn-mp');
            if (btnMP) btnMP.style.display = 'none';

            // Mostrar nuevamente el botón Confirmar Compra por si falla la validación automática
            document.getElementById('btnSubmitForm').style.display = 'block';

            // Validar que los campos requeridos estén completos antes de enviar automáticamente
            const form = document.getElementById('checkoutForm');
            const nombre = document.getElementById('cliente_nombre').value.trim();
            const telefono = document.getElementById('cliente_telefono').value.trim();
            const email = document.getElementById('cliente_email').value.trim();
            const direccion = document.getElementById('direccion_entrega').value.trim();
            
            if (nombre && telefono && email && direccion) {
                // Todos los datos están completos, enviar directamente
                form.submit();
            }
            // Si falta algún dato, el usuario debe completarlo y luego dar click en Confirmar
        }

        // Validación final
        document.getElementById('checkoutForm').addEventListener('submit', function(e) {
            const cart = JSON.parse(localStorage.getItem('energy_cart')) || [];
            if (cart.length === 0) {
                e.preventDefault();
                mostrarToastCheckout('No puedes procesar una compra con el carrito vacío.', 'error');
                return;
            }

            const radioMP = document.getElementById('pago_mp').checked;
            const paymentId = document.getElementById('mp_payment_id').value;

            if (radioMP && !paymentId) {
                e.preventDefault();
                mostrarToastCheckout('Debes completar el pago seguro con Mercado Pago antes de confirmar el pedido.', 'error');
                return;
            }

            const isTransfer = document.getElementById('pago_transferencia').checked;
            if (isTransfer) {
                const fileInput = document.getElementById('comprobante');
                if (fileInput.files.length > 0) {
                    const file = fileInput.files[0];
                    if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
                        e.preventDefault();
                        document.getElementById('comprobanteError').style.display = 'block';
                        fileInput.value = '';
                        return;
                    }
                }
            }
        });

        // Validación instantánea del formato del comprobante al seleccionar archivo
        function validarComprobante(input) {
            const errorDiv = document.getElementById('comprobanteError');
            if (input.files.length > 0) {
                const file = input.files[0];
                if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
                    errorDiv.style.display = 'block';
                    input.value = '';
                } else {
                    errorDiv.style.display = 'none';
                }
            } else {
                errorDiv.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            renderCheckoutCart();
            
            const urlParams = new URLSearchParams(window.location.search);
            const metodo = urlParams.get('metodo');
            if (metodo === 'whatsapp') {
                seleccionarMetodo('whatsapp');
            } else if (metodo === 'mercado_pago') {
                seleccionarMetodo('mercado_pago');
            } else {
                seleccionarMetodo('transferencia');
            }
        });

        // Sistema de Toast/Notificación personalizado
        let toastTimeout;
        function mostrarToastCheckout(mensaje, tipo) {
            const toast = document.getElementById('energyToast');
            const icon = document.getElementById('toastIcon');
            const msg = document.getElementById('toastMessage');
            
            toast.className = 'energy-toast ' + tipo;
            icon.innerHTML = tipo === 'success' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-exclamation-triangle-fill text-danger"></i>';
            msg.textContent = mensaje;
            
            setTimeout(() => toast.classList.add('show'), 10);
            
            clearTimeout(toastTimeout);
            toastTimeout = setTimeout(() => cerrarToast(), 3500);
        }
        
        function cerrarToast() {
            const toast = document.getElementById('energyToast');
            toast.classList.remove('show');
        }
    </script>
</body>
</html>
