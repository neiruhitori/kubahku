<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Database Configuration - PRODUCTION
 * 
 * IMPORTANT: File ini untuk server PRODUCTION
 * Backup file database.php original sebelum replace!
 */

$db['default'] = array(
    'dsn'    => '',
    'hostname' => 'localhost',  // Biasanya 'localhost' di shared hosting
    'username' => 'produsen1_root',
    'password' => 'Ptkmi2026@',
    'database' => 'produsen1_pkm',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => FALSE,  // Set FALSE untuk production (keamanan)
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8mb4',
    'dbcollat' => 'utf8mb4_unicode_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => FALSE  // Set FALSE untuk production (performa)
);

/**
 * NOTES:
 * - Jika database host bukan localhost, tanyakan ke hosting provider
 * - Beberapa hosting menggunakan: localhost, 127.0.0.1, atau IP khusus
 * - Test koneksi setelah upload untuk memastikan credentials benar
 */
