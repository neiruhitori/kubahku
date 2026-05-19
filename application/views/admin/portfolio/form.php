<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        body {
            background-color: #f5f5f5;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
        .sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: white;
            padding: 20px 0;
        }
        .sidebar-brand {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }
        .sidebar-brand h2 {
            font-size: 20px;
            margin: 0;
        }
        .sidebar-nav {
            list-style: none;
        }
        .sidebar-nav li {
            margin: 0;
        }
        .sidebar-nav a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }
        .sidebar-nav a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-left-color: white;
        }
        .sidebar-nav a.active {
            background-color: rgba(255, 255, 255, 0.2);
            border-left-color: white;
        }
        .topbar {
            background: white;
            padding: 15px 20px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .topbar-title {
            font-size: 20px;
            font-weight: 600;
            color: #333;
        }
        .topbar-user {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        .btn-logout {
            background-color: #dc3545;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }
        .btn-logout:hover {
            background-color: #c82333;
            color: white;
        }
        .main-content {
            background: white;
            padding: 30px;
            margin: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-width: 600px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5568d3 0%, #6a3d8b 100%);
        }
        .form-label {
            font-weight: 600;
            color: #333;
            margin-top: 15px;
            margin-bottom: 8px;
        }
        .form-control {
            border-radius: 5px;
            padding: 10px 15px;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .image-preview {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            border-radius: 5px;
            display: none;
        }
        .image-preview.show {
            display: block;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <div class="sidebar-brand">
                    <h2><i class="bi bi-house-heart"></i> SIKUBAH</h2>
                </div>
                <ul class="sidebar-nav">
                    <li><a href="/SIKUBAH/"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                    <li><a href="/SIKUBAH/pages"><i class="bi bi-file-earmark"></i> Kelola Pages</a></li>
                    <li><a href="/SIKUBAH/portfolio" class="active"><i class="bi bi-images"></i> Kelola Portfolio</a></li>
                    <li><a href="/SIKUBAH/content"><i class="bi bi-pencil-square"></i> Kelola Konten</a></li>
                    <li><a href="/SIKUBAH/settings"><i class="bi bi-gear"></i> Pengaturan</a></li>
                </ul>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-10">
                <!-- Topbar -->
                <div class="topbar">
                    <div class="topbar-title"><?php echo $action === 'create' ? 'Tambah Portfolio' : 'Edit Portfolio'; ?></div>
                    <div class="topbar-user">
                        <span>Admin: <strong><?php echo htmlspecialchars($_SESSION['admin_username']); ?></strong></span>
                        <div class="user-avatar"><?php echo strtoupper(substr($_SESSION['admin_username'], 0, 1)); ?></div>
                        <a href="/SIKUBAH/auth/logout" class="btn-logout">Logout</a>
                    </div>
                </div>
                
                <!-- Content Area -->
                <div class="main-content">
                    <form method="POST" action="/SIKUBAH/portfolio/<?php echo $action === 'create' ? 'store' : 'update/' . $portfolio['id']; ?>" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label class="form-label">Judul Portfolio *</label>
                            <input type="text" class="form-control" name="title" required value="<?php echo htmlspecialchars($portfolio['title'] ?? ''); ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="description" rows="5"><?php echo htmlspecialchars($portfolio['description'] ?? ''); ?></textarea>
                            <small class="form-text text-muted">Deskripsi lokasi dan spesifikasi kubah</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Upload Gambar *</label>
                            <input type="file" class="form-control" name="portfolio_image" id="portfolio_image" accept="image/*" <?php echo $action === 'create' ? 'required' : ''; ?>>
                            <small class="form-text text-muted">Gambar akan otomatis dikonversi ke format WebP. Ukuran maksimal: 5MB</small>
                            <?php if (!empty($portfolio['image']) && $action === 'edit'): ?>
                                <div style="margin-top: 10px;">
                                    <p style="font-weight: 600; margin-bottom: 5px;">Gambar Saat Ini:</p>
                                    <img src="<?php echo htmlspecialchars($portfolio['image']); ?>" class="image-preview show" alt="Preview">
                                </div>
                            <?php endif; ?>
                            <img id="preview-image" class="image-preview" alt="Preview Gambar Baru">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Alt Text Gambar</label>
                            <input type="text" class="form-control" name="image_alt" value="<?php echo htmlspecialchars($portfolio['image_alt'] ?? ''); ?>" placeholder="Deskripsi gambar untuk SEO">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Urutan Tampil</label>
                            <input type="number" class="form-control" name="order_number" value="<?php echo $portfolio['order_number'] ?? 0; ?>">
                            <small class="form-text text-muted">Nomor urutan untuk sorting (semakin kecil semakin awal tampil)</small>
                        </div>
                        
                        <div style="display: flex; gap: 10px; margin-top: 30px;">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> <?php echo $action === 'create' ? 'Tambah' : 'Update'; ?>
                            </button>
                            <a href="/SIKUBAH/portfolio" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Preview gambar saat file dipilih
        document.getElementById('portfolio_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const preview = document.getElementById('preview-image');
                    preview.src = event.target.result;
                    preview.classList.add('show');
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
