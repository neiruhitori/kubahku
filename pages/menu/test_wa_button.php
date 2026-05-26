<!DOCTYPE html>
<html>
<head>
    <title>Test WA Button - Produk</title>
    <style>
        body { font-family: Arial; padding: 40px; background: #f5f5f5; }
        .btn-wa {
            display: inline-block;
            padding: 15px 30px;
            background: #25D366;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin: 10px;
        }
        .console { background: #1e1e1e; color: #00ff00; padding: 20px; font-family: monospace; margin: 20px 0; max-height: 400px; overflow-y: auto; }
        .log { margin: 5px 0; }
        .error { color: #ff6b6b; }
    </style>
</head>
<body>
    <h1>Test Button WA - From Pages/Menu</h1>
    <p>Simulasi button dari pages/menu/produk.php</p>
    
    <div>
        <a href="https://wa.me/6285188588596?text=Test" class="btn-wa">
            📱 Test Button WA
        </a>
    </div>
    
    <h3>Console Log:</h3>
    <div class="console" id="console">
        <div class="log">Waiting...</div>
    </div>
    
    <h3>Database Check:</h3>
    <pre id="dbCheck">Run: SELECT * FROM wa_clicks ORDER BY id DESC LIMIT 1;</pre>
    
    <!-- Load Script -->
    <script src="/SIKUBAH/assets/js/wa-tracker.js"></script>
    
    <script>
        const consoleDiv = document.getElementById('console');
        const originalLog = console.log;
        const originalError = console.error;
        
        console.log = function(...args) {
            originalLog.apply(console, args);
            const log = document.createElement('div');
            log.className = 'log';
            log.textContent = args.join(' ');
            consoleDiv.appendChild(log);
            consoleDiv.scrollTop = consoleDiv.scrollHeight;
        };
        
        console.error = function(...args) {
            originalError.apply(console, args);
            const log = document.createElement('div');
            log.className = 'log error';
            log.textContent = 'ERROR: ' + args.join(' ');
            consoleDiv.appendChild(log);
            consoleDiv.scrollTop = consoleDiv.scrollHeight;
        };
        
        console.log('Test page loaded');
        console.log('Current URL:', window.location.href);
        console.log('Origin:', window.location.origin);
    </script>
</body>
</html>
