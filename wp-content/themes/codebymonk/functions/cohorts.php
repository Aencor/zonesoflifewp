<?php
/**
 * Cohort Qualification & Application Submission
 */

function zol_handle_cohort_lead() {
    check_ajax_referer('zol_cohort_nonce', 'nonce');

    $name        = sanitize_text_field($_POST['name'] ?? '');
    $email       = sanitize_email($_POST['email'] ?? '');
    $phone       = sanitize_text_field($_POST['phone'] ?? '');
    $cohort_id   = intval($_POST['cohort_id'] ?? 0);
    $cohort_name = sanitize_text_field($_POST['cohort_name'] ?? '');
    $area        = sanitize_text_field($_POST['area'] ?? '');
    $time        = sanitize_text_field($_POST['time'] ?? '');
    $exp         = sanitize_text_field($_POST['exp'] ?? '');

    if (empty($name) || empty($email) || !is_email($email)) {
        wp_send_json_error(['message' => __('Please provide a valid name and email address.', 'codebymonk')]);
    }

    if (empty($cohort_name) && $cohort_id) {
        $cohort_name = get_the_title($cohort_id);
    }
    if (empty($cohort_name)) {
        $cohort_name = __('General Event', 'codebymonk');
    }

    $post_title = sprintf('%s — %s (%s)', $name, $cohort_name, date_i18n('M j, Y'));

    $post_id = wp_insert_post([
        'post_type'   => 'cohort_application',
        'post_title'  => $post_title,
        'post_status' => 'publish',
    ]);

    if (is_wp_error($post_id)) {
        wp_send_json_error(['message' => __('Database error saving application.', 'codebymonk')]);
    }

    update_post_meta($post_id, 'lead_name', $name);
    update_post_meta($post_id, 'lead_email', $email);
    update_post_meta($post_id, 'lead_phone', $phone);
    update_post_meta($post_id, 'cohort_id', $cohort_id);
    update_post_meta($post_id, 'cohort_name', $cohort_name);
    update_post_meta($post_id, 'step_1_area', $area);
    update_post_meta($post_id, 'step_2_time', $time);
    update_post_meta($post_id, 'step_3_experience', $exp);
    update_post_meta($post_id, 'status', 'pending');

    // Notify admin via email
    $admin_email = get_option('admin_email');
    $subject = sprintf('[New Event Registration] %s registered for %s', $name, $cohort_name);
    $message = sprintf(
        "New event registration received:\n\nName: %s\nEmail: %s\nPhone: %s\nEvent: %s\nArea: %s\nTime commitment: %s\nExperience: %s\nDate: %s\n\nView in admin: %s",
        $name,
        $email,
        $phone,
        $cohort_name,
        $area,
        $time,
        $exp,
        current_time('mysql'),
        admin_url('edit.php?post_type=cohort_application')
    );
    @wp_mail($admin_email, $subject, $message);

    // Trigger Funnel & Zapier Event
    if (class_exists('ACLC_Funnel_Events')) {
        $lead_lang = function_exists('apply_filters') ? apply_filters('wpml_current_language', null) : 'es';
        ACLC_Funnel_Events::trigger('cohort_application', $email, [
            'name'        => $name,
            'phone'       => $phone,
            'cohort_id'   => $cohort_id,
            'cohort_name' => $cohort_name,
            'area'        => $area,
            'time'        => $time,
            'experience'  => $exp,
            'lang'        => in_array($lead_lang, ['es', 'en']) ? $lead_lang : 'es',
        ]);
    }

    wp_send_json_success([
        'message'     => __('Application received successfully!', 'codebymonk'),
        'lead_id'     => $post_id,
        'cohort_name' => $cohort_name,
    ]);
}
add_action('wp_ajax_zol_submit_cohort_lead', 'zol_handle_cohort_lead');
add_action('wp_ajax_nopriv_zol_submit_cohort_lead', 'zol_handle_cohort_lead');

/**
 * Personal Zones Profile Assessment Lead Submission
 */
function zol_handle_assessment_lead() {
    check_ajax_referer('zol_cohort_nonce', 'nonce');

    $name                 = sanitize_text_field($_POST['name'] ?? '');
    $email                = sanitize_email($_POST['email'] ?? '');
    $phone                = sanitize_text_field($_POST['phone'] ?? '');
    $wa_optin             = sanitize_text_field($_POST['whatsapp_optin'] ?? '1');
    $lowest_ability       = sanitize_text_field($_POST['lowest_ability'] ?? '');
    $lowest_ability_quote = sanitize_text_field($_POST['lowest_ability_quote'] ?? '');
    $zone                 = sanitize_text_field($_POST['zone'] ?? 'Amber');
    $financial_zone       = sanitize_text_field($_POST['financial_zone'] ?? '');
    $life_zone            = sanitize_text_field($_POST['life_zone'] ?? '');
    $body_zone            = sanitize_text_field($_POST['body_zone'] ?? '');

    $have_level           = sanitize_text_field($_POST['have_level'] ?? '');
    $have_level_name      = sanitize_text_field($_POST['have_level_name'] ?? '');
    $have_level_quote     = sanitize_text_field($_POST['have_level_quote'] ?? '');
    $have_level_text      = sanitize_textarea_field($_POST['have_level_text'] ?? '');

    if (empty($email) || !is_email($email)) {
        wp_send_json_error(['message' => __('Please provide a valid email address.', 'codebymonk')]);
    }
    if (empty($name)) {
        $name = __('Participant', 'codebymonk');
    }

    $post_title = sprintf('%s — %s (%s)', $name, $lowest_ability ?: ($zone . ' Zone'), date_i18n('M j, Y'));

    $post_id = wp_insert_post([
        'post_type'   => 'profile_lead',
        'post_title'  => $post_title,
        'post_status' => 'publish',
    ]);

    if (is_wp_error($post_id)) {
        wp_send_json_error(['message' => __('Database error saving result.', 'codebymonk')]);
    }

    update_post_meta($post_id, 'lead_name', $name);
    update_post_meta($post_id, 'lead_email', $email);
    update_post_meta($post_id, 'lead_phone', $phone);
    update_post_meta($post_id, 'whatsapp_optin', $wa_optin);
    update_post_meta($post_id, 'lowest_ability', $lowest_ability);
    update_post_meta($post_id, 'lowest_ability_quote', $lowest_ability_quote);
    update_post_meta($post_id, 'have_level', $have_level);
    update_post_meta($post_id, 'have_level_name', $have_level_name);
    update_post_meta($post_id, 'have_level_quote', $have_level_quote);
    update_post_meta($post_id, 'have_level_text', $have_level_text);
    update_post_meta($post_id, 'funnel_stage', 'R1_completed');
    update_post_meta($post_id, 'zone', $zone);
    update_post_meta($post_id, 'financial_zone', $financial_zone);
    update_post_meta($post_id, 'life_zone', $life_zone);
    update_post_meta($post_id, 'body_zone', $body_zone);

    $lang = sanitize_text_field($_POST['lang'] ?? 'en');
    if (!in_array($lang, ['es', 'en'])) {
        $lang = 'en';
    }
    update_post_meta($post_id, 'lead_lang', $lang);

    // Notify admin via email
    $admin_email = get_option('admin_email');
    $subject = sprintf('[New Assessment Lead] %s — Lowest Ability: %s (%s Zone, Lang: %s)', $name, $lowest_ability ?: 'N/A', $zone, strtoupper($lang));
    $message = sprintf(
        "A user completed the Personal Zones Profile Mini Assessment:\n\nName: %s\nEmail: %s\nWhatsApp/Phone: %s (Opt-in: %s)\nLanguage: %s\nLowest Ability: %s\nQuote: %s\nOverall Zone: %s\nDate: %s\n\nView in admin: %s",
        $name,
        $email,
        $phone,
        $wa_optin === '1' ? 'Yes' : 'No',
        strtoupper($lang),
        $lowest_ability,
        $lowest_ability_quote,
        $zone,
        current_time('mysql'),
        admin_url('edit.php?post_type=profile_lead')
    );
    @wp_mail($admin_email, $subject, $message);

    // Trigger Funnel Event (Slide 4 & 6 - Flujo B entry, B1 email & Mailchimp sync)
    if (class_exists('ACLC_Funnel_Events')) {
        ACLC_Funnel_Events::trigger('mini_profile_completed', $email, [
            'name'                 => $name,
            'phone'                => $phone,
            'lowest_ability'       => $lowest_ability,
            'lowest_ability_quote' => $lowest_ability_quote,
            'have_level'           => $have_level,
            'have_level_name'      => $have_level_name,
            'have_level_quote'     => $have_level_quote,
            'have_level_text'      => $have_level_text,
            'zone'                 => $zone,
            'lang'                 => $lang,
        ]);
    }

    wp_send_json_success([
        'message' => __('Assessment saved successfully!', 'codebymonk'),
        'lead_id' => $post_id,
        'zone'    => $zone,
    ]);
}
add_action('wp_ajax_zol_submit_assessment_lead', 'zol_handle_assessment_lead');
add_action('wp_ajax_nopriv_zol_submit_assessment_lead', 'zol_handle_assessment_lead');

/**
 * Send Mini Profile result via email to lead (Slide 4 CTA)
 */
function zol_handle_email_mini_profile() {
    check_ajax_referer('zol_cohort_nonce', 'nonce');

    $name                 = sanitize_text_field($_POST['name'] ?? '');
    $email                = sanitize_email($_POST['email'] ?? '');
    $lowest_ability       = sanitize_text_field($_POST['lowest_ability'] ?? '');
    $lowest_ability_quote = sanitize_text_field($_POST['lowest_ability_quote'] ?? '');
    $have_level_name      = sanitize_text_field($_POST['have_level_name'] ?? '');
    $have_level_quote     = sanitize_text_field($_POST['have_level_quote'] ?? '');
    $have_level_text      = sanitize_textarea_field($_POST['have_level_text'] ?? '');
    $lang                 = sanitize_text_field($_POST['lang'] ?? 'en');
    if (!in_array($lang, ['es', 'en'])) {
        $lang = 'en';
    }

    if (empty($email) || !is_email($email)) {
        wp_send_json_error(['message' => 'Invalid email']);
    }

    $zone                 = sanitize_text_field($_POST['zone'] ?? 'Amber');
    $finance_url          = ($lang === 'es') ? home_url('/es/perfil-financiero/') : home_url('/finance/');

    // Fallbacks if have_level_name not provided
    if (empty($have_level_name)) {
        $have_level_name = $lowest_ability ?: (($lang === 'es') ? 'Habilidad para Tener' : 'Ability to Have');
    }
    if (empty($have_level_quote)) {
        $have_level_quote = $lowest_ability_quote;
    }

    if (class_exists('ACLC_Funnel_Emails')) {
        $email_data = ACLC_Funnel_Emails::get_email_b1($name, $lowest_ability, $lowest_ability_quote, $finance_url, $lang, $zone, [], $have_level_name, $have_level_quote, $have_level_text);
        ACLC_Funnel_Emails::send($email, $email_data['subject'], $email_data['html'], $lang);
    } else {
        $is_es = ($lang === 'es');
        $subject = $is_es 
            ? sprintf('%s, este es tu resultado: %s', $name, $have_level_name)
            : sprintf('%s, here is your result: %s', $name, $have_level_name);

        $body = $is_es ? sprintf(
            "Hola %s,\n\n" .
            "Terminaste tu Mini Perfil Financiero en Zones of Life.\n\n" .
            "Tu resultado en tu Habilidad para Tener es: %s\n" .
            "\"%s\"\n\n" .
            "Tu Habilidad para Tener es una de las seis habilidades que forman tu salud financiera. Tu Perfil de Salud Financiera mide las seis (Producir, Enfocar, Investigar, Tener, Invertir y Crear riqueza) y te muestra cuál te está frenando más. Incluye tu gráfica completa, una audio-lección de Alan C. Walter para entenderla y el cuaderno de trabajo \"Tomando las riendas de tu futuro financiero\" para empezar a moverla.\n\n" .
            "Puedes acceder a tu Perfil de Salud Financiera aquí:\n%s\n\n" .
            "Equipo Zones of Life",
            $name, $have_level_name, $have_level_quote, $finance_url
        ) : sprintf(
            "Hello %s,\n\n" .
            "You completed your Financial Mini Profile on Zones of Life.\n\n" .
            "Your result in your Ability to Have is: %s\n" .
            "\"%s\"\n\n" .
            "Your Ability to Have is one of the six abilities that make up your financial health. Your Financial Health Profile measures all six (Produce, Focus, Investigate, Have, Invest, and Create Wealth) and shows you which one is holding you back most. It includes your complete chart, an Alan C. Walter audio lesson to understand it, and the \"Taking Charge of Your Financial Future\" workbook to start moving it.\n\n" .
            "Get your Financial Health Profile here:\n%s\n\n" .
            "Zones of Life Team",
            $name, $have_level_name, $have_level_quote, $finance_url
        );

        @wp_mail($email, $subject, $body);
    }

    wp_send_json_success(['message' => 'Email sent']);
}
add_action('wp_ajax_zol_email_mini_profile', 'zol_handle_email_mini_profile');
add_action('wp_ajax_nopriv_zol_email_mini_profile', 'zol_handle_email_mini_profile');

