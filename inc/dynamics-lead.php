<?php
/**
 * Dynamics 365 (Dataverse) lead integration for the Campaign template.
 *
 * Credentials are resolved in this order (first match wins):
 *   1. PHP constants defined in wp-config.php  (recommended on production)
 *   2. Real environment variables (getenv)
 *   3. A .env file in the theme root (never commit it; see .env.example)
 *
 * Required keys:
 *   DYNAMICS_TENANT_ID, DYNAMICS_CLIENT_ID, DYNAMICS_CLIENT_SECRET,
 *   DYNAMICS_RESOURCE (https://opsole-sales.crm11.dynamics.com),
 *   DYNAMICS_API_URL  (https://opsole-sales.api.crm11.dynamics.com/api/data/v9.2)
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Write a line to wp-content/themes/<theme>/dynamics-error.log (and the PHP error log).
 */
function opsole_dynamics_log(string $message): void
{
    $line = '[' . gmdate('Y-m-d H:i:s') . ' UTC] ' . $message . PHP_EOL;
    @file_put_contents(dirname(__DIR__) . '/dynamics-error.log', $line, FILE_APPEND | LOCK_EX);
    error_log('[Opsole Dynamics] ' . $message);
}

/**
 * Minimal .env parser (KEY=VALUE, # comments, optional quotes). Loaded once.
 */
function opsole_load_env_file(): array
{
    static $vars = null;
    if ($vars !== null) {
        return $vars;
    }
    $vars = [];
    $path = dirname(__DIR__) . '/.env';
    if (!is_readable($path)) {
        return $vars;
    }
    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || strpos($line, '=') === false) {
            continue;
        }
        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        if ($value !== '' && ($value[0] === '"' || $value[0] === "'")) {
            $value = trim($value, $value[0]);
        }
        $vars[$key] = $value;
    }
    return $vars;
}

function opsole_env(string $key, string $default = ''): string
{
    if (defined($key)) {
        return (string) constant($key);
    }
    $val = getenv($key);
    if ($val !== false && $val !== '') {
        return $val;
    }
    $file = opsole_load_env_file();
    return $file[$key] ?? $default;
}

/**
 * Get an OAuth2 access token via client credentials. Cached in a transient.
 *
 * @return string|WP_Error
 */
function opsole_dynamics_get_token()
{
    $cache_key = 'opsole_dynamics_token';
    $cached = get_transient($cache_key);
    if ($cached) {
        return $cached;
    }

    $tenant   = opsole_env('DYNAMICS_TENANT_ID');
    $client   = opsole_env('DYNAMICS_CLIENT_ID');
    $secret   = opsole_env('DYNAMICS_CLIENT_SECRET');
    $resource = rtrim(opsole_env('DYNAMICS_RESOURCE'), '/');

    if (!$tenant || !$client || !$secret || !$resource) {
        opsole_dynamics_log('Credentials not configured (check DYNAMICS_* constants in wp-config.php).');
        return new WP_Error('dynamics_config', 'Dynamics credentials are not configured.');
    }

    $response = wp_remote_post(
        "https://login.microsoftonline.com/{$tenant}/oauth2/v2.0/token",
        [
            'timeout' => 15,
            'body'    => [
                'grant_type'    => 'client_credentials',
                'client_id'     => $client,
                'client_secret' => $secret,
                'scope'         => $resource . '/.default',
            ],
        ]
    );

    if (is_wp_error($response)) {
        opsole_dynamics_log('Token request transport error: ' . $response->get_error_message());
        return $response;
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);
    if (empty($body['access_token'])) {
        $msg = $body['error_description'] ?? ('Unknown token error: ' . wp_remote_retrieve_body($response));
        opsole_dynamics_log('Token request failed: ' . $msg);
        return new WP_Error('dynamics_token', $msg);
    }

    // Expire 5 minutes early to be safe.
    $ttl = max(60, (int) ($body['expires_in'] ?? 3600) - 300);
    set_transient($cache_key, $body['access_token'], $ttl);

    return $body['access_token'];
}

/**
 * Create a lead in Dynamics 365.
 *
 * @param array $lead Keys: full_name, work_email, company_name, fleet_size,
 *                    identity_setup, utm_source, utm_medium, utm_campaign, page_url
 * @return true|WP_Error
 */
function opsole_dynamics_create_lead(array $lead)
{
    $token = opsole_dynamics_get_token();
    if (is_wp_error($token)) {
        return $token;
    }

    $api = rtrim(opsole_env('DYNAMICS_API_URL'), '/');
    if (!$api) {
        opsole_dynamics_log('DYNAMICS_API_URL is not configured.');
        return new WP_Error('dynamics_config', 'DYNAMICS_API_URL is not configured.');
    }

    $full_name = trim($lead['full_name'] ?? '');
    $parts     = preg_split('/\s+/', $full_name, 2);
    $firstname = count($parts) === 2 ? $parts[0] : '';
    $lastname  = count($parts) === 2 ? $parts[1] : $full_name;

    // Organic / direct traffic has no UTM parameters: label it so sales can tell it apart.
    $utm_source   = trim($lead['utm_source'] ?? '') ?: 'organic';
    $utm_medium   = trim($lead['utm_medium'] ?? '') ?: 'none';
    $utm_campaign = trim($lead['utm_campaign'] ?? '') ?: 'none';

    // Subject format: "UTM Source - UTM Campaign - Company Name".
    $subject = implode(' - ', array_filter([
        $utm_source,
        $utm_campaign,
        trim($lead['company_name'] ?? ''),
    ], static fn($v) => $v !== ''));

    $payload = [
        'lastname'                   => $lastname,
        'emailaddress1'              => $lead['work_email'] ?? '',
        'companyname'                => $lead['company_name'] ?? '',
        'subject'                    => $subject,
        'cr3bd_windowsfleetsize'     => $lead['fleet_size'] ?? '',
        'cr3bd_currentidentitysetup' => $lead['identity_setup'] ?? '',
        'cr3bd_utmsource'            => $utm_source,
        'cr3bd_utmmedium'            => $utm_medium,
        'cr3bd_utmcampaign'          => $utm_campaign,
        'cr3bd_pageurl'              => $lead['page_url'] ?? '',
    ];
    if ($firstname !== '') {
        $payload['firstname'] = $firstname;
    }
    // Drop empty optional values so Dataverse doesn't reject blank strings.
    $payload = array_filter($payload, static fn($v) => $v !== '' && $v !== null);

    $response = wp_remote_post($api . '/leads', [
        'timeout' => 20,
        'headers' => [
            'Authorization'    => 'Bearer ' . $token,
            'Content-Type'     => 'application/json; charset=utf-8',
            'Accept'           => 'application/json',
            'OData-MaxVersion' => '4.0',
            'OData-Version'    => '4.0',
        ],
        'body' => wp_json_encode($payload),
    ]);

    if (is_wp_error($response)) {
        opsole_dynamics_log('Lead request transport error: ' . $response->get_error_message());
        return $response;
    }

    $code = (int) wp_remote_retrieve_response_code($response);
    if ($code === 401) {
        // Token may have been revoked; clear cache so the next attempt refreshes.
        delete_transient('opsole_dynamics_token');
    }
    if ($code < 200 || $code >= 300) {
        $raw  = wp_remote_retrieve_body($response);
        $body = json_decode($raw, true);
        $msg  = $body['error']['message'] ?? $raw;
        opsole_dynamics_log("Lead create failed (HTTP {$code}): {$msg}");
        return new WP_Error('dynamics_api', $msg, ['status' => $code]);
    }

    return true;
}

if (!function_exists('opsole_get_campaign_url')) {
    function opsole_get_campaign_url(): string
    {
        if (!empty($_SERVER['HTTP_REFERER'])) {
            $referer = $_SERVER['HTTP_REFERER'];
            $host = $_SERVER['HTTP_HOST'] ?? '';
            if ($host && strpos($referer, $host) !== false && strpos($referer, 'thank-you') === false) {
                return $referer;
            }
        }

        if (function_exists('home_url')) {
            if (function_exists('get_page_by_path') && function_exists('get_permalink')) {
                $page = get_page_by_path('lp/campaign') ?: get_page_by_path('campaign');
                if ($page && isset($page->ID)) {
                    return get_permalink($page->ID);
                }
            }
            return home_url('/lp/campaign/');
        }

        return 'https://opsole.com/lp/campaign/';
    }
}

if (!function_exists('opsole_get_thank_you_url')) {
    function opsole_get_thank_you_url(string $fullName = '', string $workEmail = ''): string
    {
        $queryParams = '';
        if ($fullName !== '' || $workEmail !== '') {
            $queryParams = '?name=' . urlencode($fullName) . '&email=' . urlencode($workEmail);
        }

        // Strictly target /lp/thank-you/ (no /campaign/ in the URL)
        $targetPath = '/lp/thank-you/';

        if (function_exists('home_url')) {
            return home_url($targetPath) . $queryParams;
        }

        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

        return $protocol . $host . $targetPath . $queryParams;
    }
}

if (!function_exists('opsole_handle_thank_you_route_inc')) {
    function opsole_handle_thank_you_route_inc() {
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

            $file = dirname(__DIR__) . '/thank-you.php';
            if (file_exists($file)) {
                include $file;
                exit;
            }
        }
    }
}

if (function_exists('add_action')) {
    add_action('init', 'opsole_handle_thank_you_route_inc', 1);
    add_action('parse_request', 'opsole_handle_thank_you_route_inc', 1);
    add_action('template_redirect', 'opsole_handle_thank_you_route_inc', 1);
}



