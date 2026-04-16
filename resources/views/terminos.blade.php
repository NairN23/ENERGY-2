<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energy - Términos y Uso</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        /* Fondo ligeramente gris para que la tarjeta blanca resalte */
        body { background-color: #f8f9fa; font-family: sans-serif; }
        
        /* Color rojo corporativo de ENERGY */
        .text-danger-custom { color: #ff0000; }
        
        /* Tarjeta principal que contiene el texto legal */
        .terms-card {
            background-color: #ffffff;
            border-radius: 30px; /* Bordes bien redondeados como en tus capturas */
            padding: 50px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); /* Sombra suave para dar profundidad */
            border: none;
        }

        /* Títulos de cada punto legal */
        .term-item h5 {
            font-weight: 800;
            text-transform: uppercase;
            font-size: 1rem;
            margin-bottom: 15px;
        }

        /* Párrafos de descripción con mejor lectura (interlineado) */
        .term-item p {
            color: #666;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        /* Estilos de la barra de navegación */
        .nav-link { color: #333 !important; transition: 0.2s; }
        .nav-link:hover { color: #ff0000 !important; }
        
        /* Clase para marcar la pestaña en la que estamos parados */
        .active-page { color: #ff0000 !important; border-bottom: 2px solid #ff0000; }
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
                    <li class="nav-item"><a class="nav-link fw-bold small text-uppercase" href="/">Principal</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold small text-uppercase" href="/catalogo">Catálogo</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold small text-uppercase" href="/quienes-somos">Quiénes Somos</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold small text-uppercase" href="/comercializacion">Comercialización</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold small text-uppercase" href="/contacto">Contacto</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold small text-uppercase active-page" href="/terminos">Términos y Uso</a></li>
                </ul>
            </div>

            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-person fs-5"></i>
                <i class="bi bi-cart3 fs-5"></i>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold text-uppercase">Términos y <span class="text-danger-custom">Uso</span></h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="terms-card">
                    
                    <div class="term-item mb-5">
                        <h5>1. Aceptación de Términos</h5>
                        <p>Al acceder y utilizar este sitio web de ENERGY, usted acepta estar sujeto a los siguientes términos y condiciones de uso. Si no está de acuerdo con alguna parte de estos términos, no debe utilizar nuestro sitio web.</p>
                    </div>

                    <div class="term-item mb-5">
                        <h5>2. Uso de Productos</h5>
                        <p>Los suplementos comercializados por ENERGY están destinados a personas adultas sanas. Recomendamos encarecidamente consultar con un profesional de la salud antes de comenzar cualquier régimen de suplementación deportiva.</p>
                    </div>

                    <div class="term-item mb-5">
                        <h5>3. Propiedad Intelectual</h5>
                        <p>Todo el contenido presente en este sitio, incluyendo logotipos, textos, imágenes y diseños, es propiedad exclusiva de ENERGY y está protegido por las leyes vigentes.</p>
                    </div>

                    <div class="term-item mb-4">
                        <h5>4. Proceso de Comercialización</h5>
                        <p>Nuestra plataforma funciona como catálogo digital. La finalización de las órdenes se realiza a través de canales directos (WhatsApp) para garantizar un asesoramiento personal.</p>
                    </div>

                    <hr class="my-5 opacity-25">

                    <p class="text-muted small text-center m-0">
                        Última actualización: Abril 2026. ENERGY - Corrientes, Argentina.
                    </p>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>