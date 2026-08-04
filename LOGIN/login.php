<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rupantara - Login</title>
    <!-- Menggunakan Font Poppins untuk tampilan modern -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Reset CSS dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #eef3f9;
            background-image: url('background_login.png');
            background-repeat: no-repeat;
            background-attachment: fixed;
            
            /* Menggunakan cover dan left center agar proporsional */
            background-size: cover;
            background-position: left center;
            
            color: #1a365d;
        }

        /* --- HEADER NAVBAR FIXED --- */
        header {
            position: fixed; /* Header tetap berada di atas saat halaman di-scroll */
            top: 0;
            left: 0;
            width: 100%;
            height: 80px;
            display: flex;
            justify-content: space-between; /* Mendorong logo ke kiri, dan menu navigasi ke kanan */
            align-items: center;
            padding: 0 4%; /* Diperkecil menjadi 4% agar logo berada di pojok kiri atas */
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            z-index: 1000;
        }

        .logo-container {
            display: flex;
            align-items: center;
        }

        /* Gaya logo pada header (diperbesar sesuai desain) */
        .brand-logo {
            height: 55px; 
            width: auto;
            object-fit: contain;
        }

        /* Wadah untuk mengelompokkan navigasi dan profil di sebelah kanan */
        .navigation-group {
            display: flex;
            align-items: center;
            gap: 40px; /* Jarak antara menu navigasi dan profil */
        }

        nav {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        nav a {
            text-decoration: none;
            color: #1a365d;
            font-weight: 500;
            font-size: 15px;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #2563eb;
        }

        .btn-login-nav {
            background-color: #1d4ed8;
            color: #ffffff;
            padding: 8px 24px;
            border-radius: 20px;
            font-weight: 600;
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn-login-nav:hover {
            background-color: #1e40af;
            transform: translateY(-1px);
        }

        .divider {
            color: #cbd5e1;
            margin: 0 5px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .bell-icon {
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .bell-icon svg {
            fill: #475569;
            transition: fill 0.3s;
        }

        .bell-icon:hover svg {
            fill: #1e40af;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 2px solid #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-info {
            font-size: 11px;
            color: #64748b;
        }

        /* --- KONTEN UTAMA --- */
        .main-container {
            display: flex;
            flex: 1;
            justify-content: space-between;
            align-items: center;
            padding: 40px 4%; /* Disesuaikan menjadi 4% agar sejajar dengan header */
            gap: 50px;
            margin-top: 80px; 
        }

        /* Spacer kiri untuk menyeimbangkan posisi kartu login di kanan */
        .left-spacer {
            flex: 1.2;
        }

        /* Bagian Kanan: Kartu Login */
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

        /* Logo di dalam Card */
        .card-logo {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin-bottom: 15px;
        }

        /* Gaya logo di dalam kartu login */
        .card-brand-logo {
            height: 75px; 
            width: auto;
            object-fit: contain;
            margin-bottom: 15px;
        }

        /* Teks Judul Formulir */
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

        /* Gaya Input Form */
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

        /* --- CSS TAMBAHAN UNTUK ICON MATA PASSWORD --- */
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

        /* Tautan Tambahan */
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

        /* Tombol Submit */
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

        /* Opsi Login Sosial */
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

        /* --- MEDIA QUERIES UNTUK LAYAR TABLET --- */
        @media (max-width: 992px) {
            header {
                padding: 0 4%;
            }
            
            .navigation-group {
                display: none; /* Menyembunyikan menu navigasi kanan di tablet/HP agar tidak menumpuk */
            }
            
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

        /* --- MEDIA QUERIES UNTUK LAYAR HP --- */
        @media (max-width: 576px) {
            header {
                padding: 0 4%;
            }

            .brand-logo {
                height: 40px; /* Ukuran logo lebih kecil di layar HP */
            }

            .login-card {
                padding: 30px 20px;
                border-radius: 16px;
            }
        }
    </style>
</head>
<body>

    <!-- Header / Navbar (Sticky / Fixed) -->
    <header>
        <!-- Logo di pojok kiri atas -->
        <div class="logo-container">
            <img src="../GAMBAR_GAMBAR/LOGO_RUPANTARA.png" alt="Logo Rupantara" class="brand-logo">
        </div>
        
        <!-- Kelompok navigasi dan profil di sebelah kanan -->
        <div class="navigation-group">
            <nav>
                <a href="#">Beranda</a>
                <a href="#">Tentang kami</a>
                <a href="#">Fitur</a>
                <a href="#">Edukasi</a>
                <span class="divider">|</span>
                <a href="#" class="btn-login-nav">Login</a>
            </nav>
            <div class="header-right">
                <!-- Ikon Notifikasi -->
                <div class="bell-icon" title="Notifikasi">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                        <path d="M160-200v-80h80v-280q0-83 50-147.5T420-792v-28q0-25 17.5-42.5T480-880q25 0 42.5 17.5T540-820v28q80 20 130 84.5T720-560v280h80v80H160Zm320-300Zm0 420q-33 0-56.5-23.5T400-160h160q0 33-23.5 56.5T480-80ZM320-280h320v-280q0-66-47-113t-113-47q-66 0-113 47t-47 113v280Z"/>
                    </svg>
                </div>
                <!-- Profil Pengguna -->
                <div class="user-profile">
                    <div class="user-avatar">
                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px">
                            <path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-240v-32q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q30 15 47 43.5t17 62.5v32H160Z"/>
                        </svg>
                    </div>
                    <div class="user-info">
                        <strong>Hallo, User</strong>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Konten Utama -->
    <main class="main-container">
        <!-- Spacer Kiri -->
        <div class="left-spacer"></div>

        <!-- Bagian Kanan (Formulir Login) -->
        <section class="login-card-wrapper">
            <div class="login-card">
                <!-- Memuat logo asli di dalam Card -->
                <div class="card-logo">
                    <img src="../GAMBAR_GAMBAR/LOGO_RUPANTARA.png" alt="Logo Rupantara" class="card-brand-logo">
                </div>

                <h3>Masuk ke akun anda</h3>
                <p class="sub-info">Isi data di bawah untuk membuat akun baru</p>

                <!-- Formulir Login -->
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
                                <!-- Ikon Mata Terbuka Default -->
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                                    <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q56-140 176-221.5T480-803q146 0 266 81.5T920-500q-56 140-176 221.5T480-200Z"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="form-links">
                        <a href="#">Belum punya akun? daftar dulu!</a>
                        <a href="#">Lupa password</a>
                    </div>

                    <button type="submit" name="submit" class="btn-submit">MULAI!</button>
                </form>

                <!-- Opsi Login Sosial -->
                <div class="social-login">
                    <!-- Facebook Button -->
                    <button class="social-btn" title="Login dengan Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#1877F2">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </button>
                    <!-- Google Button -->
                    <button class="social-btn" title="Login dengan Google">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path fill="#EA4335" d="M12.24 10.285V14.4h6.887c-.275 1.565-1.88 4.604-6.887 4.604-4.33 0-7.859-3.578-7.859-8s3.53-8 7.859-8c2.46 0 4.105 1.025 5.047 1.926l3.245-3.125C18.29 1.55 15.492 0 12.24 0 5.58 0 0 5.37 0 12s5.58 12 12.24 12c6.96 0 11.57-4.89 11.57-11.79 0-.795-.085-1.4-.195-1.925H12.24z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </section>
    </main>

    <!-- JavaScript Untuk Toggle Show/Hide Password -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            // Mengubah tipe input antara password dan text
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Mengubah ikon sesuai keadaan (terbuka / tercoret)
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