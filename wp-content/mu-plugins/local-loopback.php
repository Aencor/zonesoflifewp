<?php
/**
 * Plugin Name: Local Environment SSL & Loopback Fix
 * Description: Enables WordPress and plugins (WPML, Site Health, WP-Cron) to perform loopback REST API requests locally through the Docker proxy.
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('http_api_curl', function(&$handle, $r, $url) {
    $host = parse_url($url, PHP_URL_HOST);
    $site_host = parse_url(home_url(), PHP_URL_HOST);

    if ($host && $site_host && $host === $site_host) {
        // Resolve domain to proxy container in Docker network
        $proxy_ip = gethostbyname('local-proxy-nginx-proxy-1');
        if ($proxy_ip && $proxy_ip !== 'local-proxy-nginx-proxy-1') {
            curl_setopt($handle, CURLOPT_RESOLVE, ["{$host}:443:{$proxy_ip}"]);
        }
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
    }
}, 10, 3);

add_filter('https_ssl_verify', function($verify, $url) {
    $host = parse_url($url, PHP_URL_HOST);
    $site_host = parse_url(home_url(), PHP_URL_HOST);
    if ($host && $site_host && $host === $site_host) {
        return false;
    }
    return $verify;
}, 10, 2);

add_filter('https_local_ssl_verify', '__return_false');
