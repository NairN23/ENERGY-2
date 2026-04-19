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

        /* Unifica los textos corrientes marcados en negro con el mismo tamaño y lectura. */
        .about-text {
            color: #111111;
            font-size: 1.05rem;
            line-height: 1.72;
            font-weight: 400;
        }

        /* Mantiene el mismo estilo en los textos descriptivos de cada bloque. */
        .about-copy {
            color: inherit;
            font-size: inherit;
            line-height: inherit;
            font-weight: inherit;
        }

        /* Reduce levemente el tamaño de los títulos laterales para que respiren mejor junto a la imagen. */
        .about-section-title {
            font-size: 1.55rem;
            line-height: 1.15;
        }

        /* Hace que cada bloque de contenido y su imagen compartan la misma altura visual. */
        .about-row {
            align-items: stretch;
        }

        /* Permite que la imagen ocupe todo el alto disponible de su columna. */
        .about-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Estira y centra verticalmente el contenido textual para acompañar la altura de la imagen. */
        .about-content {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        @media (max-width: 767.98px) {
            /* En mobile devuelve el comportamiento natural para evitar bloques demasiado altos. */
            .about-content {
                height: auto;
                margin-top: 1.5rem;
            }
        }

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

    <!-- Usa el parcial del navbar para compartir el encabezado con el resto del sitio. -->
    @include('partials.navbar')

    <div class="container py-5">
        
        <div class="text-center mb-5">
            <h2 class="fw-bold italic text-uppercase">¿Quiénes Somos?</h2>
            <hr class="mx-auto bg-danger border-danger" style="width: 50px; height: 3px; opacity: 1;">
            <p class="col-md-8 mx-auto mt-4 about-text">
                Nacimos de la pasión por el deporte en Corrientes. En <span class="text-danger fw-bold">ENERGY</span>, profesionalizamos la nutrición deportiva para que alcances tus metas de forma segura y constante. Sabemos que detrás de cada entrenamiento hay un objetivo claro, y estamos acá para darte el combustible exacto que necesitás para superar.
            </p>
        </div>

        <div class="row about-row mb-5 py-4">
            <div class="col-md-5">
                <img src="https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?auto=format&fit=crop&w=800" 
                     class="img-fluid rounded-4 shadow-custom about-image" alt="Calidad Premium">
            </div>
            <div class="col-md-6 offset-md-1">
                <div class="about-content">
                    <h3 class="fw-bold text-uppercase mb-3 about-section-title">Calidad Premium</h3>
                    <p class="about-text about-copy">
                        Trabajamos exclusivamente con laboratorios certificados y marcas líderes en el rubro de la nutrición deportiva. Entendemos que alcanzar tu mejor versión requiere dedicación, y por ello, tu salud es nuestra máxima prioridad. Cada suplemento que sale de nuestra tienda ha sido seleccionado bajo los más estrictos estándares de calidad, garantizando que recibas fórmulas puras, seguras y respaldadas por la ciencia.
                    </p>
                    <p class="about-text about-copy mb-0">
                        Nuestro equipo se encarga de auditar constantemente el origen y la originalidad de todo nuestro stock. Al elegirnos, no solo estás comprando un producto, sino que estás invirtiendo en la tranquilidad de saber que consumís suplementación con sellos de autenticidad verificados, fechas de caducidad controladas y el respaldo de una tienda que se toma tu rendimiento tan en serio como vos.
                    </p>
                </div>
            </div>
        </div>

        <div class="row about-row mb-5 py-4 flex-md-row-reverse">
            <div class="col-md-5 offset-md-1">
                <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=800" 
                     class="img-fluid rounded-4 shadow-custom about-image" alt="Máxima Energía">
            </div>
            <div class="col-md-6">
                <div class="about-content text-md-end">
                    <h3 class="fw-bold text-uppercase mb-3 about-section-title">Máxima Energía</h3>
                    <p class="about-text about-copy mb-0">
                        Entendemos lo que tu cuerpo necesita para que potencies tu rendimiento en cada repetición. Nuestro diferencial es simple: no solo vendemos, te asesoramos. Ya con la garantía de estar consumiendo lo mejor, nuestro equipo se enfoca en escucharte. Entendemos tus metas, ya sea ganar masa muscular o acelerar tu recuperación, y te guiamos para elegir exactamente lo que tu metabolismo exige para romper tus propios límites.
                    </p>
                </div>
            </div>
        </div>

        <div class="container mt-5 pt-5 mb-5 border-top">
            <h2 class="text-center fw-bold mb-5">NUESTRO EQUIPO DE PROFESIONALES</h2>

            <div class="row g-4">
                <div class="col-12 col-md-3 text-center">
                    <img src="/images/Quienes-somos/Nutricionista.png" alt="Nutricionista" class="rounded-circle mb-3 border shadow-sm" width="150" height="150" style="object-fit: cover;">
                    <h5 class="fw-bold mb-1">Martina Villanueva</h5>
                    <p class="text-muted small">Lic. en Nutrición /<br>Especialista en Nutrición Deportiva.</p>
                </div>

                <div class="col-12 col-md-3 text-center">
                    <img src="/images/Quienes-somos/Preparador Físico.png" alt="Preparador Físico" class="rounded-circle mb-3 border shadow-sm" width="150" height="150" style="object-fit: cover;">
                    <h5 class="fw-bold mb-1">Marcos Ferrero</h5>
                    <p class="text-muted small">Preparador Físico /<br>Especialista en Alto Rendimiento</p>
                </div>

                <div class="col-12 col-md-3 text-center">
                    <img src="/images/Quienes-somos/Asesor.png" alt="Asesor" class="rounded-circle mb-3 border shadow-sm" width="150" height="150" style="object-fit: cover;">
                    <h5 class="fw-bold mb-1">Tomás Herrera</h5>
                    <p class="text-muted small">Asesor/a de Suplementación<br>y Atención al Cliente.</p>
                </div>

                <div class="col-12 col-md-3 text-center">
                    <img src="/images/Quienes-somos/Logistica.png" alt="Logística" class="rounded-circle mb-3 border shadow-sm" width="150" height="150" style="object-fit: cover;">
                    <h5 class="fw-bold mb-1">Lucas Navarro</h5>
                    <p class="text-muted small">Responsable de Logística<br>y E-commerce.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>