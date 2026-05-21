<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
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

        .article-thumbnail {
            max-width: 50px;
            max-height: 50px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #dee2e6;
        }

        .badge-published {
            background-color: #28a745;
            color: white;
        }

        .badge-draft {
            background-color: #ffc107;
            color: #000;
        }

        .card {
            border: 1px solid #e0e0e0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border-radius: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5568d3 0%, #6a3d8b 100%);
        }

        /* DataTables Custom Styling */
        .dataTables_wrapper .dataTables_length select {
            padding: 4px 8px;
            border-radius: 4px;
            border: 1px solid #ced4da;
        }

        .dataTables_wrapper .dataTables_filter input {
            padding: 6px 12px;
            border-radius: 4px;
            border: 1px solid #ced4da;
            margin-left: 8px;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        table.dataTable thead th {
            background: #212529;
            color: white;
            font-weight: 600;
            border: none;
            padding: 12px 8px;
        }

        table.dataTable tbody tr:hover {
            background-color: #f8f9ff;
        }

        table.dataTable tbody td {
            vertical-align: middle;
            padding: 12px 8px;
        }

        .dataTables_info {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
        }

        .page-link {
            color: #667eea;
        }

        .page-link:hover {
            color: #5568d3;
        }

        code {
            background-color: #f8f9fa;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 0.85em;
            color: #e83e8c;
        }

        .btn-group-sm .btn {
            padding: 4px 8px;
            font-size: 0.875rem;
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar-wrapper">
            <?php include VIEWPATH . 'admin/components/sidebar.php'; ?>
        </div>

        <!-- Main Content -->
        <div class="content-wrapper">
            <div class="main-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="mb-0">Kelola Artikel</h1>
                    <button class="btn btn-primary" onclick="loadArticleForm('create')">
                        <i class="bi bi-plus-circle"></i> Tambah Artikel
                    </button>
                </div>

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

                <!-- DataTable -->
                <div class="card">
                    <div class="card-body">
                        <table id="articlesTable" class="table table-striped table-hover dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="80">Gambar</th>
                                    <th>Judul</th>
                                    <th width="200">Ringkasan</th>
                                    <th width="100">Status</th>
                                    <th width="120">Tanggal</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($articles as $article): ?>
                                    <tr>
                                        <td>
                                            <?php
                                            $clean_path = str_replace('./', '', $article['featured_image']);
                                            $img_src = 'http://localhost/SIKUBAH/' . $clean_path;
                                            ?>
                                            <img src="<?php echo htmlspecialchars($img_src); ?>"
                                                alt="<?php echo htmlspecialchars($article['title']); ?>"
                                                class="article-thumbnail"
                                                onerror="this.style.display='none';">
                                        </td>
                                        <td><strong><?php echo htmlspecialchars($article['title']); ?></strong></td>
                                        <td><?php echo substr(strip_tags($article['content']), 0, 80) . '...'; ?></td>
                                        <td>
                                            <?php if ($article['published']): ?>
                                                <span class="badge badge-published">
                                                    <i class="bi bi-check-circle"></i> Publish
                                                </span>
                                            <?php else: ?>
                                                <span class="badge badge-draft">
                                                    <i class="bi bi-clock"></i> Draft
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td data-order="<?php echo strtotime($article['created_at']); ?>">
                                            <?php echo date('d/m/Y', strtotime($article['created_at'])); ?><br>
                                            <small class="text-muted"><?php echo date('H:i', strtotime($article['created_at'])); ?></small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button class="btn btn-warning" onclick="loadArticleForm('edit', <?php echo $article['id']; ?>)" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <a href="/SIKUBAH/articles/delete/<?php echo $article['id']; ?>"
                                                    class="btn btn-danger"
                                                    onclick="return confirm('Yakin hapus artikel \'<?php echo addslashes($article['title']); ?>\'?')"
                                                    title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="articleModal" tabindex="-1" aria-labelledby="articleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="articleModalLabel">Artikel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="modalBody">
                        <!-- Form akan di-load di sini -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
        <!-- CKEditor CDN - Version 4.22.1 Standard (100% FREE, no license needed) with full features -->
        <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>

        <script>
            // Initialize DataTable with advanced features
            $(document).ready(function() {
                $('#articlesTable').DataTable({
                    responsive: true,
                    pageLength: 10,
                    lengthMenu: [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "Semua"]
                    ],
                    order: [
                        [4, 'desc']
                    ], // Sort by date column (descending)
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
                        searchPlaceholder: "Cari artikel...",
                        search: "<i class='bi bi-search'></i> Cari:",
                        lengthMenu: "Tampilkan _MENU_ artikel per halaman",
                        info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ artikel",
                        infoEmpty: "Tidak ada artikel",
                        infoFiltered: "(difilter dari _MAX_ total artikel)",
                        zeroRecords: "Tidak ada artikel yang ditemukan",
                        emptyTable: "Belum ada artikel. Klik tombol 'Tambah Artikel' untuk membuat artikel baru.",
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir",
                            next: "Selanjutnya",
                            previous: "Sebelumnya"
                        }
                    },
                    columnDefs: [{
                        targets: [0, 5], // Gambar dan Aksi columns
                        orderable: false,
                        searchable: false
                    }],
                    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                        '<"row"<"col-sm-12"tr>>' +
                        '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                    drawCallback: function() {
                        // Add custom styling after table is drawn
                        $('.dataTables_paginate .pagination').addClass('pagination-sm');
                    }
                });

                setActiveMenu();
            });

            // Load article form for create/edit
            function loadArticleForm(action, id = null) {
                let url = '/SIKUBAH/articles/form_create';
                if (action === 'edit' && id) {
                    url = '/SIKUBAH/articles/form_edit/' + id;
                }

                $.ajax({
                    url: url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#modalBody').html(response.html);

                            // Initialize CKEditor after form is loaded
                            setTimeout(function() {
                                if (CKEDITOR.instances.content) {
                                    CKEDITOR.instances.content.destroy();
                                }

                                CKEDITOR.replace('content', {
                                    height: 400,
                                    // Image Upload Configuration
                                    filebrowserBrowseUrl: '/SIKUBAH/articles/browse_image',
                                    filebrowserUploadUrl: '/SIKUBAH/articles/upload_image',
                                    filebrowserImageBrowseUrl: '/SIKUBAH/articles/browse_image',
                                    filebrowserImageUploadUrl: '/SIKUBAH/articles/upload_image',
                                    removePlugins: 'elementspath',
                                    resize_enabled: true,
                                    // Full toolbar with all features
                                    toolbar: [{
                                            name: 'document',
                                            items: ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print']
                                        },
                                        {
                                            name: 'clipboard',
                                            items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']
                                        },
                                        {
                                            name: 'editing',
                                            items: ['Find', 'Replace', '-', 'SelectAll', 'Scayt']
                                        },
                                        '/',
                                        {
                                            name: 'basicstyles',
                                            items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']
                                        },
                                        {
                                            name: 'paragraph',
                                            items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
                                        },
                                        {
                                            name: 'links',
                                            items: ['Link', 'Unlink', 'Anchor']
                                        },
                                        {
                                            name: 'insert',
                                            items: ['Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'Iframe']
                                        },
                                        '/',
                                        {
                                            name: 'styles',
                                            items: ['Styles', 'Format', 'Font', 'FontSize']
                                        },
                                        {
                                            name: 'colors',
                                            items: ['TextColor', 'BGColor']
                                        },
                                        {
                                            name: 'tools',
                                            items: ['Maximize', 'ShowBlocks']
                                        }
                                    ],
                                    // Image upload settings
                                    filebrowserUploadMethod: 'form'
                                });

                                console.log('CKEditor initialized successfully');
                            }, 300); // Increased timeout to 300ms

                            new bootstrap.Modal(document.getElementById('articleModal')).show();
                        } else {
                            alert('Error: ' + (response.message || 'Gagal memuat form'));
                        }
                    },
                    error: function() {
                        alert('Error: Gagal memuat form artikel');
                    }
                });
            }

            // Set active menu - called after DataTables init
            function setActiveMenu() {
                const currentPath = window.location.pathname;
                const menuLinks = document.querySelectorAll('.sidebar a');

                menuLinks.forEach(link => {
                    const href = link.getAttribute('href');
                    if (href && currentPath.includes(href)) {
                        link.classList.add('active');

                        // Open parent dropdown if exists
                        const parent = link.closest('.nav-item');
                        if (parent) {
                            const dropdown = parent.querySelector('.collapse');
                            if (dropdown) {
                                dropdown.classList.add('show');
                            }
                        }
                    } else {
                        link.classList.remove('active');
                    }
                });
            }
        </script>
</body>

</html>