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

    $name           = sanitize_text_field($_POST['name'] ?? '');
    $email          = sanitize_email($_POST['email'] ?? '');
    $zone           = sanitize_text_field($_POST['zone'] ?? 'Amber');
    $financial_zone = sanitize_text_field($_POST['financial_zone'] ?? '');
    $life_zone      = sanitize_text_field($_POST['life_zone'] ?? '');
    $body_zone      = sanitize_text_field($_POST['body_zone'] ?? '');

    if (empty($email) || !is_email($email)) {
        wp_send_json_error(['message' => __('Please provide a valid email address.', 'codebymonk')]);
    }
    if (empty($name)) {
        $name = __('Participant', 'codebymonk');
    }

    $post_title = sprintf('%s — %s Zone (%s)', $name, $zone, date_i18n('M j, Y'));

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
    update_post_meta($post_id, 'zone', $zone);
    update_post_meta($post_id, 'financial_zone', $financial_zone);
    update_post_meta($post_id, 'life_zone', $life_zone);
    update_post_meta($post_id, 'body_zone', $body_zone);

    // Notify admin via email
    $admin_email = get_option('admin_email');
    $subject = sprintf('[New Assessment Lead] %s scored in the %s Zone', $name, $zone);
    $message = sprintf(
        "A user completed the Personal Zones Profile Assessment:\n\nName: %s\nEmail: %s\nOverall Zone: %s\nFinancial: %s\nLife & Skills: %s\nBody: %s\nDate: %s\n\nView in admin: %s",
        $name,
        $email,
        $zone,
        $financial_zone,
        $life_zone,
        $body_zone,
        current_time('mysql'),
        admin_url('edit.php?post_type=profile_lead')
    );
    @wp_mail($admin_email, $subject, $message);

    wp_send_json_success([
        'message' => __('Assessment saved successfully!', 'codebymonk'),
        'lead_id' => $post_id,
        'zone'    => $zone,
    ]);
}
add_action('wp_ajax_zol_submit_assessment_lead', 'zol_handle_assessment_lead');
add_action('wp_ajax_nopriv_zol_submit_assessment_lead', 'zol_handle_assessment_lead');

