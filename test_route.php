<?php
// Test apakah routing ke portfolio/save_ajax bekerja

echo "<h2>Test Routing Portfolio</h2>";
echo "<hr>";

// Test 1: Simulasi request ke portfolio/save_ajax
$_SERVER['REQUEST_URI'] = '/SIKUBAH/portfolio/save_ajax';
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace('/SIKUBAH', '', $uri);
$uri = trim($uri, '/');

echo "<h3>1. URI Parsing</h3>";
echo "Original URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "Cleaned URI: $uri<br>";

$segments = explode('/', $uri);
$segments = array_filter($segments, function ($v) {
    return $v !== '';
});
$segments = array_values($segments);

echo "Segments: <pre>" . print_r($segments, true) . "</pre>";

$controller = ucfirst($segments[0] ?? 'Auth');
$method = isset($segments[1]) && !empty($segments[1]) ? $segments[1] : 'index';
$params = array_slice($segments, 2);

echo "Controller: $controller<br>";
echo "Method: $method<br>";
echo "Params: <pre>" . print_r($params, true) . "</pre>";

// Test 2: Check controller file
$controller_file = __DIR__ . '/application/controllers/' . $controller . '.php';
echo "<h3>2. Controller File Check</h3>";
echo "Looking for: $controller_file<br>";

if (file_exists($controller_file)) {
    echo "✅ File exists<br>";
    
    require_once $controller_file;
    
    if (class_exists($controller)) {
        echo "✅ Class '$controller' exists<br>";
        
        if (method_exists($controller, $method)) {
            echo "✅ Method '$method' exists<br>";
        } else {
            echo "❌ Method '$method' NOT found<br>";
            
            // List available methods
            $methods = get_class_methods($controller);
            echo "Available methods: <pre>" . print_r($methods, true) . "</pre>";
        }
    } else {
        echo "❌ Class '$controller' NOT found<br>";
    }
} else {
    echo "❌ File NOT found<br>";
}

// Test 3: Check admin routes
echo "<h3>3. Admin Routes Check</h3>";
$admin_routes = ['auth', 'dashboard', 'pages', 'portfolio', 'articles', 'content', 'settings'];
$is_admin_route = false;

foreach ($admin_routes as $route) {
    if (strpos($uri, $route) === 0) {
        $is_admin_route = true;
        echo "✅ '$uri' matches admin route: $route<br>";
        break;
    }
}

if (!$is_admin_route) {
    echo "❌ '$uri' is NOT an admin route<br>";
}

echo "<hr>";
echo "<h3>Test AJAX Request</h3>";
echo "<button onclick='testAjax()'>Test AJAX to save_ajax</button>";
echo "<div id='result'></div>";

echo "<script src='https://code.jquery.com/jquery-3.7.0.js'></script>";
echo "<script>
function testAjax() {
    console.log('Testing AJAX...');
    
    var formData = new FormData();
    formData.append('action', 'create');
    formData.append('title', 'Test from route test');
    formData.append('description', 'Test description');
    
    $.ajax({
        url: '/SIKUBAH/portfolio/save_ajax',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log('Success:', response);
            $('#result').html('<div style=\"background: #d4edda; padding: 10px; margin: 10px 0;\">Response: ' + JSON.stringify(response) + '</div>');
        },
        error: function(xhr, status, error) {
            console.error('Error:', {xhr: xhr, status: status, error: error});
            $('#result').html('<div style=\"background: #f8d7da; padding: 10px; margin: 10px 0;\">Error: ' + error + '<br>Status: ' + status + '<br>Response: ' + xhr.responseText + '</div>');
        }
    });
}
</script>";
