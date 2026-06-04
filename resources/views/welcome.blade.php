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

        /* Marquee Infinito */
        .marquee-container {
            overflow: hidden;
            position: relative;
            width: 100%;
            padding: 20px 0;
            background: linear-gradient(135deg, #fdfdfd 0%, #f8f9fa 100%);
            border-radius: 16px;
            box-shadow: inset 0 0 20px rgba(0,0,0,0.02);
        }
        .marquee-content {
            display: flex;
            width: max-content;
            animation: marquee 25s linear infinite;
        }
        .marquee-content:hover {
            animation-play-state: paused;
        }
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .marquee-card {
            width: 280px;
            margin: 0 15px;
            flex-shrink: 0;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
            border: 1px solid #f1f1f1;
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        }
        .marquee-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 10px 25px rgba(220, 53, 69, 0.1);
            border-color: rgba(220, 53, 69, 0.25);
        }
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

    <!-- PRODUCTOS EN MOVIMIENTO -->
    <section class="py-5 bg-white border-bottom">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-uppercase text-dark" style="letter-spacing: 1.5px;">Descubrí <span class="text-danger">Nuestros Suplementos</span></h2>
                <p class="text-muted small">Explorá nuestra variedad de suplementos para maximizar tu rendimiento deportivo en ENERGY.</p>
            </div>
            
            @if(isset($azar) && $azar->count() > 0)
                <div class="marquee-container">
                    <div class="marquee-content">
                        @foreach($azar as $producto)
                            <div class="marquee-card p-3 d-flex flex-column h-100">
                                <div class="position-relative mb-2" style="height: 160px; overflow: hidden; background-color: #fff; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                                    <img src="{{ $producto->imagen ?? '/images/productos/default.png' }}" style="max-height: 140px; width: auto; object-fit: contain; padding: 5px;" alt="{{ $producto->nombre }}">
                                    @if($producto->destacado)
                                        <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2 fw-bold text-uppercase" style="font-size: 0.6rem; border-radius: 6px; z-index: 2;">Destacado</span>
                                    @endif
                                    @if($producto->es_combo)
                                        <span class="badge bg-info position-absolute top-0 end-0 m-2 fw-bold text-uppercase text-white" style="font-size: 0.6rem; border-radius: 6px; z-index: 2;">Combo ⚡</span>
                                    @endif
                                </div>
                                <span class="text-danger fw-bold text-uppercase mb-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">{{ $producto->categoria->nombre ?? 'Suplemento' }}</span>
                                <h6 class="fw-bold text-dark mb-2 text-truncate" title="{{ $producto->nombre }}" style="max-width: 250px;">{{ $producto->nombre }}</h6>
                                <p class="text-muted small mb-3 flex-grow-1 text-wrap" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4; font-size: 0.75rem; max-width: 250px;">
                                    {{ $producto->descripcion ?? 'Sin descripción disponible.' }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                                    <span class="fw-bold text-dark fs-6">${{ number_format($producto->precio, 2, ',', '.') }}</span>
                                    <a href="/catalogo" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.5px;">Ver en Tienda</a>
                                </div>
                            </div>
                        @endforeach
                        {{-- Duplicado para loop infinito fluido --}}
                        @foreach($azar as $producto)
                            <div class="marquee-card p-3 d-flex flex-column h-100">
                                <div class="position-relative mb-2" style="height: 160px; overflow: hidden; background-color: #fff; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                                    <img src="{{ $producto->imagen ?? '/images/productos/default.png' }}" style="max-height: 140px; width: auto; object-fit: contain; padding: 5px;" alt="{{ $producto->nombre }}">
                                    @if($producto->destacado)
                                        <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2 fw-bold text-uppercase" style="font-size: 0.6rem; border-radius: 6px; z-index: 2;">Destacado</span>
                                    @endif
                                    @if($producto->es_combo)
                                        <span class="badge bg-info position-absolute top-0 end-0 m-2 fw-bold text-uppercase text-white" style="font-size: 0.6rem; border-radius: 6px; z-index: 2;">Combo ⚡</span>
                                    @endif
                                </div>
                                <span class="text-danger fw-bold text-uppercase mb-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">{{ $producto->categoria->nombre ?? 'Suplemento' }}</span>
                                <h6 class="fw-bold text-dark mb-2 text-truncate" title="{{ $producto->nombre }}" style="max-width: 250px;">{{ $producto->nombre }}</h6>
                                <p class="text-muted small mb-3 flex-grow-1 text-wrap" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4; font-size: 0.75rem; max-width: 250px;">
                                    {{ $producto->descripcion ?? 'Sin descripción disponible.' }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                                    <span class="fw-bold text-dark fs-6">${{ number_format($producto->precio, 2, ',', '.') }}</span>
                                    <a href="/catalogo" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.5px;">Ver en Tienda</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="text-center py-5 text-muted small">No hay suplementos cargados en este momento.</div>
            @endif
        </div>
    </section>

    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>