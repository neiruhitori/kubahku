<?php
session_start();

// SET SESSION ADMIN (bypass auth untuk test)
$_SESSION['admin_logged_in'] = true;
$_SESSION['admin_username'] = 'admin';

// Load framework
define('APPPATH', __DIR__ . '/application/');
define('BASEPATH', __DIR__ . '/system/');
define('VIEWPATH', APPPATH . 'views/');

require_once __DIR__ . '/index.php';

echo "<h2>Test Direct Controller Call</h2>";
echo "<hr>";

// Simulasi POST data
$_POST['action'] = 'create';
$_POST['title'] = 'DIRECT TEST ' . date('H:i:s');
$_POST['description'] = 'Direct controller test';
$_SERVER['REQUEST_METHOD'] = 'POST';

// Simulasi file upload dengan gambar yang ada
$test_image = __DIR__ . '/images/PRODUSEN-gold.png';
if (file_exists($test_image)) {
    $temp_file = sys_get_temp_dir() . '/direct_test_' . time() . '.png';
    copy($test_image, $temp_file);
    
    $_FILES['portfolio_image'] = [
        'name' => 'test.png',
        'type' => 'image/png',
        'tmp_name' => $temp_file,
        'error' => UPLOAD_ERR_OK,
        'size' => filesize($temp_file)
    ];
    
    echo "✅ Test image prepared<br>";
    echo "Temp file: $temp_file<br>";
} else {
    echo "❌ Test image not found: $test_image<br>";
}

echo "<h3>Request Data:</h3>";
echo "POST: <pre>" . print_r($_POST, true) . "</pre>";
echo "FILES: <pre>" . print_r($_FILES, true) . "</pre>";
echo "SESSION: <pre>" . print_r($_SESSION, true) . "</pre>";

echo "<h3>Calling Portfolio->save_ajax()...</h3>";
echo "<hr>";

// Load controller
require_once APPPATH . 'controllers/Portfolio.php';

// Capture output
ob_start();
try {
    $portfolio = new Portfolio();
    $portfolio->save_ajax();
} catch (Exception $e) {
    echo "<div style='background: #f8d7da; padding: 10px;'>";
    echo "❌ Exception: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    echo "</div>";
}
$output = ob_get_clean();

echo "<h3>Controller Output:</h3>";
echo "<div style='background: #e7f3ff; padding: 10px; border: 1px solid #b3d9ff;'>";
echo "<pre>" . htmlspecialchars($output) . "</pre>";
echo "</div>";

// Try to decode as JSON
$json = json_decode($output, true);
if ($json) {
    echo "<h3>Decoded JSON:</h3>";
    if ($json['success']) {
        echo "<div style='background: #d4edda; padding: 10px;'>✅ SUCCESS: {$json['message']}</div>";
    } else {
        echo "<div style='background: #f8d7da; padding: 10px;'>❌ FAILED: {$json['message']}</div>";
    }
}

// Check database
echo "<h3>Database Check:</h3>";
$db = new mysqli('localhost', 'root', '', 'db_sikubah');
$result = $db->query("SELECT * FROM portfolios ORDER BY id DESC LIMIT 1");
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<div style='background: #d4edda; padding: 10px;'>";
    echo "✅ Latest portfolio in database:<br>";
    echo "ID: {$row['id']}<br>";
    echo "Title: {$row['title']}<br>";
    echo "Description: {$row['description']}<br>";
    echo "Image: {$row['image']}<br>";
    echo "Created: {$row['created_at']}<br>";
    echo "</div>";
} else {
    echo "<div style='background: #fff3cd; padding: 10px;'>";
    echo "⚠️ No data found in database";
    echo "</div>";
}

echo "<hr>";
echo "<p><a href='/SIKUBAH/portfolio'>Go to Portfolio Admin</a></p>";
echo "<p><a href='/SIKUBAH/test_direct_save.php'>Refresh Test</a></p>";
