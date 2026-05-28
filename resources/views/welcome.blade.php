<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energy Sports Nutrition - Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { font-family: sans-serif; background-color: #fff; overflow-x: hidden; }
        
        /* Ajuste de Hero para que el texto resalte sin overlay */
        .hero-carousel, .hero-carousel .carousel-item { min-height: 34rem; position: relative; }
        .hero-carousel .carousel-image { width: 100%; height: 34rem; object-fit: cover; }
        
        .hero-title { 
            font-size: clamp(2.5rem, 6vw, 5rem); 
            line-height: 0.95; 
            font-weight: 800; 
            color: #fff;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.5); /* Sombra para que se lea sobre cualquier foto */
        }
        .text-accent { color: #ff0000; font-style: italic; text-transform: uppercase; }
        
        .carousel-caption {
            bottom: 30%; /* Centrado vertical */
            z-index: 10;
        }

        .carousel-control-prev, .carousel-control-next { display: none; }
        
        /* Marcas */
        .brand-badge { width: 58px; height: 58px; display: grid; place-items: center; border-radius: 50%; background: #000; color: #fff; font-size: 0.65rem; font-weight: 800; text-transform: uppercase; transition: 0.3s ease; margin: 0 auto; }
        .brand-item { display: flex; flex-direction: column; align-items: center; gap: 6px; transition: 0.3s ease; opacity: 0.95; cursor: pointer; }
        .brand-item:hover { transform: translateY(-3px); }
        .brand-item:hover .brand-badge { background: #ff0000; }
        .brand-name-small { font-size: 0.65rem; font-weight: 700; color: #888; text-transform: uppercase; }
    </style>
</head>
<body>
    @include('partials.navbar')

    <div id="heroEnergyCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel" data-bs-interval="4500">
        @if(isset($slides) && $slides->count() > 0)
            <div class="carousel-indicators">
                @foreach($slides as $index => $slide)
                    <button type="button" data-bs-target="#heroEnergyCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach($slides as $index => $slide)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ $slide->imagen }}" class="d-block w-100 carousel-image" alt="{{ $slide->titulo_blanco ?? 'ENERGY' }}">
                        <div class="carousel-caption text-center">
                            <h1 class="hero-title text-uppercase">
                                {{ $slide->titulo_blanco }} <br> 
                                <span class="text-accent">{{ $slide->titulo_rojo }}</span>
                            </h1>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&q=80&w=2000" class="d-block w-100 carousel-image" alt="Gym">
                    <div class="carousel-caption text-center">
                        <h1 class="hero-title text-uppercase">Potenciá <br> <span class="text-accent">tu mejor versión</span></h1>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- PRODUCTOS DESTACADOS -->
    <section class="py-5 bg-white border-bottom">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-uppercase text-dark" style="letter-spacing: 1.5px;">Productos <span class="text-danger">Destacados</span></h2>
                <p class="text-muted small">La mejor selección de suplementos de ENERGY para maximizar tu potencia y rendimiento.</p>
            </div>
            
            @if(isset($destacados) && $destacados->count() > 0)
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 justify-content-center">
                    @foreach($destacados as $producto)
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-radius: 12px; transition: 0.3s; background-color: #fcfcfc; border: 1px solid #f1f1f1 !important;">
                                <div class="position-relative" style="height: 200px; overflow: hidden; background-color: #fff; display: flex; align-items: center; justify-content: center;">
                                    <img src="{{ $producto->imagen ?? '/images/productos/default.png' }}" class="card-img-top" style="max-height: 170px; width: auto; object-fit: contain; padding: 10px;" alt="{{ $producto->nombre }}">
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-3 fw-bold text-uppercase shadow-sm" style="font-size: 0.65rem; border-radius: 4px; z-index: 2;">Destacado 🔥</span>
                                </div>
                                <div class="card-body d-flex flex-column p-3">
                                    <span class="text-danger fw-bold text-uppercase mb-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">{{ $producto->categoria->nombre ?? 'Suplemento' }}</span>
                                    <h6 class="fw-bold text-dark mb-2 text-truncate" title="{{ $producto->nombre }}">{{ $producto->nombre }}</h6>
                                    <p class="text-muted small mb-3 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4; font-size: 0.75rem;">
                                        {{ $producto->descripcion ?? 'Sin descripción disponible.' }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                                        <span class="fw-bold text-dark fs-6">${{ number_format($producto->precio, 2, ',', '.') }}</span>
                                        <a href="/catalogo" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.5px;">Ver en Tienda</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5 text-muted small">No hay suplementos destacados configurados en este momento.</div>
            @endif
        </div>
    </section>

    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>