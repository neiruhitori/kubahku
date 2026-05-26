-- ============================================
-- Migration: Create Categories Table
-- Database: db_sikubah  
-- Date: 2026-05-20
-- ============================================
-- INSTRUCTIONS:
-- 1. Open phpMyAdmin: http://localhost/phpmyadmin
-- 2. Select database: db_sikubah
-- 3. Click SQL tab
-- 4. Copy and paste this script
-- ============================================

USE db_sikubah;

-- Create categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    parent_id INT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_slug (slug),
    INDEX idx_active (is_active),
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample data (optional)
INSERT INTO categories (name, slug, description) VALUES
('Informasi Masjid', 'informasi-masjid', 'Artikel tentang informasi seputar masjid'),
('Tutorial', 'tutorial', 'Panduan dan tutorial'),
('Berita', 'berita', 'Berita terkini');

-- Verify
SELECT * FROM categories;
