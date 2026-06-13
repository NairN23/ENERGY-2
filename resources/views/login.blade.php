<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energy - Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        /* Estilos generales para el fondo y la tipografía de la web */
        body {
            font-family: sans-serif;
            color: #161616;
            /* Degradado de fondo con un destello rojo sutil arriba a la izquierda y fondo claro blanco/gris */
            background:
                radial-gradient(circle at top left, rgba(255, 0, 0, 0.08), transparent 24%),
                linear-gradient(180deg, #f5f5f5 0%, #ffffff 100%);
        }

        /* Contenedor principal de la página: centra la tarjeta verticalmente en la pantalla */
        .login-page {
            min-height: calc(100vh - 88px); /* Descuenta la altura estimada de la barra de navegación */
            display: flex;
            align-items: center;
            padding: 3rem 0 4rem;
        }

        /* Estructura de la tarjeta blanca centralizada */
        .login-card {
            border: 0;
            border-radius: 2rem; /* Bordes muy redondeados */
            overflow: hidden;    /* Evita que los fondos de las columnas tapen las esquinas redondeadas */
            background-color: #fff;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.12); /* Sombra difuminada para dar profundidad */
        }

        /* Columna izquierda: Panel decorativo oscuro con la foto de gimnasio */
        .login-visual {
            min-height: 100%;
            padding: 3rem;
            color: #fff;
            /* Capa negra semitransparente sobre la foto para garantizar el contraste de las letras */
            background:
                linear-gradient(145deg, rgba(10, 10, 10, 0.92), rgba(38, 38, 38, 0.82)),
                url('https://images.unsplash.com/photo-1517836357463-d25dfeac3438?auto=format&fit=crop&w=1200&q=80') center/cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Estilos específicos para que el borde cambie a rojo o verde según la validación del correo */
        .login-input.is-invalid { border-color: #dc3545 !important; background-color: #fff8f8; }
        .login-input.is-valid { border-color: #198754 !important; background-color: #f8fff8; }

        /* Estilos del chip de texto superior (si decidís usarlo en el futuro) */
        .login-chip {
            display: inline-flex;
            align-self: flex-start;
            padding: 0.45rem 0.9rem;
            border-radius: 999px;
            background-color: rgba(255, 255, 255, 0.12);
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        /* Título principal del panel visual izquierdo (ENTRÁ Y SEGUÍ TU PROGRESO) */
        .login-visual-title {
            margin-top: 1.25rem;
            font-size: clamp(2.15rem, 4vw, 3.45rem); /* Tamaño adaptativo según la pantalla */
            font-weight: 800;
            line-height: 0.98;
            text-transform: uppercase;
        }

        /* Resaltado rojo de la marca para la palabra "PROGRESO" */
        .login-visual-title span {
            color: #ff0000;
        }

        /* Párrafo descriptivo debajo del título principal */
        .login-visual-copy {
            margin-top: 1.25rem;
            max-width: 31rem;
            color: rgba(255, 255, 255, 0.84);
            font-size: 1rem;
            line-height: 1.7;
        }

        /* Grilla para las cajas de los puntos clave del panel izquierdo */
        .login-visual-points {
            display: grid;
            gap: 0.85rem;
            margin-top: 2rem;
        }

        /* Cajas individuales con fondo oscuro semitransparente para los puntos clave */
        .login-visual-point {
            padding: 0.95rem 1rem;
            border-radius: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.12);
            background-color: rgba(255, 255, 255, 0.06);
            line-height: 1.55;
        }

        /* Espaciado interno del panel del formulario (Columna derecha) */
        .login-form-panel {
            padding: 3rem;
        }

        /* Título de introducción (si decidís usar un texto pequeño arriba del título) */
        .login-eyebrow {
            color: #ff0000;
            font-size: 0.82rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        /* Título principal del formulario (BIENVENIDO A ENERGY) */
        .login-form-title {
            margin-top: 0.35rem;
            margin-bottom: 0.4rem;
            font-size: 2.15rem;
            font-weight: 800;
            text-transform: uppercase;
        }

        /* Subtítulo indicativo abajo de BIENVENIDO A ENERGY */
        .login-form-copy {
            margin-bottom: 1.75rem;
            color: #5d5d5d;
            line-height: 1.7;
        }

        /* Etiquetas de texto arriba de cada input (EMAIL / CONTRASEÑA) */
        .login-label {
            margin-bottom: 0.45rem;
            font-size: 0.88rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        /* Estilos base para los cuadros de entrada de texto */
        .login-input {
            min-height: 3.3rem;
            border: 1px solid #d8d8d8;
            border-radius: 0.9rem;
            padding: 0.95rem 1rem;
            background-color: #f7f7f7;
        }

        /* Comportamiento visual de los inputs cuando el usuario hace foco o clic adentro */
        .login-input:focus {
            background-color: #fff;
            border-color: #ff0000; /* Borde rojo identificatorio */
            box-shadow: 0 0 0 0.2rem rgba(255, 0, 0, 0.12); /* Brillo difuminado rojo */
        }

        /* Textos secundarios y enlaces pequeños (Ej: ¿La olvidaste?) */
        .login-link,
        .login-secondary {
            color: #6a6a6a;
            font-size: 0.92rem;
            text-decoration: none;
        }

        /* El enlace cambia a color rojo de ENERGY al pasar el mouse por encima */
        .login-link:hover {
            color: #ff0000;
        }

        /* Botón negro principal de envío (Iniciar sesión) */
        .login-submit {
            width: 100%;
            min-height: 3.4rem;
            border: 0;
            border-radius: 0.95rem;
            background: #111111;
            color: #fff;
            font-weight: 800;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            transition: transform 0.2s ease, background-color 0.2s ease; /* Transición suave de efectos */
        }

        /* El botón se vuelve rojo y hace un mini salto al pasar el mouse encima */
        .login-submit:hover {
            background-color: #ff0000;
            transform: translateY(-1px);
        }

        /* Alerta oculta por defecto para mensajes del sistema */
        .login-inline-alert {
            display: none;
            border-radius: 14px;
            border: 1px solid rgba(255, 0, 0, 0.2);
            background-color: #fff5f5;
            color: #7a1c1c;
        }

        /* Grilla para las dos cajas de beneficios abajo del botón */
        .login-benefits {
            margin-top: 1.4rem;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.9rem;
        }

        /* Estilo para cada bloque individual de beneficio */
        .login-benefit {
            padding: 1rem;
            border-radius: 1rem;
            border: 1px solid #ececec;
            background-color: #f8f8f8;
        }

        /* Títulos en negrita dentro de las cajas de beneficios */
        .login-benefit strong {
            display: block;
            margin-bottom: 0.25rem;
            font-size: 0.95rem;
            font-weight: 800;
        }

        /* Texto aclaratorio al final de todo el panel del formulario */
        .login-footnote {
            margin-top: 1.25rem;
            color: #6d6d6d;
            font-size: 0.92rem;
        }

        /* REGLAS RESPONSIVE: Ajustes para pantallas medianas (Tablets) */
        @media (max-width: 991.98px) {
            .login-visual,
            .login-form-panel {
                padding: 2.25rem;
            }
        }

        /* REGLAS RESPONSIVE: Ajustes estructurales para pantallas chicas (Celulares) */
        @media (max-width: 767.98px) {
            .login-page {
                padding: 2rem 0 3rem;
            }

            .login-visual,
            .login-form-panel {
                padding: 1.75rem;
            }

            /* Los beneficios se acomodan uno debajo del otro en celulares */
            .login-benefits {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    @include('partials.navbar')

    <main class="login-page">
        <div class="container">
            <div class="row g-0 login-card">
                
                <div class="col-12 col-lg-6">
                    <section class="login-visual h-100">
                        <h1 class="login-visual-title">Entrá y seguí tu <span>progreso</span></h1>
                        <p class="login-visual-copy">
                            Accedé a tu cuenta para gestionar compras, favoritos y novedades de suplementación con la misma estética fuerte y directa que viene siguiendo ENERGY.
                        </p>

                        <div class="login-visual-points">
                            <div class="login-visual-point">Comprá más rápido con tus datos ya listos y mantené ordenadas tus preferences.</div>
                            <div class="login-visual-point">Seguí tu actividad dentro de la tienda y preparate para futuras funciones de usuario.</div>
                        </div>
                    </section>
                </div>

                <div class="col-12 col-lg-6">
                    <section class="login-form-panel">
                        <h2 class="login-form-title">BIENVENIDO A ENERGY</h2>
                        <p class="login-form-copy">
                            Iniciá sesión con tu email para continuar comprando y revisar tus datos.
                        </p>

                        <form id="loginForm" action="{{ route('login.post') }}" method="POST">
                            @csrf 

                            @if ($errors->has('auth_failed'))
                                <div class="alert alert-danger mb-4" style="border-radius: 14px; font-size: 0.92rem;">
                                    Las credenciales no coinciden con nuestro sistema de ENERGY. ¿Desea <a href="{{ route('register') }}" style="color: #7a1c1c; font-weight: 800; text-decoration: underline;">Registrarse</a>?
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="email" class="login-label">Email</label>
                                <input id="email" name="email" type="email" class="form-control login-input @error('email') is-invalid @enderror" placeholder="ejemplo@energy.com.ar" value="{{ old('email') }}" required list="savedEmails" autocomplete="email">
                                <datalist id="savedEmails"></datalist>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="login-label">Contraseña</label>
                                <input id="password" name="password" type="password" class="form-control login-input @error('password') is-invalid @enderror" placeholder="Ingresá tu contraseña" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end mb-3">
                                <a href="#" class="login-link">¿La olvidaste?</a>
                            </div>

                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
                                <div class="form-check m-0">
                                    <input class="form-check-input" type="checkbox" name="remember" value="1" id="rememberUser">
                                    <label class="form-check-label login-secondary" for="rememberUser">Recordarme en este dispositivo</label>
                                </div>
                                <span class="login-secondary">Acceso seguro para clientes ENERGY</span>
                            </div>

                            <button type="submit" class="login-submit">Iniciar sesión</button>
                        </form>

                        <div class="login-benefits">
                            <div class="login-benefit">
                                <strong>Compras rápidas</strong>
                                Guardá tus datos para moverte más rápido por la tienda.
                            </div>
                            <div class="login-benefit">
                                <strong>Seguimiento simple</strong>
                                Revisá tu actividad y seguí tu progreso con claridad.
                            </div>
                        </div>

                        <div class="login-footnote">
                            ¿Todavía no tenés cuenta? <a href="{{ route('register') }}" class="login-link">Registrate acá</a>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Captura el elemento de entrada del correo electrónico
        const emailInput = document.getElementById('email');

        // Función con expresión regular que analiza que el correo tenga un formato real (@ y .com)
        function esEmailValido(valor) {
            const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            return regex.test(valor);
        }

        // Evento que se ejecuta cada vez que el usuario escribe una letra adentro de la casilla de email
        emailInput.addEventListener('input', function() {
            if (esEmailValido(this.value)) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid'); // Pinta borde verde si cumple el formato
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid'); // Pinta borde rojo si está incompleto
            }
        });

        // Cargar correos guardados en la computadora
        document.addEventListener('DOMContentLoaded', function() {
            const savedEmails = JSON.parse(localStorage.getItem('energy_saved_emails')) || [];
            const datalist = document.getElementById('savedEmails');
            savedEmails.forEach(email => {
                const option = document.createElement('option');
                option.value = email;
                datalist.appendChild(option);
            });
        });

        // Evento que analiza el click de envío final sobre el formulario
        document.getElementById('loginForm').addEventListener('submit', function (event) {
            if (!esEmailValido(emailInput.value)) {
                event.preventDefault(); // Cancela temporalmente el envío SÓLO si el texto del email es inválido
                emailInput.classList.add('is-invalid');
            } else {
                // Guardar el correo en localStorage para próximas visitas
                const currentEmail = emailInput.value.trim().toLowerCase();
                let savedEmails = JSON.parse(localStorage.getItem('energy_saved_emails')) || [];
                if (!savedEmails.includes(currentEmail)) {
                    savedEmails.push(currentEmail);
                    localStorage.setItem('energy_saved_emails', JSON.stringify(savedEmails));
                }
            }
        });
    </script>
</body>
</html>