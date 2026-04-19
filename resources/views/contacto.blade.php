<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energy - Contacto</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #fff; font-family: sans-serif; }
        
        .form-control { 
            background-color: #f2f2f2; 
            border: 2px solid transparent; 
            padding: 12px; 
            border-radius: 8px; 
            transition: 0.3s;
        }
        
        .form-control:focus { 
            background-color: #fff; 
            box-shadow: none; 
            border-color: #ff0000; 
        }

        /* Estilos de validación */
        .form-control.is-invalid {
            border-color: #dc3545;
            background-color: #fff8f8;
        }

        .form-control.is-valid {
            border-color: #198754;
        }
        
        .btn-enviar { 
            background-color: #ff0000; 
            color: white; 
            border: none; 
            padding: 12px 50px; 
            font-weight: bold; 
            border-radius: 5px; 
            transition: 0.3s;
            text-transform: uppercase;
        }

        .btn-enviar:hover { background-color: #cc0000; transform: translateY(-2px); }
        
        .info-icon { font-size: 1.3rem; color: #ff0000; margin-right: 15px; }

        .small-map-box {
            width: 100%;
            max-width: 380px;
            height: 220px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            border: 1px solid #eee;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    @include('partials.navbar')

    <div class="container py-5 mt-4">
        <div class="row g-5">
            
            <div class="col-md-5">
                <h4 class="fw-bold mb-4">
                    ¡Hola! Gracias por elegir <span class="text-danger">ENERGY</span>.
                </h4>
                
                <div class="contact-info-list mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-telephone info-icon"></i>
                        <span class="fw-semibold">Tel: 3794576548</span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-geo-alt info-icon"></i>
                        <span class="fw-semibold">Salta 560, Corrientes Capital</span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-instagram info-icon"></i>
                        <span class="fw-semibold">@energy.nutricion</span>
                    </div>
                </div>

                <div class="small-map-box">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3540.0656667957134!2d-58.8340!3d-27.4692!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjfCsDI4JzA5LjEiUyA1OMKwNTAnMDIuNCJX!5e0!3m2!1ses!2sar!4v1713545000000!5m2!1ses!2sar" 
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>

            <div class="col-md-7">
                <form id="contactForm" novalidate>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase">Nombre</label>
                        <input type="text" id="nombre" class="form-control" placeholder="María Perez" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase">Email</label>
                        <input type="email" id="email" class="form-control" placeholder="tuemail@email.com" required>
                        <div class="invalid-feedback" id="emailFeedback">
                            Por favor, ingresá un correo electrónico válido.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase">Teléfono</label>
                        <input type="tel" id="telefono" class="form-control" placeholder="3794123456" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase">Mensaje</label>
                        <textarea id="mensaje" class="form-control" rows="4" placeholder="¿En qué podemos ayudarte?" required></textarea>
                    </div>
                    
                    <div id="statusAlert" class="alert d-none mb-4" role="alert"></div>

                    <button type="submit" id="btnSubmit" class="btn btn-enviar w-100">
                        ENVIAR CONSULTA
                    </button>
                </form>
            </div>
        </div>
    </div>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const contactForm = document.getElementById('contactForm');
        const emailInput = document.getElementById('email');
        const statusAlert = document.getElementById('statusAlert');

        // Función para validar formato de email con Regex más estricto
        function validateEmail(email) {
            const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            return re.test(String(email).toLowerCase());
        }

        // Validación en tiempo real mientras el usuario escribe
        emailInput.addEventListener('input', function() {
            if (validateEmail(this.value)) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        });

        contactForm.addEventListener('submit', function (event) {
            event.preventDefault();
            
            const emailValue = emailInput.value;

            // 1. Comprobación de formato
            if (!validateEmail(emailValue)) {
                emailInput.classList.add('is-invalid');
                return;
            }

            // 2. Comprobación de dominios comunes falsos (opcional)
            const forbiddenDomains = ['test.com', 'example.com', 'mailinator.com', 'falso.com'];
            const domain = emailValue.split('@')[1];
            
            if (forbiddenDomains.includes(domain)) {
                emailInput.classList.add('is-invalid');
                document.getElementById('emailFeedback').innerText = "Este dominio de correo no está permitido.";
                return;
            }

            // Si pasa las validaciones:
            statusAlert.classList.remove('d-none', 'alert-danger');
            statusAlert.classList.add('alert-warning');
            statusAlert.innerHTML = '<i class="bi bi-info-circle me-2"></i> El sistema de envío automático está en mantenimiento. Redirigiendo a WhatsApp...';
            
            // Simular una redirección a WhatsApp para que no se pierda el contacto
            setTimeout(() => {
                const nombre = document.getElementById('nombre').value;
                const msj = document.getElementById('mensaje').value;
                const textoWA = `Hola Energy! Soy ${nombre}. Mi correo es ${emailValue}. Consulta: ${msj}`;
                window.open(`https://wa.me/543794576548?text=${encodeURIComponent(textoWA)}`, '_blank');
            }, 2000);
        });
    </script>
</body>
</html>