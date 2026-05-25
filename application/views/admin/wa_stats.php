<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'WhatsApp Statistics'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        body {
            background-color: #f5f5f5;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        .dashboard-container {
            display: flex;
            height: 100vh;
        }

        .content-wrapper {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }

        .stat-card h3 {
            font-size: 16px;
            color: #666;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .stat-card .value {
            font-size: 36px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 4px;
        }

        .stat-card .label {
            font-size: 14px;
            color: #999;
        }

        .stat-card.green .value {
            color: #25D366;
        }

        .stat-card.blue .value {
            color: #3498db;
        }

        .stat-card.orange .value {
            color: #f39c12;
        }

        .stat-card.purple .value {
            color: #9b59b6;
        }

        .page-header {
            background: white;
            padding: 24px;
            border-radius: 12px;
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 8px;
        }

        .page-header p {
            color: #7f8c8d;
            margin: 0;
        }

        .chart-container {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
            height: 300px;
            max-height: 300px;
            position: relative;
        }
        
        .chart-container canvas {
            max-height: 250px !important;
            height: 250px !important;
        }

        .table-container {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .table {
            margin: 0;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
            border-bottom: 2px solid #dee2e6;
        }

        .badge-page {
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 13px;
        }

        .icon-stat {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 12px;
        }

        .icon-stat.green {
            background-color: #e8f8f0;
            color: #25D366;
        }

        .icon-stat.blue {
            background-color: #e3f2fd;
            color: #3498db;
        }

        .icon-stat.orange {
            background-color: #fef5e7;
            color: #f39c12;
        }

        .icon-stat.purple {
            background-color: #f4ecf7;
            color: #9b59b6;
        }

        .refresh-btn {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #25D366;
            color: white;
            border: none;
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
            font-size: 24px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .refresh-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 16px rgba(37, 211, 102, 0.5);
        }

        .export-btns {
            display: flex;
            gap: 10px;
            margin-top: 16px;
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <!-- Include Sidebar -->
        <?php include VIEWPATH . 'admin/components/sidebar.php'; ?>

        <div class="content-wrapper">
            <!-- Page Header -->
            <div class="page-header">
                <h1><i class="bi bi-whatsapp me-2"></i>WhatsApp Click Statistics</h1>
                <p>Tracking klik tombol WhatsApp dari pengunjung website</p>
                <div class="export-btns">
                    <a href="/watracking/export" class="btn btn-sm btn-primary">
                        <i class="bi bi-download"></i> Export CSV
                    </a>
                    <a href="/watracking/history" class="btn btn-sm btn-secondary">
                        <i class="bi bi-clock-history"></i> View History
                    </a>
                </div>
            </div>

            <!-- Today's Stats -->
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-card green">
                        <div class="icon-stat green">
                            <i class="bi bi-cursor-fill"></i>
                        </div>
                        <h3>Klik Hari Ini</h3>
                        <div class="value" id="today-clicks"><?php echo $stats['today']['today_clicks'] ?? 0; ?></div>
                        <div class="label">Total klik WhatsApp</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card blue">
                        <div class="icon-stat blue">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h3>Pengunjung Unik</h3>
                        <div class="value" id="unique-visitors"><?php echo $stats['today']['unique_visitors'] ?? 0; ?></div>
                        <div class="label">IP address berbeda</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card orange">
                        <div class="icon-stat orange">
                            <i class="bi bi-file-earmark-text-fill"></i>
                        </div>
                        <h3>Halaman Terpopuler</h3>
                        <div class="value" style="font-size: 20px;"><?php echo $stats['today']['top_page'] ?? '-'; ?></div>
                        <div class="label"><?php echo $stats['today']['top_page_clicks'] ?? 0; ?> klik</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card purple">
                        <div class="icon-stat purple">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <h3>Total Semua Klik</h3>
                        <div class="value" id="total-clicks"><?php echo $stats['total']['total_all_clicks'] ?? 0; ?></div>
                        <div class="label">Sejak awal tracking</div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row">
                <!-- Hourly Chart -->
                <div class="col-md-6">
                    <div class="chart-container">
                        <h4 class="mb-3"><i class="bi bi-clock"></i> Klik Per Jam (Hari Ini)</h4>
                        <canvas id="hourlyChart" height="200"></canvas>
                    </div>
                </div>

                <!-- Weekly Trend Chart -->
                <div class="col-md-6">
                    <div class="chart-container">
                        <h4 class="mb-3"><i class="bi bi-calendar-week"></i> Trend 7 Hari Terakhir</h4>
                        <canvas id="weeklyChart" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Today's Page Stats Table -->
            <div class="table-container">
                <h4 class="mb-3"><i class="bi bi-bar-chart-fill"></i> Statistik Per Halaman (Hari Ini)</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Halaman</th>
                                <th>Total Klik</th>
                                <th>Pengunjung Unik</th>
                                <th>Klik Pertama</th>
                                <th>Klik Terakhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($stats['today_pages'])): ?>
                                <?php foreach ($stats['today_pages'] as $index => $page): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td>
                                            <span class="badge-page bg-primary"><?php echo htmlspecialchars($page['page_name']); ?></span>
                                        </td>
                                        <td><strong><?php echo $page['clicks']; ?></strong></td>
                                        <td><?php echo $page['unique_ips']; ?></td>
                                        <td><?php echo $page['first_click']; ?></td>
                                        <td><?php echo $page['last_click']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada data untuk hari ini</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <br><br>

            <!-- Weekly Stats Table -->
            <div class="table-container">
                <h4 class="mb-3"><i class="bi bi-calendar3"></i> Ringkasan 7 Hari Terakhir</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Total Klik</th>
                                <th>Pengunjung Unik</th>
                                <th>Halaman Diklik</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($stats['weekly'])): ?>
                                <?php foreach ($stats['weekly'] as $day): ?>
                                    <tr>
                                        <td><strong><?php echo date('d M Y', strtotime($day['click_date'])); ?></strong></td>
                                        <td><?php echo $day['total_clicks']; ?></td>
                                        <td><?php echo $day['unique_visitors']; ?></td>
                                        <td><?php echo $day['pages_clicked']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada data</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Refresh Button -->
    <button class="refresh-btn" onclick="location.reload();" title="Refresh Data">
        <i class="bi bi-arrow-clockwise"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Hourly Chart Data
        const hourlyData = <?php echo json_encode($stats['hourly_today'] ?? []); ?>;
        const hourlyLabels = [];
        const hourlyValues = [];

        // Fill all 24 hours
        for (let i = 0; i < 24; i++) {
            hourlyLabels.push(i + ':00');
            const found = hourlyData.find(d => parseInt(d.hour) === i);
            hourlyValues.push(found ? parseInt(found.clicks) : 0);
        }

        // Hourly Chart
        const hourlyCtx = document.getElementById('hourlyChart').getContext('2d');
        new Chart(hourlyCtx, {
            type: 'bar',
            data: {
                labels: hourlyLabels,
                datasets: [{
                    label: 'Klik',
                    data: hourlyValues,
                    backgroundColor: 'rgba(37, 211, 102, 0.6)',
                    borderColor: 'rgba(37, 211, 102, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Weekly Chart Data
        const weeklyData = <?php echo json_encode(array_reverse($stats['weekly'] ?? [])); ?>;
        const weeklyLabels = weeklyData.map(d => {
            const date = new Date(d.click_date);
            return date.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'short'
            });
        });
        const weeklyValues = weeklyData.map(d => parseInt(d.total_clicks));

        // Weekly Chart
        const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
        new Chart(weeklyCtx, {
            type: 'line',
            data: {
                labels: weeklyLabels,
                datasets: [{
                    label: 'Total Klik',
                    data: weeklyValues,
                    borderColor: 'rgb(52, 152, 219)',
                    backgroundColor: 'rgba(52, 152, 219, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Manual refresh only - auto refresh removed to prevent chart spam
        // User can click refresh button to update data
    </script>
</body>

</html>
