<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Escáner de Código de Barras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            text-align: center;
        }
        #scanButton {
            font-size: 18px;
            padding: 10px 20px;
            margin: 20px 0;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
        }
        #barcodeOutput {
            width: 90%;
            max-width: 300px;
            margin: 20px auto;
            padding: 10px;
            border: 2px solid #007bff;
            border-radius: 5px;
            font-size: 20px;
            min-height: 30px;
            word-break: break-all;
            background-color: #f0f0f0;
        }
        #status {
            color: #666;
            font-style: italic;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Escáner de Código de Barras</h1>
    <button id="scanButton">Iniciar Escaneo</button>
    <div id="status">Listo para escanear</div>
    <div id="barcodeOutput"></div>

    <script>
        const scanButton = document.getElementById('scanButton');
        const barcodeOutput = document.getElementById('barcodeOutput');
        const statusDisplay = document.getElementById('status');
        let barcodeBuffer = '';
        let isScanning = false;

        scanButton.addEventListener('click', toggleScan);

        function toggleScan() {
            isScanning = !isScanning;
            if (isScanning) {
                scanButton.textContent = 'Detener Escaneo';
                statusDisplay.textContent = 'Escaneando...';
                barcodeOutput.textContent = '';
                barcodeBuffer = '';
                window.addEventListener('keydown', handleScan);
            } else {
                scanButton.textContent = 'Iniciar Escaneo';
                statusDisplay.textContent = 'Listo para escanear';
                window.removeEventListener('keydown', handleScan);
            }
        }

        function handleScan(event) {
            if (!isScanning) return;

            if (event.key === 'Enter') {
                processScan();
            } else if (event.key.length === 1) { // Solo caracteres imprimibles
                barcodeBuffer += event.key;
                barcodeOutput.textContent = barcodeBuffer;
            }
        }

        function processScan() {
            if (barcodeBuffer) {
                barcodeOutput.textContent = barcodeBuffer;
                statusDisplay.textContent = 'Código escaneado';
                console.log('Código escaneado:', barcodeBuffer);
                isScanning = false;
                scanButton.textContent = 'Iniciar Nuevo Escaneo';
                window.removeEventListener('keydown', handleScan);
            }
        }

        // Manejar pegado de texto (para escáneres que funcionan como "keyboard wedge")
        document.addEventListener('paste', function(event) {
            if (isScanning) {
                event.preventDefault();
                const pastedText = (event.clipboardData || window.clipboardData).getData('text');
                barcodeOutput.textContent = pastedText;
                statusDisplay.textContent = 'Código escaneado';
                console.log('Código pegado:', pastedText);
                isScanning = false;
                scanButton.textContent = 'Iniciar Nuevo Escaneo';
                window.removeEventListener('keydown', handleScan);
            }
        });
    </script>
</body>
</html>