-- =====================================================
-- WhatsApp Click Tracking System
-- =====================================================
-- Tabel untuk menyimpan setiap klik tombol WhatsApp
-- Fitur: tracking per hari, history lengkap, dan statistik

-- Tabel utama untuk tracking setiap klik
CREATE TABLE IF NOT EXISTS wa_clicks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_name VARCHAR(100) NOT NULL COMMENT 'Nama halaman yang diklik (index, produk, harga, dll)',
    page_url VARCHAR(255) NOT NULL COMMENT 'URL lengkap halaman',
    button_type VARCHAR(50) DEFAULT 'standard' COMMENT 'Jenis button (sticky, inline, footer, dll)',
    user_ip VARCHAR(45) NULL COMMENT 'IP address pengunjung',
    user_agent TEXT NULL COMMENT 'Browser dan device info',
    referer VARCHAR(255) NULL COMMENT 'Halaman sebelumnya (jika ada)',
    click_date DATE NOT NULL COMMENT 'Tanggal klik',
    click_time TIME NOT NULL COMMENT 'Waktu klik',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_date (click_date),
    INDEX idx_page (page_name),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tracking setiap klik tombol WhatsApp';

-- Tabel untuk statistik harian (ringkasan per hari)
CREATE TABLE IF NOT EXISTS wa_daily_stats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    stat_date DATE NOT NULL UNIQUE COMMENT 'Tanggal statistik',
    total_clicks INT DEFAULT 0 COMMENT 'Total klik hari ini',
    unique_ips INT DEFAULT 0 COMMENT 'Jumlah IP unik',
    top_page VARCHAR(100) NULL COMMENT 'Halaman dengan klik terbanyak',
    top_page_clicks INT DEFAULT 0 COMMENT 'Jumlah klik halaman teratas',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_date (stat_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Ringkasan statistik harian klik WhatsApp';

-- Tabel untuk breakdown per halaman per hari
CREATE TABLE IF NOT EXISTS wa_page_stats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    stat_date DATE NOT NULL COMMENT 'Tanggal statistik',
    page_name VARCHAR(100) NOT NULL COMMENT 'Nama halaman',
    click_count INT DEFAULT 0 COMMENT 'Jumlah klik di halaman ini',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_date_page (stat_date, page_name),
    INDEX idx_date (stat_date),
    INDEX idx_page (page_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Statistik klik per halaman per hari';

-- Insert data awal untuk hari ini
INSERT INTO wa_daily_stats (stat_date, total_clicks) 
VALUES (CURDATE(), 0) 
ON DUPLICATE KEY UPDATE stat_date=stat_date;

-- View untuk statistik hari ini
CREATE OR REPLACE VIEW v_today_wa_stats AS
SELECT 
    COUNT(*) as today_clicks,
    COUNT(DISTINCT user_ip) as unique_visitors,
    (SELECT page_name FROM wa_clicks WHERE click_date = CURDATE() GROUP BY page_name ORDER BY COUNT(*) DESC LIMIT 1) as top_page,
    (SELECT COUNT(*) FROM wa_clicks WHERE click_date = CURDATE() AND page_name = (SELECT page_name FROM wa_clicks WHERE click_date = CURDATE() GROUP BY page_name ORDER BY COUNT(*) DESC LIMIT 1)) as top_page_clicks
FROM wa_clicks 
WHERE click_date = CURDATE();

-- View untuk statistik per halaman hari ini
CREATE OR REPLACE VIEW v_today_page_stats AS
SELECT 
    page_name,
    COUNT(*) as clicks,
    COUNT(DISTINCT user_ip) as unique_ips,
    MIN(click_time) as first_click,
    MAX(click_time) as last_click
FROM wa_clicks 
WHERE click_date = CURDATE()
GROUP BY page_name
ORDER BY clicks DESC;

-- View untuk history 7 hari terakhir
CREATE OR REPLACE VIEW v_wa_weekly_stats AS
SELECT 
    click_date,
    COUNT(*) as total_clicks,
    COUNT(DISTINCT user_ip) as unique_visitors,
    COUNT(DISTINCT page_name) as pages_clicked
FROM wa_clicks 
WHERE click_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
GROUP BY click_date
ORDER BY click_date DESC;

-- View untuk statistik keseluruhan
CREATE OR REPLACE VIEW v_wa_total_stats AS
SELECT 
    COUNT(*) as total_all_clicks,
    COUNT(DISTINCT user_ip) as total_unique_visitors,
    COUNT(DISTINCT click_date) as total_active_days,
    MIN(click_date) as first_click_date,
    MAX(click_date) as last_click_date,
    (SELECT page_name FROM wa_clicks GROUP BY page_name ORDER BY COUNT(*) DESC LIMIT 1) as most_clicked_page,
    (SELECT COUNT(*) FROM wa_clicks WHERE page_name = (SELECT page_name FROM wa_clicks GROUP BY page_name ORDER BY COUNT(*) DESC LIMIT 1)) as most_clicked_page_total
FROM wa_clicks;

-- Stored Procedure untuk mendapatkan dashboard stats
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS sp_get_wa_dashboard_stats()
BEGIN
    -- Statistik hari ini
    SELECT * FROM v_today_wa_stats;
    
    -- Statistik per halaman hari ini
    SELECT * FROM v_today_page_stats;
    
    -- Trend 7 hari terakhir
    SELECT * FROM v_wa_weekly_stats;
    
    -- Total keseluruhan
    SELECT * FROM v_wa_total_stats;
END //
DELIMITER ;

-- Trigger untuk update daily stats setiap ada insert
DELIMITER //
CREATE TRIGGER IF NOT EXISTS after_wa_click_insert
AFTER INSERT ON wa_clicks
FOR EACH ROW
BEGIN
    -- Update atau insert daily stats
    INSERT INTO wa_daily_stats (stat_date, total_clicks, unique_ips) 
    VALUES (NEW.click_date, 1, 1)
    ON DUPLICATE KEY UPDATE 
        total_clicks = total_clicks + 1,
        unique_ips = (SELECT COUNT(DISTINCT user_ip) FROM wa_clicks WHERE click_date = NEW.click_date);
    
    -- Update atau insert page stats
    INSERT INTO wa_page_stats (stat_date, page_name, click_count)
    VALUES (NEW.click_date, NEW.page_name, 1)
    ON DUPLICATE KEY UPDATE 
        click_count = click_count + 1;
END //
DELIMITER ;

-- Event untuk cleanup data lama (opsional, jalankan setiap bulan)
-- Menyimpan raw data 90 hari, tapi daily stats tetap permanen
DELIMITER //
CREATE EVENT IF NOT EXISTS cleanup_old_wa_clicks
ON SCHEDULE EVERY 1 MONTH
STARTS CURRENT_TIMESTAMP
DO
BEGIN
    -- Hapus data raw yang lebih dari 90 hari (tapi tetap ada di daily_stats)
    DELETE FROM wa_clicks 
    WHERE created_at < DATE_SUB(NOW(), INTERVAL 90 DAY);
END //
DELIMITER ;

-- Enable event scheduler (jika belum aktif)
SET GLOBAL event_scheduler = ON;

-- Contoh query untuk laporan
-- SELECT * FROM v_today_wa_stats; -- Statistik hari ini
-- SELECT * FROM v_today_page_stats; -- Per halaman hari ini
-- SELECT * FROM v_wa_weekly_stats; -- 7 hari terakhir
-- SELECT * FROM v_wa_total_stats; -- Total keseluruhan
-- CALL sp_get_wa_dashboard_stats(); -- Semua stats sekaligus
