<?php
/**
 * Functions and definitions for Opsole Campaign Theme / Child Theme.
 */

if (!defined('ABSPATH')) {
    exit;
}

// Load Dynamics lead integration helpers
require_once __DIR__ . '/inc/dynamics-lead.php';

/**
 * Early route handler to automatically intercept /thank-you/ URLs
 * (including URLs with query strings like ?name=...&email=...) and render thank-you.php
 * without causing 404 or 403 errors.
 */
function opsole_handle_thank_you_route() {
    if (is_admin()) {
        return;
    }

    $requestUri = strtok($_SERVER['REQUEST_URI'] ?? '', '?');
    $path = trim($requestUri, '/');
    $lastSegment = basename($path);
    $targetSlugs = ['thank-you', 'thank-you.php'];

    if (in_array($path, $targetSlugs, true) || in_array($lastSegment, $targetSlugs, true)) {
        status_header(200);
        global $wp_query;
        if (is_object($wp_query)) {
            $wp_query->is_404 = false;
            $wp_query->is_page = true;
            $wp_query->is_singular = true;
        }

        $file = __DIR__ . '/thank-you.php';
        if (file_exists($file)) {
            include $file;
            exit;
        }
    }
}

add_action('init', 'opsole_handle_thank_you_route', 1);
add_action('parse_request', 'opsole_handle_thank_you_route', 1);
add_action('template_redirect', 'opsole_handle_thank_you_route', 1);
