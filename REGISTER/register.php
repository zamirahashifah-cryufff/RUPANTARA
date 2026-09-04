<?php
session_start();
// Memeriksa status login pengguna
$is_logged_in = isset($_SESSION['login']) && $_SESSION['login'] === true;
$display_username = $is_logged_in ? $_SESSION['username'] : 'User';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rupantara - Daftar Akun</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="../navbar_responsive.css">
    <script src="../navbar_responsive.js" defer></script>
    
    <style>
        :root {
            --navy: #0E3F6B;
            --navy-dark: #0A3458;
            --blue: #59A9E8;
            --blue-dark: #174C84;
            --body: #F8FAFF;
            --white: #FFFFFF;
            --text: #1E293B;
            --muted: #64748B;
            --border: #E2E8F0;
        }

        /* Reset CSS dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', "Plus Jakarta Sans", "Inter", sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #eef3f9;
            background-image: url('../GAMBAR_GAMBAR/background_login_register.png');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            background-position: left center;
            color: #1a365d;
        }

        /* =====================================================
           HEADER (Floating Glassmorphism style) - PERSIS EDUKASI.PHP
        ===================================================== */
        nav {
            width: 90%;
            max-width: 1300px;
            height: 80px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            display: flex;
            align-items: center;
            padding: 0 28px;
            gap: 20px;
            position: sticky;
            top: 20px;
            margin: 0 auto;
            border-radius: 20px;
            z-index: 999;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 12px 30px rgba(0, 48, 135, 0.06);
            transition: all 0.3s ease;
        }

        .nav-logo {
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease;
        }

        .nav-logo:hover {
            transform: scale(1.03);
        }

        .nav-logo img {
            height: 100%;
            width: auto;
            object-fit: contain;
        }

        .nav-links {
            list-style: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-left: auto;
            background: rgba(244, 247, 252, 0.6);
            padding: 5px;
            border-radius: 14px;
            border: 1px solid rgba(226, 232, 240, 0.4);
        }

        .nav-links a {
            position: relative;
            text-decoration: none;
            color: #64748B;
            font-size: 13.5px;
            font-weight: 600;
            letter-spacing: 0.2px;
            padding: 10px 18px;
            border-radius: 10px;
            white-space: nowrap;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-block;
        }

        .nav-links a:hover {
            color: var(--blue-dark);
            background: rgba(255, 255, 255, 0.8);
        }

        .nav-links a.active {
            color: var(--blue-dark);
            background: #FFFFFF;
            box-shadow: 0 4px 12px rgba(0, 48, 135, 0.05);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .btn-login {
            min-width: 95px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 16px;
            background: linear-gradient(135deg, var(--blue-dark), #1d5fa3);
            color: white;
            border-radius: 10px;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(23, 76, 132, 0.15);
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(23, 76, 132, 0.25);
            background: linear-gradient(135deg, #123D70, #174C84);
        }

        .notification-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(244, 247, 252, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            color: #64748B;
            transition: all 0.3s ease;
        }

        .notification-btn:hover {
            background: #EAF2FF;
            color: var(--blue-dark);
            transform: translateY(-2px);
        }

        .notification-dot {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 6px;
            height: 6px;
            background: #EF4444;
            border-radius: 50%;
        }

        .nav-divider {
            width: 1px;
            height: 34px;
            background: #D9E2EC;
        }

        .user-area {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(244, 247, 252, 0.8);
            padding: 4px 12px 4px 4px;
            border-radius: 12px;
            border: 1px solid rgba(226, 232, 240, 0.5);
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .user-area:hover {
            background: #EAF2FF;
            border-color: rgba(89, 169, 232, 0.3);
        }

        .user-icon {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: white;
            color: var(--blue-dark);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
        }

        .user-greeting {
            font-size: 13px;
            font-weight: 600;
            color: #475569;
        }

        /* --- KONTEN UTAMA --- */
        .main-container {
            display: flex;
            flex: 1;
            justify-content: space-between;
            align-items: center;
            padding: 30px 4% 40px; 
            gap: 50px;
            max-width: 1300px;
            width: 90%;
            margin: 20px auto 40px; 
        }

        /* Spacer kiri untuk menyeimbangkan posisi kartu register di kanan */
        .left-spacer {
            flex: 1.2;
        }

        /* Bagian Kanan: Kartu Register */
        .register-card-wrapper {
            flex: 1;
            display: flex;
            justify-content: flex-end;
        }

        .register-card {
            background-color: rgba(255, 255, 255, 0.95);
            width: 100%;
            max-width: 460px;
            padding: 35px;
            border-radius: 24px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            text-align: center;
        }

        .card-logo {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin-bottom: 10px;
        }

        .card-brand-logo {
            height: 70px; 
            width: auto;
            object-fit: contain;
        }

        .register-card h3 {
            font-size: 20px;
            font-weight: 700;
            color: #0d3b66;
            margin-bottom: 4px;
        }

        .register-card .sub-info {
            font-size: 11px;
            color: #64748b;
            margin-bottom: 20px;
        }

        /* Gaya Input Form */
        .form-group {
            text-align: left;
            margin-bottom: 14px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #1e3a8a;
            margin-bottom: 6px;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 11px 16px;
            font-size: 13px;
            border: 1.5px solid #cbd5e1;
            border-radius: 8px;
            outline: none;
            background-color: #ffffff;
            color: #1e293b;
            transition: all 0.3s ease;
        }

        .form-group input:focus, .form-group select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        /* Tampilan khusus pilihan select modern */
        .form-group select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23475569' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
            cursor: pointer;
        }

        /* Password Wrapper & Toggle Eye */
        .password-wrapper {
            position: relative;
            width: 100%;
        }

        .password-wrapper input {
            padding-right: 45px !important;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            display: flex;
            align-items: center;
            color: #64748b;
            user-select: none;
        }

        .toggle-password svg {
            width: 18px;
            height: 18px;
            fill: currentColor;
            transition: color 0.2s;
        }

        .toggle-password:hover {
            color: #1d4ed8;
        }

        /* Pesan Kecocokan Password */
        .match-message {
            font-size: 11px;
            margin-top: 4px;
            font-weight: 500;
            display: none;
        }

        /* Footer Tautan */
        .form-footer {
            margin-top: 15px;
            margin-bottom: 20px;
            font-size: 12px;
            color: #64748b;
        }

        .form-footer a {
            color: #1d4ed8;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .form-footer a:hover {
            color: #1e40af;
            text-decoration: underline;
        }

        /* Tombol Submit */
        .btn-submit {
            width: 100%;
            background-color: #0b2545;
            color: #ffffff;
            border: none;
            padding: 12px;
            font-size: 14px;
            font-weight: 700;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.1s;
            letter-spacing: 1px;
        }

        .btn-submit:hover {
            background-color: #134074;
        }

        .btn-submit:active {
            transform: scale(0.98);
        }

        /* Opsi Register Sosial */
        .social-login {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 5px;
        }

        .social-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e2e8f0;
            background-color: #ffffff;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .social-btn svg {
            width: 18px;
            height: 18px;
        }

        /* --- MEDIA QUERIES UNTUK LAYAR TABLET --- */
        @media (max-width: 992px) {
            nav {
                width: 95%;
                padding: 0 16px;
            }

            .nav-links {
                display: none;
            }

            body {
                background-position: center center;
            }

            .main-container {
                flex-direction: column;
                padding: 20px 4% 30px;
                justify-content: center;
                gap: 30px;
                width: 95%;
            }
            
            .left-spacer {
                display: none;
            }
            
            .register-card-wrapper {
                justify-content: center;
                width: 100%;
            }
        }

        /* --- MEDIA QUERIES UNTUK LAYAR HP --- */
        @media (max-width: 576px) {
            nav {
                height: 70px;
            }

            .user-greeting {
                display: none;
            }

            .register-card {
                padding: 25px 20px;
                border-radius: 16px;
            }
        }
    </style>
</head>
<body>

    <!-- HEADER (Floating Glassmorphism style) - PERSIS EDUKASI.PHP -->
    <nav>
        <a href="../BERANDA/beranda.php" style="display:flex; align-items:center; text-decoration:none;">
            <div class="nav-logo">
                <img src="../GAMBAR_GAMBAR/LOGO.png" alt="Logo RUPANTARA">
            </div>
        </a>

        <ul class="nav-links">
            <li><a href="../BERANDA/beranda.php">Beranda</a></li>
            <li><a href="../TENTANG RUPIAH/tentangrupiah.php">Tentang Rupiah</a></li>
            <li><a href="../MATERI/edukasi.php">Edukasi</a></li>
            <li><a href="../QUIZ/quiz_intro.php">Quiz & Game</a></li>
            <li><a href="../SCANNER/index_copy.php">Scan</a></li>
        </ul>

        <div class="nav-actions">
            <?php if (!$is_logged_in): ?>
                <a href="../LOGIN/login.php" class="btn-login">Login</a>
            <?php endif; ?>

            <a href="../qr.php" class="notification-btn" title="Buka di HP / QR Code" style="text-decoration:none;">
                <i data-lucide="qr-code" style="width:18px; height:18px;"></i>
            </a>
            <a href="#" class="notification-btn">
                <i data-lucide="bell" style="width:18px; height:18px;"></i>
                <span class="notification-dot"></span>
            </a>
            <div class="nav-divider"></div>
            <a href="../PROFIL/profil.php" class="user-area" title="Profil Pengguna">
                <div class="user-icon">
                    <i data-lucide="user-round" style="width:16px; height:16px;"></i>
                </div>
                <span class="user-greeting">Halo, <?php echo htmlspecialchars($display_username); ?></span>
            </a>
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="main-container">
        <!-- Spacer Kiri (Mengandalkan desain teks bawaan dari background gambar) -->
        <div class="left-spacer"></div>

        <!-- Bagian Kanan (Formulir Register) -->
        <section class="register-card-wrapper">
            <div class="register-card">
                <!-- Logo Brand -->
                <div class="card-logo">
                    <img src="../GAMBAR_GAMBAR/LOGO_RUPANTARA.png" alt="Logo Rupantara" class="card-brand-logo">
                </div>

                <h3>Daftar dulu disini !</h3>
                <p class="sub-info">Isi data di bawah untuk membuat akun baru</p>

                <!-- Form Register -->
                <form action="proses_register.php" method="POST" id="registerForm">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Masukkan username Anda" required autocomplete="username">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Masukkan alamat email Anda" required autocomplete="email">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="password-wrapper">
                            <input type="password" id="password" name="password" placeholder="Buat password baru" required>
                            <span class="toggle-password" id="togglePassword">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                                    <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q56-140 176-221.5T480-803q146 0 266 81.5T920-500q-56 140-176 221.5T480-200Z"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="konfirmasi_password">Konfirmasi Password</label>
                        <div class="password-wrapper">
                            <input type="password" id="konfirmasi_password" name="konfirmasi_password" placeholder="Ulangi password Anda" required>
                            <span class="toggle-password" id="toggleConfirmPassword">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                                    <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q56-140 176-221.5T480-803q146 0 266 81.5T920-500q-56 140-176 221.5T480-200Z"/>
                                </svg>
                            </span>
                        </div>
                        <div class="match-message" id="matchMessage"></div>
                    </div>

                    <div class="form-group">
                        <label for="status_pengguna">Status Pengguna</label>
                        <select id="status_pengguna" name="status_pengguna" required>
                            <option value="" disabled selected>Pilih status Anda</option>
                            <option value="Siswa">Siswa (SD/SMP/SMA)</option>
                            <option value="Mahasiswa">Mahasiswa</option>
                            <option value="Umum">Umum / Profesional</option>
                            <option value="Guru">Guru / Tenaga Pendidik</option>
                        </select>
                    </div>

                    <div class="form-footer">
                        Sudah punya akun? <a href="../LOGIN/login.php">Masuk</a>
                    </div>

                    <!-- Mengubah teks tombol pendaftaran menjadi lebih sesuai -->
                    <button type="submit" name="register" class="btn-submit" id="submitBtn">DAFTAR SEKARANG!</button>
                </form>

                <!-- Opsi Register Sosial -->
                <div class="social-login">
                    <button class="social-btn" title="Daftar dengan Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#1877F2">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </button>
                    <button class="social-btn" title="Daftar dengan Google">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path fill="#EA4335" d="M12.24 10.285V14.4h6.887c-.275 1.565-1.88 4.604-6.887 4.604-4.33 0-7.859-3.578-7.859-8s3.53-8 7.859-8c2.46 0 4.105 1.025 5.047 1.926l3.245-3.125C18.29 1.55 15.492 0 12.24 0 5.58 0 0 5.37 0 12s5.58 12 12.24 12c6.96 0 11.57-4.89 11.57-11.79 0-.795-.085-1.4-.195-1.925H12.24z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </section>
    </main>

    <!-- Script Interaktif Show/Hide Password & Real-time Matching Validasi -->
    <script>
        const passwordInput = document.querySelector('#password');
        const confirmPasswordInput = document.querySelector('#konfirmasi_password');
        const togglePassword = document.querySelector('#togglePassword');
        const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
        const matchMessage = document.querySelector('#matchMessage');
        const submitBtn = document.querySelector('#submitBtn');

        // SVG Icons
        const eyeIcon = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q56-140 176-221.5T480-803q146 0 266 81.5T920-500q-56 140-176 221.5T480-200Z"/></svg>`;
        const eyeOffIcon = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="m644-428-58-58q9-47-27-83t-83-27l-58-58q11-2 22-2 75 0 127.5 52.5T620-500q0 11-2 22Zm120 120-54-54q28-30 49-65.5T792-500q-51-111-152.5-175.5T512-740q-48 0-93.5 12T332-694l-54-54q41-26 88-41t96-15q162 0 292.5 91.5T892-500q-21 53-52 100t-76 80ZM480-340q-66 0-113-47t-47-113q0-11 2-22l-58-58q-9 20-11.5 41.5T250-500q0 104 73 177t177 73q21-1 41.5-3.5T583-264l-58-58q-11 2-22 2Zm24 240L332-272l-54 54q-56-38-100-90.5T108-416q51-111 152.5-175.5T388-656l-58-58Q197-695 91.5-598T-20-416q33 53 71.5 99T138-234l-54 54 44 44L724 38l44-44Z"/></svg>`;

        // Toggle Password Utama
        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ? eyeIcon : eyeOffIcon;
        });

        // Toggle Konfirmasi Password
        toggleConfirmPassword.addEventListener('click', function () {
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ? eyeIcon : eyeOffIcon;
        });

        // Validasi Kecocokan Password Secara Real-Time
        function checkPasswordMatch() {
            const val1 = passwordInput.value;
            const val2 = confirmPasswordInput.value;

            if (val2 === "") {
                matchMessage.style.display = "none";
                submitBtn.disabled = false;
                return;
            }

            matchMessage.style.display = "block";

            if (val1 === val2) {
                matchMessage.textContent = "✓ Password cocok";
                matchMessage.style.color = "#16a34a"; 
                confirmPasswordInput.style.borderColor = "#16a34a";
                submitBtn.disabled = false;
            } else {
                matchMessage.textContent = "✗ Password belum cocok";
                matchMessage.style.color = "#dc2626"; 
                confirmPasswordInput.style.borderColor = "#dc2626";
                submitBtn.disabled = true; 
            }
        }

        passwordInput.addEventListener('input', checkPasswordMatch);
        confirmPasswordInput.addEventListener('input', checkPasswordMatch);

        // Initialize Lucide Icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    </script>
</body>
</html>