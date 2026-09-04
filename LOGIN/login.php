<?php
session_start();
// Memeriksa apakah pengguna sudah login
$is_logged_in = isset($_SESSION['login']) && $_SESSION['login'] === true;
$display_username = $is_logged_in ? $_SESSION['username'] : 'User';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rupantara - Login</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Font yang digunakan pada Edukasi & Login -->
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #eef3f9;
            background-image: url('background_login.png');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            background-position: left center;
            color: #1a365d;
            font-family: "Plus Jakarta Sans", "Inter", sans-serif;
        }

        .login-font-family, 
        .login-font-family * {
            font-family: 'Poppins', sans-serif;
        }

        .main-container {
            display: flex;
            flex: 1;
            justify-content: space-between;
            align-items: center;
            padding: 40px 4%;
            gap: 50px;
        }

        .left-spacer {
            flex: 1.2;
        }

        .login-card-wrapper {
            flex: 1;
            display: flex;
            justify-content: flex-end;
        }

        .login-card {
            background-color: rgba(255, 255, 255, 0.95);
            width: 100%;
            max-width: 450px;
            padding: 40px;
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
            margin-bottom: 15px;
        }

        .card-brand-logo {
            height: 75px; 
            width: auto;
            object-fit: contain;
            margin-bottom: 15px;
        }

        .login-card h3 {
            font-size: 19px;
            font-weight: 700;
            color: #0d3b66;
            margin-bottom: 4px;
        }

        .login-card .sub-info {
            font-size: 11px;
            color: #64748b;
            margin-bottom: 25px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #1e3a8a;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            font-size: 14px;
            border: 1.5px solid #cbd5e1;
            border-radius: 8px;
            outline: none;
            background-color: #ffffff;
            color: #1e293b;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

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
            width: 20px;
            height: 20px;
            fill: currentColor;
            transition: color 0.2s;
        }

        .toggle-password:hover {
            color: #1d4ed8;
        }

        .form-links {
            text-align: left;
            margin-bottom: 25px;
        }

        .form-links a {
            display: block;
            font-size: 13px;
            color: #1d4ed8;
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 8px;
            transition: color 0.2s;
        }

        .form-links a:hover {
            color: #1e40af;
            text-decoration: underline;
        }

        .btn-submit {
            width: 100%;
            background-color: #0b2545;
            color: #ffffff;
            border: none;
            padding: 14px;
            font-size: 14px;
            font-weight: 700;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.1s;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }

        .btn-submit:hover {
            background-color: #134074;
        }

        .btn-submit:active {
            transform: scale(0.98);
        }

        .social-login {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 10px;
        }

        .social-btn {
            width: 40px;
            height: 40px;
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
            width: 20px;
            height: 20px;
        }

        @media (max-width: 992px) {
            body {
                background-size: cover;
                background-position: center center;
            }

            .main-container {
                flex-direction: column;
                padding: 30px 4%;
                justify-content: center;
                gap: 20px;
            }
            
            .left-spacer {
                display: none; 
            }
            
            .login-card-wrapper {
                justify-content: center;
                width: 100%;
            }
        }

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

        @media(max-width: 900px) {
            nav { width: 95%; padding: 0 16px; }
            .nav-links { display: none; }
        }
    </style>
</head>
<body>

    <!-- NAVBAR HEADER -->
    <nav>
        <a href="#" style="display:flex; align-items:center; text-decoration:none;">
            <div class="nav-logo">
                <img src="../GAMBAR_GAMBAR/LOGO.png" alt="Logo RUPANTARA">
            </div>
        </a>

        <ul class="nav-links">
            <li><a href="../BERANDA/beranda.php">Beranda</a></li>
            <li><a href="../TENTANG RUPIAH/tentangrupiah.php">Tentang Rupiah</a></li>
            <li><a href="../MATERI/edukasi.php">Edukasi</a></li>
            <li><a href="../SCANNER/index.php">Scan</a></li>
            <li><a href="../QUIZ/quiz_intro.php">Quiz & Game</a></li>
        </ul>

        <div class="nav-actions">
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

    <!-- Konten Utama (Login Form) -->
    <main class="main-container login-font-family">
        <div class="left-spacer"></div>

        <section class="login-card-wrapper">
            <div class="login-card">
                <div class="card-logo">
                    <img src="../GAMBAR_GAMBAR/LOGO.png" alt="Logo Rupantara" class="card-brand-logo">
                </div>

                <h3>Masuk ke akun anda</h3>
                <p class="sub-info">Isi data di bawah untuk membuat akun baru</p>

                <?php if (isset($_GET['pesan']) && $_GET['pesan'] === 'gagal'): ?>
                    <div style="background: #FEF2F2; border: 1px solid #FCA5A5; color: #DC2626; padding: 10px 14px; border-radius: 10px; font-size: 13px; font-weight: 600; margin-bottom: 18px; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        <span>Akun tidak ditemukan!</span>
                    </div>
                <?php endif; ?>

                <!-- Form Login -->
                <form action="proses_login.php" method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Masukkan username Anda" required autocomplete="username">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="password-wrapper">
                            <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required autocomplete="current-password">
                            <span class="toggle-password" id="togglePassword">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                                    <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q56-140 176-221.5T480-803q146 0 266 81.5T920-500q-56 140-176 221.5T480-200Z"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="form-links">
                        <a href="../REGISTER/register.php">Belum punya akun? daftar dulu!</a>
                        <a href="#">Lupa password</a>
                    </div>

                    <button type="submit" name="submit" class="btn-submit">MULAI!</button>
                </form>

                <div class="social-login">
                    <button class="social-btn" title="Login dengan Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#1877F2">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </button>
                    <button class="social-btn" title="Login dengan Google">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path fill="#EA4335" d="M12.24 10.285V14.4h6.887c-.275 1.565-1.88 4.604-6.887 4.604-4.33 0-7.859-3.578-7.859-8s3.53-8 7.859-8c2.46 0 4.105 1.025 5.047 1.926l3.245-3.125C18.29 1.55 15.492 0 12.24 0 5.58 0 0 5.37 0 12s5.58 12 12.24 12c6.96 0 11.57-4.89 11.57-11.79 0-.795-.085-1.4-.195-1.925H12.24z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </section>
    </main>

    <script>
        lucide.createIcons();

        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            if (type === 'password') {
                this.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                        <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q56-140 176-221.5T480-803q146 0 266 81.5T920-500q-56 140-176 221.5T480-200Z"/>
                    </svg>
                `;
            } else {
                this.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                        <path d="m644-428-58-58q9-47-27-83t-83-27l-58-58q11-2 22-2 75 0 127.5 52.5T620-500q0 11-2 22Zm120 120-54-54q28-30 49-65.5T792-500q-51-111-152.5-175.5T512-740q-48 0-93.5 12T332-694l-54-54q41-26 88-41t96-15q162 0 292.5 91.5T892-500q-21 53-52 100t-76 80ZM480-340q-66 0-113-47t-47-113q0-11 2-22l-58-58q-9 20-11.5 41.5T250-500q0 104 73 177t177 73q21-1 41.5-3.5T583-264l-58-58q-11 2-22 2Zm24 240L332-272l-54 54q-56-38-100-90.5T108-416q51-111 152.5-175.5T388-656l-58-58Q197-695 91.5-598T-20-416q33 53 71.5 99T138-234l-54 54 44 44L724 38l44-44Z"/>
                    </svg>
                `;
            }
        });
    </script>
</body>
</html>