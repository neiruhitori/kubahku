<?php
/**
 * Script untuk membuat user admin baru
 * Jalankan: http://localhost/SIKUBAH/create_admin.php
 * 
 * PENTING: Hapus file ini setelah selesai membuat user!
 */

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_sikubah";

// KONFIGURASI USER BARU - EDIT DI SINI
$new_username = "admin_baru";
$new_email = "admin@example.com";
$new_password = "password123";  // Ganti dengan password yang diinginkan
// ====================================

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Hash password
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// Insert user baru
$stmt = $conn->prepare("INSERT INTO admins (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $new_username, $new_email, $hashed_password);

if ($stmt->execute()) {
    echo "<h2>✅ User admin berhasil dibuat!</h2>";
    echo "<p>Username: <strong>" . htmlspecialchars($new_username) . "</strong></p>";
    echo "<p>Email: <strong>" . htmlspecialchars($new_email) . "</strong></p>";
    echo "<p>Password: <strong>" . htmlspecialchars($new_password) . "</strong></p>";
    echo "<hr>";
    echo "<p><a href='/SIKUBAH/auth/login'>Login Sekarang</a></p>";
    echo "<hr>";
    echo "<p style='color: red;'><strong>⚠️ PENTING: Hapus file create_admin.php ini setelah selesai!</strong></p>";
} else {
    echo "<h2>❌ Error:</h2>";
    echo "<p>" . $stmt->error . "</p>";
    
    if (strpos($stmt->error, 'Duplicate entry') !== false) {
        echo "<p>Username atau email sudah digunakan. Gunakan yang lain.</p>";
    }
}

$stmt->close();
$conn->close();
?>
