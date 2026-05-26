<?php

class Dashboard extends Controller {
    
    public function __construct() {
        parent::__construct();
        $this->_check_auth();
    }
    
    public function index() {
        $data['title'] = 'Dashboard Admin - SIKUBAH';
        $data['username'] = $_SESSION['admin_username'];

        // Get WhatsApp stats for today
        $data['wa_stats'] = $this->get_wa_today_stats();

        $this->load_view('admin/dashboard', $data);
    }

    /**
     * Get WhatsApp statistics for today
     * Version 2.0 - With database error handling
     */
    private function get_wa_today_stats()
    {
        // Default values jika database belum ready
        $default = [
            'today_clicks' => 0,
            'unique_visitors' => 0,
            'db_error' => false
        ];

        // Check database connection
        if (!$this->db->isConnected()) {
            $default['db_error'] = true;
            return $default;
        }

        try {
            $sql = "SELECT 
                    COUNT(*) as today_clicks,
                    COUNT(DISTINCT user_ip) as unique_visitors
                    FROM wa_clicks 
                    WHERE click_date = CURDATE()";

            $result = $this->db->query($sql);

            if ($result && $result->num_rows > 0) {
                return $result->fetch_assoc();
            }

            return $default;
        } catch (Exception $e) {
            // Database error - return default values
            $default['db_error'] = true;
            return $default;
        }
    }

    private function _check_auth() {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /auth/login?redirect=' . urlencode($_SERVER['REQUEST_URI']));
            exit;
        }
    }
}
