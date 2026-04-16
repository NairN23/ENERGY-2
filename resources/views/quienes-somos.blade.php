<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energy - Quiénes Somos</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        /* Tipografía general y fondo limpio */
        body { font-family: sans-serif; background-color: #fff; }
        
        /* Color rojo característico de ENERGY */
        .text-danger { color: #ff0000 !important; }
        .italic { font-style: italic; }
        
        /* Sombra personalizada para las imágenes */
        .shadow-custom { box-shadow: 0 15px 35px rgba(0,0,0,0.1); }

        /* Estilos de la barra de navegación */
        .nav-link { 
            transition: 0.2s; 
            padding-bottom: 5px; 
            color: #333 !important;
            font-size: 0.85rem;
        }
        .nav-link:hover { color: #ff0000 !important; }
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
                        <a class="nav-link fw-bold small text-uppercase" href="/">Principal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold small text-uppercase" href="/catalogo">Catálogo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold small text-uppercase text-danger border-bottom border-danger" href="/quienes-somos">Quiénes Somos</a>
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

    <div class="container py-5">
        
        <div class="text-center mb-5">
            <h2 class="fw-bold italic text-uppercase">¿Quiénes Somos?</h2>
            <hr class="mx-auto bg-danger border-danger" style="width: 50px; height: 3px; opacity: 1;">
            <p class="col-md-8 mx-auto mt-4 text-muted">
                Nacimos de la pasión por el deporte en Corrientes. En <span class="text-danger fw-bold">ENERGY</span>, profesionalizamos la nutrición deportiva para que alcances tus metas de forma segura.
            </p>
        </div>

        <div class="row align-items-center mb-5 py-4">
            <div class="col-md-5">
                <img src="https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?auto=format&fit=crop&w=800" 
                     class="img-fluid rounded-4 shadow-custom" alt="Calidad Premium">
            </div>
            <div class="col-md-6 offset-md-1">
                <h3 class="fw-bold text-uppercase mb-3">Calidad Premium</h3>
                <p class="text-muted fs-5">
                    Trabajamos exclusivamente con laboratorios certificados y marcas líderes. Cada suplemento que sale de nuestra tienda ha sido seleccionado bajo los más estrictos estándares de calidad.
                </p>
            </div>
        </div>

        <div class="row align-items-center mb-5 py-4 flex-md-row-reverse">
            <div class="col-md-5 offset-md-1">
                <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=800" 
                     class="img-fluid rounded-4 shadow-custom" alt="Máxima Energía">
            </div>
            <div class="col-md-6">
                <h3 class="fw-bold text-uppercase mb-3 text-md-end">Máxima Energía</h3>
                <p class="text-muted fs-5 text-md-end">
                    Entendemos lo que tu cuerpo necesita para que potencies tu rendimiento en cada repetición. No solo vendemos, te asesoramos.
                </p>
            </div>
        </div>

        <div class="text-center py-5 border-top">
            <h3 class="fw-bold text-uppercase mb-4">Nuestra Misión</h3>
            <div class="row justify-content-center">
                <div class="col-4 border-end">
                    <h2 class="text-danger fw-bold m-0">100%</h2>
                    <small class="text-muted fw-bold">ORIGINAL</small>
                </div>
                <div class="col-4">
                    <h2 class="text-danger fw-bold m-0">+500</h2>
                    <small class="text-muted fw-bold">CLIENTES</small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>