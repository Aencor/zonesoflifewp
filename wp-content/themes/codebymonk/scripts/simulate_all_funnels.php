<?php
/**
 * Script de Simulación Completa de Funnels Zones of Life en Dos Idiomas (ES & EN)
 * Simula todos los correos y mensajes de WhatsApp para Enrique (enrique@attikka.com, +525619956812)
 */

// 1. Cargar WordPress
require_once __DIR__ . '/../../../../wp-load.php';
require_once WP_PLUGIN_DIR . '/aclc-plugin/includes/class-funnel-emails.php';
require_once WP_PLUGIN_DIR . '/aclc-plugin/includes/class-zapier.php';

$name  = 'Erika';
$email = 'erika@attikka.com';
$phone = '+525619956812';

$languages = ['es', 'en'];

$dashboard_url = home_url('/user-home/');
$calendly_url  = function_exists('aclc_get_coach_calendly_url') ? aclc_get_coach_calendly_url() : 'https://calendly.com/raulrivera/perfil-financiero-uno-a-uno';
$sample_graph  = home_url('/wp-content/uploads/aclc-graphs/Finance1973.png');

echo "=========================================================================\n";
echo " INICIANDO SIMULACIÓN COMPLETA DE FUNNELS EN DOS IDIOMAS (ES & EN)\n";
echo " Destinatario: {$name} ({$email})\n";
echo " Teléfono WhatsApp: {$phone}\n";
echo " Bot WhatsApp Oficial: " . ACLC_Funnel_Events::WHATSAPP_ES . "\n";
echo "=========================================================================\n\n";

foreach ($languages as $lang) {
    $is_en = ($lang === 'en');
    $lang_label = $is_en ? 'ENGLISH (EN)' : 'ESPAÑOL (ES)';

    $finance_url  = $is_en ? home_url('/finance/') : home_url('/es/perfil-financiero/');
    $quiz_url     = $is_en ? home_url('/short-quiz/') : home_url('/es/perfil-corto/');
    $coaching_url = $is_en ? home_url('/pay/?package=coaching') : home_url('/adquirir/?package=coaching');
    $lowest_hab   = $is_en ? 'Investigate' : 'Investigar';
    $quote        = $is_en
        ? 'Expensive decisions are almost never made from lack of money, but from lack of questions before signing.'
        : 'Las decisiones caras casi nunca se toman por falta de dinero, sino por falta de preguntas antes de firmar.';
    $level_name   = $is_en ? 'Struggling to have' : 'Batallando para tener';
    $level_quote  = $is_en
        ? 'Your score is in the upper Amber Zone: you are struggling to have.'
        : 'Tu resultado quedó en la parte alta de la Zona Amarilla: estás batallando para tener.';

    $abilities = $is_en ? [
        ['name' => 'Have', 'score' => 2, 'zone' => 'Yellow', 'lowest' => false],
        ['name' => 'Investigate', 'score' => 1, 'zone' => 'Red', 'lowest' => true],
        ['name' => 'Focus', 'score' => 2, 'zone' => 'Yellow', 'lowest' => false],
        ['name' => 'Invest', 'score' => 3, 'zone' => 'Green', 'lowest' => false],
        ['name' => 'Produce', 'score' => 2, 'zone' => 'Yellow', 'lowest' => false],
        ['name' => 'Create Wealth', 'score' => 2, 'zone' => 'Yellow', 'lowest' => false],
    ] : [
        ['name' => 'Tener', 'score' => 2, 'zone' => 'Amarilla', 'lowest' => false],
        ['name' => 'Investigar', 'score' => 1, 'zone' => 'Roja', 'lowest' => true],
        ['name' => 'Enfocar', 'score' => 2, 'zone' => 'Amarilla', 'lowest' => false],
        ['name' => 'Invertir', 'score' => 3, 'zone' => 'Verde', 'lowest' => false],
        ['name' => 'Producir', 'score' => 2, 'zone' => 'Amarilla', 'lowest' => false],
        ['name' => 'Crear riqueza', 'score' => 2, 'zone' => 'Amarilla', 'lowest' => false],
    ];

    echo "#########################################################################\n";
    echo " IDIOMA: {$lang_label}\n";
    echo "#########################################################################\n\n";

    echo ">>> [{$lang_label}] PARTE 1: SECUENCIA DE CORREOS ELECTRÓNICOS\n";

    $emails_to_send = [
        // Flujo A: Abandono Mini Perfil
        [
            'code' => 'A1',
            'flow' => ($is_en ? 'Flow A (Abandon 1h)' : 'Flujo A (Abandono 1h)'),
            'data' => ACLC_Funnel_Emails::get_email_a1($name, $quiz_url, $lang, 10, 20),
        ],
        [
            'code' => 'A3',
            'flow' => ($is_en ? 'Flow A (Abandon 72h)' : 'Flujo A (Abandono 72h)'),
            'data' => ACLC_Funnel_Emails::get_email_a3($name, $quiz_url, $lang, 27),
        ],

        // Flujo B: Nutrición y Venta del Perfil
        [
            'code' => 'B1',
            'flow' => ($is_en ? 'Flow B (Immediate after Mini Profile)' : 'Flujo B (Inmediato tras Mini Perfil)'),
            'data' => ACLC_Funnel_Emails::get_email_b1($name, $lowest_hab, $quote, $finance_url, $lang, 'Amber', $abilities, $level_name, $level_quote),
        ],
        [
            'code' => 'B5',
            'flow' => ($is_en ? 'Flow B (Day 1 - Order Matters)' : 'Flujo B (Día 1 - El orden importa)'),
            'data' => ACLC_Funnel_Emails::get_email_b5($name, $lowest_hab, $finance_url, $lang),
        ],
        [
            'code' => 'B7',
            'flow' => ($is_en ? 'Flow B (Day 5 - Cost of Guessing)' : 'Flujo B (Día 5 - Cuánto cuesta adivinar)'),
            'data' => ACLC_Funnel_Emails::get_email_b7($name, $finance_url, $lang),
        ],
        [
            'code' => 'B8',
            'flow' => ($is_en ? 'Flow B (Day 7 - What Profile Includes)' : 'Flujo B (Día 7 - Qué incluye tu perfil)'),
            'data' => ACLC_Funnel_Emails::get_email_b8($name, $finance_url, $lang),
        ],
        [
            'code' => 'B11',
            'flow' => ($is_en ? 'Flow B (Day 14 - Leave at mini profile?)' : 'Flujo B (Día 14 - ¿Lo dejamos en el mini perfil?)'),
            'data' => ACLC_Funnel_Emails::get_email_b11($name, $lowest_hab, $finance_url, $lang),
        ],

        // Flujo P: Compra / Activación
        [
            'code' => 'P1a',
            'flow' => ($is_en ? 'Flow P (Purchase Profile $25 USD)' : 'Flujo P (Compra Perfil Automático $500 MXN)'),
            'data' => ACLC_Funnel_Emails::get_email_p1a($name, $finance_url, $lang),
        ],
        [
            'code' => 'P1b',
            'flow' => ($is_en ? 'Flow P (Purchase Profile + Session $85 USD)' : 'Flujo P (Compra Perfil + Sesión Coach $1,640 MXN)'),
            'data' => ACLC_Funnel_Emails::get_email_p1b($name, $finance_url, $lang),
        ],

        // Flujo D: Perfil 100 Preguntas Terminado
        [
            'code' => 'D1',
            'flow' => ($is_en ? 'Flow D (Profile Ready + Chart + Workbook PDF Attached + SoundCloud Audio + Upgrade)' : 'Flujo D (Perfil Listo + Gráfica + Cuaderno PDF Adjunto + Audio SoundCloud + Sesión $1,640)'),
            'data' => ACLC_Funnel_Emails::get_email_d1($name, $dashboard_url, $coaching_url, $lang, $sample_graph, $lowest_hab),
            'attachments' => [ACLC_Funnel_Emails::get_workbook_path($lang)],
        ],
        [
            'code' => 'D3',
            'flow' => ($is_en ? 'Flow D (Day 2 - Before opening workbook, listen to audio)' : 'Flujo D (Día 2 - Antes de abrir tu cuaderno, escucha esto en SoundCloud)'),
            'data' => ACLC_Funnel_Emails::get_email_d3($name, $lang, $lowest_hab),
        ],
        [
            'code' => 'D4',
            'flow' => ($is_en ? 'Flow D (Day 4 - Getting the most from your workbook)' : 'Flujo D (Día 4 - Cómo sacarle provecho a tu cuaderno de trabajo)'),
            'data' => ACLC_Funnel_Emails::get_email_d4($name, $coaching_url, $lang, $lowest_hab),
        ],
        [
            'code' => 'D5',
            'flow' => ($is_en ? 'Flow D (Day 7 - Review chart with a coach)' : 'Flujo D (Día 7 - Revisa tu gráfica con un coach $1,640 MXN)'),
            'data' => ACLC_Funnel_Emails::get_email_d5($name, $coaching_url, $lang, $lowest_hab),
        ],

        // Rama DS: Agendamiento en Calendly
        [
            'code' => 'DS1',
            'flow' => ($is_en ? 'Branch DS (Book your session on Calendly + Workbook Attached)' : 'Rama DS (Agenda tu Sesión en Calendly con Raúl + Cuaderno Adjunto)'),
            'data' => ACLC_Funnel_Emails::get_email_ds1($name, $calendly_url, $lang, $lowest_hab),
            'attachments' => [ACLC_Funnel_Emails::get_workbook_path($lang)],
        ],
    ];

    foreach ($emails_to_send as $item) {
        $subject = "[SIMULACIÓN {$lang_label} {$item['code']}] " . $item['data']['subject'];
        $html    = $item['data']['html'];
        $attachments = array_values(array_filter(array_unique(array_merge(
            $item['attachments'] ?? [],
            $item['data']['attachments'] ?? []
        ))));
        $embedded_images = $item['data']['embedded_images'] ?? [];

        $sent = ACLC_Funnel_Emails::send($email, $subject, $html, $lang, $attachments, $embedded_images);

        if ($sent) {
            $att_note = !empty($attachments) ? ' [' . count($attachments) . ' adjuntos]' : '';
            echo "  ✓ [{$item['code']}] {$item['flow']}{$att_note} -> ENVIADO\n";
        } else {
            echo "  ✗ [{$item['code']}] {$item['flow']} -> FALLÓ (Verificar Mandrill SMTP)\n";
        }

        usleep(500000); // 0.5s pause
    }

    echo "\n>>> [{$lang_label}] PARTE 2: EVENTOS WHATSAPP (VÍA ZAPIER WEBHOOKS)\n";

    $whatsapp_events = $is_en ? [
        [
            'code'    => 'B2',
            'flow'    => 'Flow B (WhatsApp 2h after Mini Profile)',
            'message' => "Hello {$name}, here is your Financial Mini Profile result: your Ability to Have was measured as Struggling to have. We have emailed your chart and analysis to {$email}.",
        ],
        [
            'code'    => 'B6',
            'flow'    => 'Flow B (WhatsApp Day 1 - Order Matters)',
            'message' => "{$name}, did you see your Mini Profile chart? Measuring just one ability is like stepping on a scale without knowing your height. With the full Profile, you measure all 6 abilities.",
        ],
        [
            'code'    => 'D2',
            'flow'    => 'Flow D (WhatsApp Immediate after 100 questions)',
            'message' => "{$name}, your Financial Health Profile is ready. We have emailed you your chart, the Alan C. Walter audio lesson (SoundCloud), and your workbook PDF.",
        ],
        [
            'code'    => 'DS2',
            'flow'    => 'Branch DS (WhatsApp Immediate after session purchase)',
            'message' => "{$name}, your 60-minute private session with coach Raul is ready to schedule. Book your time on Calendly: {$calendly_url}",
        ],
    ] : [
        [
            'code'    => 'B2',
            'flow'    => 'Flujo B (WhatsApp 2h tras Mini Perfil)',
            'message' => "Hola {$name}, aquí está tu Mini Perfil Financiero. Mide tu Habilidad para Tener y tu resultado es: Batallando para tener. Te mandamos el resultado completo a tu correo. Tener es una de tus seis habilidades financieras; tu Perfil de Salud Financiera te muestra las seis.",
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
            echo "  ✓ [{$wa['code']}] {$wa['flow']} -> DISPARADO A ZAPIER ({$phone})\n";
        } else {
            echo "  ✗ [{$wa['code']}] {$wa['flow']} -> ERROR AL ENVIAR A ZAPIER\n";
        }
        usleep(400000);
    }

    echo "\n";
}

echo "=========================================================================\n";
echo " SIMULACIÓN BILINGÜE COMPLETADA CON ÉXITO\n";
echo "=========================================================================\n";
