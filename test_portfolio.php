<?php
session_start();

// Simulasi admin login untuk test
$_SESSION['admin_logged_in'] = true;
$_SESSION['admin_username'] = 'admin';

define('APPPATH', __DIR__ . '/application/');
define('BASEPATH', __DIR__ . '/system/');

// Database connection
$db = new mysqli('localhost', 'root', '', 'db_sikubah');
if ($db->connect_error) {
    die('Database connection failed: ' . $db->connect_error);
}
$db->set_charset('utf8mb4');

echo "<h2>Test Portfolio Insert</h2>";
echo "<hr>";

// Test 1: Database connection
echo "<h3>1. Test Database Connection</h3>";
if ($db->ping()) {
    echo "✅ Database connected successfully<br>";
} else {
    echo "❌ Database connection failed<br>";
}

// Test 2: Table structure
echo "<h3>2. Test Table Structure</h3>";
$result = $db->query("DESCRIBE portfolios");
if ($result) {
    echo "✅ Table 'portfolios' exists<br>";
    echo "<pre>";
    while ($row = $result->fetch_assoc()) {
        echo "{$row['Field']} - {$row['Type']}<br>";
    }
    echo "</pre>";
} else {
    echo "❌ Table 'portfolios' not found<br>";
}

// Test 3: Insert data
echo "<h3>3. Test Insert Data</h3>";
$title = "Test Portfolio " . date('Y-m-d H:i:s');
$description = "Test description from test_portfolio.php";
$image = "./images/test.webp";

$sql = "INSERT INTO portfolios (title, description, image) 
        VALUES (
            '" . $db->real_escape_string($title) . "',
            '" . $db->real_escape_string($description) . "',
            '" . $db->real_escape_string($image) . "'
        )";

echo "SQL Query: <pre>$sql</pre>";

if ($db->query($sql)) {
    $insert_id = $db->insert_id;
    echo "✅ Data inserted successfully! ID: $insert_id<br>";
} else {
    echo "❌ Insert failed: " . $db->error . "<br>";
}

// Test 4: Read data
echo "<h3>4. Test Read Data</h3>";
$result = $db->query("SELECT * FROM portfolios ORDER BY id DESC LIMIT 5");
if ($result && $result->num_rows > 0) {
    echo "✅ Found {$result->num_rows} records:<br>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Title</th><th>Description</th><th>Image</th><th>Created At</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['id']}</td>";
        echo "<td>{$row['title']}</td>";
        echo "<td>" . substr($row['description'], 0, 50) . "...</td>";
        echo "<td>{$row['image']}</td>";
        echo "<td>{$row['created_at']}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "⚠️ No data found<br>";
}

// Test 5: Check session
echo "<h3>5. Test Session</h3>";
echo "Admin Logged In: " . (isset($_SESSION['admin_logged_in']) ? '✅ Yes' : '❌ No') . "<br>";
echo "Admin Username: " . ($_SESSION['admin_username'] ?? 'Not set') . "<br>";

// Test 6: File upload test
echo "<h3>6. Test File Upload</h3>";
if (is_dir(__DIR__ . '/images/') && is_writable(__DIR__ . '/images/')) {
    echo "✅ Images directory exists and writable<br>";
} else {
    echo "❌ Images directory not writable<br>";
}

echo "<hr>";
echo "<p><a href='/SIKUBAH/portfolio'>Go to Portfolio Admin</a></p>";
echo "<p><a href='/SIKUBAH/test_portfolio.php'>Refresh Test</a></p>";
