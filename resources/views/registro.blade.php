<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energy - Registro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        /* Estilos generales para el fondo y la tipografía de la web */
        body {
            font-family: sans-serif;
            color: #161616;
            /* Degradado de fondo que combina un destello rojo sutil arriba a la izquierda y un fondo claro */
            background:
                radial-gradient(circle at top left, rgba(255, 0, 0, 0.08), transparent 24%),
                linear-gradient(180deg, #f5f5f5 0%, #ffffff 100%);
        }

        /* Contenedor principal de la página: centra el contenido verticalmente */
        .login-page {
            min-height: calc(100vh - 88px); /* Descuenta el tamaño estimado de la barra de navegación */
            display: flex;
            align-items: center;
            padding: 2rem 0 3rem;
        }

        /* Estructura de la tarjeta blanca centralizada */
        .login-card {
            border: 0;
            border-radius: 2rem; /* Bordes muy redondeados */
            overflow: hidden;    /* Evita que el fondo de las columnas pise las esquinas redondeadas */
            background-color: #fff;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.12); /* Sombra difuminada de fondo */
        }

        /* Columna izquierda: Panel decorativo oscuro con imagen de fondo */
        .login-visual {
            min-height: 100%;
            padding: 3rem;
            color: #fff;
            /* Capa negra semitransparente sobre la imagen de Unsplash para mejorar la lectura del texto */
            background:
                linear-gradient(145deg, rgba(10, 10, 10, 0.92), rgba(38, 38, 38, 0.82)),
                url('https://images.unsplash.com/photo-1517836357463-d25dfeac3438?auto=format&fit=crop&w=1200&q=80') center/cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Clases de validación en tiempo real para los bordes de los campos (Rojo / Verde) */
        .login-input.is-invalid { border-color: #dc3545 !important; background-color: #fff8f8; }
        .login-input.is-valid { border-color: #198754 !important; background-color: #f8fff8; }

        /* Ocultar ícono de error de Bootstrap en campos con toggle de contraseña */
        .position-relative .login-input.is-invalid {
            background-image: none !important;
        }

        /* Título principal del panel visual izquierdo */
        .login-visual-title {
            margin-top: 1.25rem;
            font-size: clamp(2.15rem, 4vw, 3.45rem); /* Tamaño de fuente adaptable a pantallas */
            font-weight: 800;
            line-height: 0.98;
            text-transform: uppercase;
        }

        /* Resaltado de color rojo de la marca para la palabra "progreso" o "ENERGY" */
        .login-visual-title span {
            color: #ff0000;
        }

        /* Párrafo descriptivo del panel visual izquierdo */
        .login-visual-copy {
            margin-top: 1.25rem;
            max-width: 31rem;
            color: rgba(255, 255, 255, 0.84);
            font-size: 1rem;
            line-height: 1.7;
        }

        /* Espaciado del panel del formulario (Columna derecha) */
        .login-form-panel {
            padding: 3rem;
        }

        /* Título principal del formulario (CREAR CUENTA) */
        .login-form-title {
            margin-top: 0.35rem;
            margin-bottom: 0.4rem;
            font-size: 2.15rem;
            font-weight: 800;
            text-transform: uppercase;
        }

        /* Subtítulo aclaratorio abajo del título principal */
        .login-form-copy {
            margin-bottom: 1.5rem;
            color: #5d5d5d;
            line-height: 1.7;
        }

        /* Estilos para las etiquetas de texto arriba de los inputs */
        .login-label {
            margin-bottom: 0.35rem;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        /* Estilos base para las cajas de entrada de texto */
        .login-input {
            min-height: 3rem;
            border: 1px solid #d8d8d8;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            background-color: #f7f7f7;
            font-size: 0.95rem;
        }

        /* Comportamiento visual de la caja de texto cuando el usuario hace clic adentro */
        .login-input:focus {
            background-color: #fff;
            border-color: #ff0000; /* Borde rojo característico de ENERGY */
            box-shadow: 0 0 0 0.2rem rgba(255, 0, 0, 0.12); /* Brillo difuminado rojo */
        }

        /* Estilo personalizado para la flecha desplegable de la selección de provincias */
        .login-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%236a6a6a' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 16px 12px;
        }

        /* Enlaces web generales (Ej: "Iniciá sesión acá") */
        .login-link {
            color: #ff0000;
            text-decoration: none;
            font-weight: 700;
        }

        .login-link:hover {
            text-decoration: underline; /* Agrega subrayado al pasar el mouse por encima */
        }

        /* Botón principal de envío del formulario (Registrarme) */
        .login-submit {
            width: 100%;
            min-height: 3.4rem;
            border: 0;
            border-radius: 0.95rem;
            background: #111111; /* Color negro original */
            color: #fff;
            font-weight: 800;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            transition: transform 0.2s ease, background-color 0.2s ease; /* Transición suave de efectos */
        }

        /* Cambio de color del botón al pasar el mouse encima (se vuelve rojo) */
        .login-submit:hover {
            background-color: #ff0000;
            transform: translateY(-1px); /* Pequeño salto hacia arriba */
        }

        /* Texto aclaratorio al final de todo el documento */
        .login-footnote {
            margin-top: 1.5rem;
            color: #6d6d6d;
            font-size: 0.92rem;
            text-align: center;
        }

        /* Líneas divisorias estéticas para separar los "Datos de cuenta" y "Datos de envío" */
        .section-divider {
            font-size: 0.75rem;
            font-weight: 800;
            color: #999;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin: 1.5rem 0 0.8rem 0;
            display: flex;
            align-items: center;
        }

        /* Genera de forma automática la línea gris continua al lado del texto de la división */
        .section-divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
            margin-left: 1rem;
        }

        /* REGLAS RESPONSIVE: Ajuste de espacios para pantallas medianas (Tablets) */
        @media (max-width: 991.98px) {
            .login-visual, .login-form-panel { padding: 2.25rem; }
        }

        /* REGLAS RESPONSIVE: Ajuste de espacios para pantallas chicas (Celulares) */
        @media (max-width: 767.98px) {
            .login-page { padding: 1rem 0 2rem; }
            .login-visual, .login-form-panel { padding: 1.5rem; }
        }
    </style>
</head>
<body>

    @include('partials.navbar')

    <main class="login-page">
        <div class="container">
            <div class="row g-0 login-card">
                
                <div class="col-12 col-lg-5 d-none d-lg-flex">
                    <section class="login-visual w-100">
                        <h1 class="login-visual-title">Formá parte de <span>ENERGY</span></h1>
                        <p class="login-visual-copy">
                            Registrate para armar tu perfil, guardar tu dirección de envío de forma segura y acelerar tus compras de suplementación deportiva.
                        </p>
                    </section>
                </div>

                <div class="col-12 col-lg-7">
                    <section class="login-form-panel">
                        <h2 class="login-form-title">CREAR CUENTA</h2>
                        <p class="login-form-copy">Completa tus datos para registrarte en la tienda.</p>

                        <form id="registerForm" action="{{ route('register.post') }}" method="POST">
                            @csrf

                            <div class="section-divider">Datos de cuenta</div>

                            <div class="row g-2 mb-2">
                                <div class="col-sm-6">
                                    <label for="name" class="login-label">Nombre Completo</label>
                                    <input id="name" name="name" type="text" class="form-control login-input @error('name') is-invalid @enderror" placeholder="Juan Pérez" value="{{ old('name') }}" required>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-sm-6">
                                    <label for="email" class="login-label">Email</label>
                                    <input id="email" name="email" type="email" class="form-control login-input @error('email') is-invalid @enderror" placeholder="ejemplo@energy.com.ar" value="{{ old('email') }}" required list="savedEmails" autocomplete="email">
                                    <datalist id="savedEmails"></datalist>
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row g-2 mb-2">
                                <div class="col-sm-6">
                                    <label for="password" class="login-label">Contraseña</label>
                                    <div class="position-relative">
                                        <input id="password" name="password" type="password" class="form-control login-input @error('password') is-invalid @enderror" placeholder="Mínimo 8 caracteres" required>
                                        <button type="button" class="btn btn-sm position-absolute end-0 top-50 translate-middle-y me-2 border-0" id="togglePassword" style="background: none; color: #666;">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-sm-6">
                                    <label for="password_confirmation" class="login-label">Confirmar Contraseña</label>
                                    <div class="position-relative">
                                        <input id="password_confirmation" name="password_confirmation" type="password" class="form-control login-input" placeholder="Repetí tu contraseña" required>
                                        <button type="button" class="btn btn-sm position-absolute end-0 top-50 translate-middle-y me-2 border-0" id="togglePasswordConfirm" style="background: none; color: #666;">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="section-divider">Datos de envío</div>

                            <div class="mb-2">
                                <label for="telefono" class="login-label">Número de Teléfono</label>
                                <input id="telefono" name="telefono" type="text" class="form-control login-input @error('telefono') is-invalid @enderror" placeholder="Ej: 3875434770" value="{{ old('telefono') }}" inputmode="numeric" required>
                                @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-2">
                                <label for="direccion" class="login-label">Dirección (Calle y Número)</label>
                                <input id="direccion" name="direccion" type="text" class="form-control login-input @error('direccion') is-invalid @enderror" placeholder="Av. Siempre Viva 742" value="{{ old('direccion') }}" required>
                                @error('direccion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row g-2 mb-4">
                                <div class="col-sm-5">
                                    <label for="departamento" class="login-label">Departamento</label>
                                    <input id="departamento" name="departamento" type="text" class="form-control login-input @error('departamento') is-invalid @enderror" placeholder="Corrientes" value="{{ old('departamento') }}" required>
                                    @error('departamento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-sm-4">
                                    <label for="provincia" class="login-label">Provincia</label>
                                    <select id="provincia" name="provincia" class="form-control login-input login-select @error('provincia') is-invalid @enderror" required>
                                        <option value="" disabled selected>Seleccioná...</option>
                                        <option value="Buenos Aires" {{ old('provincia') == 'Buenos Aires' ? 'selected' : '' }}>Buenos Aires</option>
                                        <option value="CABA" {{ old('provincia') == 'CABA' ? 'selected' : '' }}>CABA</option>
                                        <option value="Chaco" {{ old('provincia') == 'Chaco' ? 'selected' : '' }}>Chaco</option>
                                        <option value="Corrientes" {{ old('provincia') == 'Corrientes' ? 'selected' : '' }}>Corrientes</option>
                                        <option value="Córdoba" {{ old('provincia') == 'Córdoba' ? 'selected' : '' }}>Córdoba</option>
                                        <option value="Misiones" {{ old('provincia') == 'Misiones' ? 'selected' : '' }}>Misiones</option>
                                        <option value="Santa Fe" {{ old('provincia') == 'Santa Fe' ? 'selected' : '' }}>Santa Fe</option>
                                    </select>
                                    @error('provincia') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-sm-3">
                                    <label for="cp" class="login-label">C. Postal</label>
                                    <input id="cp" name="cp" type="text" class="form-control login-input @error('cp') is-invalid @enderror" placeholder="3400" value="{{ old('cp') }}" required>
                                    @error('cp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <button type="submit" class="login-submit">Registrarme</button>
                        </form>

                        <div class="login-footnote">
                            ¿Ya tenés una cuenta? <a href="/login" class="login-link">Iniciá sesión acá</a>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script>
        // Cargar correos guardados en la computadora
        document.addEventListener('DOMContentLoaded', function() {
            const savedEmails = JSON.parse(localStorage.getItem('energy_saved_emails')) || [];
            const datalist = document.getElementById('savedEmails');
            savedEmails.forEach(email => {
                const option = document.createElement('option');
                option.value = email;
                datalist.appendChild(option);
            });

            // Toggle de visualización de contraseña
            const togglePassword = document.getElementById('togglePassword');
            const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
            const passwordInput = document.getElementById('password');
            const passwordConfirmInput = document.getElementById('password_confirmation');

            togglePassword?.addEventListener('click', function(e) {
                e.preventDefault();
                const type = passwordInput.type === 'password' ? 'text' : 'password';
                passwordInput.type = type;
                this.querySelector('i').classList.toggle('bi-eye');
                this.querySelector('i').classList.toggle('bi-eye-slash');
            });

            togglePasswordConfirm?.addEventListener('click', function(e) {
                e.preventDefault();
                const type = passwordConfirmInput.type === 'password' ? 'text' : 'password';
                passwordConfirmInput.type = type;
                this.querySelector('i').classList.toggle('bi-eye');
                this.querySelector('i').classList.toggle('bi-eye-slash');
            });
        });

        // Evento que analiza el envío del formulario
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const passwordConfirmInput = document.getElementById('password_confirmation');
        const telefonoInput = document.getElementById('telefono');
        const departamentoInput = document.getElementById('departamento');
        const cpInput = document.getElementById('cp');
        const registerForm = document.getElementById('registerForm');

        // Función para validar formato de email
        function validarFormatoEmail(email) {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        }

        // Función para validar que solo tenga letras y espacios
        function validarSoloLetras(texto) {
            return /^[a-záéíóúñA-ZÁÉÍÓÚÑ\s]+$/.test(texto);
        }

        // Función para validar que solo tenga números
        function validarSoloNumeros(texto) {
            return /^\d+$/.test(texto);
        }

        // Validar teléfono: solo números
        telefonoInput?.addEventListener('blur', function () {
            const valor = this.value.trim();
            if (valor && !validarSoloNumeros(valor)) {
                this.classList.add('is-invalid');
                alert('El teléfono solo puede contener números.');
            } else {
                this.classList.remove('is-invalid');
            }
        });

        // Evento que valida el email en tiempo real cuando pierde el foco
        emailInput?.addEventListener('blur', async function () {
            const email = this.value.trim();

            if (!email) {
                emailInput.classList.remove('is-invalid', 'is-valid');
                return;
            }

            // Validar formato de email
            if (!validarFormatoEmail(email)) {
                emailInput.classList.add('is-invalid');
                emailInput.classList.remove('is-valid');
                return;
            }

            // Verificar si el email ya existe en la BD
            try {
                const response = await fetch('/verificar-email', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({ email: email })
                });

                const data = await response.json();

                if (data.existe) {
                    emailInput.classList.add('is-invalid');
                    emailInput.classList.remove('is-valid');
                    // Mostrar mensaje de error
                    const errorMsg = emailInput.nextElementSibling;
                    if (errorMsg && errorMsg.classList.contains('invalid-feedback')) {
                        errorMsg.textContent = data.mensaje;
                        errorMsg.style.display = 'block';
                    }
                } else {
                    emailInput.classList.remove('is-invalid');
                    emailInput.classList.add('is-valid');
                    const errorMsg = emailInput.nextElementSibling;
                    if (errorMsg && errorMsg.classList.contains('invalid-feedback')) {
                        errorMsg.style.display = 'none';
                    }
                }
            } catch (error) {
                console.error('Error verificando email:', error);
            }
        });

        // Validar departamento: solo letras
        departamentoInput?.addEventListener('blur', function () {
            const valor = this.value.trim();
            if (valor && !validarSoloLetras(valor)) {
                this.classList.add('is-invalid');
                alert('El departamento solo puede contener letras.');
            } else {
                this.classList.remove('is-invalid');
            }
        });

        // Validar CP: solo números
        cpInput?.addEventListener('blur', function () {
            const valor = this.value.trim();
            if (valor && !validarSoloNumeros(valor)) {
                this.classList.add('is-invalid');
                alert('El código postal solo puede contener números.');
            } else {
                this.classList.remove('is-invalid');
            }
        });

        if (registerForm && emailInput) {
            registerForm.addEventListener('submit', function (event) {
                // Validar email: formato correcto
                const email = emailInput.value.trim();
                if (!validarFormatoEmail(email)) {
                    event.preventDefault();
                    emailInput.classList.add('is-invalid');
                    alert('Por favor ingresá un correo electrónico válido.');
                    return false;
                }

                // Validar email: no esté duplicado
                if (emailInput.classList.contains('is-invalid')) {
                    event.preventDefault();
                    alert('Este correo ya está registrado. Usá otro correo electrónico.');
                    return false;
                }

                // Validar departamento: solo letras
                const departamento = departamentoInput?.value.trim();
                if (departamento && !validarSoloLetras(departamento)) {
                    event.preventDefault();
                    departamentoInput.classList.add('is-invalid');
                    alert('El departamento solo puede contener letras.');
                    return false;
                }

                // Validar teléfono: solo números
                const telefono = telefonoInput?.value.trim();
                if (telefono && !validarSoloNumeros(telefono)) {
                    event.preventDefault();
                    telefonoInput.classList.add('is-invalid');
                    alert('El teléfono solo puede contener números.');
                    return false;
                }

                // Validar CP: solo números
                const cp = cpInput?.value.trim();
                if (cp && !validarSoloNumeros(cp)) {
                    event.preventDefault();
                    cpInput.classList.add('is-invalid');
                    alert('El código postal solo puede contener números.');
                    return false;
                }

                // Validar contraseña: mínimo 8 caracteres
                if (passwordInput.value.length < 8) {
                    event.preventDefault();
                    passwordInput.classList.add('is-invalid');
                    alert('La contraseña debe tener al menos 8 caracteres.');
                    return false;
                }

                // Validar que las contraseñas coincidan
                if (passwordInput.value !== passwordConfirmInput.value) {
                    event.preventDefault();
                    passwordConfirmInput.classList.add('is-invalid');
                    alert('Las contraseñas no coinciden.');
                    return false;
                }

                // Guardar el correo en localStorage para próximas visitas
                const currentEmail = emailInput.value.trim().toLowerCase();
                if (currentEmail) {
                    let savedEmails = JSON.parse(localStorage.getItem('energy_saved_emails')) || [];
                    if (!savedEmails.includes(currentEmail)) {
                        savedEmails.push(currentEmail);
                        localStorage.setItem('energy_saved_emails', JSON.stringify(savedEmails));
                    }
                }
            });
        }
    </script>
</body>
</html>