<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? htmlspecialchars($title) : 'Kelola Portfolio'; ?></title>
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
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .dashboard-container {
            display: flex;
            height: 100vh;
        }

        .sidebar-wrapper {
            width: 280px;
            flex-shrink: 0;
            position: relative;
            z-index: 1060;
        }

        .content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .main-content {
            flex: 1;
            overflow-y: auto;
            padding: 30px;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px 12px 0 0 !important;
            padding: 20px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }

        .btn-primary:hover {
            opacity: 0.9;
        }

        .portfolio-image {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
            border: 2px solid #e9ecef;
        }

        .table> :not(caption)>*>* {
            padding: 1rem 0.75rem;
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar-wrapper">
            <?php include __DIR__ . '/../components/sidebar.php'; ?>
        </div>

        <!-- Main Content -->
        <div class="content-wrapper">
            <div class="main-content">
                <div class="container-fluid">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="fw-bold mb-1">Kelola Portfolio</h2>
                            <p class="text-muted mb-0">Kelola project kubah masjid yang sudah dikerjakan</p>
                        </div>
                        <button onclick="loadPortfolioForm('create')" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah Portfolio
                        </button>
                    </div>

                    <!-- Portfolio Table Card -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-images"></i> Daftar Portfolio</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="portfolioTable" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Gambar</th>
                                            <th>Judul</th>
                                            <th>Deskripsi</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($portfolios)): ?>
                                            <?php foreach ($portfolios as $index => $p): ?>
                                                <tr>
                                                    <td><?php echo $index + 1; ?></td>
                                                    <td>
                                                        <?php if (!empty($p['image'])): ?>
                                                            <?php
                                                            $clean_path = str_replace('./', '', $p['image']);
                                                            $img_src = 'https://produsenkubahmasjid.id/' . $clean_path;
                                                            ?>
                                                            <img src="<?php echo htmlspecialchars($img_src); ?>"
                                                                alt="<?php echo htmlspecialchars($p['title']); ?>"
                                                                class="portfolio-image"
                                                                onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                                                            <span style="display:none;" class="badge bg-secondary">No Image</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary">No Image</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><strong><?php echo htmlspecialchars($p['title']); ?></strong></td>
                                                    <td>
                                                        <?php
                                                        $desc = isset($p['description']) ? htmlspecialchars($p['description']) : '';
                                                        echo mb_strlen($desc) > 100 ? mb_substr($desc, 0, 100) . '...' : $desc;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">
                                                            <?php
                                                            echo isset($p['created_at']) ? date('d/m/Y H:i', strtotime($p['created_at'])) : '-';
                                                            ?>
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <button onclick="loadPortfolioForm('edit', <?php echo $p['id']; ?>)"
                                                            class="btn btn-sm btn-warning" title="Edit">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <button onclick="deletePortfolio(<?php echo $p['id']; ?>, '<?php echo htmlspecialchars(addslashes($p['title'])); ?>')"
                                                            class="btn btn-sm btn-danger" title="Hapus">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><!-- close container-fluid -->
            </div><!-- close main-content -->
        </div><!-- close content-wrapper -->
    </div><!-- close dashboard-container -->

    <!-- Portfolio Form Modal -->
    <div class="modal fade" id="portfolioModal" tabindex="-1" aria-labelledby="portfolioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="portfolioModalLabel">Form Portfolio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="portfolioModalBody">
                    <!-- Form will be loaded here via AJAX -->
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable with Indonesian language
            $('#portfolioTable').DataTable({
                language: {
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    zeroRecords: "Tidak ada data portfolio",
                    info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                    infoEmpty: "Tidak ada data tersedia",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    search: "Cari:",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    },
                    emptyTable: "Belum ada data portfolio. Klik tombol 'Tambah Portfolio' untuk menambahkan."
                },
                order: [
                    [0, 'asc']
                ],
                columnDefs: [{
                    targets: [1, 5],
                    orderable: false
                }],
                pageLength: 10
            });
        });

        function loadPortfolioForm(action, id = null) {
            const url = action === 'create' ?
                '/portfolio/form_create' :
                '/portfolio/form_edit/' + id;

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#portfolioModalBody').html(response.html);
                        $('#portfolioModalLabel').text(action === 'create' ? 'Tambah Portfolio' : 'Edit Portfolio');
                        new bootstrap.Modal(document.getElementById('portfolioModal')).show();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', {
                        xhr: xhr,
                        status: status,
                        error: error
                    });
                    alert('Gagal memuat form!');
                }
            });
        }

        function deletePortfolio(id, title) {
            if (confirm('Apakah Anda yakin ingin menghapus portfolio "' + title + '"?\nGambar yang terkait juga akan dihapus.')) {
                window.location.href = '/portfolio/delete/' + id;
            }
        }
    </script>

</body>

</html>