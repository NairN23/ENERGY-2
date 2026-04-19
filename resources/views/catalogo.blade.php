<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energy - Catálogo de Productos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #ffffff;
            font-family: sans-serif;
            color: #1a1a1a;
        }

        .catalogo-header {
            border-bottom: 2px solid #000;
            margin-bottom: 30px;
            padding-bottom: 10px;
        }

        .product-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
            transition: background 0.2s;
        }

        .product-row:hover {
            background-color: #f9f9f9;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .product-name {
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            margin: 0;
        }

        .product-price {
            font-weight: 800;
            font-size: 1rem;
            color: #000;
        }

        .btn-add-list {
            background: none;
            border: none;
            color: #ff0000;
            font-size: 1.2rem;
            padding: 0 10px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .btn-add-list:hover {
            transform: scale(1.2);
        }

        /* Estilo para que se parezca a tu captura */
        .list-container {
            max-width: 900px;
            margin: 0 auto;
        }
    </style>
</head>

<body>

    @include('partials.navbar')

    <div class="container py-5">
        <div class="list-container">

            <div class="catalogo-header d-flex justify-content-between align-items-end">
                <h2 class="fw-bold text-uppercase m-0">Catálogo <span class="text-danger">2026</span></h2>
                <small class="text-muted fw-bold text-uppercase">Precios sujetos a stock</small>
            </div>

            <div id="productos-lista">
                <div class="product-row">
                    <div class="product-info">
                        <button class="btn-add-list add-to-cart" data-name="Premium Whey Protein Star 2lb"
                            data-price="38500">
                            <i class="bi bi-plus-circle-fill"></i>
                        </button>
                        <h6 class="product-name">Premium Whey Protein Star Nutrition 2lb</h6>
                    </div>
                    <div class="product-price">$38.500</div>
                </div>

                <div class="product-row">
                    <div class="product-info">
                        <button class="btn-add-list add-to-cart" data-name="Creatina Monohidrato HTN 300g"
                            data-price="24000">
                            <i class="bi bi-plus-circle-fill"></i>
                        </button>
                        <h6 class="product-name">Creatina Monohidrato HTN 300g</h6>
                    </div>
                    <div class="product-price">$24.000</div>
                </div>

                <div class="product-row">
                    <div class="product-info">
                        <button class="btn-add-list add-to-cart" data-name="Iso Whey Protein ENA 2lb"
                            data-price="42000">
                            <i class="bi bi-plus-circle-fill"></i>
                        </button>
                        <h6 class="product-name">Iso Whey Protein ENA 2lb</h6>
                    </div>
                    <div class="product-price">$42.000</div>
                </div>

                <div class="product-row">
                    <div class="product-info">
                        <button class="btn-add-list add-to-cart" data-name="Pump V8 Pre-Workout Star"
                            data-price="19500">
                            <i class="bi bi-plus-circle-fill"></i>
                        </button>
                        <h6 class="product-name">Pump V8 Pre-Workout Star Nutrition</h6>
                    </div>
                    <div class="product-price">$19.500</div>
                </div>

                <div class="product-row">
                    <div class="product-info">
                        <button class="btn-add-list add-to-cart" data-name="BCAA 2:1:1 Star Nutrition"
                            data-price="17800">
                            <i class="bi bi-plus-circle-fill"></i>
                        </button>
                        <h6 class="product-name">BCAA 2:1:1 Star Nutrition</h6>
                    </div>
                    <div class="product-price">$17.800</div>
                </div>

                <div class="product-row">
                    <div class="product-info">
                        <button class="btn-add-list add-to-cart" data-name="Glutamina Micronizada ENA"
                            data-price="21500">
                            <i class="bi bi-plus-circle-fill"></i>
                        </button>
                        <h6 class="product-name">Glutamina Micronizada ENA 250g</h6>
                    </div>
                    <div class="product-price">$21.500</div>
                </div>

                <div class="product-row">
                    <div class="product-info">
                        <button class="btn-add-list add-to-cart" data-name="L-Carnitina Liquid Gentech"
                            data-price="16800">
                            <i class="bi bi-plus-circle-fill"></i>
                        </button>
                        <h6 class="product-name">L-Carnitina Liquid 1500 Gentech</h6>
                    </div>
                    <div class="product-price">$16.800</div>
                </div>

                <div class="product-row">
                    <div class="product-info">
                        <button class="btn-add-list add-to-cart" data-name="Multivitamínico Daily Complete"
                            data-price="14500">
                            <i class="bi bi-plus-circle-fill"></i>
                        </button>
                        <h6 class="product-name">Multivitamínico Daily Complete</h6>
                    </div>
                    <div class="product-price">$14.500</div>
                </div>
            </div>

        </div>
    </div>

    @include('partials.footer')

    <script>
        // Lógica para agregar al carrito (se mantiene igual)
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', () => {
                const name = button.getAttribute('data-name');
                const price = button.getAttribute('data-price');
                let cart = JSON.parse(localStorage.getItem('energy_cart')) || [];
                cart.push({ name, price });
                localStorage.setItem('energy_cart', JSON.stringify(cart));

                // Animación simple de confirmación
                button.innerHTML = '<i class="bi bi-check-circle-fill text-success"></i>';
                setTimeout(() => {
                    button.innerHTML = '<i class="bi bi-plus-circle-fill"></i>';
                }, 1000);

                if (typeof syncCartBadge === 'function') syncCartBadge();
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>