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
            font-size: 24px;
            font-weight: 700;
        }
        .sidebar-nav {
            list-style: none;
        }
        .sidebar-nav li {
            margin: 0;
        }
        .sidebar-nav a {
            display: block;
            color: rgba(255, 255, 255, 0.8);
            padding: 15px 20px;
            text-decoration: none;
            transition: all 0.3s;
        }
        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border-left: 4px solid white;
            padding-left: 16px;
        }
        .topbar {
            background: white;
            border-bottom: 1px solid #ddd;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .topbar-title {
            font-size: 18px;
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
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }
        .main-content {
            padding: 30px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px 10px 0 0;
            padding: 20px;
        }
        .stat-card {
            text-align: center;
            padding: 20px;
        }
        .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: #667eea;
        }
        .stat-label {
            color: #666;
            font-size: 14px;
            margin-top: 10px;
        }
        .btn-logout {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-logout:hover {
            background: #c82333;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row" style="min-height: 100vh;">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <div class="sidebar-brand">
                    <h2><i class="bi bi-house-heart"></i> SIKUBAH</h2>
                </div>
                <ul class="sidebar-nav">
                    <li><a href="/SIKUBAH/" class="active"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                    <li><a href="/SIKUBAH/pages"><i class="bi bi-file-earmark"></i> Kelola Pages</a></li>
                    <li><a href="/SIKUBAH/portfolio"><i class="bi bi-images"></i> Kelola Portfolio</a></li>
                    <li><a href="/SIKUBAH/content"><i class="bi bi-pencil-square"></i> Kelola Konten</a></li>
                    <li><a href="/SIKUBAH/settings"><i class="bi bi-gear"></i> Pengaturan</a></li>
                </ul>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-10">
                <!-- Topbar -->
                <div class="topbar">
                    <div class="topbar-title">Dashboard</div>
                    <div class="topbar-user">
                        <span>Admin: <strong><?php echo htmlspecialchars($username); ?></strong></span>
                        <div class="user-avatar"><?php echo strtoupper(substr($username, 0, 1)); ?></div>
                        <a href="/SIKUBAH/auth/logout" class="btn-logout">Logout</a>
                    </div>
                </div>
                
                <!-- Content Area -->
                <div class="main-content">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 style="margin-bottom: 30px;">Selamat Datang, <?php echo htmlspecialchars($username); ?>!</h3>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body stat-card">
                                    <i class="bi bi-file-earmark" style="font-size: 32px; color: #667eea;"></i>
                                    <div class="stat-number">5</div>
                                    <div class="stat-label">Total Pages</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body stat-card">
                                    <i class="bi bi-image" style="font-size: 32px; color: #667eea;"></i>
                                    <div class="stat-number">24</div>
                                    <div class="stat-label">Total Images</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body stat-card">
                                    <i class="bi bi-chat-dots" style="font-size: 32px; color: #667eea;"></i>
                                    <div class="stat-number">3</div>
                                    <div class="stat-label">Pesan Kontak</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body stat-card">
                                    <i class="bi bi-graph-up" style="font-size: 32px; color: #667eea;"></i>
                                    <div class="stat-number">1.2K</div>
                                    <div class="stat-label">Pengunjung</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row" style="margin-top: 30px;">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 style="margin: 0;">Fitur Tersedia</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6" style="margin-bottom: 20px;">
                                            <div style="padding: 15px; background: #f8f9fa; border-radius: 5px;">
                                                <h6><i class="bi bi-file-earmark"></i> Kelola Halaman</h6>
                                                <p style="color: #666; font-size: 14px; margin: 8px 0 0 0;">
                                                    Tambah, edit, atau hapus halaman website Anda dengan mudah.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="margin-bottom: 20px;">
                                            <div style="padding: 15px; background: #f8f9fa; border-radius: 5px;">
                                                <h6><i class="bi bi-pencil-square"></i> Kelola Konten</h6>
                                                <p style="color: #666; font-size: 14px; margin: 8px 0 0 0;">
                                                    Update konten text, gambar, dan media di website.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
