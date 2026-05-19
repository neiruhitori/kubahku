<?php

class Admin extends Controller {
    
    public function __construct() {
        parent::__construct();
        $this->_check_auth();
    }
    
    public function index() {
        $data['title'] = 'Dashboard Admin - SIKUBAH';
        $data['username'] = $_SESSION['admin_username'];
        $this->load_view('admin/dashboard', $data);
    }
    
    private function _check_auth() {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /SIKUBAH/auth/login?redirect=' . urlencode($_SERVER['REQUEST_URI']));
            exit;
        }
    }
}
