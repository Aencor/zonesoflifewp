<?php
/**
 * Plugin Name: Mandrill SMTP Mailer
 * Description: Routes all WordPress outgoing emails through Mandrill (Mailchimp Transactional) SMTP.
 * Version: 1.0.0
 * Author: ACLC Developer
 */

if (!defined('ABSPATH')) {
    exit;
}

if (defined('MANDRILL_SMTP_INITIALIZED')) {
    return;
}
define('MANDRILL_SMTP_INITIALIZED', true);

// Setup default Mandrill constants if not already defined in wp-config.php or environment
if (!defined('MANDRILL_API_KEY')) {
    define('MANDRILL_API_KEY', getenv('MANDRILL_API_KEY') ?: 'md-gLRp4YT69PyKB4vJ8mbmYg');
}

if (!defined('MANDRILL_HOST')) {
    define('MANDRILL_HOST', getenv('MANDRILL_HOST') ?: 'smtp.mandrillapp.com');
}

if (!defined('MANDRILL_PORT')) {
    define('MANDRILL_PORT', getenv('MANDRILL_PORT') ? (int) getenv('MANDRILL_PORT') : 587);
}

if (!defined('MANDRILL_SECURE')) {
    define('MANDRILL_SECURE', getenv('MANDRILL_SECURE') ?: 'tls');
}

if (!defined('MANDRILL_USERNAME')) {
    define('MANDRILL_USERNAME', getenv('MANDRILL_USERNAME') ?: '31645118');
}

if (!defined('MANDRILL_FROM_EMAIL')) {
    define('MANDRILL_FROM_EMAIL', getenv('MANDRILL_FROM_EMAIL') ?: 'noreply@zonesoflife.com');
}

if (!defined('MANDRILL_FROM_NAME')) {
    define('MANDRILL_FROM_NAME', getenv('MANDRILL_FROM_NAME') ?: 'Zones of Life');
}

if (!function_exists('aclc_configure_mandrill_smtp')) {
    add_action('phpmailer_init', 'aclc_configure_mandrill_smtp', 999);
    function aclc_configure_mandrill_smtp($phpmailer)
    {
        $api_key = defined('MANDRILL_API_KEY') ? trim(MANDRILL_API_KEY) : '';

        if (empty($api_key)) {
            return;
        }

        $phpmailer->isSMTP();
        $phpmailer->Host = defined('MANDRILL_HOST') ? MANDRILL_HOST : 'smtp.mandrillapp.com';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = defined('MANDRILL_PORT') ? (int) MANDRILL_PORT : 587;
        $phpmailer->SMTPSecure = defined('MANDRILL_SECURE') ? MANDRILL_SECURE : 'tls';
        $phpmailer->Username = defined('MANDRILL_USERNAME') ? MANDRILL_USERNAME : 'noreply@zonesoflife.com';
        $phpmailer->Password = $api_key;
        $phpmailer->Timeout = 15;

        // Set From email and name if not already defined on the PHPMailer instance
        if (
            empty($phpmailer->From)
            || strpos($phpmailer->From, 'wordpress@') === 0
            || strpos($phpmailer->From, 'localhost') !== false
            || strpos($phpmailer->From, '.local') !== false
            || strpos($phpmailer->From, '@gmail.com') !== false
            || strpos($phpmailer->From, '@yahoo.') !== false
            || strpos($phpmailer->From, '@hotmail.') !== false
        ) {
            $phpmailer->From = defined('MANDRILL_FROM_EMAIL') ? MANDRILL_FROM_EMAIL : 'noreply@zonesoflife.com';
        }

        if (empty($phpmailer->FromName) || $phpmailer->FromName === 'WordPress') {
            $phpmailer->FromName = defined('MANDRILL_FROM_NAME') ? MANDRILL_FROM_NAME : 'Zones of Life';
        }
    }
}

if (!function_exists('aclc_mandrill_filter_wp_mail_from')) {
    add_filter('wp_mail_from', 'aclc_mandrill_filter_wp_mail_from', 20);
    function aclc_mandrill_filter_wp_mail_from($from_email)
    {
        if (
            empty($from_email)
            || strpos($from_email, 'wordpress@') === 0
            || strpos($from_email, 'localhost') !== false
            || strpos($from_email, '.local') !== false
            || strpos($from_email, '@gmail.com') !== false
            || strpos($from_email, '@yahoo.') !== false
            || strpos($from_email, '@hotmail.') !== false
        ) {
            return defined('MANDRILL_FROM_EMAIL') ? MANDRILL_FROM_EMAIL : 'noreply@zonesoflife.com';
        }
        return $from_email;
    }
}

if (!function_exists('aclc_mandrill_filter_wp_mail_from_name')) {
    add_filter('wp_mail_from_name', 'aclc_mandrill_filter_wp_mail_from_name', 20);
    function aclc_mandrill_filter_wp_mail_from_name($from_name)
    {
        if (empty($from_name) || $from_name === 'WordPress') {
            return defined('MANDRILL_FROM_NAME') ? MANDRILL_FROM_NAME : 'Zones of Life';
        }
        return $from_name;
    }
}

if (!function_exists('aclc_mandrill_mail_failed_logger')) {
    add_action('wp_mail_failed', 'aclc_mandrill_mail_failed_logger');
    function aclc_mandrill_mail_failed_logger($wp_error)
    {
        if (is_wp_error($wp_error)) {
            error_log('[Mandrill SMTP Error] ' . $wp_error->get_error_message() . ' | Data: ' . print_r($wp_error->get_error_data(), true));
        }
    }
}

if (!function_exists('aclc_mandrill_test_send_ajax')) {
    add_action('wp_ajax_mandrill_smtp_test_send', 'aclc_mandrill_test_send_ajax');
    function aclc_mandrill_test_send_ajax()
    {
        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => 'No autorizado.']);
        }

        check_ajax_referer('mandrill_test_nonce', 'security');

        $to = isset($_POST['to_email']) ? sanitize_email($_POST['to_email']) : '';
        if (!is_email($to)) {
            wp_send_json_error(['message' => 'Por favor ingresa un correo electrónico válido.']);
        }

        $subject = 'Mandrill SMTP Test - ' . get_bloginfo('name');
        $message = "Hola!\n\nEste es un correo de prueba enviado desde " . home_url() . " mediante Mandrill SMTP.\n\nFecha: " . current_time('mysql');

        $result = wp_mail($to, $subject, $message);

        if ($result) {
            wp_send_json_success(['message' => '¡Correo de prueba enviado exitosamente a ' . esc_html($to) . ' a través de Mandrill!']);
        } else {
            global $phpmailer;
            $error_info = (isset($phpmailer) && !empty($phpmailer->ErrorInfo)) ? $phpmailer->ErrorInfo : 'Error desconocido al enviar correo.';
            wp_send_json_error(['message' => 'Fallo al enviar correo: ' . esc_html($error_info)]);
        }
    }
}
