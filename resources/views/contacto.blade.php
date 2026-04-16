<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energy - Contacto</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        /* Estilos generales */
        body { background-color: #fff; font-family: sans-serif; }
        
        /* Inputs del formulario: Fondo gris claro y sin bordes para un look moderno */
        .form-control { 
            background-color: #f2f2f2; 
            border: none; 
            padding: 12px; 
            border-radius: 8px; 
        }
        
        /* Efecto al hacer clic en un input: Resalta en rojo */
        .form-control:focus { 
            background-color: #ebebeb; 
            box-shadow: none; 
            border: 1px solid #ff0000; 
        }
        
        /* Botón Enviar con el rojo de ENERGY */
        .btn-enviar { 
            background-color: #ff0000; 
            color: white; 
            border: none; 
            padding: 12px 50px; 
            font-weight: bold; 
            border-radius: 5px; 
        }
        
        /* Estilo de los iconos de información (teléfono, sobre, etc.) */
        .info-icon { font-size: 1.5rem; color: #333; margin-right: 15px; }

        /* Links de navegación */
        .nav-link { 
            color: #333 !important; 
            font-size: 0.85rem; 
            text-transform: uppercase; 
            transition: 0.2s;
            padding-bottom: 5px;
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
                        <a class="nav-link fw-bold small {{ Request::is('/') ? 'text-danger border-bottom border-danger' : '' }}" href="/">Principal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold small {{ Request::is('catalogo') ? 'text-danger border-bottom border-danger' : '' }}" href="/catalogo">Catálogo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold small {{ Request::is('quienes-somos') ? 'text-danger border-bottom border-danger' : '' }}" href="/quienes-somos">Quiénes Somos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold small {{ Request::is('comercializacion') ? 'text-danger border-bottom border-danger' : '' }}" href="/comercializacion">Comercialización</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold small {{ Request::is('contacto') ? 'text-danger border-bottom border-danger' : '' }}" href="/contacto">Contacto</a>
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

    <div class="container py-5 mt-4">
        <div class="row g-5">
            
            <div class="col-md-5">
                <h4 class="fw-bold mb-5">
                    ¡Hola! Gracias por elegir <span class="text-danger">ENERGY</span>. Estamos para asesorarte en tu camino hacia una vida más sana.
                </h4>
                
                <div class="d-flex align-items-center mb-4">
                    <i class="bi bi-telephone info-icon"></i>
                    <span class="fw-semibold">+54 9 379 407-2323</span>
                </div>
                <div class="d-flex align-items-center mb-4">
                    <i class="bi bi-envelope info-icon"></i>
                    <span class="fw-semibold">ventas@energy.com.ar</span>
                </div>
                <div class="d-flex align-items-center mb-4">
                    <i class="bi bi-geo-alt info-icon"></i>
                    <span class="fw-semibold">Hipólito Yrigoyen 630, Corrientes, Argentina</span>
                </div>
                <div class="d-flex align-items-center mb-4">
                    <i class="bi bi-instagram info-icon"></i>
                    <span class="fw-semibold">@energy.nutricion</span>
                </div>
            </div>

            <div class="col-md-7">
                <form action="#" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre</label>
                        <input type="text" class="form-control" placeholder="ej.: María Perez">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" class="form-control" placeholder="ej.: tuemail@email.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Teléfono</label>
                        <input type="tel" class="form-control" placeholder="ej.: 1123445567">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Mensaje</label>
                        <textarea class="form-control" rows="5" placeholder="ej.: Tu mensaje"></textarea>
                    </div>
                    <button type="submit" class="btn btn-enviar">ENVIAR</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>