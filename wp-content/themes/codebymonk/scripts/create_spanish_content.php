<?php
/**
 * Script to create all Spanish pages and CPTs linked via WPML
 * Run via: wp eval-file wp-content/themes/codebymonk/scripts/create_spanish_content.php
 */

if (!defined('ABSPATH')) {
    exit;
}

global $sitepress, $wpdb;

if (!$sitepress) {
    echo "WPML Sitepress not found!\n";
    exit(1);
}

echo "=== STARTING SPANISH CONTENT CREATION ===\n";

// Helper function to create or update a WPML translation
function create_or_update_translation($orig_id, $post_type, $title, $slug, $content, $meta = []) {
    global $sitepress, $wpdb;

    $element_type = 'post_' . $post_type;
    $trid = $sitepress->get_element_trid($orig_id, $element_type);

    if (!$trid) {
        $sitepress->set_element_language_details($orig_id, $element_type, null, 'en');
        $trid = $sitepress->get_element_trid($orig_id, $element_type);
    }

    $translations = $sitepress->get_element_translations($trid, $element_type);
    $existing_es_id = isset($translations['es']) ? $translations['es']->element_id : null;

    $post_data = [
        'post_title'   => $title,
        'post_name'    => $slug,
        'post_content' => $content,
        'post_status'  => 'publish',
        'post_type'    => $post_type,
    ];

    if ($existing_es_id && get_post($existing_es_id)) {
        $post_data['ID'] = $existing_es_id;
        $es_id = wp_update_post($post_data);
        echo "Updated existing Spanish $post_type ID $es_id: $title ($slug)\n";
    } else {
        $es_id = wp_insert_post($post_data);
        if (is_wp_error($es_id)) {
            echo "Error creating Spanish $post_type: " . $es_id->get_error_message() . "\n";
            return null;
        }
        $sitepress->set_element_language_details($es_id, $element_type, $trid, 'es', 'en');
        echo "Created new Spanish $post_type ID $es_id: $title ($slug) [trid: $trid]\n";
    }

    if (!empty($meta) && function_exists('update_field')) {
        foreach ($meta as $k => $v) {
            update_field($k, $v, $es_id);
        }
    }

    return $es_id;
}

// 1. MAIN PAGES
// Page 4: Home -> Inicio
$home_content = '<!-- wp:acf/home-hero {"name":"acf/home-hero","data":{"kicker":"La evaluación","_kicker":"field_hh_kicker","title":"¿En qué Zona estás hoy?","_title":"field_hh_title","description":"Tu nivel de éxito, prosperidad, felicidad y la calidad de tus relaciones dependen de la Zona en la que estás operando. Veinte preguntas para descubrir cuál es.","_description":"field_hh_description","button_primary_text":"Descubre tu Zona — gratis","_button_primary_text":"field_hh_btn_pri_text","button_primary_link":"/es/perfil-corto/","_button_primary_link":"field_hh_btn_pri_link","button_secondary_text":"Cómo funciona","_button_secondary_text":"field_hh_btn_sec_text","button_secondary_link":"/es/evaluacion/","_button_secondary_link":"field_hh_btn_sec_link","card_title":"Las tres áreas que mide","_card_title":"field_hh_card_title","zones_title":"Las cuatro Zonas","_zones_title":"field_hh_zones_title"},"mode":"preview"} /-->

<!-- wp:acf/short-stories {"name":"acf/short-stories","data":{"kicker":"","_kicker":"field_ss_kicker","title":"PERSONAS REALES. AVANCES REALES","_title":"field_ss_title","button_text":"Todas las historias","_button_text":"field_ss_button_text","button_link":"/es/historias/","_button_link":"field_ss_button_link","stories_source":"latest","_stories_source":"field_ss_source"},"mode":"preview"} /-->

<!-- wp:acf/newsletter {"name":"acf/newsletter","data":{"kicker":"Semanal gratis","_kicker":"field_nl_kicker","title":"Boletín En La Zona","_title":"field_nl_title","description":"Una idea por semana sobre cómo subir de Zona, además de fechas de nuevas cohortes antes de que se abran públicamente.","_description":"field_nl_description","form_type":"default","_form_type":"field_nl_form_type"},"mode":"preview"} /-->';

$es_home_id = create_or_update_translation(4, 'page', 'Inicio', 'inicio', $home_content);

// Page 10: The Zones -> Las Zonas
$zones_content = '<!-- wp:acf/general-hero {"name":"acf/general-hero","data":{"kicker_icon":"","_kicker_icon":"field_gh_kicker_icon","kicker":"LAS CUATRO ZONAS DE LA VIDA","_kicker":"field_gh_kicker","title":"Descubre dónde estás — y adónde puedes llegar.","_title":"field_gh_title","description":"Este es el vocabulario en el que opera todo el ecosistema. Saber en qué Zona estás es lo que hace que cualquier otra decisión sea evidente.","_description":"field_gh_description","background_style":"tint","_background_style":"field_gh_bg_style","max_width":"64ch","_max_width":"field_gh_max_width","block_id":"","_block_id":"field_657b3d62e47ec","block_background":"light","_block_background":"field_66f3360a3ccdb","padding_options_padding_top":"md","_padding_options_padding_top":"field_68f7bcb53fc76","padding_options_padding_bottom":"md","_padding_options_padding_bottom":"field_68f7bced3fc77","padding_options":"","_padding_options":"field_68f7bc7d3fc75","margin_options_margin_top":"md","_margin_options_margin_top":"field_68f7bd063fc7a","margin_options_margin_bottom":"md","_margin_options_margin_bottom":"field_68f7bd063fc7b","margin_options":"","_margin_options":"field_68f7bd063fc79"},"mode":"edit"} /-->

<!-- wp:acf/four-zones {"name":"acf/four-zones","data":{"show_cta":"1","_show_cta":"field_fz_show_cta","cta_title":"Leer sobre las Zonas no es lo mismo que conocer la tuya","_cta_title":"field_fz_cta_title","cta_description":"Veinte preguntas, dos minutos, sin tarjeta.","_cta_description":"field_fz_cta_desc","cta_button_text":"Descubre tu Zona","_cta_button_text":"field_fz_cta_btn_text","cta_button_link":"/es/perfil-corto/","_cta_button_link":"field_fz_cta_btn_link"},"mode":"preview"} /-->';

$es_zones_id = create_or_update_translation(10, 'page', 'Las Zonas', 'zonas', $zones_content);

// Page 45: The Assessment -> La Evaluación
$assessment_content = '<!-- wp:acf/general-hero {"name":"acf/general-hero","data":{"kicker_icon":"check","_kicker_icon":"field_gh_kicker_icon","kicker":"La evaluación","_kicker":"field_gh_kicker","title":"Veinte preguntas para saber dónde estás parado","_title":"field_gh_title","description":"No hay respuestas correctas ni incorrectas. Nadie más verá esto. Te pediremos tu correo electrónico al final, no ahora.","_description":"field_gh_description","background_style":"tint","_background_style":"field_gh_bg_style","max_width":"62ch","_max_width":"field_gh_max_width"},"mode":"preview"} /-->

<!-- wp:acf/assessment-tiers {"name":"acf/assessment-tiers","data":{"card_1_badge":"Paso 1 · gratis","_card_1_badge":"field_at_c1_badge","card_1_title":"Perfil corto","_card_1_title":"field_at_c1_title","card_1_desc":"Veinte preguntas, dos minutos. Obtienes tu Zona, por qué estás en ella y cuál de las tres áreas te está frenando.","_card_1_desc":"field_at_c1_desc","card_1_btn_text":"Comenzar","_card_1_btn_text":"field_at_c1_btn_text","card_1_btn_link":"/es/perfil-corto/","_card_1_btn_link":"field_at_c1_btn_link","card_2_badge":"Paso 2 · de pago","_card_2_badge":"field_at_c2_badge","card_2_title":"Reporte Completo Automatizado","_card_2_title":"field_at_c2_title","card_2_desc":"Desglose pregunta por pregunta de las tres áreas, qué mover primero y en qué orden, y cómo se ve la Zona Verde en tu caso específico.","_card_2_desc":"field_at_c2_desc","card_2_price":"precio por definir","_card_2_price":"field_at_c2_price","card_2_btn_text":"Obtener el reporte completo","_card_2_btn_text":"field_at_c2_btn_text","card_2_btn_link":"/finance/","_card_2_btn_link":"field_at_c2_btn_link","card_3_badge":"60 minutos de Coaching Personalizado","_card_3_badge":"field_at_c3_badge","card_3_title":"Reporte Completo Uno a Uno","_card_3_title":"field_at_c3_title","card_3_desc":"Una cohorte con fecha de inicio y un grupo aquí, o coaching continuo uno a uno con un coach asignado en ACLC.","_card_3_desc":"field_at_c3_desc","card_3_btn_text":"Ver opciones","_card_3_btn_text":"field_at_c3_btn_text","card_3_btn_link":"/es/cohortes/","_card_3_btn_link":"field_at_c3_btn_link","show_guarantee":"1","_show_guarantee":"field_at_show_guarantee"},"mode":"preview"} /-->';

$es_assessment_id = create_or_update_translation(45, 'page', 'La Evaluación', 'evaluacion', $assessment_content);

// Page 21: Cohorts -> Cohortes
$cohorts_content = '<!-- wp:acf/general-hero {"name":"acf/general-hero","data":{"kicker_icon":"calendar","_kicker_icon":"field_gh_kicker_icon","kicker":"Cohortes","_kicker":"field_gh_kicker","title":"Una fecha, un grupo y nadie improvisando","_title":"field_gh_title","description":"El propósito del entrenamiento es aumentar tus habilidades de vida. Tener una habilidad significa que puedes hacer algo bien y de forma repetida — no solo cuando el día acompaña.","_description":"field_gh_description","background_style":"tint","_background_style":"field_gh_bg_style","max_width":"64ch","_max_width":"field_gh_max_width"},"mode":"preview"} /-->

<!-- wp:acf/cohorts {"name":"acf/cohorts","data":{"cohorts_source":"latest","_cohorts_source":"field_cb_source","show_steps":"1","_show_steps":"field_cb_show_steps","step_1_title":"Paso uno","_step_1_title":"field_cb_s1_title","step_1_strong":"Haz el perfil.","_step_1_strong":"field_cb_s1_strong","step_1_desc":"La cohorte comienza sabiendo ya en qué Zona estás.","_step_1_desc":"field_cb_s1_desc","step_2_title":"Paso dos","_step_2_title":"field_cb_s2_title","step_2_strong":"Comprueba la afinidad en tres pasos.","_step_2_strong":"field_cb_s2_strong","step_2_desc":"Dos minutos, para ver si esta cohorte es la adecuada para ti.","_step_2_desc":"field_cb_s2_desc","step_3_title":"Paso tres","_step_3_title":"field_cb_s3_title","step_3_strong":"Una llamada breve.","_step_3_strong":"field_cb_s3_strong","step_3_desc":"Se confirma la afinidad y se asegura tu lugar.","_step_3_desc":"field_cb_s3_desc"},"mode":"preview"} /-->';

$es_cohorts_id = create_or_update_translation(21, 'page', 'Cohortes', 'cohortes', $cohorts_content);

// Page 13: Stories -> Historias
$stories_content = '<!-- wp:acf/general-hero {"name":"acf/general-hero","data":{"kicker_icon":"users","_kicker_icon":"field_gh_kicker_icon","kicker":"Historias","_kicker":"field_gh_kicker","title":"Personas Reales. Avances Reales.","_title":"field_gh_title","description":"Cada historia incluye la gráfica de las Zonas de antes y después. Publicado siempre con consentimiento firmado.","_description":"field_gh_description","background_style":"tint","_background_style":"field_gh_bg_style","max_width":"62ch","_max_width":"field_gh_max_width","block_id":"","_block_id":"field_657b3d62e47ec","block_background":"light","_block_background":"field_66f3360a3ccdb","padding_options_padding_top":"md","_padding_options_padding_top":"field_68f7bcb53fc76","padding_options_padding_bottom":"md","_padding_options_padding_bottom":"field_68f7bced3fc77","padding_options":"","_padding_options":"field_68f7bc7d3fc75","margin_options_margin_top":"md","_margin_options_margin_top":"field_68f7bd063fc7a","margin_options_margin_bottom":"md","_margin_options_margin_bottom":"field_68f7bd063fc7b","margin_options":"","_margin_options":"field_68f7bd063fc79"},"mode":"edit"} /-->

<!-- wp:acf/short-stories {"name":"acf/short-stories","data":{"layout":"detailed","_layout":"field_ss_layout","show_header":"0","_show_header":"field_ss_show_header","stories_source":"latest","_stories_source":"field_ss_source","posts_per_page":4,"_posts_per_page":"field_ss_posts_per_page"},"mode":"preview"} /-->

<!-- wp:acf/find-your-zone {"name":"acf/find-your-zone","data":{"kicker":"HISTORIAS DE ZONA","_kicker":"field_fyz_kicker","title":"La franquicia mensual","_title":"field_fyz_title","description":"Una historia real al mes con su gráfica de perfil, antes y después. Es la prueba que ningún competidor puede copiar, porque depende de la evaluación.","_description":"field_fyz_description","button_text":"Descubre tu Zona","_button_text":"field_fyz_btn_text","button_link":"/es/perfil-corto/","_button_link":"field_fyz_btn_link","background_style":"tint","_background_style":"field_fyz_bg_style"},"mode":"preview"} /-->';

$es_stories_id = create_or_update_translation(13, 'page', 'Historias', 'historias', $stories_content);

// Page 42: Articles -> Artículos
$articles_content = '<!-- wp:acf/general-hero {"name":"acf/general-hero","data":{"kicker":"Artículos","_kicker":"field_gh_kicker","title":"Coaching y Entrenamiento","_title":"field_gh_title","description":"Escrito por los coaches que realizan el trabajo en el terreno.","_description":"field_gh_description","background_style":"tint","_background_style":"field_gh_bg_style","max_width":"62ch","_max_width":"field_gh_max_width"},"mode":"preview"} /-->

<!-- wp:acf/articles {"name":"acf/articles","data":{"articles_source":"latest","_articles_source":"field_art_source","posts_per_page":3,"_posts_per_page":"field_art_posts_per_page","show_read_more":"1","_show_read_more":"field_art_show_read_more","read_more_text":"Leer más","_read_more_text":"field_art_read_more_text"},"mode":"preview"} /-->';

$es_articles_id = create_or_update_translation(42, 'page', 'Artículos', 'articulos', $articles_content);

// Page 48: Short profile -> Perfil Corto
$quiz_content = '<!-- wp:acf/assessment-quiz {"name":"acf/assessment-quiz","data":{"intro_kicker":"Gratis · dos minutos","_intro_kicker":"field_aq_intro_kicker","intro_title":"Veinte preguntas","_intro_title":"field_aq_intro_title","intro_desc":"Sin respuestas correctas. Nadie más verá esto. Te pediremos tu correo al final, no ahora.","_intro_desc":"field_aq_intro_desc","start_button_text":"Comenzar","_start_button_text":"field_aq_btn_text"},"mode":"preview"} /-->';

$es_quiz_id = create_or_update_translation(48, 'page', 'Perfil Corto', 'perfil-corto', $quiz_content);

// Page 58: Contact -> Contacto
$contact_content = '<!-- wp:acf/general-hero {"name":"acf/general-hero","data":{"kicker_icon":"mail","_kicker_icon":"field_gh_kicker_icon","kicker":"Contacto","_kicker":"field_gh_kicker","title":"Habla con un coach","_title":"field_gh_title","description":"¿Tienes preguntas sobre las Zonas, las cohortes o el coaching personalizado? Envíanos un mensaje y nuestro equipo se comunicará contigo.","_description":"field_gh_description","background_style":"tint","_background_style":"field_gh_bg_style","max_width":"62ch","_max_width":"field_gh_max_width"},"mode":"preview"} /-->

<!-- wp:acf/contact {"name":"acf/contact","data":{"cf7_form_id":54,"_cf7_form_id":"field_contact_cf7_id","cf7_shortcode":"[contact-form-7 id=\u002254\u0022 title=\u0022Contact form 1\u0022]","_cf7_shortcode":"field_contact_cf7_shortcode","show_info_card":"1","_show_info_card":"field_contact_show_card","company_name":"Advanced Coaching \u0026 Leadership Center, Inc.","_company_name":"field_contact_card_title","address":"1400 Camp Letoli Road\nSaint Jo, Texas 76265\nEstados Unidos","_address":"field_contact_card_address","phone":"+1 940-995-2054","_phone":"field_contact_card_phone","dev_note":""},"mode":"preview"} /-->';

$es_contact_id = create_or_update_translation(58, 'page', 'Contacto', 'contacto', $contact_content);

// Page 3: Privacy policy -> Política de Privacidad
$privacy_content = '<p>En Zones of Life y Advanced Coaching & Leadership Center respetamos su privacidad y nos comprometemos a proteger sus datos personales.</p><p>Esta política de privacidad le informará sobre cómo cuidamos sus datos personales cuando visita nuestro sitio web y le informará sobre sus derechos de privacidad y cómo la ley lo protege.</p>';
$es_privacy_id = create_or_update_translation(3, 'page', 'Política de Privacidad', 'politica-de-privacidad', $privacy_content);

// Page 57: Cookie policy -> Política de Cookies
$cookie_content = '<p>Utilizamos cookies para ayudar a mejorar su experiencia en nuestro sitio web. Esta política de cookies explica qué son las cookies, cómo las utilizamos y sus opciones con respecto a su uso.</p>';
$es_cookie_id = create_or_update_translation(57, 'page', 'Política de Cookies', 'politica-de-cookies', $cookie_content);

// 2. COHORTS (CPT: cohort)
$cohort_translations = [
    19 => [
        'title' => 'Cohorte de Otoño',
        'slug'  => 'cohorte-otono',
        'meta'  => [
            'month'           => 'OCTUBRE',
            'day'             => '14',
            'start_date_full' => 'Inicia el 14 de Octubre',
            'details'         => 'Sesiones grupales intensivas guiadas por facilitadores sénior de ACLC.',
            'badge_text'      => 'Inscripciones abiertas'
        ]
    ],
    20 => [
        'title' => 'Cohorte de Invierno',
        'slug'  => 'cohorte-invierno',
        'meta'  => [
            'month'           => 'ENERO',
            'day'             => '15',
            'start_date_full' => 'Inicia el 15 de Enero',
            'details'         => 'Enfoque en establecimiento de metas y bases operativas para el nuevo año.',
            'badge_text'      => 'Próximamente'
        ]
    ],
    26 => [
        'title' => 'Cohorte de Primavera',
        'slug'  => 'cohorte-primavera',
        'meta'  => [
            'month'           => 'ABRIL',
            'day'             => '08',
            'start_date_full' => 'Inicia el 8 de Abril',
            'details'         => 'Aceleración de resultados y consolidación en la Zona Verde.',
            'badge_text'      => 'Próximamente'
        ]
    ]
];

foreach ($cohort_translations as $orig_id => $cdata) {
    create_or_update_translation($orig_id, 'cohort', $cdata['title'], $cdata['slug'], '', $cdata['meta']);
}

// 3. STORIES (CPT: story)
$story_translations = [
    7 => [
        'title' => 'Blair Singer',
        'slug'  => 'blair-singer',
        'meta'  => [
            'story'        => 'Describe el coaching y trabajo de entrenamiento como una verdadera ventaja en los negocios, las relaciones, la riqueza y la paz mental.',
            'author'       => 'Blair Singer',
            'position'     => 'Autor y Empresario Internacional',
            'location'     => 'Estados Unidos',
            'before_level' => 'Yellow',
            'after_level'  => 'Green'
        ]
    ],
    5 => [
        'title' => 'Rita Khagram',
        'slug'  => 'rita-khagram',
        'meta'  => [
            'story'        => 'Comenta que el entrenamiento le dio herramientas para mantenerse enfocada, que las habilidades de salud equilibraron su bienestar, y que pasó de la Zona Roja a la Verde en dos días en el rancho.',
            'author'       => 'Rita Khagram',
            'position'     => 'Líder Empresarial',
            'location'     => 'Inglaterra, Kenia e India',
            'before_level' => 'Red',
            'after_level'  => 'Green'
        ]
    ],
    12 => [
        'title' => 'Rigoberto Acosta',
        'slug'  => 'rigoberto-acosta',
        'meta'  => [
            'story'        => 'Expresa que recuperó habilidades ocultas para disfrutar la vida y expandir su liderazgo exponencialmente.',
            'author'       => 'Rigoberto Acosta',
            'position'     => 'Coach y Consultor de Negocios',
            'location'     => 'México',
            'before_level' => 'Yellow',
            'after_level'  => 'Green'
        ]
    ],
    6 => [
        'title' => 'David Pritchett',
        'slug'  => 'david-pritchett',
        'meta'  => [
            'story'        => 'Logró transformar la cultura de su organización y alinear a su equipo directivo hacia un rendimiento consistente en la Zona Verde.',
            'author'       => 'David Pritchett',
            'position'     => 'Director Ejecutivo',
            'location'     => 'Estados Unidos',
            'before_level' => 'Yellow',
            'after_level'  => 'Golden'
        ]
    ]
];

foreach ($story_translations as $orig_id => $sdata) {
    create_or_update_translation($orig_id, 'story', $sdata['title'], $sdata['slug'], '', $sdata['meta']);
}

// 4. NAVIGATION MENU (Spanish Primary Navigation)
$es_menu_name = 'Primary Navigation ES';
$es_menu = wp_get_nav_menu_object($es_menu_name);
$es_menu_id = $es_menu ? $es_menu->term_id : wp_create_nav_menu($es_menu_name);

if ($es_menu_id && !is_wp_error($es_menu_id)) {
    echo "Spanish Menu ID: $es_menu_id\n";

    $old_items = wp_get_nav_menu_items($es_menu_id);
    if ($old_items) {
        foreach ($old_items as $item) {
            wp_delete_post($item->ID, true);
        }
    }

    $menu_items = [
        ['title' => 'Las Zonas',      'id' => $es_zones_id],
        ['title' => 'La Evaluación',  'id' => $es_assessment_id],
        ['title' => 'Cohortes',       'id' => $es_cohorts_id],
        ['title' => 'Historias',      'id' => $es_stories_id],
        ['title' => 'Artículos',      'id' => $es_articles_id],
    ];

    foreach ($menu_items as $pos => $mi) {
        if ($mi['id']) {
            wp_update_nav_menu_item($es_menu_id, 0, [
                'menu-item-title'     => $mi['title'],
                'menu-item-object'    => 'page',
                'menu-item-object-id' => $mi['id'],
                'menu-item-type'      => 'post_type',
                'menu-item-status'    => 'publish',
                'menu-item-position'  => $pos + 1
            ]);
        }
    }

    $orig_menu_id = 2; // Primary Navigation EN
    $menu_trid = $sitepress->get_element_trid($orig_menu_id, 'tax_nav_menu');
    if (!$menu_trid) {
        $sitepress->set_element_language_details($orig_menu_id, 'tax_nav_menu', null, 'en');
        $menu_trid = $sitepress->get_element_trid($orig_menu_id, 'tax_nav_menu');
    }
    if ($menu_trid) {
        $sitepress->set_element_language_details($es_menu_id, 'tax_nav_menu', $menu_trid, 'es', 'en');
        echo "Linked Spanish menu in WPML (trid: $menu_trid)\n";
    }
}

echo "=== FINISHED SPANISH CONTENT CREATION ===\n";
