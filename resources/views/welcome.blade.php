<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energy Sports Nutrition - Principal</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body { font-family: sans-serif; background-color: #fff; color: #1a1a1a; overflow-x: hidden; }
        
        /* Navbar Custom */
        .nav-link { transition: 0.3s; color: #333 !important; font-size: 0.85rem; text-transform: uppercase; }
        .nav-link:hover { color: #ff0000 !important; }

        /* Carousel - Banner Principal */
        .hero-carousel, .hero-carousel .carousel-item {
            min-height: 34rem;
            position: relative;
        }
        .hero-carousel .carousel-image {
            width: 100%; height: 34rem; object-fit: cover;
        }
        .overlay {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.4); z-index: 1;
        }
        .hero-carousel .carousel-caption {
            right: 50%; bottom: 50%; left: 50%;
            width: min(900px, calc(100% - 2rem));
            transform: translate(-50%, 50%); z-index: 2;
        }
        .hero-title { font-size: clamp(2.5rem, 6vw, 5rem); line-height: 0.95; font-weight: 800; }
        .text-accent { color: #ff0000; font-style: italic; text-transform: uppercase; }
        .carousel-control-prev, .carousel-control-next { display: none; }

        /* --- SECCIÓN DE MARCAS: 6 ITEMS CON CÍRCULOS --- */
        .brands-section {
            padding: 1.2rem 0 !important;
            background-color: #ffffff;
            border-top: 1px solid #f0f0f0;
        }

        .brand-badge {
            width: 58px; 
            height: 58px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: #000; 
            color: #fff;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            transition: 0.3s ease;
            margin: 0 auto;
        }

        .brand-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            transition: 0.3s ease;
            opacity: 0.95;
        }

        .brand-item:hover {
            transform: translateY(-3px);
        }

        .brand-item:hover .brand-badge {
            background: #ff0000; 
            box-shadow: 0 4px 12px rgba(255, 0, 0, 0.2);
        }

        .brand-name-small {
            font-size: 0.65rem;
            font-weight: 700;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>

    @include('partials.navbar')

    <div id="heroEnergyCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel" data-bs-interval="4500">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroEnergyCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroEnergyCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroEnergyCarousel" data-bs-slide-to="2"></button>
        </div>
    
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&q=80&w=2000" class="d-block w-100 carousel-image" alt="Gym">
                </div>
    
            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438?auto=format&fit=crop&q=80&w=2000" class="d-block w-100 carousel-image" alt="Supps">
            </div>
    
            <div class="carousel-item">
                <img src="https://inlitoral.info/images/resize/466900.webp?fm=webp" class="d-block w-100 carousel-image" alt="Envios NEA">
            </div>
        </div>
    </div>

    <section class="brands-section">
        <div class="container">
            <div class="row row-cols-3 row-cols-md-6 g-3 align-items-center justify-content-center text-center">
                <div class="col">
                    <div class="brand-item">
                        <div class="brand-badge">ENA</div>
                        <span class="brand-name-small">Ena</span>
                    </div>
                </div>
                <div class="col">
                    <div class="brand-item">
                        <div class="brand-badge">STAR</div>
                        <span class="brand-name-small">Star</span>
                    </div>
                </div>
                <div class="col">
                    <div class="brand-item">
                        <div class="brand-badge">HTN</div>
                        <span class="brand-name-small">Htn</span>
                    </div>
                </div>
                <div class="col">
                    <div class="brand-item">
                        <div class="brand-badge">GENT</div>
                        <span class="brand-name-small">Gentech</span>
                    </div>
                </div>
                <div class="col">
                    <div class="brand-item">
                        <div class="brand-badge">XTR</div>
                        <span class="brand-name-small">Xtrenght</span>
                    </div>
                </div>
                <div class="col">
                    <div class="brand-item">
                        <div class="brand-badge">ON</div>
                        <span class="brand-name-small">Optimum</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>