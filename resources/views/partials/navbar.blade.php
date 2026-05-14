@php
    /**
     * CONFIGURACIÓN DEL MENÚ
     * Definimos los enlaces en un arreglo para no repetir código HTML.
     * 'active' usa la función request()->is() de Laravel para resaltar la página actual.
     */
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
    /* Estilos generales de la barra de navegación */
    .energy-navbar {
        background-color: #fff;
    }

    /* Estilo del Logo: Apila el nombre y el subtítulo en columna */
    .energy-navbar .navbar-brand {
        display: flex;
        flex-direction: column;
        gap: 0.1rem;
        font-size: clamp(1rem, 1.5vw, 1.25rem);
        line-height: 1;
        white-space: normal;
    }

    /* Estilo del subtítulo debajo del logo */
    .energy-navbar .brand-subtitle {
        color: #6c757d;
        font-size: 0.68rem;
        font-weight: 300;
        letter-spacing: 0.16em;
        text-transform: uppercase;
    }

    /* Quita bordes y sombras por defecto del botón de menú móvil */
    .energy-navbar .navbar-toggler {
        border: 0;
        box-shadow: none !important;
        padding: 0.35rem 0.5rem;
    }

    .energy-navbar .navbar-toggler:focus {
        box-shadow: none;
    }

    /* Diseño de los enlaces del menú */
    .energy-navbar .energy-nav-link {
        border-bottom: 2px solid transparent;
        color: #333 !important;
        font-size: 0.83rem;
        letter-spacing: 0.04em;
        padding: 0.75rem 0 !important;
        transition: color 0.2s ease, border-color 0.2s ease;
    }

    /* Estado 'Hover' (pasar el mouse) y 'Active' (página actual) en rojo */
    .energy-navbar .energy-nav-link:hover,
    .energy-navbar .energy-nav-link.active {
        color: #ff0000 !important;
        border-bottom-color: #ff0000;
    }

    /* Alineación vertical de los elementos de la lista */
    .energy-navbar .energy-nav-list {
        align-items: center;
    }

    /* Contenedor de iconos de usuario y carrito */
    .energy-navbar .energy-actions {
        flex-shrink: 0;
        min-width: max-content;
    }

    /* Estilo para los iconos de acción */
    .energy-navbar .energy-action-link {
        color: #333;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    /* Color rojo para iconos activos o al pasar el mouse */
    .energy-navbar .energy-action-link:hover,
    .energy-navbar .energy-action-link.active {
        color: #ff0000;
    }

    /* Tamaño de los iconos de Bootstrap */
    .energy-navbar .energy-action-icon {
        font-size: 1.35rem;
    }

    /* AJUSTES PARA TABLETS Y MÓVILES (Menos de 1200px) */
    @media (max-width: 1199.98px) {
        .energy-navbar .navbar-collapse {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(0, 0, 0, 0.08);
        }

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

        /* Acciones (User/Carrito) se van al final del menú desplegable */
        .energy-navbar .energy-actions {
            justify-content: center;
            margin-top: 1rem;
            padding-top: 1rem;
            width: 100%;
            border-top: 1px solid rgba(0, 0, 0, 0.08);
        }
    }

    /* AJUSTES PARA ESCRITORIO (Más de 1200px) */
    @media (min-width: 1200px) {
        .energy-navbar .energy-nav-list {
            gap: 1.25rem !important;
        }

        .energy-navbar .energy-nav-link {
            padding: 0.5rem 0 !important;
        }
    }
</style>

<!-- ESTRUCTURA DEL NAVBAR -->
<nav class="navbar navbar-expand-xl navbar-light border-bottom sticky-top py-3 energy-navbar">
    <div class="container">
        <!-- Logo de la marca -->
        <a class="navbar-brand fw-bold" href="/">
            <span>ENERGY</span>
            <span class="brand-subtitle">Sports Nutrition</span>
        </a>

        <!-- Botón Hamburguesa para móviles -->
        <button class="navbar-toggler" type="button" id="mainNavbarToggler" aria-controls="mainNavbar" aria-expanded="false" aria-label="Abrir menú de navegación">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenedor colapsable del menú -->
        <div class="collapse navbar-collapse justify-content-xl-center" id="mainNavbar">
            
            <!-- Generación dinámica de links mediante el arreglo definido arriba -->
            <ul class="navbar-nav energy-nav-list mx-xl-auto">
                @foreach ($navItems as $item)
                    <li class="nav-item">
                        <a class="nav-link fw-bold text-uppercase energy-nav-link {{ $item['active'] ? 'active' : '' }}" href="{{ $item['url'] }}">
                            {{ $item['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <!-- Iconos de Login y Carrito -->
            <div class="d-flex align-items-center gap-3 energy-actions">
                <!-- Enlace de Usuario/Login -->
                <a href="/login" class="energy-action-link {{ request()->is('login') ? 'active' : '' }}" aria-label="Ir al login de usuario">
                    <i class="bi bi-person energy-action-icon" aria-hidden="true"></i>
                </a>
                
                <!-- Enlace de Carrito con indicador de cantidad (Badge) -->
                <a href="/carrito" class="energy-action-link position-relative" aria-label="Ver carrito de compras">
                    <i class="bi bi-cart3 energy-action-icon" aria-hidden="true"></i>
                    <!-- El badge se oculta/muestra mediante JS según si hay productos -->
                    <span id="cart-count-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.55rem; display: none;">
                        0
                    </span>
                </a>
            </div>
        </div>
    </div>
</nav>

<script>
    /**
     * ACTUALIZACIÓN DEL CARRITO
     * Busca los productos guardados en el navegador (localStorage) y actualiza el número rojo.
     */
    function syncCartBadge() {
        const badge = document.getElementById('cart-count-badge');
        if (badge) {
            const cart = JSON.parse(localStorage.getItem('energy_cart')) || [];
            const totalItems = cart.length;
            
            badge.innerText = totalItems;
            
            // Si el carrito está vacío, ocultamos el círculo rojo
            badge.style.display = totalItems > 0 ? 'block' : 'none';
        }
    }

    // Ejecuta la actualización al cargar la página
    document.addEventListener('DOMContentLoaded', syncCartBadge);

    /**
     * LÓGICA DEL BOTÓN MÓVIL (MENU HAMBURGUESA)
     * Asegura que el menú abra y cierre correctamente y actualice los estados de accesibilidad.
     */
    document.addEventListener('DOMContentLoaded', () => {
        const toggler = document.getElementById('mainNavbarToggler');
        const collapseElement = document.getElementById('mainNavbar');

        if (!toggler || !collapseElement) return;

        const updateExpanded = () => {
            toggler.setAttribute('aria-expanded', collapseElement.classList.contains('show') ? 'true' : 'false');
        };

        // Verifica si Bootstrap 5 está disponible para usar su motor de animaciones
        if (window.bootstrap && window.bootstrap.Collapse) {
            const collapse = window.bootstrap.Collapse.getOrCreateInstance(collapseElement, { toggle: false });

            toggler.addEventListener('click', () => {
                collapse.toggle();
            });

            collapseElement.addEventListener('shown.bs.collapse', updateExpanded);
            collapseElement.addEventListener('hidden.bs.collapse', updateExpanded);
        } else {
            // Si no hay Bootstrap JS, funciona mediante cambio de clases básico
            toggler.addEventListener('click', () => {
                collapseElement.classList.toggle('show');
                updateExpanded();
            });
        }

        updateExpanded();
    });

    /**
     * SINCRONIZACIÓN ENTRE PESTAÑAS
     * Si el usuario agrega algo al carrito en otra pestaña, esta función actualiza el número en la actual.
     */
    window.addEventListener('storage', (event) => {
        if (event.key === 'energy_cart') {
            syncCartBadge();
        }
    });
</script>