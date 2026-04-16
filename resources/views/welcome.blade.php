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

        /* Hero Section - Portada Principal */
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                        url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&q=80&w=2000'); 
            background-size: cover; 
            background-position: center; 
            height: 100vh;
            display: flex; 
            align-items: center; 
            justify-content: center; 
            color: white; 
            text-align: center;
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

    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                ENERGY <span class="fw-light small text-muted text-uppercase" style="font-size: 0.7rem;">Sports Nutrition</span>
            </a>

            <div class="collapse navbar-collapse justify-content-center">
                <ul class="navbar-nav gap-3">
                    <li class="nav-item">
                        <a class="nav-link fw-bold small text-uppercase active-nav" href="/">Principal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold small text-uppercase" href="/catalogo">Catálogo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold small text-uppercase" href="/quienes-somos">Quiénes Somos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold small text-uppercase" href="/comercializacion">Comercialización</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold small text-uppercase" href="/contacto">Contacto</a>
                    </li>
                </ul>
            </div>

            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-person fs-5"></i>
                <div class="position-relative">
                    <i class="bi bi-cart3 fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.5rem;">0</span>
                </div>
            </div>
        </div>
    </nav>

    <header class="hero-section">
        <div class="container">
            <span class="badge bg-danger mb-3 px-3 py-2">LAS MEJORES MARCAS</span>
            <h1 class="display-2 fw-bold text-uppercase">Potenciá <br> <span class="text-accent">tu mejor versión</span></h1>
            <p class="lead mb-5">Más que una tienda, somos tu aliado en el camino hacia la cima de tu rendimiento.</p>
            
            <a href="/catalogo" class="btn btn-danger-custom btn-lg">Explorar Tienda</a>
        </div>
    </header>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>