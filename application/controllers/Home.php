<?php

class Home extends Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        // Homepage is rendered directly from index.php HTML
        // No need to load separate view
        header('Location: /');
        exit;
    }

    /**
     * Display articles listing page
     */
    public function blog()
    {
        $articles = [];

        // Check if articles table exists
        $check_table = $this->db->query("SHOW TABLES LIKE 'articles'");

        if ($check_table && $check_table->num_rows > 0) {
            $result = $this->db->query("SELECT id, title, slug, content, excerpt, featured_image, author_id, published, created_at FROM articles WHERE published = 1 ORDER BY created_at DESC");

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $articles[] = $row;
                }
            }
        }

        // If view exists, load it. Otherwise show simple HTML
        $view_file = VIEWPATH . 'home/articles_section.php';
        if (file_exists($view_file)) {
            $data['articles'] = $articles;
            $data['title'] = 'Blog Artikel - SIKUBAH';
            $this->load_view('home/articles_section', $data);
        } else {
            // Simple fallback HTML
            echo '<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - SIKUBAH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <h1 class="mb-4">Blog Artikel</h1>';

            if (empty($articles)) {
                echo '<div class="alert alert-info">Belum ada artikel yang dipublikasikan.</div>';
            } else {
                foreach ($articles as $article) {
                    echo '<div class="card mb-3">
                        <div class="card-body">
                            <h3>' . htmlspecialchars($article['title']) . '</h3>
                            <p>' . htmlspecialchars($article['excerpt'] ?? substr(strip_tags($article['content']), 0, 150)) . '...</p>
                            <a href="/blog/' . $article['slug'] . '" class="btn btn-primary">Baca Selengkapnya</a>
                        </div>
                    </div>';
                }
            }

            echo '<div class="mt-4">
                <a href="/" class="btn btn-secondary">Kembali ke Homepage</a>
            </div>
        </div>
    </body>
    </html>';
        }
    }

    /**
     * Display single article detail page
     */
    public function article($slug = '')
    {
        if (empty($slug)) {
            header('Location: /blog');
            exit;
        }

        // Check if articles table exists
        $check_table = $this->db->query("SHOW TABLES LIKE 'articles'");

        if (!$check_table || $check_table->num_rows === 0) {
            header('Location: /blog');
            exit;
        }

        $result = $this->db->query("SELECT * FROM articles WHERE slug = '" . $this->db->escape_string($slug) . "' AND published = 1");

        if (!$result || $result->num_rows === 0) {
            header('HTTP/1.0 404 Not Found');
            echo '<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Artikel Tidak Ditemukan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5 text-center">
        <h1>404</h1>
        <p>Artikel tidak ditemukan</p>
        <a href="/blog" class="btn btn-primary">Kembali ke Blog</a>
        <a href="/" class="btn btn-secondary">Ke Homepage</a>
    </div>
</body>
</html>';
            exit;
        }

        $article = $result->fetch_assoc();

        // Get previous and next articles for navigation
        $prev_result = $this->db->query("SELECT id, title, slug FROM articles WHERE created_at < '" . $this->db->escape_string($article['created_at']) . "' AND published = 1 ORDER BY created_at DESC LIMIT 1");
        $next_result = $this->db->query("SELECT id, title, slug FROM articles WHERE created_at > '" . $this->db->escape_string($article['created_at']) . "' AND published = 1 ORDER BY created_at ASC LIMIT 1");

        $data['article'] = $article;
        $data['prev_article'] = $prev_result && $prev_result->num_rows > 0 ? $prev_result->fetch_assoc() : null;
        $data['next_article'] = $next_result && $next_result->num_rows > 0 ? $next_result->fetch_assoc() : null;
        $data['title'] = $article['title'] . ' - Blog SIKUBAH';

        // Check if view exists
        $view_file = VIEWPATH . 'home/article_detail.php';
        if (file_exists($view_file)) {
            $this->load_view('home/article_detail', $data);
        } else {
            // Simple fallback HTML
            echo '<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . htmlspecialchars($article['title']) . '</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <article>
            <h1 class="mb-4">' . htmlspecialchars($article['title']) . '</h1>
            <div class="text-muted mb-4">
                <small>Dipublikasikan: ' . date('d M Y', strtotime($article['created_at'])) . '</small>
            </div>';

            if (!empty($article['featured_image'])) {
                echo '<img src="' . htmlspecialchars($article['featured_image']) . '" class="img-fluid mb-4" alt="' . htmlspecialchars($article['title']) . '">';
            }

            echo '<div class="content">' . $article['content'] . '</div>
        </article>
        <div class="mt-5">
            <a href="/blog" class="btn btn-secondary">Kembali ke Blog</a>
            <a href="/" class="btn btn-outline-secondary">Ke Homepage</a>
        </div>
    </div>
</body>
</html>';
        }
    }
}
