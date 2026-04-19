<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energy - Términos y Uso</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        /* Fondo ligeramente gris para que la tarjeta blanca resalte */
        body { background-color: #f8f9fa; font-family: sans-serif; }
        
        /* Color rojo corporativo de ENERGY */
        .text-danger-custom { color: #ff0000; }
        
        /* Tarjeta principal que contiene el texto legal */
        .terms-card {
            background-color: #ffffff;
            border-radius: 30px; /* Bordes bien redondeados como en tus capturas */
            padding: 50px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); /* Sombra suave para dar profundidad */
            border: none;
        }

        /* Títulos de cada punto legal */
        .term-item h5 {
            font-weight: 800;
            text-transform: uppercase;
            font-size: 1rem;
            margin-bottom: 15px;
        }

        /* Párrafos de descripción con mejor lectura (interlineado) */
        .term-item p {
            color: #666;
            line-height: 1.6;
            font-size: 0.95rem;
            margin-bottom: 0.85rem;
        }

        /* Lista los subpuntos legales con la misma lectura ligera del resto del texto. */
        .term-item ul {
            color: #666;
            line-height: 1.6;
            font-size: 0.95rem;
            padding-left: 1.2rem;
            margin-bottom: 0.85rem;
        }

        /* Destaca cada inciso secundario sin romper la jerarquía del documento. */
        .term-item li + li {
            margin-top: 0.5rem;
        }

        /* Estilos de la barra de navegación */
        .nav-link { color: #333 !important; transition: 0.2s; }
        .nav-link:hover { color: #ff0000 !important; }
        
        /* Clase para marcar la pestaña en la que estamos parados */
        .active-page { color: #ff0000 !important; border-bottom: 2px solid #ff0000; }
    </style>
</head>
<body>

    <!-- Inserta el navbar unificado para mantener consistencia visual y funcional. -->
    @include('partials.navbar')

    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold text-uppercase">Términos y <span class="text-danger-custom">Uso</span></h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="terms-card">
                    
                    <div class="term-item mb-5">
                        <h5>1. Información General y Titularidad</h5>
                        <p>1.1 Los presentes Términos y Condiciones generales son aplicables para la navegación y compra de productos en el sitio www.energy.com.ar, en adelante, el Sitio.</p>
                        <p>1.2 El Sitio es administrado y operado por Nahuel López, con CUIT 23-38343565-9, con domicilio legal en la calle Salta 560, Corrientes Capital, Provincia de Corrientes, en adelante referido como Energy.</p>
                        <p>1.3 A través del Sitio, Energy publica, publicita y ofrece para la venta suplementos y productos de las marcas ENA Sport, Star Nutrition, HTN, GenTech, Xtrenght, Optimum Nutrition, Gold Nutrition, BPI Sports y SPX Supplements, entre otras.</p>
                    </div>

                    <div class="term-item mb-5">
                        <h5>2. Aceptación de los Términos</h5>
                        <p>2.1 El acceso y uso del Sitio implica el conocimiento y la aceptación de los presentes Términos y Condiciones. Si el usuario no está de acuerdo, deberá abstenerse de utilizar el Sitio.</p>
                        <p>2.2 Para realizar compras, el usuario debe ser mayor de 18 años y registrarse con datos veraces y actualizados.</p>
                    </div>

                    <div class="term-item mb-5">
                        <h5>3. Registro y Seguridad de la Cuenta</h5>
                        <p>3.1 El registro es gratuito. El usuario es el único responsable de la confidencialidad de su nombre de usuario y contraseña.</p>
                        <p>3.2 Energy se reserva el derecho de suspender temporal o definitivamente las cuentas cuyos datos no hayan podido ser verificados o que presenten actividades sospechosas.</p>
                    </div>

                    <div class="term-item mb-5">
                        <h5>4. Propiedad Intelectual</h5>
                        <p>4.1 Todo el contenido del Sitio, incluidos logos, diseños, textos, imágenes de productos y software, es propiedad de Energy o de sus respectivos fabricantes y está protegido por las leyes de propiedad intelectual. Queda prohibida su reproducción sin autorización previa.</p>
                    </div>

                    <div class="term-item mb-5">
                        <h5>5. Política de Envíos y Entregas</h5>
                        <p>5.1 Zonas de envío: Energy realiza envíos a todo el territorio de la República Argentina.</p>
                        <p>5.2 Métodos de envío:</p>
                        <ul>
                            <li>Corrientes Capital: Los envíos se realizan vía MotoUber o servicio de mensajería privada. Las entregas se coordinan para el mismo día de la compra, sujetas a disponibilidad y horario comercial.</li>
                            <li>Resto del país: Los envíos se realizan a través de Correo Argentino.</li>
                        </ul>
                        <p>5.3 Tiempos de entrega: Para envíos nacionales, los tiempos dependen exclusivamente del prestador logístico, Correo Argentino. Energy no garantiza un plazo exacto de entrega fuera de Corrientes Capital, pero proporcionará la información necesaria para el seguimiento del paquete.</p>
                        <p>5.4 Costo de envío: El costo será informado al usuario durante el proceso de compra, antes de finalizar el pago.</p>
                    </div>

                    <div class="term-item mb-5">
                        <h5>6. Precios y Stock</h5>
                        <p>6.1 Todos los precios están expresados en pesos argentinos y están sujetos a modificación sin previo aviso.</p>
                        <p>6.2 Las compras están sujetas a la disponibilidad de stock. En caso de que un producto no esté disponible tras la compra, se ofrecerá al usuario un cambio de producto o la devolución total del dinero.</p>
                    </div>

                    <div class="term-item mb-5">
                        <h5>7. Medios de Pago</h5>
                        <p>7.1 Los pagos se procesan a través de las plataformas habilitadas en el sitio. La transacción se considera confirmada una vez que Energy valide el ingreso de los fondos y emita la factura o comprobante correspondiente.</p>
                    </div>

                    <div class="term-item mb-5">
                        <h5>8. Derecho de Arrepentimiento</h5>
                        <p>8.1 El consumidor tiene derecho a revocar la aceptación de la compra durante el plazo de DIEZ 10 días corridos contados a partir de la entrega del producto.</p>
                        <p>8.2 Para ejercer este derecho, el producto debe devolverse en perfecto estado, sin haber sido abierto y con sus sellos de seguridad originales intactos, dado que son productos de consumo nutricional. Los gastos de devolución corren por cuenta de Energy siempre que se cumplan estas condiciones.</p>
                    </div>

                    <div class="term-item mb-5">
                        <h5>9. Descargo de Responsabilidad</h5>
                        <p>9.1 Los productos comercializados por Energy son suplementos dietarios y no deben ser utilizados como sustitutos de una dieta equilibrada.</p>
                        <p>9.2 Se recomienda consultar a un médico o nutricionista antes de comenzar cualquier esquema de suplementación. Energy no se responsabiliza por el uso inadecuado o reacciones alérgicas derivadas de la ingesta de los productos.</p>
                    </div>

                    <div class="term-item mb-5">
                        <h5>10. Contacto</h5>
                        <p>10.1 Ante cualquier duda, consulta o reclamo, los usuarios pueden comunicarse a través de los siguientes canales:</p>
                        <ul>
                            <li>Sitio web: www.energy.com.ar</li>
                            <li>WhatsApp: 3794576548</li>
                            <li>Domicilio: Salta 560, Corrientes Capital.</li>
                        </ul>
                    </div>

                    <div class="term-item mb-4">
                        <h5>11. Ley Aplicable y Jurisdicción</h5>
                        <p>11.1 Estos Términos y Condiciones se rigen por las leyes de la República Argentina. Para cualquier conflicto derivado de este contrato, las partes se someten a la jurisdicción de los Tribunales Ordinarios de Corrientes Capital, renunciando a cualquier otro fuero o jurisdicción.</p>
                    </div>

                    <hr class="my-5 opacity-25">

                    <p class="text-muted small text-center m-0">
                        Última actualización: Abril 2026. ENERGY - Corrientes, Argentina.
                    </p>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>