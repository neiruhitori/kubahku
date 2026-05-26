<?php

class Home extends Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $data['title'] = 'SIKUBAH - Jasa Kubah Masjid';
        $this->load_view('home/index', $data);
    }

    /**
     * Display articles listing page
     */
    public function blog()
    {
        $articles = [];

        $result = $this->db->query("SELECT id, title, slug, content, excerpt, featured_image, author_id, published, created_at FROM articles WHERE published = 1 ORDER BY created_at DESC");

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $articles[] = $row;
            }
        }

        $data['articles'] = $articles;
        $data['title'] = 'Blog Artikel - SIKUBAH';
        $this->load_view('home/articles_section', $data);
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

        $result = $this->db->query("SELECT * FROM articles WHERE slug = '" . $this->db->escape_string($slug) . "' AND published = 1");

        if (!$result || $result->num_rows === 0) {
            header('HTTP/1.0 404 Not Found');
            echo '404 - Article not found';
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

        $this->load_view('home/article_detail', $data);
    }
}
