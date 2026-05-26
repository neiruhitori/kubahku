#!/usr/bin/env php
<?php
/**
 * SCRIPT DEPLOYMENT KE PRODUCTION
 * ================================
 * Script ini akan mengganti semua path development ke production
 * 
 * CARA PAKAI:
 * php deploy_to_production.php
 */

echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║      DEPLOYMENT SCRIPT - SIKUBAH PRODUCTION               ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

// Konfigurasi
$config = [
    'development' => [
        'base_url' => 'http://localhost/SIKUBAH',
        'path' => '/SIKUBAH',
        'domain' => 'localhost'
    ],
    'production' => [
        'base_url' => 'https://produsenkubahmasjid.id',
        'path' => '',  // Root domain, tidak ada subfolder
        'domain' => 'produsenkubahmasjid.id'
    ]
];

// Konfirmasi dari user
echo "⚠️  PERHATIAN:\n";
echo "Script ini akan mengganti SEMUA path development ke production.\n";
echo "Pastikan Anda sudah backup project sebelum melanjutkan!\n\n";
echo "Development URL: {$config['development']['base_url']}\n";
echo "Production URL:  {$config['production']['base_url']}\n\n";
echo "Lanjutkan? (yes/no): ";

$handle = fopen("php://stdin", "r");
$line = fgets($handle);
if (trim($line) != 'yes') {
    echo "\n❌ Deployment dibatalkan.\n";
    exit;
}
fclose($handle);

echo "\n🔄 Memulai proses deployment...\n\n";

// Direktori yang akan di-scan
$directories = [
    __DIR__,
    __DIR__ . '/pages',
    __DIR__ . '/pages/menu',
    __DIR__ . '/pages/menu/assesoris',
    __DIR__ . '/assets/js',
    __DIR__ . '/application/config'
];

// File yang akan di-skip
$skip_files = [
    'deploy_to_production.php',
    'database_production.sql',
    'config.production.php',
    'database.production.php',
    '.git',
    'vendor',
    'node_modules'
];

$total_files = 0;
$total_replacements = 0;

// Fungsi untuk replace dalam file
function replaceInFile($file, $search, $replace) {
    $content = file_get_contents($file);
    $original = $content;
    
    // Replace semua pattern
    foreach ($search as $key => $pattern) {
        $content = str_replace($pattern, $replace[$key], $content);
    }
    
    // Hitung jumlah replacement
    $count = $original !== $content ? 1 : 0;
    
    if ($count > 0) {
        file_put_contents($file, $content);
    }
    
    return $count;
}

// Pattern yang akan diganti
$search_patterns = [
    'http://localhost/SIKUBAH/',
    'http://localhost/SIKUBAH',
    '/SIKUBAH/',
    'localhost/SIKUBAH'
];

$replace_patterns = [
    'https://produsenkubahmasjid.id/',
    'https://produsenkubahmasjid.id',
    '/',
    'produsenkubahmasjid.id'
];

// Scan dan replace
foreach ($directories as $dir) {
    if (!is_dir($dir)) continue;
    
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    
    foreach ($files as $file) {
        if (!$file->isFile()) continue;
        
        $filename = $file->getFilename();
        $filepath = $file->getPathname();
        
        // Skip file tertentu
        $should_skip = false;
        foreach ($skip_files as $skip) {
            if (strpos($filepath, $skip) !== false) {
                $should_skip = true;
                break;
            }
        }
        
        if ($should_skip) continue;
        
        // Hanya process file PHP, JS, HTML
        $ext = strtolower($file->getExtension());
        if (!in_array($ext, ['php', 'js', 'html', 'htm'])) continue;
        
        echo "📝 Processing: " . basename($filepath) . "...";
        
        $count = replaceInFile($filepath, $search_patterns, $replace_patterns);
        
        if ($count > 0) {
            echo " ✅ UPDATED\n";
            $total_replacements += $count;
        } else {
            echo " ⏭️  SKIP\n";
        }
        
        $total_files++;
    }
}

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║                    DEPLOYMENT SUMMARY                      ║\n";
echo "╠════════════════════════════════════════════════════════════╣\n";
echo "║  Total files scanned:  " . str_pad($total_files, 35) . "║\n";
echo "║  Files updated:        " . str_pad($total_replacements, 35) . "║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

echo "✅ Deployment selesai!\n\n";

echo "📋 LANGKAH SELANJUTNYA:\n";
echo "1. Ganti database.php dengan database.production.php\n";
echo "2. Ganti config.php dengan config.production.php\n";
echo "3. Upload semua file ke FTP server\n";
echo "4. Import database_production.sql ke database remote\n";
echo "5. Test website di browser\n\n";

echo "🔐 JANGAN LUPA:\n";
echo "- Hapus file development yang tidak perlu (debug_*.php, test_*.php)\n";
echo "- Ganti password admin default\n";
echo "- Pastikan .htaccess sudah benar\n";
echo "- Test semua fungsi website\n\n";

?>
