@php
    // Centraliza el orden del menu y calcula que enlace debe mostrarse como activo.
    $navItems = [
        ['label' => 'Principal', 'url' => '/', 'active' => request()->is('/')],
        ['label' => 'Quiénes Somos', 'url' => '/quienes-somos', 'active' => request()->is('quienes-somos')],
        ['label' => 'Contacto', 'url' => '/contacto', 'active' => request()->is('contacto')],
        ['label' => 'Comercialización', 'url' => '/comercializacion', 'active' => request()->is('comercializacion')],
        ['label' => 'Términos y Usos', 'url' => '/terminos', 'active' => request()->is('terminos')],
        ['label' => 'Catálogo', 'url' => '/catalogo', 'active' => request()->is('catalogo')],
    ];
@endphp

<style>
    /* Mantiene la base del navbar consistente en todas las vistas que usan este parcial. */
    .energy-navbar {
        background-color: #fff;
    }

    /* Apila marca y subtitulo para que el logo se adapte sin romper el header. */
    .energy-navbar .navbar-brand {
        display: flex;
        flex-direction: column;
        gap: 0.1rem;
        font-size: clamp(1rem, 1.5vw, 1.25rem);
        line-height: 1;
        white-space: normal;
    }

    /* Diferencia visualmente el subtitulo sin competir con el nombre principal. */
    .energy-navbar .brand-subtitle {
        color: #6c757d;
        font-size: 0.68rem;
        font-weight: 300;
        letter-spacing: 0.16em;
        text-transform: uppercase;
    }

    /* Limpia el boton hamburguesa para que se integre con el diseño del navbar. */
    .energy-navbar .navbar-toggler {
        border: 0;
        box-shadow: none !important;
        padding: 0.35rem 0.5rem;
    }

    .energy-navbar .navbar-toggler:focus {
        box-shadow: none;
    }

    /* Da estilo comun a los enlaces y prepara el subrayado del estado activo. */
    .energy-navbar .energy-nav-link {
        border-bottom: 2px solid transparent;
        color: #333 !important;
        font-size: 0.83rem;
        letter-spacing: 0.04em;
        padding: 0.75rem 0 !important;
        transition: color 0.2s ease, border-color 0.2s ease;
    }

    /* Resalta hover y pagina actual con el color de acento de la marca. */
    .energy-navbar .energy-nav-link:hover,
    .energy-navbar .energy-nav-link.active {
        color: #ff0000 !important;
        border-bottom-color: #ff0000;
    }

    /* Mantiene la lista alineada cuando el navbar esta expandido. */
    .energy-navbar .energy-nav-list {
        align-items: center;
    }

    /* Reserva un bloque fijo para las acciones de usuario y carrito. */
    .energy-navbar .energy-actions {
        flex-shrink: 0;
        min-width: max-content;
    }

    /* Convierte los iconos del header en accesos clicables sin romper la estetica. */
    .energy-navbar .energy-action-link {
        color: #333;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .energy-navbar .energy-action-link:hover,
    .energy-navbar .energy-action-link.active {
        color: #ff0000;
    }

    /* Agranda levemente los iconos de usuario y carrito para darles más presencia visual. */
    .energy-navbar .energy-action-icon {
        font-size: 1.35rem;
    }

    @media (max-width: 1199.98px) {
        /* Separa visualmente el panel desplegable del encabezado en tablet y mobile. */
        .energy-navbar .navbar-collapse {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(0, 0, 0, 0.08);
        }

        /* Pasa el menu a columna para evitar amontonamiento en pantallas chicas. */
        .energy-navbar .energy-nav-list {
            align-items: stretch;
            gap: 0.25rem !important;
        }

        .energy-navbar .nav-item {
            text-align: center;
        }

        .energy-navbar .energy-nav-link {
            padding: 0.65rem 0 !important;
        }

        /* Mueve las acciones debajo del menu cuando el contenido esta colapsado. */
        .energy-navbar .energy-actions {
            justify-content: center;
            margin-top: 1rem;
            padding-top: 1rem;
            width: 100%;
            border-top: 1px solid rgba(0, 0, 0, 0.08);
        }
    }

    @media (min-width: 1200px) {
        /* Aumenta la separacion horizontal del menu cuando hay espacio de escritorio. */
        .energy-navbar .energy-nav-list {
            gap: 1.25rem !important;
        }

        /* Reduce la altura visual del link para un header mas compacto en desktop. */
        .energy-navbar .energy-nav-link {
            padding: 0.5rem 0 !important;
        }
    }
</style>

<!-- Navbar compartido que reutilizan todas las paginas publicas. -->
<nav class="navbar navbar-expand-xl navbar-light border-bottom sticky-top py-3 energy-navbar">
    <div class="container">
        <!-- Marca principal del sitio con acceso directo a la portada. -->
        <a class="navbar-brand fw-bold" href="/">
            <span>ENERGY</span>
            <span class="brand-subtitle">Sports Nutrition</span>
        </a>

        <!-- Boton que abre o cierra el menu cuando el navbar entra en modo colapsado. -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Abrir menú de navegación">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenedor colapsable que agrupa enlaces y acciones del encabezado. -->
        <div class="collapse navbar-collapse justify-content-xl-center" id="mainNavbar">
            <!-- Genera los enlaces a partir del arreglo superior para no repetir markup. -->
            <ul class="navbar-nav energy-nav-list mx-xl-auto">
                @foreach ($navItems as $item)
                    <li class="nav-item">
                        <a class="nav-link fw-bold text-uppercase energy-nav-link {{ $item['active'] ? 'active' : '' }}" href="{{ $item['url'] }}">
                            {{ $item['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <!-- Accesos rapidos a cuenta y carrito alineados al extremo del navbar. -->
            <div class="d-flex align-items-center gap-3 energy-actions">
                <a href="/login" class="energy-action-link {{ request()->is('login') ? 'active' : '' }}" aria-label="Ir al login de usuario">
                    <i class="bi bi-person energy-action-icon" aria-hidden="true"></i>
                </a>
                <div class="position-relative">
                    <i class="bi bi-cart3 energy-action-icon" aria-hidden="true"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.5rem;">0</span>
                </div>
            </div>
        </div>
    </div>
</nav>