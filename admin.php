<?php
session_start();

// ============================================
// SIKUBAH - CODEIGNITER 3 MINI FRAMEWORK
// ============================================

define('APPPATH', __DIR__ . '/application/');
define('BASEPATH', __DIR__ . '/system/');
define('VIEWPATH', APPPATH . 'views/');

// Error handling
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Auto-loader untuk classes
spl_autoload_register(function ($class) {
    $file = APPPATH . 'models/' . $class . '.php';
    if (file_exists($file)) {
        require $file;
        return;
    }

    $file = APPPATH . 'controllers/' . $class . '.php';
    if (file_exists($file)) {
        require $file;
        return;
    }
});

// Simple Database Class
class Database
{
    public $conn;

    public function __construct()
    {
        $this->conn = new mysqli('localhost', 'root', '', 'db_sikubah');
        if ($this->conn->connect_error) {
            die('Database connection failed: ' . $this->conn->connect_error);
        }
        $this->conn->set_charset('utf8mb4');
    }

    public function query($sql)
    {
        return $this->conn->query($sql);
    }

    public function prepare($sql)
    {
        return $this->conn->prepare($sql);
    }

    public function escape_string($str)
    {
        return $this->conn->real_escape_string($str);
    }

    public function insert_id()
    {
        return $this->conn->insert_id;
    }

    public function affected_rows()
    {
        return $this->conn->affected_rows;
    }
}

// Base Controller
class Controller
{
    public $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function load_view($view, $data = [])
    {
        extract($data);
        require VIEWPATH . $view . '.php';
    }
}

// Get current URL and Route
$route = isset($_GET['route']) ? trim($_GET['route'], '/') : '';

if (empty($route)) {
    // Default to dashboard (Admin controller)
    $controller = 'Admin';
    $method = 'index';
    $params = [];
} else {
    $segments = explode('/', $route);
    $controller = ucfirst($segments[0] ?? 'admin');
    $method = $segments[1] ?? 'index';
    $params = array_slice($segments, 2);
}

// Load controller
$controller_file = APPPATH . 'controllers/' . $controller . '.php';

if (!file_exists($controller_file)) {
    http_response_code(404);
    die('Controller not found: ' . $controller);
}

require $controller_file;
$ctrl_class = $controller;
$controller_obj = new $ctrl_class();

// Check if method exists
if (!method_exists($controller_obj, $method)) {
    http_response_code(404);
    die('Method not found: ' . $method);
}

// Call method with parameters
call_user_func_array([$controller_obj, $method], $params);
