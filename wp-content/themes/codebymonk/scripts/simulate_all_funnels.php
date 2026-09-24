<?php
/**
 * Script de Simulación Completa de Funnels Zones of Life
 * Envía todos los correos del funnel a erika@attikka.com y enrique@attikka.com
 */

// 1. Cargar WordPress
require_once __DIR__ . '/../../../../wp-load.php';
require_once WP_PLUGIN_DIR . '/aclc-plugin/includes/class-funnel-emails.php';
require_once WP_PLUGIN_DIR . '/aclc-plugin/includes/class-zapier.php';

$recipients = [
    [
        'name'  => 'Enrique',
        'email' => 'enrique@attikka.com',
        'phone' => '+525619956812'
    ]
];

$lang = 'es';
$finance_url    = home_url('/es/perfil-financiero/');
$quiz_url       = home_url('/es/perfil-corto/');
$dashboard_url  = home_url('/user-home/');
$coaching_url   = home_url('/adquirir/?package=coaching');
$calendly_url   = function_exists('aclc_get_coach_calendly_url') ? aclc_get_coach_calendly_url() : 'https://calendly.com/';
$sample_graph   = home_url('/wp-content/uploads/aclc-graphs/Finance1973.png');

echo "=====================================================\n";
echo " INICIANDO SIMULACIÓN COMPLETA (CORREOS + WHATSAPP)\n";
echo " Destinatario: Enrique (enrique@attikka.com)\n";
echo " WhatsApp Destino: +525619956812\n";
echo " WhatsApp Emisor Oficial: " . ACLC_Funnel_Events::WHATSAPP_ES . "\n";
echo "=====================================================\n\n";

foreach ($recipients as $recipient) {
    $name  = $recipient['name'];
    $email = $recipient['email'];
    $phone = $recipient['phone'];

    echo ">>> PARTE 1: ENVIANDO SECUENCIA DE CORREOS (MANDRILL SMTP)\n";

    $emails_to_send = [
        // FLUJO A: Abandono del Mini Perfil
        [
            'code' => 'A1',
            'flow' => 'Flujo A (Abandono 1h)',
            'data' => ACLC_Funnel_Emails::get_email_a1($name, $quiz_url, $lang, 10, 20),
        ],
        [
            'code' => 'A3',
            'flow' => 'Flujo A (Abandono 72h)',
            'data' => ACLC_Funnel_Emails::get_email_a3($name, $quiz_url, $lang, 27),
        ],

        // FLUJO B: Nutrición y Venta del Perfil ($500 MXN)
        [
            'code' => 'B1',
            'flow' => 'Flujo B (Inmediato tras Mini Perfil)',
            'data' => ACLC_Funnel_Emails::get_email_b1(
                $name,
                'Investigar',
                'Las decisiones caras casi nunca se toman por falta de dinero, sino por falta de preguntas antes de firmar.',
                $finance_url,
                $lang,
                'Amber',
                [
                    ['name' => 'Tener', 'score' => 2, 'zone' => 'Amarilla', 'lowest' => false],
                    ['name' => 'Investigar', 'score' => 1, 'zone' => 'Roja', 'lowest' => true],
                    ['name' => 'Enfocar', 'score' => 2, 'zone' => 'Amarilla', 'lowest' => false],
                    ['name' => 'Invertir', 'score' => 3, 'zone' => 'Verde', 'lowest' => false],
                    ['name' => 'Producir', 'score' => 2, 'zone' => 'Amarilla', 'lowest' => false],
                    ['name' => 'Crear riqueza', 'score' => 2, 'zone' => 'Amarilla', 'lowest' => false],
                ],
                'Batallando para tener',
                'Tu resultado quedó en la parte alta de la Zona Amarilla: estás batallando para tener.'
            ),
        ],
        [
            'code' => 'B5',
            'flow' => 'Flujo B (Día 1 - El orden importa)',
            'data' => ACLC_Funnel_Emails::get_email_b5($name, 'Investigar', $finance_url, $lang),
        ],
        [
            'code' => 'B7',
            'flow' => 'Flujo B (Día 5 - Cuánto cuesta adivinar)',
            'data' => ACLC_Funnel_Emails::get_email_b7($name, $finance_url, $lang),
        ],
        [
            'code' => 'B8',
            'flow' => 'Flujo B (Día 7 - Qué incluye tu perfil)',
            'data' => ACLC_Funnel_Emails::get_email_b8($name, $finance_url, $lang),
        ],
        [
            'code' => 'B11',
            'flow' => 'Flujo B (Día 14 - ¿Lo dejamos en el mini perfil?)',
            'data' => ACLC_Funnel_Emails::get_email_b11($name, 'Investigar', $finance_url, $lang),
        ],

        // FLUJO P: Confirmación de Compra
        [
            'code' => 'P1a',
            'flow' => 'Flujo P (Compra Perfil Automático $500 MXN)',
            'data' => ACLC_Funnel_Emails::get_email_p1a($name, $finance_url, $lang),
        ],
        [
            'code' => 'P1b',
            'flow' => 'Flujo P (Compra Perfil + Sesión Coach $1,640 MXN)',
            'data' => ACLC_Funnel_Emails::get_email_p1b($name, $finance_url, $lang),
        ],

        // FLUJO D: Perfil de 100 Preguntas Terminado (con entregables reales y PDF adjunto)
        [
            'code' => 'D1',
            'flow' => 'Flujo D (Perfil Listo + Gráfica + Cuaderno PDF Adjunto + Audio + Sesión $1,940)',
            'data' => ACLC_Funnel_Emails::get_email_d1($name, $dashboard_url, $coaching_url, $lang, $sample_graph, 'Investigar'),
            'attachments' => [ACLC_Funnel_Emails::get_workbook_path($lang)],
        ],
        [
            'code' => 'D3',
            'flow' => 'Flujo D (Día 2 - Antes de abrir tu cuaderno, escucha esto en SoundCloud)',
            'data' => ACLC_Funnel_Emails::get_email_d3($name, $lang, 'Investigar'),
        ],
        [
            'code' => 'D4',
            'flow' => 'Flujo D (Día 4 - Cómo sacarle provecho a tu cuaderno de trabajo)',
            'data' => ACLC_Funnel_Emails::get_email_d4($name, $coaching_url, $lang, 'Investigar'),
        ],
        [
            'code' => 'D5',
            'flow' => 'Flujo D (Día 7 - Revisa con un Coach $1,940 MXN)',
            'data' => ACLC_Funnel_Emails::get_email_d5($name, $coaching_url, $lang, 'Investigar'),
        ],

        // RAMA DS: Agendamiento de Sesión Privada en Calendly con Raúl
        [
            'code' => 'DS1',
            'flow' => 'Rama DS (Agenda tu Sesión en Calendly con Raúl + Cuaderno Adjunto)',
            'data' => ACLC_Funnel_Emails::get_email_ds1($name, $calendly_url, $lang, 'Investigar'),
            'attachments' => [ACLC_Funnel_Emails::get_workbook_path($lang)],
        ],
    ];

    foreach ($emails_to_send as $item) {
        $subject = "[SIMULACIÓN {$item['code']}] " . $item['data']['subject'];
        $html    = $item['data']['html'];
        $attachments = $item['attachments'] ?? [];

        $sent = ACLC_Funnel_Emails::send($email, $subject, $html, $lang, $attachments);

        if ($sent) {
            $att_note = !empty($attachments) ? ' [PDF Adjunto ' . round(filesize($attachments[0])/1048576, 2) . 'MB]' : '';
            echo "  ✓ [{$item['code']}] {$item['flow']}{$att_note} -> ENVIADO\n";
        } else {
            echo "  ✗ [{$item['code']}] {$item['flow']} -> FALLÓ\n";
        }

        usleep(400000); // 0.4 segundos
    }

    echo "\n>>> PARTE 2: ENVIANDO EVENTOS WHATSAPP (A TRAVÉS DE ZAPIER)\n";

    $whatsapp_events = [
        [
            'code'    => 'B2',
            'flow'    => 'Flujo B (WhatsApp 2h tras Mini Perfil)',
            'message' => "{$name}, aquí está tu resultado del Mini Perfil Financiero. Tu Habilidad para Tener quedó en Batallando para tener. Te enviamos la gráfica y explicación completa a tu correo: {$email}",
        ],
        [
            'code'    => 'B6',
            'flow'    => 'Flujo B (WhatsApp Día 1 - El orden importa)',
            'message' => "{$name}, ¿viste tu gráfica del Mini Perfil? Medir una sola habilidad es como pesarte sin saber tu estatura. Con tu Perfil completo mides las 6 habilidades por solo $500 MXN.",
        ],
        [
            'code'    => 'D2',
            'flow'    => 'Flujo D (WhatsApp Inmediato al generarse la gráfica de 100 preguntas)',
            'message' => "{$name}, tu Perfil de Salud Financiera está listo. Te enviamos a tu correo la gráfica, el audio de Alan C. Walter (SoundCloud) y tu cuaderno de trabajo en PDF.",
        ],
        [
            'code'    => 'DS2',
            'flow'    => 'Rama DS (WhatsApp Inmediato tras compra con sesión)',
            'message' => "{$name}, tu sesión privada de 60 minutos con tu coach Raul está lista para agendar. Ingresa aquí para elegir tu horario: {$calendly_url}",
        ],
    ];

    foreach ($whatsapp_events as $wa) {
        $dispatched = ACLC_Zapier::dispatch_whatsapp_message($phone, $wa['message'], $name, $email, $lang, $wa['code']);
        if ($dispatched) {
            echo "  ✓ [{$wa['code']}] {$wa['flow']} -> DISPARADO A ZAPIER (+525619956812)\n";
        } else {
            echo "  ✗ [{$wa['code']}] {$wa['flow']} -> ERROR AL ENVIAR A ZAPIER\n";
        }
        usleep(300000);
    }

    echo "\n";
}

echo "=====================================================\n";
echo " SIMULACIÓN COMPLETADA EXITOSAMENTE\n";
echo "=====================================================\n";
