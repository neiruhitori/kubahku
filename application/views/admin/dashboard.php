<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Dashboard'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        body {
            background-color: #f5f5f5;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        .dashboard-container {
            display: flex;
            height: 100vh;
            position: relative;
        }

        .sidebar-wrapper {
            flex-shrink: 0;
            width: 280px;
            transition: width 0.3s ease;
            overflow: hidden;
            height: 100vh;
        }

        .sidebar-wrapper.collapsed {
            width: 70px;
        }

        .content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .topbar {
            background: white;
            border-bottom: 1px solid #ddd;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
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
            font-size: 14px;
        }

        .main-content {
            flex: 1;
            overflow-y: auto;
            padding: 30px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px 10px 0 0;
            padding: 20px;
            border: none;
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

        /* Main content scrollbar */
        .main-content::-webkit-scrollbar {
            width: 8px;
        }

        .main-content::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .main-content::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .main-content::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar Wrapper -->
        <div class="sidebar-wrapper" id="sidebar-wrapper">
            <?php include VIEWPATH . 'admin/components/sidebar.php'; ?>
        </div>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Topbar -->
            <div class="topbar">
                <div class="topbar-title">Dashboard</div>
                <div class="topbar-user">
                    <span>Admin: <strong><?php echo htmlspecialchars($username); ?></strong></span>
                    <div class="user-avatar"><?php echo strtoupper(substr($username, 0, 1)); ?></div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <div class="row">
                    <div class="col-12">
                        <h3 style="margin-bottom: 30px;">Selamat Datang, <?php echo htmlspecialchars($username); ?>!</h3>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-12 mb-3">
                        <div class="card">
                            <div class="card-body stat-card">
                                <i class="bi bi-file-earmark" style="font-size: 32px; color: #667eea;"></i>
                                <div class="stat-number">5</div>
                                <div class="stat-label">Total Pages</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12 mb-3">
                        <div class="card">
                            <div class="card-body stat-card">
                                <i class="bi bi-image" style="font-size: 32px; color: #667eea;"></i>
                                <div class="stat-number">24</div>
                                <div class="stat-label">Total Images</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12 mb-3">
                        <div class="card">
                            <div class="card-body stat-card">
                                <i class="bi bi-chat-dots" style="font-size: 32px; color: #667eea;"></i>
                                <div class="stat-number">3</div>
                                <div class="stat-label">Pesan Kontak</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12 mb-3">
                        <div class="card">
                            <div class="card-body stat-card">
                                <i class="bi bi-graph-up" style="font-size: 32px; color: #667eea;"></i>
                                <div class="stat-number">1.2K</div>
                                <div class="stat-label">Pengunjung</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Features Section -->
                <div class="row" style="margin-top: 30px;">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 style="margin: 0;">Fitur Tersedia</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div style="padding: 15px; background: #f8f9fa; border-radius: 5px;">
                                            <h6><i class="bi bi-file-earmark"></i> Kelola Halaman</h6>
                                            <p style="color: #666; font-size: 14px; margin: 8px 0 0 0;">
                                                Tambah, edit, atau hapus halaman website Anda dengan mudah.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>