<?php
/**
 * Database Setup Script
 * Jalankan file ini sekali untuk setup database dan tabel
 */

$servername = "localhost";
$username = "root";
$password = "";

try {
    // Koneksi ke MySQL
    $conn = new mysqli($servername, $username, $password);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Pilih database (pastikan sudah ada)
    $conn->select_db("db_sikubah");
    
    if ($conn->connect_error) {
        die("Database db_sikubah tidak ditemukan! Pastikan database sudah dibuat di server. Error: " . $conn->connect_error);
    }
    
    echo "✓ Database 'db_sikubah' berhasil terhubung.<br>";
    
    // Buat tabel admins
    $sql_admins = "CREATE TABLE IF NOT EXISTS admins (
        id INT PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        full_name VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    
    if ($conn->query($sql_admins) === TRUE) {
        echo "✓ Tabel 'admins' berhasil dibuat/ada.<br>";
    } else {
        echo "✗ Error membuat tabel admins: " . $conn->error . "<br>";
    }
    
    // Buat tabel pages
    $sql_pages = "CREATE TABLE IF NOT EXISTS pages (
        id INT PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(255) NOT NULL,
        slug VARCHAR(255) UNIQUE NOT NULL,
        content LONGTEXT,
        published TINYINT DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    
    if ($conn->query($sql_pages) === TRUE) {
        echo "✓ Tabel 'pages' berhasil dibuat/ada.<br>";
    } else {
        echo "✗ Error membuat tabel pages: " . $conn->error . "<br>";
    }
    
    // Buat tabel content
    $sql_content = "CREATE TABLE IF NOT EXISTS content (
        id INT PRIMARY KEY AUTO_INCREMENT,
        page_id INT NOT NULL,
        section VARCHAR(100),
        title VARCHAR(255),
        description LONGTEXT,
        image_url VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (page_id) REFERENCES pages(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    
    if ($conn->query($sql_content) === TRUE) {
        echo "✓ Tabel 'content' berhasil dibuat/ada.<br>";
    } else {
        echo "✗ Error membuat tabel content: " . $conn->error . "<br>";
    }
    
    // Buat tabel portfolios
    $sql_portfolios = "CREATE TABLE IF NOT EXISTS portfolios (
        id INT PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(255) NOT NULL,
        description LONGTEXT,
        image VARCHAR(255),
        image_alt VARCHAR(255),
        order_number INT DEFAULT 0,
        published TINYINT DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    
    if ($conn->query($sql_portfolios) === TRUE) {
        echo "✓ Tabel 'portfolios' berhasil dibuat/ada.<br>";
    } else {
        echo "✗ Error membuat tabel portfolios: " . $conn->error . "<br>";
    }
    
    // Insert default admin jika belum ada
    $check_admin = "SELECT COUNT(*) as count FROM admins WHERE username = 'admin'";
    $result = $conn->query($check_admin);
    $row = $result->fetch_assoc();
    
    if ($row['count'] == 0) {
        $hashed_password = password_hash('admin123', PASSWORD_BCRYPT);
        $sql_insert = "INSERT INTO admins (username, email, password, full_name) 
                       VALUES ('admin', 'admin@sikubah.id', '" . $conn->real_escape_string($hashed_password) . "', 'Administrator')";
        
        if ($conn->query($sql_insert) === TRUE) {
            echo "✓ Admin default berhasil dibuat.<br>";
            echo "  - Username: <strong>admin</strong><br>";
            echo "  - Password: <strong>admin123</strong><br>";
        } else {
            echo "✗ Error insert admin: " . $conn->error . "<br>";
        }
    } else {
        echo "✓ Admin sudah ada.<br>";
    }
    
    echo "<br><strong style='color: green;'>✓ Setup Database Berhasil!</strong><br>";
    echo "Anda dapat <a href='/SIKUBAH/auth/login'>login di sini</a>.<br>";
    echo "<br><small>Catatan: Hapus file setup.php setelah setup selesai untuk keamanan.</small>";
    
    $conn->close();
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
