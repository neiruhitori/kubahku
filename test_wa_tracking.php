<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test WhatsApp Tracking</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #25D366;
            border-bottom: 3px solid #25D366;
            padding-bottom: 10px;
        }
        .test-button {
            display: inline-block;
            padding: 15px 30px;
            background: #25D366;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin: 10px;
            font-weight: bold;
            transition: all 0.3s;
        }
        .test-button:hover {
            background: #128C7E;
            transform: translateY(-2px);
        }
        .console-log {
            background: #1e1e1e;
            color: #00ff00;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            max-height: 400px;
            overflow-y: auto;
        }
        .log-entry {
            margin: 5px 0;
            padding: 5px;
            border-left: 3px solid #00ff00;
            padding-left: 10px;
        }
        .log-error {
            border-left-color: #ff0000;
            color: #ff6b6b;
        }
        .info-box {
            background: #e3f2fd;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .success-box {
            background: #e8f5e9;
            border-left: 4px solid #4CAF50;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .button-group {
            margin: 20px 0;
        }
        .stats {
            display: flex;
            gap: 20px;
            margin: 20px 0;
        }
        .stat-card {
            flex: 1;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #25D366;
        }
        .stat-label {
            color: #666;
            margin-top: 5px;
        }
        #clearBtn {
            background: #dc3545;
        }
        #clearBtn:hover {
            background: #c82333;
        }
        #refreshBtn {
            background: #007bff;
        }
        #refreshBtn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 WhatsApp Tracking Test Page</h1>
        
        <div class="info-box">
            <strong>📋 Cara Test:</strong><br>
            1. Klik tombol WhatsApp di bawah<br>
            2. Lihat console log di bawah untuk tracking info<br>
            3. Cek apakah data masuk ke database<br>
            4. Refresh halaman ini untuk lihat update counter
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-number" id="totalClicks">0</div>
                <div class="stat-label">Total Klik Hari Ini</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="uniqueIps">0</div>
                <div class="stat-label">Pengunjung Unik</div>
            </div>
        </div>

        <div class="button-group">
            <h3>Test Buttons:</h3>
            <a href="https://wa.me/6285188588596?text=Test%20tracking" class="test-button">
                📱 Test Button 1 (Standard)
            </a>
            <a href="https://wa.me/6285188588596?text=Test%20sticky" class="test-button sticky-wa">
                📱 Test Button 2 (Sticky)
            </a>
            <a href="https://wa.me/6285188588596?text=Test%20inline" class="test-button inline-wa">
                📱 Test Button 3 (Inline)
            </a>
        </div>

        <div style="margin: 20px 0;">
            <button id="refreshBtn" class="test-button">🔄 Refresh Stats</button>
            <button id="clearBtn" class="test-button">🗑️ Clear Console</button>
        </div>

        <h3>📊 Console Log:</h3>
        <div class="console-log" id="consoleLog">
            <div class="log-entry">Waiting for button click...</div>
        </div>

        <div class="success-box" style="margin-top: 20px;">
            <strong>✅ Langkah Verifikasi:</strong><br>
            1. Buka Browser Console (F12) untuk melihat detail log<br>
            2. Klik salah satu tombol WhatsApp di atas<br>
            3. Lihat log di bawah ini - harus ada "Tracking success!"<br>
            4. Buka phpMyAdmin → Tabel wa_clicks → Harus ada data baru<br>
            5. Buka Dashboard Admin → Counter harus bertambah
        </div>
    </div>

    <!-- Load WA Tracker Script -->
    <script src="<?php echo 'http://localhost/SIKUBAH/'; ?>assets/js/wa-tracker.js"></script>

    <!-- Test Console -->
    <script>
        const consoleLogDiv = document.getElementById('consoleLog');
        const originalConsoleLog = console.log;
        const originalConsoleError = console.error;

        // Intercept console.log
        console.log = function(...args) {
            originalConsoleLog.apply(console, args);
            logToPage(args, false);
        };

        // Intercept console.error
        console.error = function(...args) {
            originalConsoleError.apply(console, args);
            logToPage(args, true);
        };

        function logToPage(args, isError) {
            const timestamp = new Date().toLocaleTimeString();
            const message = args.map(arg => {
                if (typeof arg === 'object') {
                    return JSON.stringify(arg, null, 2);
                }
                return String(arg);
            }).join(' ');

            const logEntry = document.createElement('div');
            logEntry.className = 'log-entry' + (isError ? ' log-error' : '');
            logEntry.textContent = `[${timestamp}] ${message}`;
            consoleLogDiv.appendChild(logEntry);
            consoleLogDiv.scrollTop = consoleLogDiv.scrollHeight;
        }

        // Clear console button
        document.getElementById('clearBtn').addEventListener('click', function() {
            consoleLogDiv.innerHTML = '<div class="log-entry">Console cleared...</div>';
        });

        // Refresh stats button
        document.getElementById('refreshBtn').addEventListener('click', function() {
            loadStats();
        });

        // Load current stats from database
        function loadStats() {
            fetch('/watracking/stats?json=1')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('totalClicks').textContent = data.today.today_clicks || 0;
                    document.getElementById('uniqueIps').textContent = data.today.unique_visitors || 0;
                    console.log('Stats loaded:', data.today);
                })
                .catch(err => {
                    console.error('Error loading stats:', err);
                });
        }

        // Load stats on page load
        loadStats();

        // Log initial message
        console.log('WA Tracking Test Page Loaded');
        console.log('Script location:', '<?php echo 'http://localhost/SIKUBAH/'; ?>assets/js/wa-tracker.js');
        console.log('Tracking endpoint:', window.location.origin + '/watracking/track');
    </script>
</body>
</html>
