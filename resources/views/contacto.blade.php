<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energy - Contacto Validado</title>
    
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
        
        /* Validación Visual */
        .form-control:focus { background-color: #fff; border-color: #ff0000; box-shadow: none; }
        .form-control.is-invalid { border-color: #dc3545 !important; background-color: #fff8f8; }
        .form-control.is-valid { border-color: #198754 !important; background-color: #f8fff8; }
        
        .btn-enviar { 
            background-color: #ff0000; 
            color: white; 
            border: none; 
            padding: 14px; 
            font-weight: bold; 
            border-radius: 8px; 
            text-transform: uppercase;
            transition: 0.3s;
        }
        .btn-enviar:hover { background-color: #cc0000; transform: translateY(-2px); }
        
        .small-map-box {
            width: 100%; max-width: 380px; height: 220px;
            border-radius: 15px; overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08); border: 1px solid #eee; margin-top: 20px;
        }
    </style>
</head>
<body>

    @include('partials.navbar')

    <div class="container py-5 mt-4">
        <div class="row g-5">
            <div class="col-md-5">
                <h4 class="fw-bold mb-4">¡Hola! Gracias por elegir <span class="text-danger">ENERGY</span>.</h4>
                <div class="mb-4">
                    <p><i class="bi bi-telephone text-danger me-2"></i> 3794576548</p>
                    <p><i class="bi bi-geo-alt text-danger me-2"></i> Salta 560, Corrientes Capital</p>
                    <p><i class="bi bi-instagram text-danger me-2"></i> @energy.nutricion</p>
                </div>
                <div class="small-map-box">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3540.04505417833!2d-58.8373188!3d-27.4678255!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94456ca4237d8001%3A0x6734151a37c86576!2sSalta%20560%2C%20W3400%20Corrientes!5e0!3m2!1ses-419!2sar!4v1713554400000!5m2!1ses-419!2sar" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>

            <div class="col-md-7">
                <form id="contactForm" novalidate>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">NOMBRE</label>
                        <input type="text" id="nombre" class="form-control" placeholder="Tu nombre completo" required>
                        <div class="invalid-feedback">Solo se permiten letras en este campo.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small">EMAIL</label>
                        <input type="email" id="email" class="form-control" placeholder="ejemplo@gmail.com" required>
                        <div class="invalid-feedback">Ingresa un correo electrónico válido.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">TELÉFONO</label>
                        <input type="tel" id="telefono" class="form-control" placeholder="3794..." required>
                        <div class="invalid-feedback">Solo se permiten números (mínimo 7 dígitos).</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small">MENSAJE</label>
                        <textarea id="mensaje" class="form-control" rows="4" placeholder="¿En qué te ayudamos?" required></textarea>
                    </div>
                    
                    <div id="statusAlert" class="alert mb-4" style="display: none;" role="alert"></div>

                    <button type="submit" class="btn btn-enviar w-100">ENVIAR CONSULTA</button>
                </form>
            </div>
        </div>
    </div>

    @include('partials.footer')

    <script>
        const form = document.getElementById('contactForm');
        const inputNombre = document.getElementById('nombre');
        const inputEmail = document.getElementById('email');
        const inputTelefono = document.getElementById('telefono');
        const alertBox = document.getElementById('statusAlert');

        // 1. VALIDACIÓN TIEMPO REAL: NOMBRE (Bloquea números y símbolos)
        inputNombre.addEventListener('input', function() {
            this.value = this.value.replace(/[^a-zA-ZÁÉÍÓÚáéíóúÑñ\s]/g, '');
            if (this.value.length >= 3) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        });

        // 2. VALIDACIÓN TIEMPO REAL: TELÉFONO (Bloquea letras)
        inputTelefono.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length >= 7) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        });

        // 3. VALIDACIÓN TIEMPO REAL: EMAIL
        inputEmail.addEventListener('input', function() {
            const regexEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (regexEmail.test(this.value)) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        });

        // PROCESO DE ENVÍO
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Verificamos si todos tienen la clase 'is-valid'
            const nombreOk = inputNombre.classList.contains('is-valid');
            const emailOk = inputEmail.classList.contains('is-valid');
            const telefoOk = inputTelefono.classList.contains('is-valid');
            const mensajeOk = document.getElementById('mensaje').value.trim() !== "";

            if (nombreOk && emailOk && telefoOk && mensajeOk) {
                alertBox.style.display = 'block';
                alertBox.className = 'alert alert-success';
                alertBox.innerHTML = '<i class="bi bi-check-circle-fill"></i> ¡DATOS CORRECTOS! Formulario enviado.';
                form.reset();
                // Limpiar clases de validación
                [inputNombre, inputEmail, inputTelefono].forEach(i => i.classList.remove('is-valid'));
            } else {
                alertBox.style.display = 'block';
                alertBox.className = 'alert alert-danger';
                alertBox.innerHTML = '<i class="bi bi-exclamation-triangle-fill"></i> Por favor, completa los campos correctamente.';
                
                // Forzar validación visual si intentan enviar vacío
                if(!nombreOk) inputNombre.classList.add('is-invalid');
                if(!emailOk) inputEmail.classList.add('is-invalid');
                if(!telefoOk) inputTelefono.classList.add('is-invalid');
            }
        });
    </script>
</body>
</html>