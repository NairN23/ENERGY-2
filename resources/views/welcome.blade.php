<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energy Sports Nutrition - Principal</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body { font-family: sans-serif; background-color: #fff; }
        
        /* Navbar Custom */
        .nav-link { transition: 0.3s; color: #333 !important; padding-bottom: 5px; }
        .nav-link:hover { color: #ff0000 !important; }
        .active-nav { color: #ff0000 !important; border-bottom: 2px solid #ff0000; }

        /* Da una altura más contenida al carousel para que no ocupe toda la pantalla. */
        .hero-carousel,
        .hero-carousel .carousel-item {
            min-height: 34rem;
        }

        /* Hace que cada imagen mantenga formato de banner sin convertirse en pantalla completa. */
        .hero-carousel .carousel-image {
            width: 100%;
            height: 34rem;
            object-fit: cover;
        }

        /* Centra el bloque de texto del carousel y lo mantiene por encima del overlay. */
        .hero-carousel .carousel-caption {
            right: 50%;
            bottom: 50%;
            left: 50%;
            width: min(900px, calc(100% - 2rem));
            transform: translate(-50%, 50%);
            z-index: 2;
        }

        /* Ajusta el tamaño del titular para que siga siendo dominante en mobile. */
        .hero-carousel .hero-title {
            font-size: clamp(2.5rem, 6vw, 5.5rem);
            line-height: 0.95;
        }

        /* Personaliza indicadores y flechas para que acompañen la identidad visual. */
        .hero-carousel .carousel-indicators [data-bs-target] {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin: 0 0.35rem;
        }

        .hero-carousel .carousel-control-prev,
        .hero-carousel .carousel-control-next {
            width: 8%;
        }

        /* Crea una seccion separada para exhibir las marcas asociadas a la tienda. */
        .brands-section {
            padding: 3.5rem 0 4rem;
            background: linear-gradient(180deg, #fff 0%, #f8f8f8 100%);
        }

        /* Acomoda las marcas en filas fluidas sin generar desbordes en mobile. */
        .brands-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(110px, 1fr));
            gap: 1.25rem;
        }

        /* Presenta cada marca como un sello alineado con la estética deportiva del sitio. */
        .brand-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
            text-align: center;
        }

        /* Genera el circulo negro principal para que cada marca contraste con el fondo claro. */
        .brand-badge {
            width: 86px;
            height: 86px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, #2b2b2b, #111 60%, #000 100%);
            color: #fff;
            font-size: 0.82rem;
            font-weight: 800;
            letter-spacing: 0.04em;
            line-height: 1.05;
            text-transform: uppercase;
            border: 1px solid rgba(255, 0, 0, 0.45);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.18);
            transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        }

        /* Agranda levemente cada sello para dar una respuesta visual al hover. */
        .brand-item:hover .brand-badge {
            transform: scale(1.08);
            border-color: rgba(255, 0, 0, 0.75);
            box-shadow: 0 16px 28px rgba(255, 0, 0, 0.18);
        }

        /* Refuerza la lectura del nombre completo de cada marca debajo del sello. */
        .brand-name {
            color: #3b3b3b;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        @media (max-width: 767.98px) {
            /* Reduce aún más la altura en mobile para que el carousel quede compacto. */
            .hero-carousel,
            .hero-carousel .carousel-item,
            .hero-carousel .carousel-image {
                min-height: 24rem;
                height: 24rem;
            }

            /* Compacta la caja de texto en pantallas chicas para mejorar lectura. */
            .hero-carousel .carousel-caption {
                width: calc(100% - 2.5rem);
            }

            /* Reduce el padding de la seccion para que las marcas no ocupen demasiado alto. */
            .brands-section {
                padding: 2.5rem 0 3rem;
            }

            .brand-badge {
                width: 74px;
                height: 74px;
                font-size: 0.72rem;
            }
        }

        .btn-danger-custom { 
            background-color: #ff0000; 
            border: none; 
            padding: 15px 45px; 
            font-weight: 800; 
            text-transform: uppercase; 
            border-radius: 5px; 
            color: white; 
            text-decoration: none; 
            transition: 0.3s;
        }
        
        .btn-danger-custom:hover {
            background-color: #cc0000;
            transform: scale(1.05);
        }

        .text-accent { color: #ff0000; font-style: italic; text-transform: uppercase; }
        .italic { font-style: italic; }
    </style>
</head>
<body>

    <!-- Inserta el navbar compartido para reutilizar la misma navegacion responsive. -->
    @include('partials.navbar')

    <!-- Reemplaza el hero estático por un carousel principal con mensaje comercial y CTA. -->
    <div id="carouselExampleCaptions" class="carousel slide hero-carousel" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&q=80&w=2000" class="d-block w-100 carousel-image" alt="Mancuernas y equipamiento de gimnasio">
                <div class="carousel-caption">
                    <span class="badge bg-danger mb-3 px-3 py-2">LAS MEJORES MARCAS</span>
                    <h1 class="hero-title fw-bold text-uppercase">Potenciá <br> <span class="text-accent">tu mejor versión</span></h1>
                    <p class="lead mb-5">Más que una tienda, somos tu aliado en el camino hacia la cima de tu rendimiento.</p>
                    <a href="/catalogo" class="btn btn-danger-custom btn-lg">Explorar Tienda</a>
                </div>
            </div>

            <div class="carousel-item">
                <img src="/images/Principal/slide-2.png" class="d-block w-100 carousel-image" alt="Productos destacados de suplementación en gimnasio">
            </div>

            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1571019613540-9965c1f9864b?auto=format&fit=crop&q=80&w=2000" class="d-block w-100 carousel-image" alt="Atleta entrenando con intensidad">
                <div class="carousel-caption d-none d-md-block">
                    <h5 class="fw-bold text-uppercase">Energía para cada objetivo</h5>
                    <p>Proteínas, creatinas y accesorios para acompañar tu progreso dentro y fuera del gym.</p>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Muestra las marcas con las que trabaja la tienda en una grilla responsive bajo el carousel. -->
    <section class="brands-section">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-uppercase mb-0">Marcas que impulsan tu rendimiento</h2>
            </div>

            <div class="brands-grid">
                <div class="brand-item">
                    <div class="brand-badge">ENA</div>
                    <div class="brand-name">ENA Sport</div>
                </div>
                <div class="brand-item">
                    <div class="brand-badge">STAR</div>
                    <div class="brand-name">Star Nutrition</div>
                </div>
                <div class="brand-item">
                    <div class="brand-badge">HTN</div>
                    <div class="brand-name">HTN</div>
                </div>
                <div class="brand-item">
                    <div class="brand-badge">GENT</div>
                    <div class="brand-name">GenTech</div>
                </div>
                <div class="brand-item">
                    <div class="brand-badge">XTR</div>
                    <div class="brand-name">Xtrenght</div>
                </div>
                <div class="brand-item">
                    <div class="brand-badge">ON</div>
                    <div class="brand-name">Optimum Nutrition</div>
                </div>
                <div class="brand-item">
                    <div class="brand-badge">GOLD</div>
                    <div class="brand-name">Gold Nutrition</div>
                </div>
                <div class="brand-item">
                    <div class="brand-badge">BPI</div>
                    <div class="brand-name">BPI Sports</div>
                </div>
                <div class="brand-item">
                    <div class="brand-badge">SPX</div>
                    <div class="brand-name">Supplements X</div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>