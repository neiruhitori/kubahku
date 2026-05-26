<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test WA Tracking Endpoint</title>
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
            margin-bottom: 20px;
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
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .test-btn:hover {
            background: #128C7E;
        }
        .test-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        .result {
            margin: 20px 0;
            padding: 15px;
            border-radius: 5px;
            display: none;
        }
        .result.success {
            background: #e8f5e9;
            border-left: 4px solid #4CAF50;
            color: #2e7d32;
        }
        .result.error {
            background: #ffebee;
            border-left: 4px solid #f44336;
            color: #c62828;
        }
        .console {
            background: #1e1e1e;
            color: #00ff00;
            padding: 15px;
            border-radius: 5px;
            font-family: monospace;
            font-size: 12px;
            margin: 20px 0;
            max-height: 400px;
            overflow-y: auto;
        }
        .log-entry {
            margin: 5px 0;
            padding: 3px 0;
        }
        .log-entry.error {
            color: #ff6b6b;
        }
        .log-entry.success {
            color: #51cf66;
        }
        .log-entry.info {
            color: #74c0fc;
        }
        pre {
            background: #f4f4f4;
            padding: 10px;
            border-radius: 5px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Test WA Tracking Endpoint</h1>
        <p>Test ini akan mengirim data tracking langsung ke endpoint <code>/watracking/track</code></p>

        <div style="margin: 20px 0;">
            <button id="testBtn" class="test-btn" onclick="testTracking()">
                🚀 Test Tracking Sekarang
            </button>
            <button class="test-btn" onclick="clearLog()" style="background: #666;">
                🗑️ Clear Log
            </button>
        </div>

        <div id="resultSuccess" class="result success"></div>
        <div id="resultError" class="result error"></div>

        <h3>📋 Console Log:</h3>
        <div class="console" id="consoleLog">
            <div class="log-entry info">Waiting for test...</div>
        </div>

        <h3>📊 Test Data yang Dikirim:</h3>
        <pre id="testData">{
  "page_name": "test-endpoint",
  "page_url": "https://produsenkubahmasjid.id/test_tracking_endpoint.php",
  "button_type": "test-button"
}</pre>
    </div>

    <script>
        const consoleLog = document.getElementById('consoleLog');
        const resultSuccess = document.getElementById('resultSuccess');
        const resultError = document.getElementById('resultError');
        const testBtn = document.getElementById('testBtn');

        function addLog(message, type = 'info') {
            const entry = document.createElement('div');
            entry.className = `log-entry ${type}`;
            const timestamp = new Date().toLocaleTimeString();
            entry.textContent = `[${timestamp}] ${message}`;
            consoleLog.appendChild(entry);
            consoleLog.scrollTop = consoleLog.scrollHeight;
        }

        function clearLog() {
            consoleLog.innerHTML = '<div class="log-entry info">Log cleared. Ready for new test...</div>';
            resultSuccess.style.display = 'none';
            resultError.style.display = 'none';
        }

        async function testTracking() {
            testBtn.disabled = true;
            testBtn.textContent = '⏳ Testing...';
            
            resultSuccess.style.display = 'none';
            resultError.style.display = 'none';

            addLog('Starting tracking test...', 'info');

            // Prepare form data
            const formData = new FormData();
            formData.append('page_name', 'test-endpoint');
            formData.append('page_url', window.location.href);
            formData.append('button_type', 'test-button');

            addLog('Sending POST request to /watracking/track', 'info');

            try {
                const response = await fetch('/watracking/track', {
                    method: 'POST',
                    body: formData
                });

                addLog(`Response status: ${response.status} ${response.statusText}`, response.ok ? 'success' : 'error');

                const contentType = response.headers.get('content-type');
                addLog(`Content-Type: ${contentType}`, 'info');

                let data;
                if (contentType && contentType.includes('application/json')) {
                    data = await response.json();
                    addLog('Response body (JSON):', 'info');
                    addLog(JSON.stringify(data, null, 2), 'info');
                } else {
                    const text = await response.text();
                    addLog('Response body (Text):', 'info');
                    addLog(text.substring(0, 500), 'info'); // First 500 chars
                    data = { error: 'Response is not JSON', body: text };
                }

                if (response.ok && data.success) {
                    addLog('✅ TRACKING BERHASIL!', 'success');
                    resultSuccess.textContent = `✅ Success! Click ID: ${data.data?.click_id || 'N/A'}`;
                    resultSuccess.style.display = 'block';
                    
                    addLog(`Click ID: ${data.data?.click_id}`, 'success');
                    addLog(`Page: ${data.data?.page_name}`, 'success');
                    addLog(`Timestamp: ${data.data?.timestamp}`, 'success');
                    
                    setTimeout(() => {
                        addLog('💡 Sekarang refresh debug page untuk melihat data baru', 'info');
                        addLog('💡 Atau buka: https://produsenkubahmasjid.id/debug_wa_stats.php', 'info');
                    }, 1000);
                } else {
                    addLog('❌ TRACKING GAGAL!', 'error');
                    resultError.textContent = `❌ Error: ${data.message || data.error || 'Unknown error'}`;
                    resultError.style.display = 'block';
                }

            } catch (error) {
                addLog(`❌ FETCH ERROR: ${error.message}`, 'error');
                resultError.textContent = `❌ Fetch Error: ${error.message}`;
                resultError.style.display = 'block';
                
                addLog('Possible causes:', 'error');
                addLog('1. Endpoint /watracking/track tidak dapat diakses', 'error');
                addLog('2. Controller WaTracking tidak ditemukan', 'error');
                addLog('3. Database connection error', 'error');
            }

            testBtn.disabled = false;
            testBtn.textContent = '🚀 Test Tracking Sekarang';
        }

        // Auto test on page load
        addLog('Page loaded. Ready to test!', 'success');
    </script>
</body>
</html>
