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
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5568d3 0%, #6a3d8b 100%);
        }
        table td img {
            max-width: 100px;
            max-height: 100px;
            border-radius: 5px;
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
                    <div class="topbar-title">Kelola Portfolio</div>
                    <div class="topbar-user">
                        <span>Admin: <strong><?php echo htmlspecialchars($_SESSION['admin_username']); ?></strong></span>
                        <div class="user-avatar"><?php echo strtoupper(substr($_SESSION['admin_username'], 0, 1)); ?></div>
                        <a href="/SIKUBAH/auth/logout" class="btn-logout">Logout</a>
                    </div>
                </div>
                
                <!-- Content Area -->
                <div class="main-content">
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <div style="margin-bottom: 20px;">
                        <a href="/SIKUBAH/portfolio/create" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah Portfolio
                        </a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Gambar</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Urutan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($portfolios)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada portfolio</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($portfolios as $item): ?>
                                        <tr>
                                            <td>
                                                <?php if (!empty($item['image'])): ?>
                                                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['image_alt']); ?>">
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($item['title']); ?></td>
                                            <td><?php echo substr(htmlspecialchars($item['description']), 0, 50) . (strlen($item['description']) > 50 ? '...' : ''); ?></td>
                                            <td><?php echo $item['order_number']; ?></td>
                                            <td>
                                                <a href="/SIKUBAH/portfolio/edit/<?php echo $item['id']; ?>" class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                                <a href="/SIKUBAH/portfolio/delete/<?php echo $item['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
