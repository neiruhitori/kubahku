<?php

class Articles extends Controller {
    
    public function __construct() {
        parent::__construct();
        $this->_check_auth();
    }

    // Tampilkan daftar articles - sorted by newest first
    public function index() {
        $sql = "SELECT * FROM articles ORDER BY created_at DESC";
        $result = $this->db->query($sql);
        
        $data['title'] = 'Kelola Artikel - SIKUBAH';
        $data['articles'] = [];
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data['articles'][] = $row;
            }
        }
        
        $this->load_view('admin/articles/index', $data);
    }

    // Return create form HTML for AJAX modal
    public function form_create()
    {
        $data['title'] = 'Tambah Artikel';
        $data['action'] = 'create';
        $data['article'] = [];
        $data['is_ajax'] = true;

        ob_start();
        $this->load_view('admin/articles/form-modal', $data);
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

        $sql = "SELECT * FROM articles WHERE id = " . intval($id) . " LIMIT 1";
        $result = $this->db->query($sql);

        if (!$result || $result->num_rows === 0) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Artikel tidak ditemukan']);
            exit;
        }

        $data['title'] = 'Edit Artikel';
        $data['action'] = 'edit';
        $data['article'] = $result->fetch_assoc();
        $data['is_ajax'] = true;

        ob_start();
        $this->load_view('admin/articles/form-modal', $data);
        $html = ob_get_clean();

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'html' => $html]);
        exit;
    }

    // Save article via AJAX (both create and update)
    public function save_ajax()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit;
        }

        $action = isset($_POST['action']) ? $_POST['action'] : 'create';
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $title = isset($_POST['title']) ? trim($_POST['title']) : '';
        $slug = isset($_POST['slug']) ? trim($_POST['slug']) : '';
        $content = isset($_POST['content']) ? trim($_POST['content']) : '';
        $published = isset($_POST['published']) ? intval($_POST['published']) : 0;

        if (empty($title)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Judul artikel harus diisi!']);
            exit;
        }

        if (empty($slug)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Slug artikel harus diisi!']);
            exit;
        }

        if (empty($content)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Konten artikel harus diisi!']);
            exit;
        }

        // Validate slug uniqueness
        $slug_check_sql = "SELECT id FROM articles WHERE slug = '" . $this->db->escape_string($slug) . "'";
        if ($action === 'edit' && $id > 0) {
            $slug_check_sql .= " AND id != " . intval($id);
        }
        $slug_check_result = $this->db->query($slug_check_sql);
        if ($slug_check_result && $slug_check_result->num_rows > 0) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Slug sudah digunakan, silakan gunakan slug lain!']);
            exit;
        }

        if ($action === 'create') {
            // Handle create
            $featured_image = '';
            if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
                $featured_image = $this->_upload_and_convert_image($_FILES['featured_image']);
                if (!$featured_image) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Gagal upload gambar!']);
                    exit;
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Gambar artikel harus diupload!']);
                exit;
            }

            $sql = "INSERT INTO articles (title, slug, content, featured_image, author_id, published) 
                    VALUES (
                        '" . $this->db->escape_string($title) . "',
                        '" . $this->db->escape_string($slug) . "',
                        '" . $this->db->escape_string($content) . "',
                        '" . $this->db->escape_string($featured_image) . "',
                        " . (isset($_SESSION['admin_id']) ? intval($_SESSION['admin_id']) : 1) . ",
                        " . intval($published) . "
                    )";

            if ($this->db->query($sql)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Artikel berhasil ditambahkan!']);
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Gagal menambah artikel: ' . $this->db->conn->error]);
                exit;
            }
        } else if ($action === 'edit' && $id > 0) {
            // Handle update
            $sql_get = "SELECT featured_image FROM articles WHERE id = " . intval($id) . " LIMIT 1";
            $result_get = $this->db->query($sql_get);
            $current_article = $result_get->fetch_assoc();
            $featured_image = $current_article['featured_image'];

            // Handle image upload if new image provided
            if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
                // Delete old image
                if ($current_article['featured_image'] && file_exists(__DIR__ . '/../../' . $current_article['featured_image'])) {
                    @unlink(__DIR__ . '/../../' . $current_article['featured_image']);
                }

                // Upload and convert new image
                $featured_image = $this->_upload_and_convert_image($_FILES['featured_image']);
                if (!$featured_image) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Gagal upload gambar!']);
                    exit;
                }
            }

            $sql = "UPDATE articles SET 
                    title = '" . $this->db->escape_string($title) . "',
                    slug = '" . $this->db->escape_string($slug) . "',
                    content = '" . $this->db->escape_string($content) . "',
                    featured_image = '" . $this->db->escape_string($featured_image) . "',
                    published = " . intval($published) . "
                    WHERE id = " . intval($id);

            if ($this->db->query($sql)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Artikel berhasil diupdate!']);
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Gagal mengupdate artikel: ' . $this->db->conn->error]);
                exit;
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Action tidak valid']);
            exit;
        }
    }

    // Delete article
    public function delete($id = null) {
        if (!$id) {
            header('Location: /articles');
            exit;
        }

        // Get article to delete its image
        $sql_get = "SELECT featured_image FROM articles WHERE id = " . intval($id) . " LIMIT 1";
        $result_get = $this->db->query($sql_get);
        $article = $result_get->fetch_assoc();

        // Delete image if exists
        if ($article['featured_image'] && file_exists(__DIR__ . '/../../' . $article['featured_image'])) {
            @unlink(__DIR__ . '/../../' . $article['featured_image']);
        }

        $sql = "DELETE FROM articles WHERE id = " . intval($id);

        if ($this->db->query($sql)) {
            $_SESSION['success'] = 'Artikel berhasil dihapus!';
        } else {
            $_SESSION['error'] = 'Gagal menghapus artikel!';
        }

        header('Location: /articles');
        exit;
    }

    private function _check_auth() {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /auth/login?redirect=' . urlencode($_SERVER['REQUEST_URI']));
            exit;
        }
    }

    private function _generate_slug($title) {
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }
    
    private function _upload_and_convert_image($file) {
        $upload_dir = __DIR__ . '/../../images/';
        
        // Create directory if not exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        // Allowed MIME types
        $allowed_mimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        if (!in_array($mime, $allowed_mimes)) {
            return false;
        }
        
        // Check file size (max 5MB)
        if ($file['size'] > 5 * 1024 * 1024) {
            return false;
        }
        
        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_.-]/', '', basename($file['name']));
        $target_path = $upload_dir . $filename;
        
        // Load image based on type
        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($file['tmp_name']);
                break;
            case 'image/png':
                $image = imagecreatefrompng($file['tmp_name']);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($file['tmp_name']);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($file['tmp_name']);
                break;
            case 'image/bmp':
                $image = imagecreatefrombmp($file['tmp_name']);
                break;
            default:
                return false;
        }
        
        if (!$image) {
            return false;
        }
        
        // Convert to WebP with quality 80
        $webp_filename = time() . '_' . pathinfo($file['name'], PATHINFO_FILENAME) . '.webp';
        $webp_path = $upload_dir . $webp_filename;
        
        if (imagewebp($image, $webp_path, 80)) {
            imagedestroy($image);
            return './images/' . $webp_filename;
        }
        
        imagedestroy($image);
        return false;
    }

    // Handle image upload from CKEditor
    public function upload_image()
    {
        // Check if file was uploaded
        if (!isset($_FILES['upload']) || $_FILES['upload']['error'] !== UPLOAD_ERR_OK) {
            $this->_ckeditor_error_response('File upload gagal!');
            return;
        }

        $file = $_FILES['upload'];
        
        // Upload and convert image
        $image_path = $this->_upload_and_convert_image($file);
        
        if (!$image_path) {
            $this->_ckeditor_error_response('Gagal upload gambar! Format tidak didukung atau ukuran terlalu besar (max 5MB).');
            return;
        }

        // Convert relative path to absolute URL
        $image_url = 'https://produsenkubahmasjid.id/' . ltrim($image_path, './');
        
        // CKEditor requires specific response format
        $this->_ckeditor_success_response($image_url);
    }

    // Browse image handler (untuk dialog browse)
    public function browse_image()
    {
        $upload_dir = __DIR__ . '/../../images/';
        $images = [];
        
        if (is_dir($upload_dir)) {
            $files = scandir($upload_dir);
            foreach ($files as $file) {
                if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'])) {
                    $images[] = [
                        'name' => $file,
                        'url' => 'https://produsenkubahmasjid.id/images/' . $file,
                        'size' => filesize($upload_dir . $file)
                    ];
                }
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'images' => $images]);
    }

    // CKEditor success response format
    private function _ckeditor_success_response($url)
    {
        // Check if this is CKEditor 4 callback format
        if (isset($_GET['CKEditorFuncNum'])) {
            $funcNum = $_GET['CKEditorFuncNum'];
            echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', 'Upload berhasil!');</script>";
        } else {
            // CKEditor 5 format or direct upload
            header('Content-Type: application/json');
            echo json_encode([
                'uploaded' => 1,
                'fileName' => basename($url),
                'url' => $url
            ]);
        }
        exit;
    }

    // CKEditor error response format  
    private function _ckeditor_error_response($message)
    {
        if (isset($_GET['CKEditorFuncNum'])) {
            $funcNum = $_GET['CKEditorFuncNum'];
            echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '', '$message');</script>";
        } else {
            header('Content-Type: application/json');
            echo json_encode([
                'uploaded' => 0,
                'error' => [
                    'message' => $message
                ]
            ]);
        }
        exit;
    }
}
