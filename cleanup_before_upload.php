#!/usr/bin/env php
<?php
/**
 * SCRIPT CLEANUP - Hapus File Development Sebelum Upload
 * =======================================================
 * Script ini akan menghapus file-file development yang tidak perlu di production
 * 
 * CARA PAKAI:
 * php cleanup_before_upload.php
 */

echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║        CLEANUP SCRIPT - SIKUBAH PRODUCTION                ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

// File yang akan dihapus
$files_to_delete = [
    // Development test files
    'debug_wa_stats.php',
    'test_tracking_endpoint.php',
    'test_wa_tracking.php',
    'quick_test_tracking.php',
    'create_admin.php',
    
    // Deployment scripts
    'deploy_to_production.php',
    'cleanup_before_upload.php',  // Script ini sendiri
    
    // Backup config files
    'application/config/database.production.php',
    'application/config/config.production.php',
    'application/config/database.local.php',
    'application/config/config.local.php',
    
    // Backup htaccess
    '.htaccess.production',
    '.htaccess.local',
    
    // Documentation (optional - comment jika ingin keep)
    'FIXES_APPLIED.md',
    'INSTRUKSI_FIX_CACHE.md',
    'PERBAIKAN_SUMMARY.md',
    'TROUBLESHOOTING_WA.md',
    'WA_TRACKING_GUIDE.md',
    'WA_TRACKING_SUMMARY.md',
    'DOKUMENTASI_TRACKING_WA.md',
    'CARA_KERJA_TRACKING_WA.md',
    'PANDUAN_DEPLOYMENT.md',
    'DEPLOYMENT_CHECKLIST.md',
    'DEPLOYMENT_SUMMARY.md',
    
    // Setup files
    'setup.php.txt',
];

// Database export (akan di-upload manual)
$db_files = [
    'database_production.sql',
];

echo "⚠️  PERHATIAN:\n";
echo "Script ini akan MENGHAPUS file-file development.\n";
echo "Pastikan Anda sudah BACKUP project terlebih dahulu!\n\n";

echo "📋 File yang akan dihapus:\n";
foreach ($files_to_delete as $file) {
    $exists = file_exists(__DIR__ . '/' . $file);
    echo ($exists ? "  ✓ " : "  ⏭️  ") . $file . "\n";
}

echo "\n📄 File database (tidak akan dihapus, upload manual):\n";
foreach ($db_files as $file) {
    echo "  💾 " . $file . "\n";
}

echo "\nLanjutkan hapus file? (yes/no): ";

$handle = fopen("php://stdin", "r");
$line = fgets($handle);
if (trim($line) != 'yes') {
    echo "\n❌ Cleanup dibatalkan.\n";
    exit;
}
fclose($handle);

echo "\n🗑️  Menghapus file...\n\n";

$deleted_count = 0;
$not_found_count = 0;

foreach ($files_to_delete as $file) {
    $filepath = __DIR__ . '/' . $file;
    
    if (file_exists($filepath)) {
        if (unlink($filepath)) {
            echo "  ✅ Deleted: $file\n";
            $deleted_count++;
        } else {
            echo "  ❌ Failed to delete: $file\n";
        }
    } else {
        echo "  ⏭️  Not found: $file\n";
        $not_found_count++;
    }
}

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║                    CLEANUP SUMMARY                         ║\n";
echo "╠════════════════════════════════════════════════════════════╣\n";
echo "║  Files deleted:        " . str_pad($deleted_count, 35) . "║\n";
echo "║  Files not found:      " . str_pad($not_found_count, 35) . "║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

echo "✅ Cleanup selesai!\n\n";

echo "📋 LANGKAH SELANJUTNYA:\n";
echo "1. Verify file yang dihapus sudah benar\n";
echo "2. Upload project via FTP\n";
echo "3. Upload database_production.sql manual via phpMyAdmin\n";
echo "4. Test website di browser\n\n";

echo "⚠️  REMINDER:\n";
echo "- File database_production.sql masih ada (untuk di-upload manual)\n";
echo "- Script ini sudah dihapus sendiri (tidak akan ada di FTP)\n";
echo "- Backup ada di lokal jika perlu restore\n\n";

?>
