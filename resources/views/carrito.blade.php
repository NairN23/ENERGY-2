<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energy - Mi Carrito</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #fcfaf8; font-family: sans-serif; }
        .cart-container { background: white; border-radius: 20px; padding: 30px; border: 1px solid #eee; }
        .btn-remove { color: #ff0000; cursor: pointer; font-size: 0.7rem; transition: 0.3s; }
        .btn-remove:hover { text-decoration: underline; }
        .summary-box { background: #fff; border-radius: 20px; padding: 25px; border: 1px solid #eee; }
        .product-item { border-bottom: 1px solid #f1f1f1; padding: 15px 0; }
        .product-item:last-child { border-bottom: none; }
    </style>
</head>
<body>

    @include('partials.navbar')

    <div class="container py-5">
        <h2 class="fw-bold text-uppercase mb-4 italic" style="letter-spacing: -1px;">Tu <span class="text-danger">Carrito</span></h2>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="cart-container shadow-sm">
                    <div id="cart-items-list"></div>
                    
                    <div id="cart-actions-container" class="mt-4 pt-3 border-top" style="display: none;">
                        <form action="{{ route('carrito.vaciar') }}" method="POST" id="formVaciarCarrito">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger px-3 py-2 fw-bold" style="border-radius: 10px; font-size: 0.78rem; letter-spacing: 0.03em;">
                                <i class="bi bi-trash3-fill me-1"></i> VACIAR CARRITO COMPLETAMENTE
                            </button>
                        </form>
                    </div>
                    
                    <div id="empty-cart-msg" style="display: none;" class="text-center py-5">
                        <i class="bi bi-cart-x display-1 text-muted"></i>
                        <p class="mt-3 lead">Tu carrito está vacío.</p>
                        <a href="/catalogo" class="btn btn-danger rounded-pill px-4 fw-bold">VOLVER AL CATÁLOGO</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="summary-box shadow-sm">
                    <h5 class="fw-bold mb-4 text-uppercase" style="font-size: 0.9rem; letter-spacing: 1px;">Resumen de compra</h5>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span id="subtotal" class="fw-bold">$0</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Envío (NEA)</span>
                        <span class="text-success fw-bold">Gratis</span>
                    </div>
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold fs-5">Total</span>
                        <span class="fw-bold fs-5 text-danger" id="total">$0</span>
                    </div>
                    
                    <a href="{{ route('compra.confirmar') }}" class="btn btn-danger w-100 py-3 fw-bold rounded-pill text-uppercase shadow" id="btnCheckoutOnline">
                        <i class="bi bi-credit-card-2-back me-2"></i> Iniciar Compra / Pagar
                    </a>
                    
                    <p class="text-center text-muted mt-3" style="font-size: 0.7rem;">
                        Inicia el registro de tu compra de forma segura y elige tu método de pago preferido.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        /**
         * SINCRONIZACIÓN CON BASE DE DATOS MARIADB
         * Al cargar la página, si Laravel envió productos guardados de la sesión,
         * los inyectamos en el localStorage para que persistan correctamente.
         */
        function inicializarCarritoDesdeBD() {
            @if(isset($carritoBD))
                const carritoDesdeBD = {!! $carritoBD !!};
                
                if (carritoDesdeBD && carritoDesdeBD.length > 0) {
                    // Si hay elementos en la BD, actualizamos el localStorage con lo que recuperó el servidor
                    localStorage.setItem('energy_cart', JSON.stringify(carritoDesdeBD));
                }
            @endif
        }

        /**
         * Lee los productos guardados en el navegador (localStorage)
         * y genera el HTML para mostrarlos en pantalla con cantidades.
         */
        function renderCart() {
            const cart = JSON.parse(localStorage.getItem('energy_cart')) || [];
            const listContainer = document.getElementById('cart-items-list');
            const emptyMsg = document.getElementById('empty-cart-msg');
            const actionsContainer = document.getElementById('cart-actions-container');
            const subtotalEl = document.getElementById('subtotal');
            const totalEl = document.getElementById('total');
            const btnCheckoutOnline = document.getElementById('btnCheckoutOnline');

            if (cart.length === 0) {
                listContainer.innerHTML = '';
                emptyMsg.style.display = 'block';
                actionsContainer.style.display = 'none';
                subtotalEl.innerText = '$0';
                totalEl.innerText = '$0';
                if(btnCheckoutOnline) {
                    btnCheckoutOnline.style.pointerEvents = 'none';
                    btnCheckoutOnline.classList.add('disabled', 'btn-secondary');
                    btnCheckoutOnline.classList.remove('btn-danger');
                }
                return;
            }

            emptyMsg.style.display = 'none';
            actionsContainer.style.display = 'block';
            if(btnCheckoutOnline) {
                btnCheckoutOnline.style.pointerEvents = 'auto';
                btnCheckoutOnline.classList.remove('disabled', 'btn-secondary');
                btnCheckoutOnline.classList.add('btn-danger');
            }
            let html = '';
            let total = 0;

            cart.forEach((item) => {
                const price = parseFloat(item.price);
                const qty = parseInt(item.cantidad || 1);
                const subtotal = price * qty;
                total += subtotal;

                html += `
                <div class="product-item d-flex align-items-center justify-content-between py-3 border-bottom">
                    <div>
                        <h6 class="mb-0 fw-bold text-uppercase" style="font-size: 0.85rem;">${item.name}</h6>
                        <small class="text-muted">Unidad: $${price.toLocaleString()}</small>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="input-group input-group-sm bg-light rounded-pill px-2 py-1" style="max-width: 100px; border: 1px solid #ddd;">
                            <button class="btn btn-xs btn-link p-0 text-dark fw-bold border-0" onclick="changeCartQty(${item.id}, -1)" style="font-size: 0.75rem; text-decoration: none; width: 18px; height: 18px; line-height: 1;">-</button>
                            <input type="text" class="form-control text-center p-0 border-0 bg-transparent" value="${qty}" style="width: 32px; font-size: 0.8rem; height: 18px; box-shadow: none;" readonly>
                            <button class="btn btn-xs btn-link p-0 text-dark fw-bold border-0" onclick="changeCartQty(${item.id}, 1)" style="font-size: 0.75rem; text-decoration: none; width: 18px; height: 18px; line-height: 1;">+</button>
                        </div>
                        <div class="text-end" style="min-width: 90px;">
                            <p class="mb-0 fw-bold">$${subtotal.toLocaleString()}</p>
                            <span class="btn-remove fw-bold text-uppercase" onclick="removeItem(${item.id})" style="font-size: 0.7rem;">Eliminar</span>
                        </div>
                    </div>
                </div>
                `;
            });

            listContainer.innerHTML = html;
            subtotalEl.innerText = `$${total.toLocaleString()}`;
            totalEl.innerText = `$${total.toLocaleString()}`;
        }

        /**
         * Cambia la cantidad de un producto en el carrito, validando stock
         */
        function changeCartQty(id, change) {
            let cart = JSON.parse(localStorage.getItem('energy_cart')) || [];
            const itemIndex = cart.findIndex(item => item.id === id);
            if (itemIndex === -1) return;

            const currentQty = parseInt(cart[itemIndex].cantidad || 1);
            const newQty = currentQty + change;
            const stock = parseInt(cart[itemIndex].stock || 9999);

            if (newQty < 1) {
                removeItem(id);
                return;
            }

            if (newQty > stock) {
                alert('No puedes agregar más unidades de las disponibles en stock (Máximo: ' + stock + ').');
                return;
            }

            cart[itemIndex].cantidad = newQty;
            localStorage.setItem('energy_cart', JSON.stringify(cart));
            renderCart();

            // Guardar cambio en base de datos
            fetch("{{ route('carrito.actualizarCantidad') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ producto_id: id, cantidad: newQty })
            })
            .then(res => res.json())
            .then(data => {
                if (typeof syncCartBadge === 'function') syncCartBadge();
            })
            .catch(err => console.error(err));
        }

        /**
         * Elimina un producto del carrito
         */
        function removeItem(id) {
            if (!confirm('¿Seguro deseas eliminar este suplemento de tu carrito?')) return;
            let cart = JSON.parse(localStorage.getItem('energy_cart')) || [];
            const index = cart.findIndex(item => item.id === id);
            if (index !== -1) {
                cart.splice(index, 1);
                localStorage.setItem('energy_cart', JSON.stringify(cart));
            }
            renderCart();
            
            fetch(`/carrito/eliminar/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(() => {
                if(typeof syncCartBadge === 'function') syncCartBadge();
            })
            .catch(err => console.error(err));
        }

        // Al vaciar el carrito por completo limpiamos el almacenamiento del navegador
        document.getElementById('formVaciarCarrito').addEventListener('submit', function(e) {
            localStorage.removeItem('energy_cart');
            if(typeof syncCartBadge === 'function') syncCartBadge();
        });

        /**
         * Redirige al checkout pre-seleccionando WhatsApp
         */
        function enviarPedidoWhatsApp() {
            const cart = JSON.parse(localStorage.getItem('energy_cart')) || [];
            if(cart.length === 0) return alert("Tu carrito está vacío");
            window.location.href = "{{ route('compra.confirmar') }}?metodo=whatsapp";
        }

        // Ejecutar la sincronización y el renderizado apenas cargue el DOM
        document.addEventListener('DOMContentLoaded', () => {
            inicializarCarritoDesdeBD();
            renderCart();
            if(typeof syncCartBadge === 'function') syncCartBadge();
        });
    </script>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>