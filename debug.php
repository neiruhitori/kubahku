<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Debug SIKUBAH Admin System</h2>";

// Test 1: Basic PHP
echo "<h3>1. PHP Basic Test</h3>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Status: OK<br><br>";

// Test 2: File exists
echo "<h3>2. File Existence Check</h3>";
$files = [
    'admin.php',
    'application/controllers/Auth.php',
    'application/views/auth/login.php',
];
foreach ($files as $file) {
    $path = __DIR__ . '/' . $file;
    $status = file_exists($path) ? '✓' : '✗';
    echo "$status $file<br>";
}
echo "<br>";

// Test 3: Database Connection
echo "<h3>3. Database Connection Test</h3>";
$conn = new mysqli('localhost', 'root', '', 'db_sikubah');
if ($conn->connect_error) {
    echo "✗ Connection Error: " . $conn->connect_error . "<br>";
} else {
    echo "✓ Connected to db_sikubah<br>";
    
    // Check tables
    echo "<h3>4. Table Check</h3>";
    $tables = ['admins', 'pages', 'content'];
    foreach ($tables as $table) {
        $result = $conn->query("SHOW TABLES LIKE '$table'");
        $status = $result && $result->num_rows > 0 ? '✓' : '✗';
        echo "$status Table: $table<br>";
    }
    
    // Check admin user
    echo "<h3>5. Admin User Check</h3>";
    $result = $conn->query("SELECT id, username, email FROM admins LIMIT 1");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "✓ Admin user found: " . $row['username'] . "<br>";
    } else {
        echo "✗ No admin user found in database<br>";
    }
    
    $conn->close();
}

echo "<br><h3>Next Step:</h3>";
echo "If all tests pass, try: <a href='/SIKUBAH/admin/auth/login'>admin/auth/login</a><br>";
echo "If database tests fail, run: <a href='/SIKUBAH/setup.php'>setup.php</a>";
?>
