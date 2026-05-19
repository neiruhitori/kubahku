<?php
session_start();
echo "<h2>Session Debug</h2>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
echo "<hr>";
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "SCRIPT_FILENAME: " . $_SERVER['SCRIPT_FILENAME'] . "<br>";
echo "<hr>";
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']) {
    echo "✓ Admin session active<br>";
    echo "Username: " . $_SESSION['admin_username'];
} else {
    echo "✗ No admin session<br>";
    echo "<a href='/SIKUBAH/auth/login'>Go to Login</a>";
}
?>
