<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Configuration - PRODUCTION
 * 
 * IMPORTANT: File ini untuk server PRODUCTION
 * Sesuaikan base_url dengan domain Anda
 */

// Base URL - GANTI dengan domain production Anda
// Contoh: https://produsenkubahmasjid.id/ atau https://www.produsenkubahmasjid.id/
$config['base_url'] = 'https://produsenkubahmasjid.id/';

$config['index_page'] = '';
$config['uri_protocol'] = 'REQUEST_URI';
$config['url_suffix'] = '';
$config['language'] = 'english';
$config['charset'] = 'UTF-8';
$config['enable_hooks'] = FALSE;
$config['log_threshold'] = 0;  // 0 = disable logging untuk production
$config['log_path'] = '';
$config['log_file_permissions'] = 0644;
$config['cache_path'] = '';
$config['cache_query_string'] = FALSE;
$config['encryption_key'] = 'sikubah_secret_key_2026';

// Session Configuration
$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = 'ci_session';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = NULL;  // Will use system temp dir
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;

// Cookie Configuration
$config['cookie_prefix'] = '';
$config['cookie_domain'] = '';
$config['cookie_path'] = '/';
$config['cookie_secure'] = TRUE;  // TRUE untuk HTTPS
$config['cookie_httponly'] = TRUE;  // TRUE untuk keamanan
$config['cookie_samesite'] = 'Lax';

/**
 * NOTES:
 * - Pastikan base_url sesuai dengan domain Anda
 * - Gunakan HTTPS jika sudah ada SSL certificate
 * - cookie_secure = TRUE hanya jika menggunakan HTTPS
 */
