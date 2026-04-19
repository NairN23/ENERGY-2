<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energy - Comercialización</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
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
            border-radius: 40px;
            border: 1px solid #f0f0f0;
            overflow: hidden;
            background-color: #fff;
        }

        /* Hace que la imagen de medios de pago se adapte al ancho del contenedor. */
        .payment-box-image {
            display: block;
            width: 100%;
            height: auto;
        }

        /* Ajusta el tamaño del icono del primer paso sin competir con el título. */
        .step-icon {
            width: 92px;
            height: auto;
            display: block;
            margin: 1rem auto 0;
        }
    </style>
</head>
<body>

    <!-- Carga el navbar compartido para evitar duplicar estructura y estilos del encabezado. -->
    @include('partials.navbar')

    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="display-3 fw-bold text-uppercase">CÓMO <span class="text-danger-custom">COMPRAR</span></h1>
            <p class="text-muted fs-5 mt-3">Tu suplementación favorita en la puerta de tu casa. Rápido, seguro y garantizado.</p>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm p-4 rounded-4 position-relative">
                    <div class="step-number">01</div>
                    <div class="mt-4 text-center">
                        <h5 class="fw-bold text-uppercase">Elegí tus productos</h5>
                        <p class="text-muted small">Navegá por nuestro catálogo y seleccioná los suplementos que mejor se adapten a tu objetivo físico.</p>
                        <img src="/images/Comercializacion/icono-elegir.png" class="step-icon" alt="Elegí tus productos">
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 card-highlight shadow-sm p-4 rounded-4 position-relative">
                    <div class="step-number text-danger-custom" style="opacity: 0.15;">02</div>
                    <div class="mt-4 text-center">
                        <h5 class="fw-bold text-uppercase">Coordiná el pago</h5>
                        <p class="text-muted small">Aceptamos transferencias, tarjetas de crédito/débito y pagos en efectivo al momento de la entrega.</p>
                        <img src="/images/Comercializacion/icono-coordinar.png" class="step-icon" alt="Coordiná el pago">
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm p-4 rounded-4 position-relative">
                    <div class="step-number">03</div>
                    <div class="mt-4 text-center">
                        <h5 class="fw-bold text-uppercase">Recibí y entrená</h5>
                        <p class="text-muted small">Enviamos a todo el NEA. Si sos de Corrientes o Resistencia, recibís en el día con nuestro cadete exclusivo.</p>
                        <img src="/images/Comercializacion/icono-envios.png" class="step-icon" alt="Recibí y entrená">
                    </div>
                </div>
            </div>
        </div>

        <div class="payment-box mt-5">
            <img src="/images/Comercializacion/met.de.pago.jpg" class="payment-box-image" alt="Métodos de pago y beneficios disponibles en Energy">
        </div>
    </div>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>