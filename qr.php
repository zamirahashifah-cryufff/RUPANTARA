<?php
// Deteksi IP Address komputer/laptop saat ini
function getLocalIP() {
    $ip = '192.168.18.81'; // Default fallback berdasarkan deteksi Wi-Fi saat ini
    
    // Coba deteksi via hostname
    $host = gethostname();
    $host_ip = gethostbyname($host);
    if ($host_ip && $host_ip !== '127.0.0.1' && filter_var($host_ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        $ip = $host_ip;
    }
    
    // Coba server addr jika diakses via IP
    if (isset($_SERVER['SERVER_ADDR']) && $_SERVER['SERVER_ADDR'] !== '127.0.0.1' && $_SERVER['SERVER_ADDR'] !== '::1') {
        $ip = $_SERVER['SERVER_ADDR'];
    }
    
    return $ip;
}

$local_ip = getLocalIP();
$default_url = "http://" . $local_ip . "/RUPANTARA/";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Akses RUPANTARA - Buka di HP / Perangkat Lain</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- QRCode.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <style>
        :root {
            --navy: #0E3F6B;
            --navy-dark: #0A3458;
            --blue: #59A9E8;
            --blue-dark: #174C84;
            --blue-light: #EFF6FF;
            --body: #F4F7FC;
            --white: #FFFFFF;
            --text: #1E293B;
            --muted: #64748B;
            --border: #E2E8F0;
            --success: #10B981;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #EEF4FB 0%, #F8FAFC 100%);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
        }

        .container {
            width: 100%;
            max-width: 900px;
            background: var(--white);
            border-radius: 28px;
            box-shadow: 0 20px 50px rgba(14, 63, 107, 0.08), 0 4px 12px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(226, 232, 240, 0.8);
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
            }
        }

        /* Sisi Kiri: Visual QR Code */
        .qr-section {
            background: linear-gradient(160deg, #0E3F6B 0%, #174C84 100%);
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: var(--white);
            position: relative;
        }

        .qr-section::before {
            content: '';
            position: absolute;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(89, 169, 232, 0.2) 0%, rgba(255,255,255,0) 70%);
            top: -50px;
            left: -50px;
            border-radius: 50%;
        }

        .qr-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .qr-box-wrapper {
            background: var(--white);
            padding: 18px;
            border-radius: 22px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
            display: inline-block;
            margin-bottom: 20px;
            position: relative;
            transition: transform 0.3s ease;
        }

        .qr-box-wrapper:hover {
            transform: scale(1.02);
        }

        #qrcode {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 210px;
            height: 210px;
        }

        #qrcode img {
            border-radius: 12px;
            width: 210px !important;
            height: 210px !important;
        }

        .qr-section h3 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .qr-section p {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.8);
            max-width: 260px;
        }

        /* Sisi Kanan: Kontrol & Petunjuk */
        .info-section {
            padding: 40px 35px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .header-info {
            margin-bottom: 24px;
        }

        .logo-tag {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .logo-tag span {
            font-size: 20px;
            font-weight: 800;
            color: var(--navy);
            letter-spacing: -0.5px;
        }

        .header-info h1 {
            font-size: 22px;
            font-weight: 800;
            color: var(--navy);
            line-height: 1.3;
            margin-bottom: 6px;
        }

        .header-info p {
            font-size: 13.5px;
            color: var(--muted);
        }

        /* Input URL & Target */
        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: flex;
            justify-content: space-between;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 6px;
        }

        .input-group {
            display: flex;
            position: relative;
            background: var(--blue-light);
            border: 1.5px solid #D0E1FD;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .input-group:focus-within {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(89, 169, 232, 0.2);
        }

        .input-group input {
            flex: 1;
            border: none;
            background: transparent;
            padding: 10px 14px;
            font-size: 13px;
            font-weight: 600;
            color: var(--navy-dark);
            outline: none;
        }

        .btn-copy {
            background: var(--navy);
            color: white;
            border: none;
            padding: 0 16px;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s;
        }

        .btn-copy:hover {
            background: var(--blue-dark);
        }

        /* Halaman Pilihan Cepat */
        .page-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 8px;
        }

        .page-pill {
            background: #F1F5F9;
            border: 1px solid var(--border);
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 11.5px;
            font-weight: 600;
            color: #475569;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .page-pill:hover, .page-pill.active {
            background: var(--navy);
            color: white;
            border-color: var(--navy);
        }

        /* Langkah-langkah */
        .steps-card {
            background: #F8FAFC;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 20px;
        }

        .steps-title {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--navy);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .steps-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .steps-list li {
            font-size: 12.5px;
            color: #334155;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .step-num {
            background: #E2E8F0;
            color: var(--navy);
            font-weight: 800;
            font-size: 10.5px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 2px;
        }

        /* Action Buttons */
        .action-row {
            display: flex;
            gap: 10px;
        }

        .btn-action {
            flex: 1;
            padding: 11px 16px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--navy), #174C84);
            color: white;
            border: none;
            box-shadow: 0 4px 14px rgba(14, 63, 107, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(14, 63, 107, 0.3);
        }

        .btn-outline {
            background: white;
            color: var(--navy);
            border: 1.5px solid var(--border);
        }

        .btn-outline:hover {
            background: #F8FAFC;
            border-color: var(--navy);
        }

        /* Toast notification */
        .toast {
            position: fixed;
            bottom: 25px;
            background: #0F172A;
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
            pointer-events: none;
            z-index: 9999;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Sisi Kiri: QR Code -->
        <div class="qr-section">
            <div class="qr-badge">
                <i data-lucide="scan-line" style="width: 14px; height: 14px;"></i>
                Scan untuk Buka
            </div>

            <div class="qr-box-wrapper">
                <div id="qrcode"></div>
            </div>

            <h3>Pindai dengan Kamera HP</h3>
            <p>Pastikan HP & Komputer terhubung ke jaringan Wi-Fi yang sama.</p>
        </div>

        <!-- Sisi Kanan: Informasi & Kontrol -->
        <div class="info-section">
            <div>
                <div class="header-info">
                    <div class="logo-tag">
                        <i data-lucide="smartphone" style="width: 22px; height: 22px; color: var(--navy);"></i>
                        <span>RUPANTARA</span>
                    </div>
                    <h1>Akses Website di Perangkat Lain</h1>
                    <p>Buka seluruh fitur Rupantara dari smartphone, tablet, atau laptop lain secara langsung.</p>
                </div>

                <!-- Input URL -->
                <div class="form-group">
                    <label class="form-label">
                        <span>URL Website Saat Ini:</span>
                        <span style="color: var(--muted); font-size: 11px;">IP Terdeteksi: <strong><?= htmlspecialchars($local_ip) ?></strong></span>
                    </label>
                    <div class="input-group">
                        <input type="text" id="targetUrl" value="<?= htmlspecialchars($default_url) ?>" placeholder="http://192.168.x.x/RUPANTARA/">
                        <button class="btn-copy" id="btnCopy" onclick="copyUrl()">
                            <i data-lucide="copy" style="width: 14px; height: 14px;"></i>
                            Salin
                        </button>
                    </div>

                    <!-- Shortcut Halaman -->
                    <div class="page-pills">
                        <span class="page-pill active" onclick="setSubPage('')">Beranda</span>
                        <span class="page-pill" onclick="setSubPage('LOGIN/login.php')">Login</span>
                        <span class="page-pill" onclick="setSubPage('REGISTER/register.php')">Register</span>
                        <span class="page-pill" onclick="setSubPage('SCANNER/scanner.php')">Scanner</span>
                        <span class="page-pill" onclick="setSubPage('QUIZ/quiz.php')">Quiz</span>
                    </div>
                </div>

                <!-- Langkah Praktis -->
                <div class="steps-card">
                    <div class="steps-title">
                        <i data-lucide="check-circle" style="width: 15px; height: 15px; color: var(--navy);"></i>
                        Panduan Menghubungkan:
                    </div>
                    <ul class="steps-list">
                        <li>
                            <span class="step-num">1</span>
                            <span>Pastikan <strong>Apache di XAMPP</strong> sudah menyala (hijau).</span>
                        </li>
                        <li>
                            <span class="step-num">2</span>
                            <span>Sambungkan HP ke <strong>Wi-Fi yang sama</strong> dengan laptop ini.</span>
                        </li>
                        <li>
                            <span class="step-num">3</span>
                            <span>Arahkan kamera HP ke QR Code di samping & klik link.</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="action-row">
                <a href="<?= htmlspecialchars($default_url) ?>" target="_blank" class="btn-action btn-outline">
                    <i data-lucide="external-link" style="width: 16px; height: 16px;"></i>
                    Buka di Tab Baru
                </a>
                <button onclick="downloadQR()" class="btn-action btn-primary">
                    <i data-lucide="download" style="width: 16px; height: 16px;"></i>
                    Download QR Image
                </button>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="toast">
        <i data-lucide="check" style="width: 16px; height: 16px; color: #34D399;"></i>
        <span id="toastMsg">Tautan berhasil disalin!</span>
    </div>

    <script>
        // Inisialisasi Lucide Icons
        lucide.createIcons();

        const baseHostUrl = "http://<?= $local_ip ?>/RUPANTARA/";
        let currentUrl = baseHostUrl;
        const qrcodeContainer = document.getElementById("qrcode");
        const urlInput = document.getElementById("targetUrl");

        // Objek QRCode
        let qrCodeObj = new QRCode(qrcodeContainer, {
            text: currentUrl,
            width: 210,
            height: 210,
            colorDark: "#0E3F6B",
            colorLight: "#FFFFFF",
            correctLevel: QRCode.CorrectLevel.H
        });

        // Update QR code saat input diketik
        urlInput.addEventListener("input", function() {
            updateQRCode(this.value);
        });

        function updateQRCode(newUrl) {
            if (!newUrl.trim()) return;
            currentUrl = newUrl.trim();
            qrCodeObj.clear();
            qrCodeObj.makeCode(currentUrl);
        }

        function setSubPage(path) {
            // Update pill styling
            document.querySelectorAll('.page-pill').forEach(pill => pill.classList.remove('active'));
            event.target.classList.add('active');

            const fullUrl = baseHostUrl + path;
            urlInput.value = fullUrl;
            updateQRCode(fullUrl);
            showToast("Target URL diubah ke: " + (path || "Beranda"));
        }

        function copyUrl() {
            navigator.clipboard.writeText(urlInput.value).then(() => {
                showToast("Tautan berhasil disalin ke clipboard!");
            });
        }

        function downloadQR() {
            const img = qrcodeContainer.querySelector("img");
            if (img && img.src) {
                const link = document.createElement("a");
                link.href = img.src;
                link.download = "QR_Code_Rupantara.png";
                link.click();
                showToast("Gambar QR Code berhasil diunduh!");
            }
        }

        function showToast(msg) {
            const toast = document.getElementById("toast");
            document.getElementById("toastMsg").innerText = msg;
            toast.classList.add("show");
            setTimeout(() => {
                toast.classList.remove("show");
            }, 2500);
        }
    </script>
</body>
</html>
