<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energy - Catálogo de Suplementos</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        /* Estilos de fondo y tipografía */
        body { background-color: #f8f9fa; font-family: sans-serif; color: #333; }

        /* Tarjeta de producto con efectos de transición */
        .product-card {
            border: none;
            border-radius: 20px; 
            background-color: #fff;
            transition: all 0.3s ease;
            padding: 20px;
        }
        
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        /* Contenedor gris para las imágenes */
        .img-wrapper {
            background-color: #f4f4f4; 
            border-radius: 15px;
            height: 240px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin-bottom: 15px;
        }
        
        .img-wrapper img {
            max-height: 85%;
            max-width: 85%;
            object-fit: contain;
        }

        /* Textos y etiquetas */
        .category-tag {
            font-size: 0.7rem;
            font-weight: 800;
            color: #ff0000;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            display: block;
        }

        .product-name {
            font-size: 1rem;
            font-weight: 700;
            line-height: 1.3;
            height: 2.6em;
            overflow: hidden;
            margin-bottom: 10px;
            color: #1a1a1a;
        }

        .product-description {
            font-size: 0.8rem;
            color: #777;
            height: 3.2em;
            overflow: hidden;
            margin-bottom: 20px;
            line-height: 1.4;
        }

        .price-text {
            font-size: 1.3rem;
            font-weight: 800;
            color: #000;
        }

        /* Botón de añadir (+) */
        .btn-add {
            background-color: #ff4d4d; 
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
        }

        .btn-add:hover {
            background-color: #ff0000;
            transform: scale(1.1);
        }
    </style>
</head>
<body>

    @include('partials.navbar')

    <div class="container py-5">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            
            <div class="col">
                <div class="card product-card shadow-sm h-100">
                    <div class="img-wrapper">
                        <img src="/images/productos/Premium Whey Protein Sta.png" alt="Star Nutrition">
                    </div>
                    <div class="card-body p-0">
                        <span class="category-tag">Proteínas</span>
                        <h6 class="product-name">Premium Whey Protein Star Nutrition 2lb</h6>
                        <p class="product-description">Proteína de suero de máxima pureza para recuperación muscular.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price-text">$38500</span>
                            <button class="btn-add add-to-cart" data-name="Premium Whey Star" data-price="38500">
                                <i class="bi bi-plus-lg fs-5"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card product-card shadow-sm h-100">
                    <div class="img-wrapper">
                        <img src="/images/productos/Creatina Monohidrato.png .png" alt="HTN">
                    </div>
                    <div class="card-body p-0">
                        <span class="category-tag">Fuerza</span>
                        <h6 class="product-name">Creatina Monohidrato HTN 300g</h6>
                        <p class="product-description">Aumenta tu potencia muscular y fuerza explosiva diaria.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price-text">$24000</span>
                            <button class="btn-add add-to-cart" data-name="Creatina HTN" data-price="24000">
                                <i class="bi bi-plus-lg fs-5"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card product-card shadow-sm h-100">
                    <div class="img-wrapper">
                        <img src="/images/productos/Pump V8 Pre-Workout Star Nutrition.png" alt="Star Nutrition">
                    </div>
                    <div class="card-body p-0">
                        <span class="category-tag">Pre-Entreno</span>
                        <h6 class="product-name">Pump V8 Pre-Workout Star Nutrition</h6>
                        <p class="product-description">Fórmula diseñada para máxima energía y vascularización.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price-text">$19500</span>
                            <button class="btn-add add-to-cart" data-name="Pump V8 Star" data-price="19500">
                                <i class="bi bi-plus-lg fs-5"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card product-card shadow-sm h-100">
                    <div class="img-wrapper">
                        <img src="/images/productos/L-Carnitina 1500.png" alt="Gentech">
                    </div>
                    <div class="card-body p-0">
                        <span class="category-tag">Quemadores</span>
                        <h6 class="product-name">L-Carnitina 1500 Gentech Liquida</h6>
                        <p class="product-description">Favorece la movilización de grasas para obtener energía.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price-text">$16800</span>
                            <button class="btn-add add-to-cart" data-name="L-Carnitina Gentech" data-price="16800">
                                <i class="bi bi-plus-lg fs-5"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card product-card shadow-sm h-100">
                    <div class="img-wrapper">
                        <img src="/images/productos/BCAA.png" alt="Star Nutrition">
                    </div>
                    <div class="card-body p-0">
                        <span class="category-tag">Aminoácidos</span>
                        <h6 class="product-name">BCAA 2:1:1 Star Nutrition 200g</h6>
                        <p class="product-description">Mantiene y recupera las fibras musculares fatigadas.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price-text">$17800</span>
                            <button class="btn-add add-to-cart" data-name="BCAA Star" data-price="17800">
                                <i class="bi bi-plus-lg fs-5"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card product-card shadow-sm h-100">
                    <div class="img-wrapper">
                        <img src="/images/productos/Iso Whey Protein.png" alt="ENA">
                    </div>
                    <div class="card-body p-0">
                        <span class="category-tag">Proteínas</span>
                        <h6 class="product-name">Iso Whey Protein ENA Nutrition 2lb</h6>
                        <p class="product-description">Proteína aislada de máxima absorción, baja en sodio.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price-text">$42000</span>
                            <button class="btn-add add-to-cart" data-name="Iso Whey ENA" data-price="42000">
                                <i class="bi bi-plus-lg fs-5"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card product-card shadow-sm h-100">
                    <div class="img-wrapper">
                        <img src="/images/productos/Glutamina.png" alt="ENA">
                    </div>
                    <div class="card-body p-0">
                        <span class="category-tag">Recuperación</span>
                        <h6 class="product-name">Glutamina Micronizada ENA 250g</h6>
                        <p class="product-description">Ideal para evitar el catabolismo y mejorar defensas.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price-text">$21500</span>
                            <button class="btn-add add-to-cart" data-name="Glutamina ENA" data-price="21500">
                                <i class="bi bi-plus-lg fs-5"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card product-card shadow-sm h-100">
                    <div class="img-wrapper">
                        <img src="/images/productos/Multivitamínico .png" alt="Gentech">
                    </div>
                    <div class="card-body p-0">
                        <span class="category-tag">Salud</span>
                        <h6 class="product-name">Multivitamínico Daily Complete</h6>
                        <p class="product-description">Aporta todos los micronutrientes para el día a día.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price-text">$14500</span>
                            <button class="btn-add add-to-cart" data-name="Multivitamin" data-price="14500">
                                <i class="bi bi-plus-lg fs-5"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('partials.footer')

    <script>
        /**
         * Lógica del carrito:
         * Guarda en el LocalStorage el nombre y precio del producto al hacer clic.
         */
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', () => {
                const name = button.getAttribute('data-name');
                const price = button.getAttribute('data-price');
                let cart = JSON.parse(localStorage.getItem('energy_cart')) || [];
                cart.push({ name, price });
                localStorage.setItem('energy_cart', JSON.stringify(cart));
                if (typeof syncCartBadge === 'function') syncCartBadge();
                alert('¡' + name + ' agregado!');
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>