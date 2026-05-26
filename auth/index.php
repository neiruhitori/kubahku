<?php
/**
 * Auth Router Workaround for Nginx
 * File: auth/index.php
 * 
 * Workaround untuk routing /auth/login ketika nginx belum dikonfigurasi
 * File ini akan forward request ke index.php root dengan proper routing
 */

// Set the URI untuk routing
$_SERVER['REQUEST_URI'] = '/auth/login';
$_SERVER['PATH_INFO'] = '/auth/login';

// Include main index.php
require_once __DIR__ . '/../index.php';
