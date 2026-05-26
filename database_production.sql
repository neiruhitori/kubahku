-- ============================================
-- EXPORT DATABASE UNTUK PRODUCTION
-- ============================================
-- Database: produsen1_pkm
-- Generated: 2026-05-26
-- ============================================

-- Gunakan database production
USE produsen1_pkm;

-- ============================================
-- 1. TABEL USERS
-- ============================================
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `role` enum('admin','editor','viewer') DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 2. TABEL WA_CLICKS (WhatsApp Tracking)
-- ============================================
CREATE TABLE IF NOT EXISTS `wa_clicks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(100) NOT NULL COMMENT 'Nama halaman yang diklik',
  `page_url` varchar(255) NOT NULL COMMENT 'URL lengkap halaman',
  `button_type` varchar(50) DEFAULT 'standard' COMMENT 'Jenis button',
  `user_ip` varchar(45) DEFAULT NULL COMMENT 'IP address pengunjung',
  `user_agent` text DEFAULT NULL COMMENT 'Browser dan device info',
  `referer` varchar(255) DEFAULT NULL COMMENT 'Halaman sebelumnya',
  `click_date` date NOT NULL COMMENT 'Tanggal klik',
  `click_time` time NOT NULL COMMENT 'Waktu klik',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_date` (`click_date`),
  KEY `idx_page` (`page_name`),
  KEY `idx_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 3. TABEL WA_DAILY_STATS (Statistik Harian)
-- ============================================
CREATE TABLE IF NOT EXISTS `wa_daily_stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stat_date` date NOT NULL COMMENT 'Tanggal statistik',
  `total_clicks` int(11) DEFAULT 0 COMMENT 'Total klik hari ini',
  `unique_ips` int(11) DEFAULT 0 COMMENT 'Jumlah IP unik',
  `top_page` varchar(100) DEFAULT NULL COMMENT 'Halaman dengan klik terbanyak',
  `top_page_clicks` int(11) DEFAULT 0 COMMENT 'Jumlah klik halaman teratas',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `stat_date` (`stat_date`),
  KEY `idx_date` (`stat_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 4. TABEL WA_PAGE_STATS (Statistik Per Halaman)
-- ============================================
CREATE TABLE IF NOT EXISTS `wa_page_stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stat_date` date NOT NULL COMMENT 'Tanggal statistik',
  `page_name` varchar(100) NOT NULL COMMENT 'Nama halaman',
  `click_count` int(11) DEFAULT 0 COMMENT 'Jumlah klik di halaman ini',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_date_page` (`stat_date`,`page_name`),
  KEY `idx_date` (`stat_date`),
  KEY `idx_page` (`page_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 5. TABEL ARTICLES (Optional - jika ada fitur artikel)
-- ============================================
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `excerpt` varchar(500) DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `status` enum('draft','published','archived') DEFAULT 'draft',
  `view_count` int(11) DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_category` (`category_id`),
  KEY `idx_author` (`author_id`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 6. TABEL CATEGORIES (Optional - jika ada fitur artikel)
-- ============================================
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 7. TABEL PORTFOLIO (Optional - jika ada fitur portfolio)
-- ============================================
CREATE TABLE IF NOT EXISTS `portfolio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `project_date` date DEFAULT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `status` enum('draft','published') DEFAULT 'draft',
  `order_number` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_status` (`status`),
  KEY `idx_order` (`order_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- INSERT DEFAULT ADMIN USER
-- ============================================
-- Password: admin123 (GANTI SETELAH LOGIN PERTAMA!)
INSERT INTO `users` (`username`, `email`, `password`, `full_name`, `role`) VALUES
('admin', 'admin@produsenkubahmasjid.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin')
ON DUPLICATE KEY UPDATE `username` = `username`;

-- ============================================
-- NOTES FOR PRODUCTION:
-- ============================================
-- 1. Jalankan script ini di phpMyAdmin atau MySQL client
-- 2. Pastikan database 'produsen1_pkm' sudah dibuat
-- 3. Ganti password default admin setelah login
-- 4. Backup database secara berkala
-- 5. Hapus file setup/install setelah selesai

-- ============================================
-- END OF DATABASE EXPORT
-- ============================================
