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
    
    <!-- Menggunakan Font Poppins untuk tampilan kartu login yang modern -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* Reset CSS dasar untuk area di luar navbar */
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
        }

        /* --- STYLING KHUSUS LOGIN CARD (Menggunakan Font Poppins) --- */
        .login-font-family, 
        .login-font-family * {
            font-family: 'Poppins', sans-serif;
        }

        /* --- KONTEN UTAMA --- */
        .main-container {
            display: flex;
            flex: 1;
            justify-content: space-between;
            align-items: center;
            padding: 40px 4%;
            gap: 50px;
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

        /* --- CSS ICON MATA PASSWORD --- */
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
            .login-card {
                padding: 30px 20px;
                border-radius: 16px;
            }
        }
    </style>
</head>
<body>

    <!-- NAVBAR (Tanpa Button Login) -->
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-blue-50 py-3 px-6 md:px-12 flex justify-between items-center w-full">
        <!-- Logo & Brand Name -->
        <div class="flex items-center gap-3">
            <img src="../GAMBAR_GAMBAR/LOGO_RUPANTARA.png" alt="Rupantara Logo" class="h-14 md:h-16 w-auto object-contain onerror-fallback">
            <div class="flex items-center text-xl md:text-2xl tracking-wider uppercase font-black select-none">
                <span class="text-[#0D3268]">RUP</span><span class="text-[#4FA1E4] font-semibold">ANTARA</span>
            </div>
        </div>
        
        <!-- Menu Items (Tombol Login Dihilangkan) -->
        <div class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600">
            <a href="#" class="hover:text-blue-600 transition-colors">Beranda</a>
            <a href="#" class="hover:text-blue-600 transition-colors">Tentang kami</a>
            <a href="#" class="hover:text-blue-600 transition-colors">Fitur</a>
            <a href="#" class="hover:text-blue-600 transition-colors">Edukasi</a>
        </div>
        
        <!-- Icons & User Info -->
        <div class="flex items-center gap-4">
            <button class="text-slate-500 hover:text-blue-600 relative">
                <i class="fa-regular fa-bell text-lg"></i>
                <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
            <div class="flex items-center gap-2 border-l pl-4 border-slate-200">
                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700">
                    <i class="fa-regular fa-user"></i>
                </div>
                <span class="text-xs font-semibold text-slate-500 hidden sm:inline">Halo, User</span>
            </div>
        </div>
    </nav>

    <!-- Konten Utama (Login Form) -->
    <main class="main-container login-font-family">
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

    <script>
        // Toggle view/hide password
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

        // Error Image Fallback
        document.querySelectorAll('.onerror-fallback').forEach(img => {
            img.onerror = function() {
                this.style.display = 'none';
            };
        });
    </script>
</body>
</html>