<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quick Test - WA Tracking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
            margin-bottom: 10px;
        }
        .test-btn {
            display: inline-block;
            padding: 15px 30px;
            background: #25D366;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin: 10px 0;
            font-weight: bold;
        }
        .test-btn:hover {
            background: #128C7E;
        }
        .info {
            background: #e3f2fd;
            padding: 15px;
            border-left: 4px solid #2196F3;
            margin: 20px 0;
        }
        .success {
            background: #e8f5e9;
            padding: 15px;
            border-left: 4px solid #4CAF50;
            margin: 20px 0;
        }
        .error {
            background: #ffebee;
            padding: 15px;
            border-left: 4px solid #f44336;
            margin: 20px 0;
        }
        .console {
            background: #1e1e1e;
            color: #00ff00;
            padding: 15px;
            border-radius: 5px;
            font-family: monospace;
            font-size: 12px;
            margin: 20px 0;
            max-height: 300px;
            overflow-y: auto;
        }
        .log-entry {
            margin: 5px 0;
        }
        #scriptStatus, #trackingTest {
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Quick Test - WA Tracking</h1>
        <p><strong>Test Cepat:</strong> Cek apakah script loaded dan tracking berfungsi</p>

        <!-- Script Load Test -->
        <div id="scriptStatus">
            <h3>1️⃣ Script Load Test</h3>
            <p>Checking if wa-tracker.js is loaded...</p>
        </div>

        <!-- Tracking Test -->
        <div id="trackingTest">
            <h3>2️⃣ Tracking Test</h3>
            <a href="https://wa.me/6285188588596?text=Test" class="test-btn">
                📱 Klik Button WA Ini
            </a>
            <p style="color: #666; font-size: 14px;">Klik button di atas, lalu cancel dialog WhatsApp</p>
        </div>

        <!-- Console Log -->
        <h3>3️⃣ Console Log</h3>
        <div class="console" id="consoleLog">
            <div class="log-entry">Waiting...</div>
        </div>

        <!-- Database Check -->
        <div class="info">
            <strong>📊 Cek Database:</strong><br>
            Setelah klik button WA, jalankan query ini:<br>
            <code style="background: #fff; padding: 5px; display: block; margin-top: 10px;">
                SELECT * FROM wa_clicks ORDER BY id DESC LIMIT 1;
            </code>
        </div>
    </div>

    <!-- Load WA Tracker Script -->
    <script src="/SIKUBAH/assets/js/wa-tracker.js"></script>

    <!-- Test Script -->
    <script>
        const statusDiv = document.getElementById('scriptStatus');
        const consoleLogDiv = document.getElementById('consoleLog');

        // Override console.log to capture logs
        const originalLog = console.log;
        const originalError = console.error;

        function addLog(message, type = 'log') {
            const entry = document.createElement('div');
            entry.className = 'log-entry';
            entry.style.color = type === 'error' ? '#ff6b6b' : '#00ff00';
            entry.textContent = `[${new Date().toLocaleTimeString()}] ${message}`;
            consoleLogDiv.appendChild(entry);
            consoleLogDiv.scrollTop = consoleLogDiv.scrollHeight;
        }

        console.log = function(...args) {
            originalLog.apply(console, args);
            addLog(args.join(' '), 'log');
        };

        console.error = function(...args) {
            originalError.apply(console, args);
            addLog('ERROR: ' + args.join(' '), 'error');
        };

        // Check if script loaded
        setTimeout(() => {
            if (typeof initTracking === 'function') {
                statusDiv.innerHTML = `
                    <h3>1️⃣ Script Load Test</h3>
                    <div class="success">
                        ✅ <strong>BERHASIL!</strong> Script wa-tracker.js ter-load dengan benar.<br>
                        Function initTracking tersedia.
                    </div>
                `;
                addLog('✅ Script loaded successfully!');
            } else {
                statusDiv.innerHTML = `
                    <h3>1️⃣ Script Load Test</h3>
                    <div class="error">
                        ❌ <strong>GAGAL!</strong> Script wa-tracker.js tidak ter-load.<br>
                        Periksa browser console (F12) untuk error details.
                    </div>
                `;
                addLog('❌ Script NOT loaded - initTracking function not found', 'error');
            }
        }, 500);

        // Log initial message
        addLog('Test page loaded');
        addLog('Waiting for wa-tracker.js...');
    </script>
</body>
</html>
