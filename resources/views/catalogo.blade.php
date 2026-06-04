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
                @if(auth()->user()->isAdmin())
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
                                @if($producto->es_combo)
                                    <span class="badge bg-info position-absolute top-0 end-0 m-2 fw-bold text-uppercase text-white" style="font-size: 0.65rem; border-radius: 6px; z-index: 2;">Combo ⚡</span>
                                @endif
                            </div>
                            <div class="card-body p-0">
                                <span class="category-tag">{{ $producto->categoria->nombre ?? 'Suplemento' }}</span>
                                <h6 class="product-name">{{ $producto->nombre }}</h6>
                                <p class="product-description mb-2">{{ Str::limit($producto->descripcion ?? 'Sin descripción disponible', 80) }}</p>
                                
                                @if($producto->es_combo && $producto->productos_combo_collection->count() > 0)
                                    <div class="mb-3 p-2 bg-light rounded-3 border" style="font-size: 0.72rem; line-height: 1.3;">
                                        <div class="fw-bold text-dark mb-1" style="font-size: 0.65rem; letter-spacing: 0.5px; text-transform: uppercase;"><i class="bi bi-gift-fill text-danger me-1"></i>Contiene:</div>
                                        @foreach($producto->productos_combo_collection as $comp)
                                            <div class="text-truncate" title="{{ $comp->nombre }}">
                                                <i class="bi bi-caret-right-fill text-danger" style="font-size: 0.5rem;"></i> {{ $comp->nombre }}
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="mb-3 d-none d-lg-block" style="height: 57px;"></div>
                                @endif
                                <div class="mb-3 d-flex align-items-center justify-content-between">
                                    @if($producto->stock > 0)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-1" style="font-size: 0.7rem;">Stock: {{ $producto->stock }}</span>
                                        <div class="d-flex align-items-center gap-1 bg-light rounded-pill px-2 py-1" style="border: 1px solid #ddd;">
                                            <button class="btn btn-xs btn-link p-0 text-dark fw-bold" onclick="decQty({{ $producto->id }})" style="font-size: 0.75rem; text-decoration: none; width: 16px; height: 16px; line-height: 1;">-</button>
                                            <input type="number" id="qty_{{ $producto->id }}" class="form-control text-center p-0 border-0 bg-transparent" value="1" min="1" max="{{ $producto->stock }}" style="width: 24px; font-size: 0.75rem; height: 16px; box-shadow: none;" readonly>
                                            <button class="btn btn-xs btn-link p-0 text-dark fw-bold" onclick="incQty({{ $producto->id }}, {{ $producto->stock }})" style="font-size: 0.75rem; text-decoration: none; width: 16px; height: 16px; line-height: 1;">+</button>
                                        </div>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2 py-1" style="font-size: 0.7rem;">Sin Stock</span>
                                    @endif
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price-text">${{ number_format($producto->precio, 2, ',', '.') }}</span>

                                    @auth
                                        @if($producto->stock > 0)
                                            <button class="btn-add add-to-cart" data-id="{{ $producto->id }}" data-name="{{ $producto->nombre }}" data-price="{{ $producto->precio }}" data-stock="{{ $producto->stock }}">
                                                <i class="bi bi-plus-lg fs-5"></i>
                                            </button>
                                        @else
                                            <button class="btn-add bg-secondary text-white-50 cursor-not-allowed" disabled style="cursor: not-allowed; background-color: #6c757d;">
                                                <i class="bi bi-x-lg fs-5"></i>
                                            </button>
                                        @endif
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

        // Funciones para incrementar y decrementar cantidad en la vista del catálogo
        function decQty(id) {
            const input = document.getElementById('qty_' + id);
            if (input && parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }

        function incQty(id, max) {
            const input = document.getElementById('qty_' + id);
            if (input && parseInt(input.value) < max) {
                input.value = parseInt(input.value) + 1;
            }
        }

        /**
         * Lógica del carrito:
         * Guarda en el LocalStorage y sincroniza con MariaDB la cantidad y el stock.
         */
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', () => {
                const id = parseInt(button.getAttribute('data-id'));
                const name = button.getAttribute('data-name');
                const price = parseFloat(button.getAttribute('data-price'));
                const stock = parseInt(button.getAttribute('data-stock'));
                const qtyInput = document.getElementById('qty_' + id);
                const quantity = qtyInput ? parseInt(qtyInput.value) : 1;

                let cart = JSON.parse(localStorage.getItem('energy_cart')) || [];
                const itemIndex = cart.findIndex(item => item.id === id);

                if (itemIndex !== -1) {
                    const currentQty = parseInt(cart[itemIndex].cantidad || 1);
                    if (currentQty + quantity > stock) {
                        alert('No puedes agregar más de ' + stock + ' unidades de este producto.');
                        return;
                    }
                    cart[itemIndex].cantidad = currentQty + quantity;
                } else {
                    cart.push({ id, name, price, cantidad: quantity, stock });
                }

                // Sincronización mediante AJAX
                fetch("{{ route('carrito.agregarAjax') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ producto_id: id, cantidad: quantity })
                })
                .then(res => res.json())
                .then(data => {
                    localStorage.setItem('energy_cart', JSON.stringify(cart));
                    if (typeof syncCartBadge === 'function') syncCartBadge();
                    
                    if (qtyInput) qtyInput.value = 1;
                    alert('¡' + name + ' (' + quantity + ' und) agregado al carrito!');
                })
                .catch(err => {
                    console.error(err);
                    alert('Error al sincronizar con el servidor.');
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>