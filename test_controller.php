<?php
session_start();

// Simulasi admin login
$_SESSION['admin_logged_in'] = true;
$_SESSION['admin_username'] = 'admin';

// Load framework
define('APPPATH', __DIR__ . '/application/');
define('BASEPATH', __DIR__ . '/system/');
define('VIEWPATH', APPPATH . 'views/');

// Auto-loader
spl_autoload_register(function ($class) {
    $file = APPPATH . 'controllers/' . $class . '.php';
    if (file_exists($file)) {
        require $file;
        return;
    }
});

// Database class
class Database {
    public $conn;
    public function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'db_sikubah');
        if ($this->conn->connect_error) {
            die('Database connection failed: ' . $this->conn->connect_error);
        }
        $this->conn->set_charset('utf8mb4');
    }
    public function query($sql) {
        return $this->conn->query($sql);
    }
    public function escape_string($str) {
        return $this->conn->real_escape_string($str);
    }
}

// Base Controller
class Controller {
    public $db;
    public function __construct() {
        $this->db = new Database();
    }
    public function load_view($view, $data = []) {
        extract($data);
        require VIEWPATH . $view . '.php';
    }
}

echo "<h2>Test Portfolio Controller</h2>";
echo "<hr>";

// Simulasi POST data
$_POST['action'] = 'create';
$_POST['title'] = 'Test via Controller ' . date('H:i:s');
$_POST['description'] = 'Test description via controller endpoint';

// Simulasi file upload
$test_image_path = __DIR__ . '/images/PRODUSEN-gold.png';
if (file_exists($test_image_path)) {
    // Copy file ke temp location
    $temp_path = sys_get_temp_dir() . '/test_upload.png';
    copy($test_image_path, $temp_path);
    
    $_FILES['portfolio_image'] = [
        'name' => 'test_image.png',
        'type' => 'image/png',
        'tmp_name' => $temp_path,
        'error' => UPLOAD_ERR_OK,
        'size' => filesize($temp_path)
    ];
    
    echo "✅ Test file prepared: $test_image_path<br>";
    echo "✅ Temp file: $temp_path<br>";
} else {
    echo "❌ Test image not found: $test_image_path<br>";
}

echo "<h3>POST Data:</h3>";
echo "<pre>" . print_r($_POST, true) . "</pre>";

echo "<h3>FILES Data:</h3>";
echo "<pre>" . print_r($_FILES, true) . "</pre>";

echo "<h3>Calling Portfolio Controller...</h3>";

// Load and call controller
require APPPATH . 'controllers/Portfolio.php';
$portfolio = new Portfolio();

// Capture output
ob_start();
$portfolio->save_ajax();
$output = ob_get_clean();

echo "<h3>Controller Output:</h3>";
echo "<pre>" . htmlspecialchars($output) . "</pre>";

// Try to decode as JSON
$json = json_decode($output, true);
if ($json) {
    echo "<h3>JSON Response:</h3>";
    echo "<pre>" . print_r($json, true) . "</pre>";
    
    if ($json['success']) {
        echo "<p style='color: green; font-weight: bold;'>✅ SUCCESS: {$json['message']}</p>";
    } else {
        echo "<p style='color: red; font-weight: bold;'>❌ FAILED: {$json['message']}</p>";
    }
}

echo "<hr>";
echo "<p><a href='/SIKUBAH/test_portfolio.php'>View Data Test</a></p>";
echo "<p><a href='/SIKUBAH/portfolio'>Go to Portfolio Admin</a></p>";
