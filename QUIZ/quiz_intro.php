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
    <title>RUPANTARA - Uji Pengetahuanmu tentang Rupiah</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        :root {
            --navy: #17325C;
            --navy-dark: #10233F;
            --navy-soft: #E7EDF7;
            --bg: #FAF8FF;
            --card: #fff;
            --border: #E3E7EF;
            --text-main: #1E2A3A;
            --text-sub: #7A8494;
            --header-border: #ECE9F3;
            --footer-bg: #E9E7F2;
            --blue: #59A9E8;
            --blue-dark: #174C84;
            --body: #F8FAFF;
            --white: #FFFFFF;
            --text: #1E293B;
            --muted: #64748B;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            font-weight: 500;
            background: var(--bg);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes typing {
            from {
                width: 0;
            }
            to {
                width: 100%;
            }
        }

        @keyframes blink {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0;
            }
        }

        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* =====================================================
           HEADER (Floating Glassmorphism style)
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

        /* Page Content Layout */
        .page-content {
            flex: 1;
            padding: 32px 16px 8px;
        }

        .page-wrapper {
            max-width: 1100px;
            margin: 50px auto 0 auto;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* Hero Section */
        .hero {
            position: relative;
            border-radius: 28px;
            overflow: hidden;
            border: 1px solid var(--border);
            background: url('../GAMBAR_GAMBAR/hero_quiz.jpg') center center / cover no-repeat;
            padding: 56px 48px;
            min-height: 420px;
            display: flex;
            align-items: center;
            transition: transform .3s ease;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(255,255,255,.75) 0%, rgba(255,255,255,.45) 40%, rgba(255,255,255,.1) 70%);
            z-index: 1;
        }

        .hero:hover {
            transform: translateY(-2px);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 560px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            animation: fadeInUp .8s ease;
        }

        .hero-title {
            font-size: 52px;
            font-weight: 800;
            font-style: italic;
            line-height: 1.05;
            letter-spacing: -1px;
            background: linear-gradient(90deg, #0F2547 0%, #3D63A6 60%, #8FADD9 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: fadeInUp .8s ease .1s both;
        }

        .hero-subtitle {
            font-size: 19px;
            font-weight: 700;
            color: var(--navy);
            overflow: hidden;
            white-space: nowrap;
            border-right: 3px solid var(--navy);
            animation: typing 2s steps(40, end), blink .75s step-end infinite;
            width: 0;
            animation-fill-mode: forwards;
        }

        .hero-desc {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-sub);
            line-height: 1.7;
            max-width: 460px;
            animation: fadeInUp .8s ease .3s both;
        }

        .hero-cta {
            margin-top: 8px;
            align-self: flex-start;
            background: linear-gradient(135deg, var(--navy), #2a4a7a);
            color: #fff;
            border: none;
            border-radius: 999px;
            padding: 14px 30px;
            font-family: inherit;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all .3s cubic-bezier(.34, 1.56, .64, 1);
            position: relative;
            overflow: hidden;
            animation: fadeInUp .8s ease .4s both;
            box-shadow: 0 4px 15px rgba(23, 50, 92, .2);
        }

        .hero-cta:hover {
            transform: translateY(-3px) scale(1.03);
            box-shadow: 0 12px 30px rgba(23, 50, 92, .35);
            animation: glow 2s ease infinite;
        }

        .hero-cta:active {
            transform: scale(.97);
        }

        .hero-cta .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, .4);
            transform: scale(0);
            animation: ripple .6s linear;
            pointer-events: none;
        }

        .hero-meta {
            font-size: 12px;
            font-weight: 600;
            color: #9AA3B4;
            letter-spacing: .2px;
            animation: fadeIn .8s ease .5s both;
        }

        .hero-illustration {
            position: absolute;
            right: -40px;
            bottom: 0;
            top: 0;
            width: 62%;
            display: flex;
            align-items: flex-end;
            justify-content: flex-end;
            z-index: 1;
            pointer-events: none;
            transition: transform .1s ease-out;
        }

        .hero-illustration svg {
            width: 100%;
            height: 100%;
        }

        .hero-dots {
            position: absolute;
            top: 24px;
            right: 36px;
            z-index: 1;
            opacity: .5;
            animation: float 4s ease-in-out infinite;
        }

        @media(max-width:820px) {
            .hero {
                padding: 40px 28px;
            }

            .hero-title {
                font-size: 38px;
            }

            .hero-illustration {
                width: 80%;
                opacity: .5;
            }

            .hero-subtitle {
                white-space: normal;
                border: none;
                animation: fadeInUp .8s ease .2s both;
                width: auto;
            }
        }

        /* Features */
        .features-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(23, 50, 92, .06);
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            margin-top: -40px;
            position: relative;
            z-index: 3;
            animation: fadeInUp .8s ease .3s both;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 28px 30px;
            border-right: 1px solid var(--border);
            transition: all .3s ease;
            cursor: pointer;
        }

        .feature-item:last-child {
            border-right: none;
        }

        .feature-item:hover {
            background: var(--navy-soft);
            transform: translateY(-4px);
        }

        .feature-icon {
            flex-shrink: 0;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--navy-soft);
            color: var(--navy);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .3s ease;
        }

        .feature-item:hover .feature-icon {
            background: var(--navy);
            color: #fff;
            transform: scale(1.1) rotate(5deg);
        }

        .feature-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 4px;
            transition: color .3s ease;
        }

        .feature-item:hover .feature-title {
            color: var(--navy);
        }

        .feature-desc {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-sub);
        }

        .feature-counter {
            font-size: 24px;
            font-weight: 800;
            color: var(--navy);
            margin-bottom: 4px;
            opacity: 0;
            transform: translateY(20px);
            transition: all .6s ease;
        }

        .feature-counter.show {
            opacity: 1;
            transform: translateY(0);
        }

        @media(max-width:820px) {
            .features-card {
                grid-template-columns: 1fr;
            }

            .feature-item {
                border-right: none;
                border-bottom: 1px solid var(--border);
            }

            .feature-item:last-child {
                border-bottom: none;
            }
        }

        /* =====================================================
           FOOTER (Desain Baru, Modern & Interaktif)
        ===================================================== */
        footer {
            margin-top: 100px;
            background: linear-gradient(180deg, #0A1E3F 0%, #051021 100%);
            color: #E2E8F0;
            padding: 80px 8% 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            position: relative;
        }

        .footer-main {
            display: grid;
            grid-template-columns: 1.3fr 0.8fr 1fr;
            gap: 70px;
            padding-bottom: 50px;
        }

        .footer-brand-card {
            width: 150px;
            height: 54px;
            background: #FFFFFF;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            padding: 6px 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .footer-brand-card:hover {
            background: #FFFFFF;
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.25);
        }

        .footer-brand-card img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .footer-title {
            font-size: 24px;
            font-weight: 800;
            color: #FFFFFF;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }

        .footer-title span {
            color: var(--blue);
        }

        .footer-desc {
            font-size: 13.5px;
            color: #94A3B8;
            line-height: 1.6;
            max-width: 320px;
        }

        .footer-column h3 {
            color: #FFFFFF;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 24px;
            position: relative;
            padding-bottom: 8px;
        }

        .footer-column h3::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 30px;
            height: 2px;
            background: var(--blue);
            border-radius: 2px;
        }

        .footer-nav {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .footer-nav a {
            color: #94A3B8;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.25s ease;
        }

        .footer-nav a:hover {
            color: #FFFFFF;
            transform: translateX(6px);
        }

        .footer-contact-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .footer-contact-item {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            color: #94A3B8;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-contact-item:hover {
            color: #FFFFFF;
        }

        .footer-contact-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--blue);
            transition: all 0.3s ease;
        }

        .footer-contact-item:hover .footer-contact-icon {
            background: var(--blue-dark);
            border-color: var(--blue);
            color: #FFFFFF;
            transform: scale(1.05);
        }

        .footer-bottom {
            margin-top: 40px;
            padding-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .footer-copy {
            font-size: 13px;
            color: #64748B;
        }

        .footer-bottom-links {
            display: flex;
            gap: 20px;
        }

        .footer-bottom-links a {
            color: #64748B;
            text-decoration: none;
            font-size: 13px;
            transition: color 0.25s ease;
        }

        .footer-bottom-links a:hover {
            color: #94A3B8;
        }

        /* Particles */
        .particle {
            position: fixed;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--navy);
            opacity: .15;
            pointer-events: none;
            z-index: 0;
            animation: float 6s ease-in-out infinite;
        }
    </style>
</head>

<body>

    <!-- Ambient particles -->
    <div id="particles"></div>

    <!-- NAVBAR HEADER -->
    <nav>
        <a href="../BERANDA/beranda.html" style="display:flex; align-items:center; text-decoration:none;">
            <div class="nav-logo">
                <img src="../GAMBAR_GAMBAR/LOGO.png" alt="Logo RUPANTARA">
            </div>
        </a>

        <ul class="nav-links">
            <li><a href="../BERANDA/beranda.php">Beranda</a></li>
            <li><a href="../TENTANG RUPIAH/tentangrupiah.php">Tentang Rupiah</a></li>
            <li><a href="../MATERI/edukasi.php">Edukasi</a></li>
            <li><a href="../QUIZ/quiz_intro.php" class="active">Quiz</a></li>
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
            <div class="user-area">
                <div class="user-icon">
                    <i data-lucide="user-round" style="width:16px; height:16px;"></i>
                </div>
                <span class="user-greeting">Halo, <?php echo htmlspecialchars($display_username); ?></span>
            </div>
        </div>
    </nav>

    <div class="page-content">
        <div class="page-wrapper">
            <div class="hero" id="hero">
                <div class="hero-content">
                    <div class="hero-title">RUPANTARA</div>
                    <div class="hero-subtitle">Uji pengetahuanmu tentang Rupiah Indonesia</div>
                    <div class="hero-desc">Jawab 10 soal pilihan ganda untuk menguji seberapa jauh pengetahuanmu tentang
                        Rupiah, sejarah, simbol, dan perannya dalam perekonomian Indonesia.</div>
                    <a href="quiz.php" class="hero-cta" id="startBtn">Mulai Sekarang</a>
                    <div class="hero-meta"><span class="counter" data-target="10">0</span> soal &nbsp;&middot;&nbsp;
                        Pilihan Ganda &nbsp;&middot;&nbsp; Skor Otomatis</div>
                </div>
            </div>

            <div class="features-card" id="featuresCard">
                <div class="feature-item" data-delay="0">
                    <div class="feature-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="4" y="3" width="16" height="18" rx="2" />
                            <line x1="8" y1="8" x2="16" y2="8" />
                            <line x1="8" y1="12" x2="16" y2="12" />
                            <line x1="8" y1="16" x2="13" y2="16" />
                        </svg></div>
                    <div>
                        <div class="feature-counter" data-target="10">0</div>
                        <div class="feature-title">Soal</div>
                        <div class="feature-desc">Pilihan ganda</div>
                    </div>
                </div>
                <div class="feature-item" data-delay="100">
                    <div class="feature-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="9" />
                            <polyline points="12 7 12 12 15.5 14" />
                        </svg></div>
                    <div>
                        <div class="feature-counter" data-target="5">0</div>
                        <div class="feature-title">Menit</div>
                        <div class="feature-desc">Waktu fleksibel</div>
                    </div>
                </div>
                <div class="feature-item" data-delay="200">
                    <div class="feature-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M8 21h8" />
                            <path d="M12 17v4" />
                            <path d="M7 4h10v5a5 5 0 0 1-10 0V4Z" />
                            <path d="M7 6H4a2 2 0 0 0 2 4" />
                            <path d="M17 6h3a2 2 0 0 1-2 4" />
                        </svg></div>
                    <div>
                        <div class="feature-counter" data-target="100">0</div>
                        <div class="feature-title">% Akurasi</div>
                        <div class="feature-desc">Skor & peringkat</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        <div class="footer-main">
            <div class="footer-column">
                <div class="footer-brand-card">
                    <img src="../GAMBAR_GAMBAR/LOGO.png" alt="Logo RUPANTARA">
                </div>
                <p class="footer-desc">Rupiah Nusantara (RUPANTARA) adalah platform edukasi keuangan masa depan yang membantu mengenali kedaulatan, nilai, dan keamanan mata uang Rupiah secara interaktif.</p>
            </div>
            <div class="footer-column">
                <h3>NAVIGASI</h3>
                <div class="footer-nav">
                    <a href="#"><i data-lucide="chevron-right" style="width:14px; height:14px;"></i>Beranda</a>
                    <a href="../TENTANG RUPIAH/tentangrupiah.html"><i data-lucide="chevron-right" style="width:14px; height:14px;"></i>Tentang Rupiah</a>
                    <a href="../MATERI/edukasi.php"><i data-lucide="chevron-right" style="width:14px; height:14px;"></i>Edukasi</a>
                    <a href="../QUIZ/quiz_intro.html"><i data-lucide="chevron-right" style="width:14px; height:14px;"></i>Quiz</a>
                    <a href="../SCANNER/index.html"><i data-lucide="chevron-right" style="width:14px; height:14px;"></i>Scan</a>
                </div>
            </div>
            <div class="footer-column">
                <h3>HUBUNGI KAMI</h3>
                <div class="footer-contact-list">
                    <a href="tel:+6282340950845" class="footer-contact-item">
                        <div class="footer-contact-icon">
                            <i data-lucide="phone" style="width:16px; height:16px;"></i>
                        </div>
                        <span>+62 823-4095-0845</span>
                    </a>
                    <div class="footer-contact-item">
                        <div class="footer-contact-icon">
                            <i data-lucide="map-pin" style="width:16px; height:16px;"></i>
                        </div>
                        <span>Purwokerto, Indonesia</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- SUB-FOOTER BOTTOM -->
        <div class="footer-bottom">
            <p class="footer-copy">&copy; 2024 RUPANTARA Educational Platform. All rights reserved.</p>
            <div class="footer-bottom-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Help Center</a>
            </div>
        </div>
    </footer>

    <script>
        // Inisialisasi Lucide Icons
        lucide.createIcons();

        // Login check
        (function () {
            const p = new URLSearchParams(location.search), n = p.get('nickname'), s = document.getElementById('startBtn'), a = document.getElementById('authArea');
            if (n) { s.href = 'quiz.php?nickname=' + encodeURIComponent(n); const k = n.trim().split(/\s+/), i = k.length === 1 ? k[0].slice(0, 2).toUpperCase() : (k[0][0] + k[1][0]).toUpperCase(); a.innerHTML = '<div class="user-avatar" title="' + n + '">' + i + '</div>'; }
        })();

        // Mobile menu
        const menuToggle = document.getElementById('menuToggle'), navLinks = document.getElementById('navLinks');
        menuToggle.addEventListener('click', () => { navLinks.classList.toggle('show'); menuToggle.textContent = navLinks.classList.contains('show') ? '✕' : '☰'; });

        // Ripple effect on CTA
        document.getElementById('startBtn').addEventListener('click', function (e) {
            const r = document.createElement('span'); r.className = 'ripple';
            const rect = this.getBoundingClientRect(); const size = Math.max(rect.width, rect.height);
            r.style.width = r.style.height = size + 'px'; r.style.left = (e.clientX - rect.left - size / 2) + 'px'; r.style.top = (e.clientY - rect.top - size / 2) + 'px';
            this.appendChild(r); setTimeout(() => r.remove(), 600);
        });

        // Ambient particles
        const particles = document.getElementById('particles');
        for (let i = 0; i < 15; i++) {
            const p = document.createElement('div'); p.className = 'particle';
            p.style.left = Math.random() * 100 + 'vw'; p.style.top = Math.random() * 100 + 'vh';
            p.style.animationDelay = Math.random() * 6 + 's'; p.style.animationDuration = (4 + Math.random() * 4) + 's';
            p.style.width = p.style.height = (4 + Math.random() * 6) + 'px'; p.style.opacity = .1 + Math.random() * .1;
            particles.appendChild(p);
        }

        // Counter animation on scroll
        const counters = document.querySelectorAll('.feature-counter');
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target, target = parseInt(el.dataset.target), delay = parseInt(el.closest('.feature-item').dataset.delay) || 0;
                    setTimeout(() => { el.classList.add('show'); let c = 0; const step = Math.max(1, Math.floor(target / 30)), iv = setInterval(() => { c += step; if (c >= target) { c = target; clearInterval(iv); } el.textContent = c; }, 30); }, delay);
                    obs.unobserve(el);
                }
            });
        }, { threshold: .5 });
        counters.forEach(c => obs.observe(c));
    </script>
</body>

</html>