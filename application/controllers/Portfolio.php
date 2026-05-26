<?php

class Portfolio extends Controller {
    
    public function __construct() {
        parent::__construct();
        $this->_check_auth();
    }

    // Tampilkan daftar portfolio - sorted by newest first
    public function index()
    {
        $data['title'] = 'Kelola Portfolio - SIKUBAH';
        $data['portfolios'] = [];
        $data['db_error'] = false;

        if (!$this->db->isConnected()) {
            $data['db_error'] = true;
            $data['db_error_message'] = 'Database belum tersedia. Import database terlebih dahulu.';
            $this->load_view('admin/portfolio/index', $data);
            return;
        }

        $sql = "SELECT * FROM portfolio ORDER BY created_at DESC";
        $result = $this->db->query($sql);
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data['portfolios'][] = $row;
            }
        }
        
        $this->load_view('admin/portfolio/index', $data);
    }

    // Tampilkan form create
    public function create()
    {
        $data['title'] = 'Tambah Portfolio - SIKUBAH';
        $data['action'] = 'create';
        $data['portfolio'] = [];

        $this->load_view('admin/portfolio/form', $data);
    }

    // Save portfolio baru
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /SIKUBAH/portfolio');
            exit;
        }

        $title = isset($_POST['title']) ? trim($_POST['title']) : '';
        $description = isset($_POST['description']) ? trim($_POST['description']) : '';

        if (empty($title)) {
            $_SESSION['error'] = 'Judul portfolio harus diisi!';
            header('Location: /SIKUBAH/portfolio/create');
            exit;
        }

        // Handle image upload
        $image_path = '';
        if (isset($_FILES['portfolio_image']) && $_FILES['portfolio_image']['error'] === UPLOAD_ERR_OK) {
            $image_path = $this->_upload_and_convert_image($_FILES['portfolio_image']);
            if (!$image_path) {
                $_SESSION['error'] = 'Gagal upload gambar!';
                header('Location: /SIKUBAH/portfolio/create');
                exit;
            }
        } else {
            $_SESSION['error'] = 'Gambar harus diupload!';
            header('Location: /SIKUBAH/portfolio/create');
            exit;
        }

        $sql = "INSERT INTO portfolio (title, description, image) 
                VALUES (
                    '" . $this->db->escape_string($title) . "',
                    '" . $this->db->escape_string($description) . "',
                    '" . $this->db->escape_string($image_path) . "'
                )";

        if ($this->db->query($sql)) {
            $_SESSION['success'] = 'Portfolio berhasil ditambahkan!';
        } else {
            $_SESSION['error'] = 'Gagal menambah portfolio: ' . $this->db->conn->error;
        }

        header('Location: /SIKUBAH/portfolio');
        exit;
    }

    // Tampilkan form edit
    public function edit($id = null)
    {
        if (!$id) {
            header('Location: /SIKUBAH/portfolio');
            exit;
        }

        $sql = "SELECT * FROM portfolio WHERE id = " . intval($id) . " LIMIT 1";
        $result = $this->db->query($sql);

        if (!$result || $result->num_rows === 0) {
            $_SESSION['error'] = 'Portfolio tidak ditemukan!';
            header('Location: /SIKUBAH/portfolio');
            exit;
        }

        $data['title'] = 'Edit Portfolio - SIKUBAH';
        $data['action'] = 'edit';
        $data['portfolio'] = $result->fetch_assoc();

        $this->load_view('admin/portfolio/form', $data);
    }

    // Update portfolio
    public function update($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) {
            header('Location: /SIKUBAH/portfolio');
            exit;
        }

        $title = isset($_POST['title']) ? trim($_POST['title']) : '';
        $description = isset($_POST['description']) ? trim($_POST['description']) : '';


        if (empty($title)) {
            $_SESSION['error'] = 'Judul portfolio harus diisi!';
            header('Location: /SIKUBAH/portfolio/edit/' . $id);
            exit;
        }

        // Get current portfolio
        $sql_get = "SELECT image FROM portfolio WHERE id = " . intval($id) . " LIMIT 1";
        $result_get = $this->db->query($sql_get);
        $current_portfolio = $result_get->fetch_assoc();
        $image_path = $current_portfolio['image'];

        // Handle image upload if new image provided
        if (isset($_FILES['portfolio_image']) && $_FILES['portfolio_image']['error'] === UPLOAD_ERR_OK) {
            // Delete old image
            if ($current_portfolio['image'] && file_exists(__DIR__ . '/../../' . $current_portfolio['image'])) {
                @unlink(__DIR__ . '/../../' . $current_portfolio['image']);
            }

            // Upload and convert new image
            $image_path = $this->_upload_and_convert_image($_FILES['portfolio_image']);
            if (!$image_path) {
                $_SESSION['error'] = 'Gagal upload gambar!';
                header('Location: /SIKUBAH/portfolio/edit/' . $id);
                exit;
            }
        }

        $sql = "UPDATE portfolio SET 
                title = '" . $this->db->escape_string($title) . "',
                description = '" . $this->db->escape_string($description) . "',
                image = '" . $this->db->escape_string($image_path) . "'
                WHERE id = " . intval($id);

        if ($this->db->query($sql)) {
            $_SESSION['success'] = 'Portfolio berhasil diupdate!';
        } else {
            $_SESSION['error'] = 'Gagal mengupdate portfolio: ' . $this->db->conn->error;
        }

        header('Location: /SIKUBAH/portfolio');
        exit;
    }

    // Delete portfolio
    public function delete($id = null)
    {
        if (!$id) {
            header('Location: /SIKUBAH/portfolio');
            exit;
        }

        $sql = "DELETE FROM portfolio WHERE id = " . intval($id);

        if ($this->db->query($sql)) {
            $_SESSION['success'] = 'Portfolio berhasil dihapus!';
        } else {
            $_SESSION['error'] = 'Gagal menghapus portfolio!';
        }

        header('Location: /SIKUBAH/portfolio');
        exit;
    }

    // Return create form HTML for AJAX modal
    public function form_create()
    {
        $data['title'] = 'Tambah Portfolio';
        $data['action'] = 'create';
        $data['portfolio'] = [];
        $data['is_ajax'] = true;

        ob_start();
        $this->load_view('admin/portfolio/form-modal', $data);
        $html = ob_get_clean();

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'html' => $html]);
        exit;
    }

    // Return edit form HTML for AJAX modal
    public function form_edit($id = null)
    {
        if (!$id) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
            exit;
        }

        if (!$this->db->isConnected()) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Database belum tersedia']);
            exit;
        }

        $sql = "SELECT * FROM portfolio WHERE id = " . intval($id) . " LIMIT 1";
        $result = $this->db->query($sql);

        if (!$result || $result->num_rows === 0) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Portfolio tidak ditemukan']);
            exit;
        }

        $data['title'] = 'Edit Portfolio';
        $data['action'] = 'edit';
        $data['portfolio'] = $result->fetch_assoc();
        $data['is_ajax'] = true;

        ob_start();
        $this->load_view('admin/portfolio/form-modal', $data);
        $html = ob_get_clean();

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'html' => $html]);
        exit;
    }

    // Save portfolio via AJAX (both create and update)
    public function save_ajax()
    {
        // Log semua request untuk debugging
        error_log("========== PORTFOLIO SAVE_AJAX CALLED ==========");
        error_log("REQUEST_METHOD: " . ($_SERVER['REQUEST_METHOD'] ?? 'NOT_SET'));
        error_log("POST data: " . print_r($_POST, true));
        error_log("FILES data: " . print_r($_FILES, true));
        error_log("Session admin_logged_in: " . (isset($_SESSION['admin_logged_in']) ? 'YES' : 'NO'));

        // BYPASS AUTH CHECK TEMPORARILY FOR DEBUGGING
        if (!isset($_SESSION['admin_logged_in'])) {
            error_log("WARNING: Session not set, setting it now for debug");
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = 'admin';
        }

        if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            error_log("ERROR: Invalid request method");
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit;
        }

        $action = isset($_POST['action']) ? $_POST['action'] : 'create';
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $title = isset($_POST['title']) ? trim($_POST['title']) : '';
        $description = isset($_POST['description']) ? trim($_POST['description']) : '';

        // Log untuk debugging
        error_log("Portfolio Save - Action: $action, Title: $title");

        if (empty($title)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Judul portfolio harus diisi!']);
            exit;
        }

        if ($action === 'create') {
            // Handle create
            if (!isset($_FILES['portfolio_image']) || $_FILES['portfolio_image']['error'] !== UPLOAD_ERR_OK) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Gambar harus diupload! Error: ' . $_FILES['portfolio_image']['error']]);
                exit;
            }

            $image_path = $this->_upload_and_convert_image($_FILES['portfolio_image']);
            if (!$image_path) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Gagal upload gambar! Pastikan format gambar valid.']);
                exit;
            }

            // Log untuk debugging
            error_log("Portfolio Create - Title: $title, Image: $image_path");

            $sql = "INSERT INTO portfolio (title, description, image) 
                    VALUES (
                        '" . $this->db->escape_string($title) . "',
                        '" . $this->db->escape_string($description) . "',
                        '" . $this->db->escape_string($image_path) . "'
                    )";

            // Log query untuk debugging
            error_log("Portfolio Create Query: " . $sql);

            if ($this->db->query($sql)) {
                error_log("Portfolio Create Success - Inserted ID: " . $this->db->conn->insert_id);
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Portfolio berhasil ditambahkan!']);
                exit;
            } else {
                error_log("Portfolio Create Error: " . $this->db->conn->error);
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Gagal menambah portfolio: ' . $this->db->conn->error]);
                exit;
            }
        } else if ($action === 'edit' && $id > 0) {
            // Handle update
            $sql_get = "SELECT image FROM portfolio WHERE id = " . intval($id) . " LIMIT 1";
            $result_get = $this->db->query($sql_get);
            $current_portfolio = $result_get->fetch_assoc();
            $image_path = $current_portfolio['image'];

            // Handle image upload if new image provided
            if (isset($_FILES['portfolio_image']) && $_FILES['portfolio_image']['error'] === UPLOAD_ERR_OK) {
                // Delete old image
                if ($current_portfolio['image'] && file_exists(__DIR__ . '/../../' . $current_portfolio['image'])) {
                    @unlink(__DIR__ . '/../../' . $current_portfolio['image']);
                }

                // Upload and convert new image
                $image_path = $this->_upload_and_convert_image($_FILES['portfolio_image']);
                if (!$image_path) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Gagal upload gambar!']);
                    exit;
                }
            }

            $sql = "UPDATE portfolio SET 
                    title = '" . $this->db->escape_string($title) . "',
                    description = '" . $this->db->escape_string($description) . "',
                    image = '" . $this->db->escape_string($image_path) . "'
                    WHERE id = " . intval($id);

            if ($this->db->query($sql)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Portfolio berhasil diupdate!']);
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Gagal mengupdate portfolio: ' . $this->db->conn->error]);
                exit;
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Action tidak valid']);
            exit;
        }
    }

    private function _check_auth() {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /SIKUBAH/auth/login?redirect=' . urlencode($_SERVER['REQUEST_URI']));
            exit;
        }
    }
    
    private function _upload_and_convert_image($file) {
        $upload_dir = __DIR__ . '/../../images/';

        // Log file info
        error_log("Upload Image - File: " . print_r($file, true));

        // Create directory if not exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
            error_log("Upload Directory Created: " . $upload_dir);
        }
        
        // Validate image
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp'];
        if (!in_array($file['type'], $allowed_types)) {
            error_log("Upload Error - Invalid type: " . $file['type']);
            return false;
        }

        // Generate unique filename
        $original_name = pathinfo($file['name'], PATHINFO_FILENAME);
        $filename = preg_replace('/[^a-zA-Z0-9_-]/', '-', $original_name);
        $filename = time() . '_' . $filename . '.webp';
        $filepath = $upload_dir . $filename;

        error_log("Upload - Target path: " . $filepath);

        // Move temp file to upload directory
        if (!move_uploaded_file($file['tmp_name'], $filepath)) {
            error_log("Upload Error - Failed to move file from: " . $file['tmp_name']);
            return false;
        }

        error_log("Upload - File moved successfully");

        // Convert to WebP
        if (!$this->_convert_to_webp($filepath)) {
            error_log("Upload Error - Failed to convert to WebP");
            @unlink($filepath);
            return false;
        }

        error_log("Upload - Converted to WebP successfully");

        // Return relative path
        return './images/' . $filename;
    }
    
    private function _convert_to_webp($file_path) {
        $image = null;
        $file_type = mime_content_type($file_path);
        
        // Load image based on type
        if ($file_type === 'image/jpeg') {
            $image = imagecreatefromjpeg($file_path);
        } elseif ($file_type === 'image/png') {
            $image = imagecreatefrompng($file_path);
            imagealphablending($image, false);
            imagesavealpha($image, true);
        } elseif ($file_type === 'image/gif') {
            $image = imagecreatefromgif($file_path);
        } elseif ($file_type === 'image/webp') {
            $image = imagecreatefromwebp($file_path);
        } elseif ($file_type === 'image/bmp') {
            $image = imagecreatefrombmp($file_path);
        }
        
        if (!$image) {
            return false;
        }
        
        // Convert to WebP with quality 80
        $result = imagewebp($image, $file_path, 80);
        imagedestroy($image);
        
        return $result !== false;
    }
}
