<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energy - Comercialización</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #ffffff; }
        
        /* Estilo para los números grandes de fondo */
        .step-number {
            font-size: 4.5rem;
            font-weight: 800;
            color: #000;
            opacity: 0.05;
            line-height: 1;
            position: absolute;
            top: 20px;
            left: 20px;
        }

        /* Card del medio (Paso 02) con borde rojo */
        .card-highlight {
            border: 1px solid #ff0000 !important;
        }

        .text-danger-custom { color: #ff0000; }
        
        /* Caja de métodos de pago */
        .payment-box {
            background-color: #f9f9f9;
            border-radius: 40px;
            border: 1px solid #f0f0f0;
        }

        .method-text {
            font-weight: 700;
            color: #aaa;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top mb-5">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">ENERGY</a>
            
            <div class="collapse navbar-collapse justify-content-center">
                <ul class="navbar-nav gap-4">
                    <li class="nav-item"><a class="nav-link fw-bold small text-dark" href="/">PRINCIPAL</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold small text-dark" href="/catalogo">CATÁLOGO</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold small text-dark" href="/quienes-somos">QUIÉNES SOMOS</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold small text-danger border-bottom border-danger" href="/comercializacion">COMERCIALIZACIÓN</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold small text-dark" href="/contacto">CONTACTO</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="display-3 fw-bold text-uppercase">CÓMO <span class="text-danger-custom">COMPRAR</span></h1>
            <p class="text-muted fs-5 mt-3">Tu suplementación favorita en la puerta de tu casa. Rápido, seguro y garantizado.</p>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm p-4 rounded-4 position-relative">
                    <div class="step-number">01</div>
                    <div class="mt-4">
                        <h5 class="fw-bold text-uppercase">Elegí tus productos</h5>
                        <p class="text-muted small">Navegá por nuestro catálogo y seleccioná los suplementos que mejor se adapten a tu objetivo físico.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 card-highlight shadow-sm p-4 rounded-4 position-relative">
                    <div class="step-number text-danger-custom" style="opacity: 0.15;">02</div>
                    <div class="mt-4">
                        <h5 class="fw-bold text-uppercase">Coordiná el pago</h5>
                        <p class="text-muted small">Aceptamos transferencias, tarjetas de crédito/débito y pagos en efectivo al momento de la entrega.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm p-4 rounded-4 position-relative">
                    <div class="step-number">03</div>
                    <div class="mt-4">
                        <h5 class="fw-bold text-uppercase">Recibí y entrená</h5>
                        <p class="text-muted small">Enviamos a todo el NEA. Si sos de Corrientes o Resistencia, recibís en el día con nuestro cadete exclusivo.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="payment-box p-5 text-center mt-5">
            <h4 class="fw-bold text-uppercase mb-5">Métodos de pago <span class="text-danger-custom">Soportados</span></h4>
            <div class="d-flex flex-wrap justify-content-center gap-5">
                <span class="method-text fs-4">VISA</span>
                <span class="method-text fs-4">MASTERCARD</span>
                <span class="method-text fs-4">MERCPAGO</span>
                <span class="method-text fs-4">EFECTIVO</span>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top py-3">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">
           ENERGY <span class="fw-light small text-muted text-uppercase" style="font-size: 0.7rem;">Sports Nutrition</span>
        </a>

        <div class="collapse navbar-collapse justify-content-center">
            <ul class="navbar-nav gap-3">
                <li class="nav-item">
                    <a class="nav-link fw-bold small text-uppercase {{ Request::is('/') ? 'text-danger border-bottom border-danger' : 'text-dark' }}" href="/">Principal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold small text-uppercase {{ Request::is('catalogo') ? 'text-danger border-bottom border-danger' : 'text-dark' }}" href="/catalogo">Catálogo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold small text-uppercase {{ Request::is('quienes-somos') ? 'text-danger border-bottom border-danger' : 'text-dark' }}" href="/quienes-somos">Quiénes Somos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold small text-uppercase {{ Request::is('comercializacion') ? 'text-danger border-bottom border-danger' : 'text-dark' }}" href="/comercializacion">Comercialización</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold small text-uppercase {{ Request::is('contacto') ? 'text-danger border-bottom border-danger' : 'text-dark' }}" href="/contacto">Contacto</a>
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

<style>
    .nav-link { transition: 0.2s; padding-bottom: 5px; }
    .nav-link:hover { color: #ff0000 !important; }
</style>
<style>
    /* Estilo para que se vea igual a tus capturas */
    .nav-link {
        color: #333 !important;
        transition: 0.3s;
    }
    .nav-link:hover {
        color: #ff0000 !important;
    }
    /* Clase opcional: si quieres resaltar la pestaña actual, 
       agrégala manualmente al link de la página donde estés */
    .active-nav {
        color: #ff0000 !important;
        border-bottom: 2px solid #ff0000;
    }
</style>
</html>