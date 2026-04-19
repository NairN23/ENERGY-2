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
                    <div id="cart-items-list">
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
                    
                    <button onclick="enviarPedidoWhatsApp()" class="btn btn-danger w-100 py-3 fw-bold rounded-pill text-uppercase shadow">
                        <i class="bi bi-whatsapp me-2"></i> Finalizar por WhatsApp
                    </button>
                    
                    <p class="text-center text-muted mt-3" style="font-size: 0.7rem;">
                        Al hacer clic, se abrirá un chat con el detalle de tu pedido.
                    </p>
                </div>
            </div>
        </div>
    </div>


    <script>
        function renderCart() {
            const cart = JSON.parse(localStorage.getItem('energy_cart')) || [];
            const listContainer = document.getElementById('cart-items-list');
            const emptyMsg = document.getElementById('empty-cart-msg');
            const subtotalEl = document.getElementById('subtotal');
            const totalEl = document.getElementById('total');

            if (cart.length === 0) {
                listContainer.innerHTML = '';
                emptyMsg.style.display = 'block';
                subtotalEl.innerText = '$0';
                totalEl.innerText = '$0';
                return;
            }

            emptyMsg.style.display = 'none';
            let html = '';
            let total = 0;

            cart.forEach((item, index) => {
                const price = parseFloat(item.price);
                total += price;

                html += `
                <div class="product-item d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-0 fw-bold text-uppercase" style="font-size: 0.85rem;">${item.name}</h6>
                        <small class="text-muted">Unidad: $${price.toLocaleString()}</small>
                    </div>
                    <div class="text-end">
                        <p class="mb-0 fw-bold">$${price.toLocaleString()}</p>
                        <span class="btn-remove fw-bold text-uppercase" onclick="removeItem(${index})">Eliminar</span>
                    </div>
                </div>
                `;
            });

            listContainer.innerHTML = html;
            subtotalEl.innerText = `$${total.toLocaleString()}`;
            totalEl.innerText = `$${total.toLocaleString()}`;
        }

        function removeItem(index) {
            let cart = JSON.parse(localStorage.getItem('energy_cart')) || [];
            cart.splice(index, 1);
            localStorage.setItem('energy_cart', JSON.stringify(cart));
            renderCart();
            if(typeof syncCartBadge === 'function') syncCartBadge();
        }

        function enviarPedidoWhatsApp() {
            const cart = JSON.parse(localStorage.getItem('energy_cart')) || [];
            if(cart.length === 0) return alert("Tu carrito está vacío");

            let mensaje = "¡Hola ENERGY! ⚡ Quiero realizar el siguiente pedido:%0A%0A";
            let total = 0;

            cart.forEach((item, i) => {
                mensaje += `- ${item.name} ($${item.price})%0A`;
                total += parseFloat(item.price);
            });

            mensaje += `%0A*Total: $${total.toLocaleString()}*%0A%0A_¿Me confirmarías stock para coordinar el envío?_`;

            const telefono = "543794576548"; // Tu número real de Energy
            window.open(`https://wa.me/${telefono}?text=${mensaje}`, '_blank');
        }

        document.addEventListener('DOMContentLoaded', renderCart);
    </script>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>