<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energy - Comercialización</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        /* Fondo general de la página en blanco puro */
        body { background-color: #ffffff; }

        /* Estilo base para todas las tarjetas */
        .card {
            /* He oscurecido este gris para que sea visible (antes era #f8f9fa) */
            background-color: #eaeaea; 
            transition: all 0.3s ease;
        }
        
        /* Estilo para los números grandes decorativos que aparecen detrás del texto de cada paso */
        .step-number {
            font-size: 4.5rem;
            font-weight: 800;
            color: #000;
            opacity: 0.05; /* Muy transparente para que no dificulte la lectura del texto principal */
            line-height: 1;
            position: absolute; /* Posicionamiento absoluto respecto a la tarjeta (card) */
            top: 20px;
            left: 20px;
        }

        /* Clase específica para resaltar la tarjeta del paso 02 con un borde rojo característico */
        .card-highlight {
            background-color: #ffffff !important; /* Mantiene la tarjeta central blanca */
            border: 1px solid #ff0000 !important;
        }

        /* Color rojo corporativo personalizado para textos resaltados */
        .text-danger-custom { color: #ff0000; }
        
        /* Estenedor para la sección de métodos de pago con bordes muy redondeados */
        .payment-box {
            border-radius: 40px;
            border: 1px solid #f0f0f0;
            overflow: hidden; /* Asegura que la imagen respete el redondeado del contenedor */
            background-color: #fff;
        }

        /* Hace que la imagen de medios de pago ocupe todo el ancho disponible sin deformarse */
        .payment-box-image {
            display: block;
            width: 100%;
            height: auto;
        }

        /* Configuración de tamaño y alineación para los iconos ilustrativos de cada paso */
        .step-icon {
            width: 92px;
            height: auto;
            display: block;
            margin: 1rem auto 0; /* Centrado horizontal con margen superior */
        }

        /* Tarjetas de Medios de Pago Interactivos */
        .payment-card {
            border: none;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            background: linear-gradient(145deg, #ffffff, #f1f1f1);
            border: 1px solid #e0e0e0;
        }
        .payment-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(255, 0, 0, 0.1);
            border-color: #ff0000;
        }
        .payment-card .icon-container {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background-color: rgba(255, 0, 0, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2.2rem;
            color: #ff0000;
            transition: all 0.3s ease;
        }
        .payment-card:hover .icon-container {
            background-color: #ff0000;
            color: #ffffff;
            transform: scale(1.1);
        }
        .payment-card h5 {
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            color: #1a1a1a;
            font-size: 1.1rem;
        }
        .payment-card p {
            font-size: 0.82rem;
            color: #666;
            margin-bottom: 0;
            line-height: 1.4;
        }

        /* Estilos de los Modales de Medios de Pago */
        .modal-content {
            border-radius: 24px;
            border: none;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
        }
        .modal-header {
            background: #000;
            color: #fff;
            border-bottom: none;
            padding: 20px 30px;
        }
        .modal-body {
            padding: 30px;
        }

        /* Tarjetas de Pasos de Compra Interactivos */
        .step-card {
            background-color: #eaeaea;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            border: 1px solid transparent !important;
        }
        .step-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
            background-color: #ffffff !important;
            border-color: #ff0000 !important;
        }
        .step-card-highlight {
            background-color: #ffffff !important;
            border: 1px solid #ff0000 !important;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .step-card-highlight:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(255, 0, 0, 0.1);
        }
    </style>
</head>
<body>

    @include('partials.navbar')

    <div class="container py-5">
        <div class="text-center mb-5">
            @php
                $tituloRaw = \App\Models\PaginaContenido::getValor('comercializacion_titulo', 'CÓMO COMPRAR');
                // Si contiene "CÓMO COMPRAR", lo separamos para pintar "COMPRAR" en rojo.
                if (stripos($tituloRaw, 'cómo comprar') !== false) {
                    $tituloHtml = 'CÓMO <span class="text-danger-custom">COMPRAR</span>';
                } else {
                    // Si tiene otra palabra, separamos la última palabra para pintarla en rojo
                    $palabras = explode(' ', $tituloRaw);
                    if (count($palabras) > 1) {
                        $ultima = array_pop($palabras);
                        $tituloHtml = implode(' ', $palabras) . ' <span class="text-danger-custom">' . $ultima . '</span>';
                    } else {
                        $tituloHtml = '<span class="text-danger-custom">' . $tituloRaw . '</span>';
                    }
                }
            @endphp
            <h1 class="display-3 fw-bold text-uppercase">{!! $tituloHtml !!}</h1>
            <p class="text-muted fs-5 mt-3">{!! \App\Models\PaginaContenido::getValor('comercializacion_subtitulo', 'Tu suplementación favorita en la puerta de tu casa. Rápido, seguro y garantizado.') !!}</p>
        </div>

        <div class="row g-4 mb-5">
            
            <div class="col-md-4">
                <!-- Tarjeta 01 -->
                <div class="card h-100 step-card border-0 shadow-sm p-4 rounded-4 position-relative" data-bs-toggle="modal" data-bs-target="#modalPaso1">
                    <div class="step-number">01</div>
                    <div class="mt-4 text-center">
                        <h5 class="fw-bold text-uppercase">{!! \App\Models\PaginaContenido::getValor('comercializacion_paso1_titulo', 'Elegí tus productos') !!}</h5>
                        <p class="text-muted small">{!! \App\Models\PaginaContenido::getValor('comercializacion_paso1_desc', 'Navegá por nuestro catálogo y seleccioná los suplementos que mejor se adapten a tu objetivo físico.') !!}</p>
                        <img src="/images/Comercializacion/icono-elegir.png" class="step-icon" alt="Elegí tus productos">
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Tarjeta 02 -->
                <div class="card h-100 step-card-highlight shadow-sm p-4 rounded-4 position-relative" data-bs-toggle="modal" data-bs-target="#modalPaso2">
                    <div class="step-number text-danger-custom" style="opacity: 0.15;">02</div>
                    <div class="mt-4 text-center">
                        <h5 class="fw-bold text-uppercase">{!! \App\Models\PaginaContenido::getValor('comercializacion_paso2_titulo', 'Coordiná el pago') !!}</h5>
                        <p class="text-muted small">{!! \App\Models\PaginaContenido::getValor('comercializacion_paso2_desc', 'Aceptamos transferencias, tarjetas de crédito/débito y pagos en efectivo al momento de la entrega.') !!}</p>
                        <img src="/images/Comercializacion/icono-coordinar.png" class="step-icon" alt="Coordiná el pago">
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Tarjeta 03 -->
                <div class="card h-100 step-card border-0 shadow-sm p-4 rounded-4 position-relative" data-bs-toggle="modal" data-bs-target="#modalPaso3">
                    <div class="step-number">03</div>
                    <div class="mt-4 text-center">
                        <h5 class="fw-bold text-uppercase">{!! \App\Models\PaginaContenido::getValor('comercializacion_paso3_titulo', 'Recibí y entrená') !!}</h5>
                        <p class="text-muted small">{!! \App\Models\PaginaContenido::getValor('comercializacion_paso3_desc', 'Enviamos a todo el NEA. Si sos de Corrientes o Resistencia, recibís en el día con nuestro cadete exclusivo.') !!}</p>
                        <img src="/images/Comercializacion/icono-envios.png" class="step-icon" alt="Recibí y entrená">
                    </div>
                </div>
            </div>
        </div>

        <!-- SECCIÓN DE MEDIOS DE PAGO DINÁMICOS -->
        <div class="mt-5 pt-4">
            <h3 class="fw-bold text-center text-uppercase mb-4">Medios de <span class="text-danger-custom">Pago Aceptados</span></h3>
            <p class="text-center text-muted small mb-5">Hacé clic en cualquiera de las tarjetas de abajo para conocer en detalle las formas de pago, CBU, beneficios y tiempos de procesamiento.</p>
            
            <div class="row g-4 justify-content-center">
                <!-- Tarjeta 1: Transferencia -->
                <div class="col-md-4">
                    <div class="payment-card" data-bs-toggle="modal" data-bs-target="#modalTransferencia">
                        <div class="icon-container">
                            <i class="bi bi-bank"></i>
                        </div>
                        <h5>Transferencia Bancaria</h5>
                        <p><strong>Ahorrá un 10%</strong> de forma automática. Datos de CBU y alias al instante.</p>
                    </div>
                </div>

                <!-- Tarjeta 2: Mercado Pago -->
                <div class="col-md-4">
                    <div class="payment-card" data-bs-toggle="modal" data-bs-target="#modalMercadoPago">
                        <div class="icon-container" style="color: #00b1ea; background-color: rgba(0, 177, 234, 0.08);">
                            <i class="bi bi-wallet2"></i>
                        </div>
                        <h5>Mercado Pago</h5>
                        <p>Acreditación instantánea. Tarjetas de crédito/débito y dinero en cuenta.</p>
                    </div>
                </div>

                <!-- Tarjeta 3: Whatsapp / Efectivo -->
                <div class="col-md-4">
                    <div class="payment-card" data-bs-toggle="modal" data-bs-target="#modalEfectivo">
                        <div class="icon-container" style="color: #25d366; background-color: rgba(37, 211, 102, 0.08);">
                            <i class="bi bi-whatsapp"></i>
                        </div>
                        <h5>Efectivo / WhatsApp</h5>
                        <p>Coordiná el envío a domicilio y aboná al momento de recibir tus suplementos.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL 1: TRANSFERENCIA BANCARIA -->
    <div class="modal fade" id="modalTransferencia" tabindex="-1" aria-labelledby="modalTransferenciaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-uppercase d-flex align-items-center gap-2" id="modalTransferenciaLabel">
                        <i class="bi bi-bank text-danger"></i> Transferencia Bancaria
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger border-0 p-3 mb-4 rounded-3" style="background-color: rgba(255, 0, 0, 0.05); color: #ff0000;">
                        <i class="bi bi-percent fs-5 me-2 align-middle"></i> <strong>10% de descuento directo</strong> aplicado automáticamente sobre el total de tu compra al elegir este método.
                    </div>
                    <p class="text-muted small mb-3">Podés transferir desde cualquier Home Banking o billetera virtual usando los siguientes datos oficiales:</p>
                    
                    <div class="p-3 bg-light rounded-4 border mb-4">
                        <div class="mb-2"><strong>Banco:</strong> Galicia</div>
                        <div class="mb-2"><strong>CBU:</strong> 0070089020000012345678</div>
                        <div class="mb-2"><strong>Alias:</strong> ENERGY.NUTRICION.MP</div>
                        <div class="mb-0"><strong>Titular:</strong> ENERGY SRL</div>
                    </div>
                    
                    <h6 class="fw-bold mb-2 text-uppercase" style="font-size: 0.8rem;"><i class="bi bi-shield-check text-success me-1"></i> ¿Cómo informar el pago?</h6>
                    <p class="text-muted small mb-0">Durante el proceso de compra (Checkout), tendrás disponible un botón de carga para subir una captura o PDF del comprobante de transferencia y agilizar la aprobación del pedido.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL 2: MERCADO PAGO -->
    <div class="modal fade" id="modalMercadoPago" tabindex="-1" aria-labelledby="modalMercadoPagoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: #00b1ea;">
                    <h5 class="modal-title fw-bold text-uppercase d-flex align-items-center gap-2" id="modalMercadoPagoLabel">
                        <i class="bi bi-wallet2 text-white"></i> Mercado Pago
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info border-0 p-3 mb-4 rounded-3" style="background-color: rgba(0, 177, 234, 0.05); color: #00b1ea;">
                        <i class="bi bi-lightning-charge-fill fs-5 me-2 align-middle"></i> Acreditación 100% instantánea. El stock de tu pedido se reserva en el acto.
                    </div>
                    <p class="text-muted small mb-3">La pasarela integrada te permite pagar con:</p>
                    
                    <div class="row g-3 text-center mb-4">
                        <div class="col-4">
                            <div class="p-2 border rounded-3 bg-light">
                                <i class="bi bi-credit-card fs-4 text-primary d-block mb-1"></i>
                                <span class="small d-block" style="font-size: 0.7rem;">Tarjetas</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 border rounded-3 bg-light">
                                <i class="bi bi-phone fs-4 text-success d-block mb-1"></i>
                                <span class="small d-block" style="font-size: 0.7rem;">Dinero MP</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 border rounded-3 bg-light">
                                <i class="bi bi-qr-code-scan fs-4 text-warning d-block mb-1"></i>
                                <span class="small d-block" style="font-size: 0.7rem;">Código QR</span>
                            </div>
                        </div>
                    </div>
                    
                    <h6 class="fw-bold mb-2 text-uppercase" style="font-size: 0.8rem;"><i class="bi bi-info-circle text-info me-1"></i> Sandbox de Pruebas</h6>
                    <p class="text-muted small mb-0">Esta tienda cuenta con el sandbox activo de Mercado Pago para simular transacciones reales sin costos, permitiéndote probar todo el flujo de compra de forma fluida.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL 3: EFECTIVO / WHATSAPP -->
    <div class="modal fade" id="modalEfectivo" tabindex="-1" aria-labelledby="modalEfectivoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: #25d366;">
                    <h5 class="modal-title fw-bold text-uppercase d-flex align-items-center gap-2" id="modalEfectivoLabel">
                        <i class="bi bi-whatsapp text-white"></i> Efectivo / WhatsApp
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success border-0 p-3 mb-4 rounded-3" style="background-color: rgba(37, 211, 102, 0.05); color: #15803d;">
                        <i class="bi bi-truck fs-5 me-2 align-middle"></i> Coordiná de forma 100% personalizada con nuestros asesores comerciales por chat.
                    </div>
                    <p class="text-muted small mb-3">Especialmente diseñado para:</p>
                    
                    <ul class="text-muted small mb-4">
                        <li class="mb-2"><strong>Pago contra entrega (Corrientes/Resistencia):</strong> Le pagás al cadete en efectivo al recibir tu pedido.</li>
                        <li class="mb-2"><strong>Envíos al Interior del NEA:</strong> Coordiná despachos especiales en colectivo o por correo privado.</li>
                        <li class="mb-0"><strong>Dudas y Consultas:</strong> ¿No sabés qué sabor elegir? Te ayudamos por chat.</li>
                    </ul>
                    
                    <h6 class="fw-bold mb-2 text-uppercase" style="font-size: 0.8rem;"><i class="bi bi-whatsapp text-success me-1"></i> Redirección automática</h6>
                    <p class="text-muted small mb-0">Al confirmar tu pedido con este método, se generará una plantilla de texto detallada con tus productos y el total, y te redirigiremos a WhatsApp para enviar el mensaje con un solo clic.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PASO 1 -->
    <div class="modal fade" id="modalPaso1" tabindex="-1" aria-labelledby="modalPaso1Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-uppercase d-flex align-items-center gap-2" id="modalPaso1Label">
                        <i class="bi bi-box-sealer text-danger"></i> 1. Elegí tus Productos
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-dark small mb-3">
                        Explorá nuestro catálogo interactivo de suplementos deportivos premium. Podés filtrar productos por categorías para encontrar de forma rápida lo que necesitás:
                    </p>
                    <ul class="text-muted small mb-4">
                        <li class="mb-2"><strong>Proteínas y Aminoácidos:</strong> Para la recuperación y el desarrollo muscular óptimo.</li>
                        <li class="mb-2"><strong>Pre-entrenos y Creatinas:</strong> Para aumentar tu energía y fuerza en cada sesión.</li>
                        <li class="mb-2"><strong>Quemadores y Salud:</strong> Para optimizar tu composición corporal y bienestar general.</li>
                    </ul>
                    <p class="text-muted small mb-0">
                        Cada producto cuenta con controles de cantidad y stock real para evitar inconvenientes, y los <strong>combos de ahorro</strong> detallan todos los componentes que incluyen.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PASO 2 -->
    <div class="modal fade" id="modalPaso2" tabindex="-1" aria-labelledby="modalPaso2Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: #ff0000;">
                    <h5 class="modal-title fw-bold text-uppercase d-flex align-items-center gap-2" id="modalPaso2Label">
                        <i class="bi bi-wallet2 text-white"></i> 2. Coordiná el Pago
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-dark small mb-3">
                        Ofrecemos diferentes modalidades de pago seguras y adaptadas a tu comodidad:
                    </p>
                    <ul class="text-muted small mb-4">
                        <li class="mb-2"><strong>Transferencia Bancaria:</strong> Pagá cómodamente y obtené un <strong>10% de descuento directo</strong> en tu pedido. Podrás subir tu comprobante de pago en el mismo checkout.</li>
                        <li class="mb-2"><strong>Mercado Pago:</strong> Integración inmediata con tu cuenta de Mercado Pago o tarjetas para acreditación instantánea.</li>
                        <li class="mb-2"><strong>WhatsApp / Efectivo:</strong> Reservá tu pedido y coordina directamente con nuestro equipo el pago en efectivo contra entrega.</li>
                    </ul>
                    <p class="text-muted small mb-0">
                        En la sección de abajo podés hacer clic en cada método de pago para conocer los alias, CBU y detalles correspondientes de facturación.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PASO 3 -->
    <div class="modal fade" id="modalPaso3" tabindex="-1" aria-labelledby="modalPaso3Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-uppercase d-flex align-items-center gap-2" id="modalPaso3Label">
                        <i class="bi bi-truck text-danger"></i> 3. Recibí y Entrená
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-dark small mb-3">
                        Llegamos a donde estés con envíos rápidos y seguros en toda la región:
                    </p>
                    <ul class="text-muted small mb-4">
                        <li class="mb-2"><strong>Corrientes Capital y Resistencia:</strong> Recibís tu pedido en el día a través de nuestro servicio exclusivo de motomandados.</li>
                        <li class="mb-2"><strong>Interior del NEA:</strong> Despachamos mediante transportistas de confianza o colectivos dentro de las 24 horas hábiles posteriores al pago.</li>
                    </ul>
                    <p class="text-muted small mb-0">
                        Una vez despachado el pedido, recibirás las notificaciones de estado correspondientes y nuestro canal de WhatsApp quedará abierto para que le hagas seguimiento en tiempo real con un asesor.
                    </p>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cards = document.querySelectorAll('[data-bs-toggle="modal"]');
            
            cards.forEach(card => {
                const targetModalId = card.getAttribute('data-bs-target');
                const modalEl = document.querySelector(targetModalId);
                if (!modalEl) return;
                
                let modalInstance = null;
                let active = false;
                
                let hoverTimeout = null;
                
                // Abrir modal en mouseenter con retardo (Hover Intent)
                card.addEventListener('mouseenter', () => {
                    if (!window.matchMedia('(hover: hover)').matches) return;
                    
                    // Limpiar temporizadores previos
                    clearTimeout(hoverTimeout);
                    
                    // Retardo de 300ms para asegurar la intención de hover
                    hoverTimeout = setTimeout(() => {
                        // Cerrar otros modals que puedan estar abiertos
                        document.querySelectorAll('.modal.show').forEach(openModal => {
                            if (openModal !== modalEl) {
                                const inst = bootstrap.Modal.getInstance(openModal);
                                if (inst) inst.hide();
                            }
                        });
                        
                        if (!modalInstance) {
                            modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                        }
                        modalInstance.show();
                        active = true;
                    }, 300);
                });
                
                // Cancelar la apertura si el mouse sale antes de que se cumpla el retardo
                card.addEventListener('mouseleave', () => {
                    clearTimeout(hoverTimeout);
                });
                
                // Seguir movimiento de coordenadas para cerrar modal si sale de ambos contenedores
                function onMouseMove(e) {
                    if (!active) return;
                    
                    const cardRect = card.getBoundingClientRect();
                    const modalContent = modalEl.querySelector('.modal-content');
                    const modalRect = modalContent ? modalContent.getBoundingClientRect() : null;
                    
                    const x = e.clientX;
                    const y = e.clientY;
                    
                    // Añadir un margen de 15px alrededor de la tarjeta para evitar cierres accidentales al mover el mouse
                    const insideCard = (
                        x >= cardRect.left - 15 && 
                        x <= cardRect.right + 15 && 
                        y >= cardRect.top - 15 && 
                        y <= cardRect.bottom + 15
                    );
                    
                    // Añadir un margen de 15px alrededor del modal
                    const insideModal = modalRect ? (
                        x >= modalRect.left - 15 && 
                        x <= modalRect.right + 15 && 
                        y >= modalRect.top - 15 && 
                        y <= modalRect.bottom + 15
                    ) : false;
                    
                    if (!insideCard && !insideModal) {
                        clearTimeout(hoverTimeout);
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                        active = false;
                    }
                }
                
                // Escuchar el cierre manual por backdrop/botones para resetear estado activo
                modalEl.addEventListener('hidden.bs.modal', () => {
                    active = false;
                    clearTimeout(hoverTimeout);
                });
                
                window.addEventListener('mousemove', onMouseMove);
            });
        });
    </script>
</body>
</html>