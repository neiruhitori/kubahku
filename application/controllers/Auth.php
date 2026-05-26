<?php

class Auth extends Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function login() {
        if ($this->_is_logged_in()) {
            header('Location: /dashboard');
            exit;
        }
        
        $data['title'] = 'Login Admin - SIKUBAH';
        $data['message'] = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = isset($_POST['username']) ? trim($_POST['username']) : '';
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';
            
            if (empty($username) || empty($password)) {
                $data['message'] = '<div class="alert alert-danger">Username dan password tidak boleh kosong!</div>';
            } else {
                // Ambil user dari database
                $user = $this->_get_user_by_username($username);
                
                if ($user && password_verify($password, $user['password'])) {
                    // Login berhasil
                    $_SESSION['admin_id'] = $user['id'];
                    $_SESSION['admin_username'] = $user['username'];
                    $_SESSION['admin_email'] = $user['email'];
                    $_SESSION['admin_logged_in'] = true;

                    header('Location: /dashboard');
                    exit;
                } else {
                    $data['message'] = '<div class="alert alert-danger">Username atau password salah!</div>';
                }
            }
        }
        
        $this->load_view('auth/login', $data);
    }
    
    public function logout() {
        session_destroy();
        header('Location: /auth/login');
        exit;
    }
    
    private function _is_logged_in() {
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }
    
    private function _get_user_by_username($username) {
        $sql = "SELECT * FROM admins WHERE username = '" . $this->db->escape_string($username) . "' LIMIT 1";
        $result = $this->db->query($sql);
        
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }
}
