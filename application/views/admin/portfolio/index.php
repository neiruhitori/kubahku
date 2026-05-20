<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.1.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            background-color: #f5f5f5;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        .dashboard-container {
            display: flex;
            height: 100vh;
        }

        .sidebar-wrapper {
            width: 280px;
            flex-shrink: 0;
        }

        .content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .topbar {
            background: white;
            padding: 15px 30px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
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

        .main-content {
            flex: 1;
            overflow-y: auto;
            padding: 30px;
        }

        .content-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5568d3 0%, #6a3d8b 100%);
            color: white;
        }

        table td img {
            max-width: 50px;
            max-height: 50px;
            border-radius: 5px;
            object-fit: cover;
        }

        @media (max-width: 992px) {
            .dashboard-container {
                flex-direction: column;
            }

            .sidebar-wrapper {
                width: 100%;
                height: auto;
            }

            .content-wrapper {
                height: auto;
            }

            .main-content {
                min-height: calc(100vh - 120px);
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar Component -->
        <div class="sidebar-wrapper">
            <?php include VIEWPATH . 'admin/components/sidebar.php'; ?>
        </div>

        <!-- Main Content Area -->
        <div class="content-wrapper">
            <!-- Topbar -->
            <div class="topbar">
                <div class="topbar-title">Kelola Portfolio</div>
                <div class="topbar-user">
                    <span>Admin: <strong><?php echo htmlspecialchars($_SESSION['admin_username']); ?></strong></span>
                    <div class="user-avatar"><?php echo strtoupper(substr($_SESSION['admin_username'], 0, 1)); ?></div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="main-content">
                <div class="content-card">
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['success'];
                            unset($_SESSION['success']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['error'];
                            unset($_SESSION['error']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <div style="margin-bottom: 20px;">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#portfolioModal" onclick="loadPortfolioForm('create')">
                            <i class="bi bi-plus-circle"></i> Tambah Portfolio
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table id="portfolioTable" class="table table-hover table-striped table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th>Gambar</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($portfolios)): ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Belum ada portfolio</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($portfolios as $item): ?>
                                        <tr>
                                            <td>
                                                <?php if (!empty($item['image'])): ?>
                                                    <img src="<?php echo htmlspecialchars(str_replace('./images/', '/images/', $item['image'])); ?>" alt="<?php echo htmlspecialchars($item['image_alt']); ?>" style="max-width: 50px; max-height: 50px; border-radius: 5px; object-fit: cover;" onerror="this.src='/images/placeholder.png'">
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($item['title']); ?></td>
                                            <td><?php echo substr(htmlspecialchars($item['description']), 0, 50) . (strlen($item['description']) > 50 ? '...' : ''); ?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#portfolioModal" onclick="loadPortfolioForm('edit', <?php echo $item['id']; ?>)">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </button>
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
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.bootstrap5.min.js"></script>

    <!-- Modal Portfolio Form -->
    <div class="modal fade" id="portfolioModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Form Portfolio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBody">
                    <!-- Form akan dimuat di sini via AJAX -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize DataTables
        document.addEventListener('DOMContentLoaded', function() {
            new DataTable('#portfolioTable', {
                pageLength: 10,
                lengthMenu: [
                    [5, 10, 25, 50],
                    [5, 10, 25, 50]
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                },
                columnDefs: [{
                        orderable: false,
                        targets: 3
                    } // Disable sorting for Aksi column
                ]
            });
        });

        // Load portfolio form via AJAX
        function loadPortfolioForm(action, id = null) {
            const url = action === 'create' ?
                '/SIKUBAH/portfolio/form_create' :
                `/SIKUBAH/portfolio/form_edit/${id}`;

            document.getElementById('modalTitle').textContent = action === 'create' ? 'Tambah Portfolio' : 'Edit Portfolio';
            document.getElementById('modalBody').innerHTML = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('modalBody').innerHTML = data.html;
                    } else {
                        document.getElementById('modalBody').innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('modalBody').innerHTML = '<div class="alert alert-danger">Gagal memuat form</div>';
                });
        }
    </script>
</body>

</html>