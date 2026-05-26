<?php

/**
 * WhatsApp Click Tracking Controller
 * 
 * Controller untuk menangani tracking klik tombol WhatsApp
 * dan menampilkan statistik di dashboard admin
 */
class WaTracking extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * API endpoint untuk track klik WhatsApp
     * Method: POST
     * URL: /watracking/track
     * Version 2.0 - With database error handling
     * 
     * Expected POST data:
     * - page_name: nama halaman (index, produk, harga, dll)
     * - page_url: URL lengkap halaman
     * - button_type: jenis button (sticky, inline, footer)
     */
    public function track()
    {
        // Set header untuk JSON response
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST');

        try {
            // Check database connection
            if (!$this->db->isConnected()) {
                // Database belum ready - RETURN SUCCESS agar button WA tetap work!
                echo json_encode([
                    'success' => true,
                    'message' => 'Click registered (database pending)',
                    'tracking' => false,
                    'data' => [
                        'page_name' => $_POST['page_name'] ?? 'unknown',
                        'timestamp' => date('Y-m-d H:i:s')
                    ]
                ]);
                exit;
            }

            // Ambil data dari POST
            $page_name = isset($_POST['page_name']) ? $this->db->escape_string($_POST['page_name']) : 'unknown';
            $page_url = isset($_POST['page_url']) ? $this->db->escape_string($_POST['page_url']) : '';
            $button_type = isset($_POST['button_type']) ? $this->db->escape_string($_POST['button_type']) : 'standard';

            // Ambil informasi tambahan
            $user_ip = $this->get_client_ip();
            $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
            $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
            
            $click_date = date('Y-m-d');
            $click_time = date('H:i:s');

            // Insert ke database
            $sql = "INSERT INTO wa_clicks 
                    (page_name, page_url, button_type, user_ip, user_agent, referer, click_date, click_time) 
                    VALUES 
                    ('$page_name', '$page_url', '$button_type', '$user_ip', '$user_agent', '$referer', '$click_date', '$click_time')";

            $result = $this->db->query($sql);

            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Click tracked successfully',
                    'tracking' => true,
                    'data' => [
                        'click_id' => $this->db->insert_id(),
                        'page_name' => $page_name,
                        'timestamp' => date('Y-m-d H:i:s')
                    ]
                ]);
            } else {
                // Query failed tapi tetap return success agar button WA work
                echo json_encode([
                    'success' => true,
                    'message' => 'Click registered (tracking unavailable)',
                    'tracking' => false,
                    'data' => [
                        'page_name' => $page_name,
                        'timestamp' => date('Y-m-d H:i:s')
                    ]
                ]);
            }
        } catch (Exception $e) {
            // Error tapi tetap return success agar button WA work
            echo json_encode([
                'success' => true,
                'message' => 'Click registered (error: ' . $e->getMessage() . ')',
                'tracking' => false,
                'data' => [
                    'timestamp' => date('Y-m-d H:i:s')
                ]
            ]);
        }

        exit;
    }

    /**
     * Get client IP address (even behind proxy)
     */
    private function get_client_ip()
    {
        $ip = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        }

        return $ip;
    }

    /**
     * Get statistik untuk dashboard admin
     * Method: GET
     * URL: /watracking/stats
     */
    public function stats()
    {
        // Check if user is logged in admin
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /auth/login');
            exit;
        }

        // Ambil semua statistik
        $stats = [
            'today' => $this->get_today_stats(),
            'today_pages' => $this->get_today_page_stats(),
            'weekly' => $this->get_weekly_stats(),
            'total' => $this->get_total_stats(),
            'hourly_today' => $this->get_hourly_stats_today()
        ];

        // Return JSON untuk AJAX request
        if (isset($_GET['json']) && $_GET['json'] == '1') {
            header('Content-Type: application/json');
            echo json_encode($stats);
            exit;
        }

        // Atau load view untuk halaman penuh
        $data = [
            'title' => 'WhatsApp Click Statistics',
            'stats' => $stats
        ];

        $this->load_view('admin/wa_stats', $data);
    }

    /**
     * Get statistik hari ini
     * Version 2.0 - With error handling
     */
    private function get_today_stats()
    {
        $default = [
            'today_clicks' => 0,
            'unique_visitors' => 0,
            'top_page' => '-',
            'top_page_clicks' => 0
        ];

        if (!$this->db->isConnected()) {
            return $default;
        }

        try {
            $sql = "SELECT 
                    COUNT(*) as today_clicks,
                    COUNT(DISTINCT user_ip) as unique_visitors,
                    (SELECT page_name FROM wa_clicks WHERE click_date = CURDATE() GROUP BY page_name ORDER BY COUNT(*) DESC LIMIT 1) as top_page,
                    (SELECT COUNT(*) FROM wa_clicks WHERE click_date = CURDATE() AND page_name = (SELECT page_name FROM wa_clicks WHERE click_date = CURDATE() GROUP BY page_name ORDER BY COUNT(*) DESC LIMIT 1)) as top_page_clicks
                    FROM wa_clicks 
                    WHERE click_date = CURDATE()";

            $result = $this->db->query($sql);
            return $result ? $result->fetch_assoc() : $default;
        } catch (Exception $e) {
            return $default;
        }
    }

    /**
     * Get statistik per halaman hari ini
     * Version 2.0 - With error handling
     */
    private function get_today_page_stats()
    {
        $data = [];

        if (!$this->db->isConnected()) {
            return $data;
        }

        try {
            $sql = "SELECT 
                    page_name,
                    COUNT(*) as clicks,
                    COUNT(DISTINCT user_ip) as unique_ips,
                    MIN(click_time) as first_click,
                    MAX(click_time) as last_click
                    FROM wa_clicks 
                    WHERE click_date = CURDATE()
                    GROUP BY page_name
                    ORDER BY clicks DESC";

            $result = $this->db->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }

            return $data;
        } catch (Exception $e) {
            return $data;
        }
    }

    /**
     * Get statistik 7 hari terakhir
     * Version 2.0 - With error handling
     */
    private function get_weekly_stats()
    {
        $data = [];

        if (!$this->db->isConnected()) {
            return $data;
        }

        try {
            $sql = "SELECT 
                    click_date,
                    COUNT(*) as total_clicks,
                    COUNT(DISTINCT user_ip) as unique_visitors,
                    COUNT(DISTINCT page_name) as pages_clicked
                    FROM wa_clicks 
                    WHERE click_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                    GROUP BY click_date
                    ORDER BY click_date DESC";

            $result = $this->db->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }

            return $data;
        } catch (Exception $e) {
            return $data;
        }
    }

    /**
     * Get total statistik keseluruhan
     * Version 2.0 - With error handling
     */
    private function get_total_stats()
    {
        $default = [
            'total_all_clicks' => 0,
            'total_unique_visitors' => 0,
            'total_active_days' => 0,
            'first_click_date' => '-',
            'last_click_date' => '-',
            'most_clicked_page' => '-',
            'most_clicked_page_total' => 0
        ];

        if (!$this->db->isConnected()) {
            return $default;
        }

        try {
            $sql = "SELECT 
                    COUNT(*) as total_all_clicks,
                    COUNT(DISTINCT user_ip) as total_unique_visitors,
                    COUNT(DISTINCT click_date) as total_active_days,
                    MIN(click_date) as first_click_date,
                    MAX(click_date) as last_click_date,
                    (SELECT page_name FROM wa_clicks GROUP BY page_name ORDER BY COUNT(*) DESC LIMIT 1) as most_clicked_page,
                    (SELECT COUNT(*) FROM wa_clicks WHERE page_name = (SELECT page_name FROM wa_clicks GROUP BY page_name ORDER BY COUNT(*) DESC LIMIT 1)) as most_clicked_page_total
                    FROM wa_clicks";

            $result = $this->db->query($sql);
            return $result ? $result->fetch_assoc() : $default;
        } catch (Exception $e) {
            return $default;
        }
    }

    /**
     * Get statistik per jam untuk hari ini
     */
    private function get_hourly_stats_today()
    {
        $sql = "SELECT 
                HOUR(click_time) as hour,
                COUNT(*) as clicks
                FROM wa_clicks 
                WHERE click_date = CURDATE()
                GROUP BY HOUR(click_time)
                ORDER BY hour ASC";

        $result = $this->db->query($sql);
        $data = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    /**
     * Get history lengkap dengan pagination
     * Method: GET
     * URL: /watracking/history
     */
    public function history()
    {
        // Check if user is logged in admin
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /auth/login');
            exit;
        }

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 50;
        $offset = ($page - 1) * $limit;

        // Get total records
        $count_sql = "SELECT COUNT(*) as total FROM wa_clicks";
        $count_result = $this->db->query($count_sql);
        $total_records = $count_result ? $count_result->fetch_assoc()['total'] : 0;
        $total_pages = ceil($total_records / $limit);

        // Get paginated data
        $sql = "SELECT * FROM wa_clicks 
                ORDER BY created_at DESC 
                LIMIT $limit OFFSET $offset";

        $result = $this->db->query($sql);
        $clicks = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $clicks[] = $row;
            }
        }

        $data = [
            'title' => 'WhatsApp Click History',
            'clicks' => $clicks,
            'current_page' => $page,
            'total_pages' => $total_pages,
            'total_records' => $total_records
        ];

        $this->load_view('admin/wa_history', $data);
    }

    /**
     * Export data ke CSV
     * Method: GET
     * URL: /watracking/export
     */
    public function export()
    {
        // Check if user is logged in admin
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /auth/login');
            exit;
        }

        $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
        $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

        $sql = "SELECT * FROM wa_clicks 
                WHERE click_date BETWEEN '$start_date' AND '$end_date'
                ORDER BY created_at DESC";

        $result = $this->db->query($sql);

        // Set headers for CSV download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=wa_clicks_' . $start_date . '_' . $end_date . '.csv');

        $output = fopen('php://output', 'w');

        // CSV Header
        fputcsv($output, ['ID', 'Page Name', 'Page URL', 'Button Type', 'User IP', 'Date', 'Time', 'Created At']);

        // CSV Data
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                fputcsv($output, [
                    $row['id'],
                    $row['page_name'],
                    $row['page_url'],
                    $row['button_type'],
                    $row['user_ip'],
                    $row['click_date'],
                    $row['click_time'],
                    $row['created_at']
                ]);
            }
        }

        fclose($output);
        exit;
    }
}
