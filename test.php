<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIKUBAH - Setup Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f5f5;
            padding: 40px 0;
        }
        .test-container {
            background: white;
            border-radius: 10px;
            padding: 30px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .test-item {
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .test-item.pass {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .test-item.fail {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        .test-icon {
            font-size: 20px;
            font-weight: bold;
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }
        .status {
            text-align: center;
            padding: 20px;
            margin-top: 30px;
            border-radius: 5px;
        }
        .status.ready {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <div class="test-container">
        <h1>🔍 SIKUBAH - Setup Test</h1>
        
        <?php
        $tests = [];
        $all_pass = true;
        
        // Test 1: PHP Version
        $php_version = phpversion();
        $test1 = version_compare($php_version, '7.4', '>=');
        $tests[] = [
            'name' => 'PHP Version ≥ 7.4',
            'result' => $test1,
            'detail' => 'Versi PHP: ' . $php_version
        ];
        $all_pass = $all_pass && $test1;
        
        // Test 2: Directory Structure
        $test2 = is_dir('application') && is_dir('system') && is_dir('assets');
        $tests[] = [
            'name' => 'Folder Structure',
            'result' => $test2,
            'detail' => 'Folder application, system, assets ada'
        ];
        $all_pass = $all_pass && $test2;
        
        // Test 3: Database Connection
        $test3 = false;
        $db_detail = 'Tidak terhubung ke database';
        $conn = @new mysqli('localhost', 'root', '', 'db_sikubah');
        if (!$conn->connect_error) {
            $test3 = true;
            $db_detail = 'Database db_sikubah terhubung ✓';
            $conn->close();
        } else {
            $all_pass = false;
            $db_detail = 'Error: ' . $conn->connect_error;
        }
        $tests[] = [
            'name' => 'Database Connection',
            'result' => $test3,
            'detail' => $db_detail
        ];
        
        // Test 4: Admins Table
        $test4 = false;
        $table_detail = 'Tabel tidak ditemukan';
        $conn = @new mysqli('localhost', 'root', '', 'db_sikubah');
        if (!$conn->connect_error) {
            $result = $conn->query("SHOW TABLES LIKE 'admins'");
            if ($result->num_rows > 0) {
                $test4 = true;
                // Check for default admin
                $admin_check = $conn->query("SELECT COUNT(*) as count FROM admins WHERE username = 'admin'");
                $row = $admin_check->fetch_assoc();
                if ($row['count'] > 0) {
                    $table_detail = 'Tabel admins ada dengan admin default ✓';
                } else {
                    $table_detail = 'Tabel admins ada (perlu setup)';
                }
            }
            $conn->close();
        }
        $tests[] = [
            'name' => 'Admins Table',
            'result' => $test4,
            'detail' => $table_detail
        ];
        $all_pass = $all_pass && $test4;
        
        // Test 5: .htaccess
        $test5 = file_exists('.htaccess');
        $tests[] = [
            'name' => '.htaccess Configuration',
            'result' => $test5,
            'detail' => 'File .htaccess ' . ($test5 ? 'ada ✓' : 'tidak ada')
        ];
        $all_pass = $all_pass && $test5;
        
        // Display tests
        foreach ($tests as $test) {
            $class = $test['result'] ? 'pass' : 'fail';
            $icon = $test['result'] ? '✓' : '✗';
            echo '<div class="test-item ' . $class . '">';
            echo '<span class="test-icon">' . $icon . '</span>';
            echo '<div>';
            echo '<strong>' . $test['name'] . '</strong><br>';
            echo '<small>' . $test['detail'] . '</small>';
            echo '</div>';
            echo '</div>';
        }
        
        // Final status
        if ($all_pass) {
            echo '<div class="status ready">';
            echo '<h4>✓ Sistem Siap!</h4>';
            echo '<p style="margin: 10px 0;">Semua test passed. Sistem ready untuk digunakan.</p>';
            echo '<hr>';
            echo '<div style="text-align: left; background: white; padding: 15px; border-radius: 5px; margin-top: 15px;">';
            echo '<strong>Akses Aplikasi:</strong><br>';
            echo '• <a href="/SIKUBAH/">Home Page</a><br>';
            echo '• <a href="/SIKUBAH/auth/login">Admin Login</a><br><br>';
            echo '<strong>Login Info:</strong><br>';
            echo '• Username: <code>admin</code><br>';
            echo '• Password: <code>admin123</code><br>';
            echo '</div>';
            echo '</div>';
        } else {
            echo '<div class="status" style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24;">';
            echo '<h4>⚠️ Ada Masalah</h4>';
            echo '<p>Silakan fix test yang gagal dan jalankan setup.php lagi.</p>';
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>
