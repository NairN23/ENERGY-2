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

        /* Links de navegación heredados del diseño original de esta vista. */
        .nav-link { 
            color: #333 !important; 
            font-size: 0.85rem; 
            text-transform: uppercase; 
            transition: 0.2s;
            padding-bottom: 5px;
        }
        .nav-link:hover { color: #ff0000 !important; }

        /* Hace visible el aviso temporal directamente dentro del formulario de contacto. */
        .contact-inline-alert {
            display: none;
            border-radius: 14px;
            border: 1px solid rgba(255, 0, 0, 0.2);
            background-color: #fff5f5;
            color: #7a1c1c;
        }
    </style>
</head>
<body>

    <!-- Monta el navbar centralizado para conservar enlaces e interaccion responsive. -->
    @include('partials.navbar')

    <div class="container py-5 mt-4">
        <div class="row g-5">
            
            <div class="col-md-5">
                <h4 class="fw-bold mb-5">
                    ¡Hola! Gracias por elegir <span class="text-danger">ENERGY</span>. Estamos para asesorarte en tu camino hacia una vida más sana.
                </h4>
                
                <div class="d-flex align-items-center mb-4">
                    <i class="bi bi-telephone info-icon"></i>
                    <span class="fw-semibold">Teléfono: 3794576548</span>
                </div>
                <div class="d-flex align-items-center mb-4">
                    <i class="bi bi-envelope info-icon"></i>
                    <span class="fw-semibold">Sitio web: www.energy.com.ar</span>
                </div>
                <div class="d-flex align-items-center mb-4">
                    <i class="bi bi-geo-alt info-icon"></i>
                    <span class="fw-semibold">Domicilio: Salta 560, Corrientes Capital</span>
                </div>
                <div class="d-flex align-items-center mb-4">
                    <i class="bi bi-instagram info-icon"></i>
                    <span class="fw-semibold">@energy.nutricion</span>
                </div>
            </div>

            <div class="col-md-7">
                <form id="contactUnderConstructionForm" action="#" method="POST">
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
                    <div id="contactConstructionAlert" class="alert contact-inline-alert mb-4" role="alert">
                        La sección de inicio de sesión todavía está en construcción.
                    </div>
                    <button type="submit" class="btn btn-enviar">ENVIAR</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Intercepta el submit del formulario hasta que exista el envío real de contacto.
        document.getElementById('contactUnderConstructionForm').addEventListener('submit', function (event) {
            event.preventDefault();
            document.getElementById('contactConstructionAlert').style.display = 'block';
        });
    </script>
</body>
</html>