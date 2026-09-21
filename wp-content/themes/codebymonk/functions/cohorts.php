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
        $cohort_name = __('General Cohort', 'codebymonk');
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
    $subject = sprintf('[New Cohort Lead] %s applied for %s', $name, $cohort_name);
    $message = sprintf(
        "New application received:\n\nName: %s\nEmail: %s\nPhone: %s\nCohort: %s\nArea: %s\nTime commitment: %s\nExperience: %s\nDate: %s\n\nView in admin: %s",
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
    $lang                 = sanitize_text_field($_POST['lang'] ?? 'en');
    if (!in_array($lang, ['es', 'en'])) {
        $lang = 'en';
    }

    if (empty($email) || !is_email($email)) {
        wp_send_json_error(['message' => 'Invalid email']);
    }

    $finance_url = home_url('/finance/');

    if (class_exists('ACLC_Funnel_Emails')) {
        $email_data = ACLC_Funnel_Emails::get_email_b1($name, $lowest_ability, $lowest_ability_quote, $finance_url, $lang);
        ACLC_Funnel_Emails::send($email, $email_data['subject'], $email_data['html']);
    } else {
        $is_es = ($lang === 'es');
        $subject = $is_es 
            ? sprintf('%s, tu resultado del Mini Perfil Financiero', $name)
            : sprintf('%s, your lowest ability is %s', $name, $lowest_ability);

        $body = $is_es ? sprintf(
            "Hola %s,\n\n" .
            "Completaste tu Mini Perfil Financiero en Zones of Life.\n\n" .
            "Tu habilidad más baja identificada es: %s\n" .
            "\"%s\"\n\n" .
            "Lo que este resultado todavía no te dice: por qué %s está ahí, cuál de las otras cinco la arrastra y cuál es el primer movimiento con más impacto.\n\n" .
            "Eso está en tu Perfil de Salud Financiera: 100 preguntas, tu gráfica completa, el reporte de las seis habilidades, el Cuaderno de Trabajo y la audio-lección de Alan C. Walter.\n\n" .
            "Puedes acceder a tu Perfil de Salud Financiera aquí:\n%s\n\n" .
            "Equipo Zones of Life",
            $name, $lowest_ability, $lowest_ability_quote, $lowest_ability, $finance_url
        ) : sprintf(
            "Hi %s,\n\n" .
            "You completed your Financial Mini Profile on Zones of Life.\n\n" .
            "Your lowest ability identified is: %s\n" .
            "\"%s\"\n\n" .
            "What this result still doesn't tell you: why %s sits where it does, which of the other five is dragging it down, and which first move has the most impact.\n\n" .
            "That's in your Financial Health Profile: 100 questions, your full chart, the report on all six abilities, the Financial Fitness Workbook and Alan C. Walter's audio lesson.\n\n" .
            "Get your Financial Health Profile here:\n%s\n\n" .
            "Zones of Life Team",
            $name, $lowest_ability, $lowest_ability_quote, $lowest_ability, $finance_url
        );

        @wp_mail($email, $subject, $body);
    }

    wp_send_json_success(['message' => 'Email sent']);
}
add_action('wp_ajax_zol_email_mini_profile', 'zol_handle_email_mini_profile');
add_action('wp_ajax_nopriv_zol_email_mini_profile', 'zol_handle_email_mini_profile');
add_action('wp_ajax_nopriv_zol_email_mini_profile', 'zol_handle_email_mini_profile');

