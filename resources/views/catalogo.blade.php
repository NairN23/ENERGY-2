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
            text-decoration: none;
        }

        .btn-add:hover {
            background-color: #ff0000;
            transform: scale(1.1);
            color: white;
        }
    </style>
</head>
<body>

    @include('partials.navbar')

    <div class="container py-5">
        @php use Illuminate\Support\Str; @endphp

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold mb-1">Catálogo de Suplementos</h1>
                <p class="text-muted mb-0">Todos los productos disponibles en ENERGY con sus categorías y precios actualizados.</p>
            </div>
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.index') }}" class="btn btn-danger rounded-pill px-4 fw-bold">Ir al Panel</a>
                @endif
            @endauth
        </div>

        @if(isset($productos) && $productos->count())
            @php
                $uniqueCategories = $productos->map(function($p) {
                    return $p->categoria;
                })->filter()->unique('id')->values();
            @endphp

            <!-- FILTRO DE CATEGORÍAS -->
            <div class="d-flex flex-wrap gap-2 mb-4 align-items-center bg-white p-3 shadow-sm" style="border-radius: 12px;">
                <span class="text-uppercase fw-bold small text-muted me-2"><i class="bi bi-funnel-fill text-danger me-1"></i> Filtrar Categorías:</span>
                <button class="btn btn-sm btn-dark rounded-pill px-3 py-1.5 fw-bold text-uppercase filter-btn active" data-category="all" style="font-size: 0.72rem; letter-spacing: 0.5px;">Todos</button>
                @foreach($uniqueCategories as $cat)
                    <button class="btn btn-sm btn-outline-dark rounded-pill px-3 py-1.5 fw-bold text-uppercase filter-btn" data-category="{{ $cat->id }}" style="font-size: 0.72rem; letter-spacing: 0.5px;">{{ $cat->nombre }}</button>
                @endforeach
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                @foreach($productos as $producto)
                    <div class="col product-item" data-category-id="{{ $producto->categoria->id ?? 0 }}" style="transition: opacity 0.25s ease, transform 0.25s ease;">
                        <div class="card product-card shadow-sm h-100">
                            <div class="img-wrapper position-relative">
                                <img src="{{ $producto->imagen ?? '/images/productos/default.png' }}" alt="{{ $producto->nombre }}">
                                @if($producto->destacado)
                                    <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2 fw-bold text-uppercase" style="font-size: 0.65rem; border-radius: 6px; z-index: 2;">Destacado</span>
                                @endif
                                @if($producto->es_combo)
                                    <span class="badge bg-info position-absolute top-0 end-0 m-2 fw-bold text-uppercase text-white" style="font-size: 0.65rem; border-radius: 6px; z-index: 2;">Combo ⚡</span>
                                @endif
                            </div>
                            <div class="card-body p-0">
                                <span class="category-tag">{{ $producto->categoria->nombre ?? 'Suplemento' }}</span>
                                <h6 class="product-name">{{ $producto->nombre }}</h6>
                                <p class="product-description">{{ Str::limit($producto->descripcion ?? 'Sin descripción disponible', 80) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price-text">${{ number_format($producto->precio, 2, ',', '.') }}</span>

                                    @auth
                                        <button class="btn-add add-to-cart" data-name="{{ $producto->nombre }}" data-price="{{ $producto->precio }}">
                                            <i class="bi bi-plus-lg fs-5"></i>
                                        </button>
                                    @endauth
                                    @guest
                                        <a href="{{ route('login') }}" class="btn-add" title="Iniciá sesión para comprar">
                                            <i class="bi bi-lock-fill fs-5"></i>
                                        </a>
                                    @endguest
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-warning mt-4" role="alert">
                No hay productos disponibles en el catálogo por el momento. Por favor, intenta nuevamente más tarde.
            </div>
        @endif
    </div>

    @include('partials.footer')

    <script>
        // CATEGORY FILTER LOGIC
        document.querySelectorAll('.filter-btn').forEach(button => {
            button.addEventListener('click', () => {
                // Remove active classes
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    btn.classList.remove('active', 'btn-dark');
                    btn.classList.add('btn-outline-dark');
                });
                
                // Set active to clicked
                button.classList.add('active', 'btn-dark');
                button.classList.remove('btn-outline-dark');
                
                const selectedCategory = button.getAttribute('data-category');
                
                document.querySelectorAll('.product-item').forEach(item => {
                    const itemCategory = item.getAttribute('data-category-id');
                    
                    if (selectedCategory === 'all' || itemCategory === selectedCategory) {
                        item.style.display = 'block';
                        setTimeout(() => {
                            item.style.opacity = '1';
                            item.style.transform = 'scale(1)';
                        }, 20);
                    } else {
                        item.style.opacity = '0';
                        item.style.transform = 'scale(0.95)';
                        setTimeout(() => {
                            item.style.display = 'none';
                        }, 200);
                    }
                });
            });
        });

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