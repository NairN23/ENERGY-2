<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaginaContenido;

class PaginaContenidosSeeder extends Seeder
{
    public function run(): void
    {
        $contenidos = [
            // --- QUIÉNES SOMOS ---
            [
                'pagina' => 'quienes_somos',
                'clave' => 'quienes_somos_principal_titulo',
                'titulo' => 'Quiénes Somos - Título Principal',
                'valor' => '¿Quiénes Somos?',
            ],
            [
                'pagina' => 'quienes_somos',
                'clave' => 'quienes_somos_principal_texto',
                'titulo' => 'Quiénes Somos - Texto Principal',
                'valor' => 'Nacimos de la pasión por el deporte en Corrientes. En ENERGY, profesionalizamos la nutrición deportiva para que alcances tus metas de forma segura y constante. Sabemos que detrás de cada entrenamiento hay un objetivo claro, y estamos acá para darte el combustible exacto que necesitás para superar.',
            ],
            [
                'pagina' => 'quienes_somos',
                'clave' => 'quienes_somos_calidad_titulo',
                'titulo' => 'Quiénes Somos - Calidad Título',
                'valor' => 'Calidad Premium',
            ],
            [
                'pagina' => 'quienes_somos',
                'clave' => 'quienes_somos_calidad_texto1',
                'titulo' => 'Quiénes Somos - Calidad Párrafo 1',
                'valor' => 'Trabajamos exclusivamente con laboratorios certificados y marcas líderes en el rubro de la nutrición deportiva. Entendemos que alcanzar tu mejor versión requiere dedicación, y por ello, tu salud es nuestra máxima prioridad. Cada suplemento que sale de nuestra tienda ha sido seleccionado bajo los más estrictos estándares de calidad, garantizando que recibas fórmulas puras, seguras y respaldadas por la ciencia.',
            ],
            [
                'pagina' => 'quienes_somos',
                'clave' => 'quienes_somos_calidad_texto2',
                'titulo' => 'Quiénes Somos - Calidad Párrafo 2',
                'valor' => 'Nuestro equipo se encarga de auditar constantemente el origen y la originalidad de todo nuestro stock. Al elegirnos, no solo estás comprando un producto, sino que estás invirtiendo en la tranquilidad de saber que consumís suplementación con sellos de autenticidad verificados, fechas de caducidad controladas y el respaldo de una tienda que se toma tu rendimiento tan en serio como vos.',
            ],
            [
                'pagina' => 'quienes_somos',
                'clave' => 'quienes_somos_energia_titulo',
                'titulo' => 'Quiénes Somos - Energía Título',
                'valor' => 'Máxima Energía',
            ],
            [
                'pagina' => 'quienes_somos',
                'clave' => 'quienes_somos_energia_texto',
                'titulo' => 'Quiénes Somos - Energía Texto',
                'valor' => 'Entendemos lo que tu cuerpo necesita para que potencies tu rendimiento en cada repetición. Nuestro diferencial es simple: no solo vendemos, te asesoramos. Ya con la garantía de estar consumiendo lo mejor, nuestro equipo se enfoca en escucharte. Entendemos tus metas, ya sea ganar masa muscular o acelerar tu recuperación, y te guiamos para elegir exactamente lo que tu metabolismo exige para romper tus propios límites.',
            ],

            // --- COMERCIALIZACIÓN ---
            [
                'pagina' => 'comercializacion',
                'clave' => 'comercializacion_titulo',
                'titulo' => 'Comercialización - Título Principal',
                'valor' => 'CÓMO COMPRAR',
            ],
            [
                'pagina' => 'comercializacion',
                'clave' => 'comercializacion_subtitulo',
                'titulo' => 'Comercialización - Subtítulo',
                'valor' => 'Tu suplementación favorita en la puerta de tu casa. Rápido, seguro y garantizado.',
            ],
            [
                'pagina' => 'comercializacion',
                'clave' => 'comercializacion_paso1_titulo',
                'titulo' => 'Comercialización - Paso 1 Título',
                'valor' => 'Elegí tus productos',
            ],
            [
                'pagina' => 'comercializacion',
                'clave' => 'comercializacion_paso1_desc',
                'titulo' => 'Comercialización - Paso 1 Descripción',
                'valor' => 'Navegá por nuestro catálogo y seleccioná los suplementos que mejor se adapten a tu objetivo físico.',
            ],
            [
                'pagina' => 'comercializacion',
                'clave' => 'comercializacion_paso2_titulo',
                'titulo' => 'Comercialización - Paso 2 Título',
                'valor' => 'Coordiná el pago',
            ],
            [
                'pagina' => 'comercializacion',
                'clave' => 'comercializacion_paso2_desc',
                'titulo' => 'Comercialización - Paso 2 Descripción',
                'valor' => 'Aceptamos transferencias, tarjetas de crédito/débito y pagos en efectivo al momento de la entrega.',
            ],
            [
                'pagina' => 'comercializacion',
                'clave' => 'comercializacion_paso3_titulo',
                'titulo' => 'Comercialización - Paso 3 Título',
                'valor' => 'Recibí y entrená',
            ],
            [
                'pagina' => 'comercializacion',
                'clave' => 'comercializacion_paso3_desc',
                'titulo' => 'Comercialización - Paso 3 Descripción',
                'valor' => 'Enviamos a todo el NEA. Si sos de Corrientes o Resistencia, recibís en el día con nuestro cadete exclusivo.',
            ],

            // --- INICIO / WELCOME ---
            [
                'pagina' => 'welcome',
                'clave' => 'welcome_slide1_titulo',
                'titulo' => 'Inicio - Slide 1 Título',
                'valor' => 'POTENCIÁ TU MEJOR VERSIÓN',
            ],
            [
                'pagina' => 'welcome',
                'clave' => 'welcome_slide2_titulo',
                'titulo' => 'Inicio - Slide 2 Título',
                'valor' => 'CALIDAD GARANTIZADA',
            ],
            [
                'pagina' => 'welcome',
                'clave' => 'welcome_slide3_titulo',
                'titulo' => 'Inicio - Slide 3 Título',
                'valor' => 'ENVÍOS A TODO EL NEA',
            ],

            // --- CONTACTO ---
            [
                'pagina' => 'contacto',
                'clave' => 'contacto_telefono',
                'titulo' => 'Contacto - Teléfono',
                'valor' => '3794576548',
            ],
            [
                'pagina' => 'contacto',
                'clave' => 'contacto_direccion',
                'titulo' => 'Contacto - Dirección',
                'valor' => 'Salta 560, Corrientes Capital',
            ],
            [
                'pagina' => 'contacto',
                'clave' => 'contacto_instagram',
                'titulo' => 'Contacto - Instagram',
                'valor' => '@energy.nutricion',
            ],
            [
                'pagina' => 'contacto',
                'clave' => 'contacto_mapa_url',
                'titulo' => 'Contacto - Mapa Google (URL del src del iframe)',
                'valor' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3540.04505417833!2d-58.8373188!3d-27.4678255!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94456ca4237d8001%3A0x6734151a37c86576!2sSalta%20560%2C%20W3400%20Corrientes!5e0!3m2!1ses-419!2sar!4v1713554400000!5m2!1ses-419!2sar',
            ],
        ];

        foreach ($contenidos as $cont) {
            PaginaContenido::updateOrCreate(
                ['clave' => $cont['clave']],
                [
                    'pagina' => $cont['pagina'],
                    'titulo' => $cont['titulo'],
                    'valor' => $cont['valor'],
                ]
            );
        }
    }
}
