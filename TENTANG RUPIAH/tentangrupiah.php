<?php
session_start();

// Menyimpan URL halaman ini ke dalam session agar jika pengguna login, mereka dapat dikembalikan ke sini
$_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'];

// Memeriksa status login pengguna
$is_logged_in = isset($_SESSION['login']) && $_SESSION['login'] === true;
$display_username = $is_logged_in ? $_SESSION['username'] : 'User';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tentang Rupiah - RUPANTARA</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="../navbar_responsive.css">
    <script src="../navbar_responsive.js" defer></script>
    
    <style>

        /* =====================================================
           GLOBAL
        ===================================================== */

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f5f9fc;
        }

        /* =====================================================
           NAVBAR (FLOATING GLASSMORPHISM STYLE)
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
            color: #174C84;
            background: rgba(255, 255, 255, 0.8);
        }

        .nav-links a.active {
            color: #174C84;
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
            background: linear-gradient(135deg, #174C84, #1d5fa3);
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
            color: #174C84;
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
            color: #174C84;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
        }

        .user-greeting {
            font-size: 13px;
            font-weight: 600;
            color: #475569;
        }

        /* =====================================================
           ACCORDION
        ===================================================== */

        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition:
                max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                padding 0.3s ease;
        }

        .accordion-content.open {
            max-height: 2000px;
        }


        /* =====================================================
           FAN MONEY
        ===================================================== */

        .fan-container {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            height: 240px;
            padding-bottom: 20px;
        }

        .fan-note {
            width: 140px;
            transition:
                transform 0.3s ease,
                z-index 0.3s ease;
            margin-left: -40px;
            cursor: pointer;
            border-radius: 6px;
            box-shadow:
                0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .fan-note:first-child {
            margin-left: 0;
        }

        .fan-note:hover {
            transform:
                translateY(-20px)
                scale(1.1)
                rotate(0deg) !important;

            z-index: 50 !important;
        }


        /* =====================================================
           SECURITY CARDS
        ===================================================== */

        .security-card {
            cursor: pointer;
            transition:
                transform 0.3s ease,
                box-shadow 0.3s ease;
        }

        .security-card:hover {
            transform: translateY(-5px);
        }

        .security-card:active {
            transform: scale(0.98);
        }


        /* =====================================================
           SECURITY CARD ART
        ===================================================== */

        .card-art {
            pointer-events: none;
        }


        /* =====================================================
           SECURITY DETAIL POPUP
        ===================================================== */

        #securityDetail {
            position: fixed;
            inset: 0;

            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(6px);

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 20px;

            opacity: 0;
            visibility: hidden;

            transition:
                opacity 0.3s ease,
                visibility 0.3s ease;

            z-index: 1000;
        }

        #securityDetail.active {
            opacity: 1;
            visibility: visible;
        }

        .security-modal {
            width: 100%;
            max-width: 900px;
            max-height: 90vh;
            overflow-y: auto;

            background: white;
            border-radius: 28px;

            box-shadow:
                0 25px 60px rgba(15, 23, 42, 0.25);

            transform: translateY(20px) scale(0.97);

            transition:
                transform 0.3s ease;
        }

        #securityDetail.active .security-modal {
            transform: translateY(0) scale(1);
        }


        /* =====================================================
           DOT DIVIDER
        ===================================================== */

        .dot-divider {
            border-top:
                2px dotted #cbd5e1;
        }


        /* =====================================================
           SECURITY VISUAL
        ===================================================== */

        #detailVisual img {
            max-width: 100%;
            max-height: 260px;
            object-fit: contain;
            margin: auto;
        }


        /* =====================================================
           FOOTER (Modern & Interaktif)
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
            color: #59A9E8;
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
            background: #59A9E8;
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
            color: #59A9E8;
            transition: all 0.3s ease;
        }

        .footer-contact-item:hover .footer-contact-icon {
            background: #174C84;
            border-color: #59A9E8;
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


        /* =====================================================
           MOBILE
        ===================================================== */

        @media (max-width: 900px) {
            nav {
                width: 95%;
                padding: 0 16px;
            }

            .fan-container {
                transform: scale(0.75);
                margin-left: -40px;
                margin-right: -40px;
            }

            .security-modal {
                border-radius: 20px;
            }

            .nav-links {
                display: none;
            }
            .footer-main {
                grid-template-columns: 1fr;
                gap: 45px;
            }
            .footer-bottom {
                justify-content: center;
                text-align: center;
                flex-direction: column-reverse;
            }
        }

        @media (max-width: 576px) {
            nav {
                height: 70px;
            }
            .user-greeting {
                display: none;
            }
        }

    </style>

</head>


<body class="text-[#1E293B]">

    <!-- =====================================================
         NAVBAR (Floating Glassmorphism)
    ===================================================== -->
    <nav>
        <a href="../BERANDA/beranda.php" style="display:flex; align-items:center; text-decoration:none;">
            <div class="nav-logo">
                <img src="../GAMBAR_GAMBAR/LOGO.png" alt="Logo RUPANTARA" class="onerror-fallback">
            </div>
        </a>

        <ul class="nav-links">
            <li><a href="../BERANDA/beranda.php">Beranda</a></li>
            <li><a href="../TENTANG RUPIAH/tentangrupiah.php" class="active">Tentang Rupiah</a></li>
            <li><a href="../MATERI/edukasi.php">Edukasi</a></li>
            <li><a href="../QUIZ/quiz_intro.php">Quiz</a></li>
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


    <!-- =====================================================
         HERO
    ===================================================== -->

    <header
        class="relative overflow-hidden bg-gradient-to-b from-blue-50 to-white pt-24 pb-24 px-6 md:px-12 lg:px-24">

        <!-- Background Grid -->
        <div
            class="absolute inset-0 opacity-[0.03] pointer-events-none bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:16px_16px]">
        </div>


        <div
            class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">


            <!-- LEFT -->
            <div class="lg:col-span-6 z-10">

                <h1
                    class="text-4xl md:text-5xl lg:text-6xl font-black text-blue-950 leading-tight mb-4">

                    TENTANG
                    <br>

                    <span class="text-blue-600">
                        RUPIAH
                    </span>

                </h1>


                <p
                    class="text-slate-600 text-base md:text-lg mb-8 max-w-lg leading-relaxed">

                    Kenali sejarah, pecahan, dan unsur keamanan
                    mata uang Indonesia secara interaktif.

                </p>


                <a
                    href="#belajar-section"
                    class="inline-flex items-center gap-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3.5 rounded-xl shadow-lg shadow-blue-500/20 hover:shadow-xl transition-all duration-300">

                    Jelajahi Pecahan

                    <i class="fa-solid fa-arrow-right"></i>

                </a>

            </div>



            <!-- RIGHT -->
            <div
                class="lg:col-span-6 flex justify-center lg:justify-end relative">

                <div
                    class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[350px] h-[350px] bg-blue-400/10 rounded-full blur-3xl -z-10">
                </div>


                <div
                    class="relative w-full max-w-[380px] flex flex-col items-end pr-8 select-none">


                    <img
                        src="../GAMBAR_GAMBAR/uang_100000.jpg"
                        alt="100 Ribu"
                        class="w-[280px] md:w-[310px] rounded shadow-md transform rotate-[-4deg] translate-x-[-15px] relative z-40 hover:scale-105 transition-transform duration-300">


                    <img
                        src="../GAMBAR_GAMBAR/uang_50000.jpg"
                        alt="50 Ribu"
                        class="w-[280px] md:w-[310px] rounded shadow-md transform rotate-[-3deg] translate-x-[-5px] -mt-[110px] md:-mt-[125px] relative z-30 hover:scale-105 transition-transform duration-300">


                    <img
                        src="../GAMBAR_GAMBAR/uang_1000.jpg"
                        onerror="this.src='../GAMBAR_GAMBAR/uang_10000.jpg'"
                        alt="10 Ribu"
                        class="w-[280px] md:w-[310px] rounded shadow-md transform rotate-[-2deg] translate-x-[5px] -mt-[110px] md:-mt-[125px] relative z-20 hover:scale-105 transition-transform duration-300">


                    <img
                        src="../GAMBAR_GAMBAR/uang_5000.jpg"
                        alt="5 Ribu"
                        class="w-[280px] md:w-[310px] rounded shadow-md transform rotate-[-1deg] translate-x-[15px] -mt-[110px] md:-mt-[125px] relative z-10 hover:scale-105 transition-transform duration-300">


                    <img
                        src="../GAMBAR_GAMBAR/uang_2000.jpg"
                        alt="2 Ribu"
                        class="w-[280px] md:w-[310px] rounded shadow-md transform rotate-[0deg] translate-x-[25px] -mt-[110px] md:-mt-[125px] relative z-0 hover:scale-105 transition-transform duration-300">

                </div>

            </div>

        </div>

    </header>



    <!-- =====================================================
         MAIN
    ===================================================== -->

    <main
        id="belajar-section"
        class="max-w-5xl mx-auto px-4 md:px-6 py-16">


        <!-- =================================================
             APA ITU RUPIAH
        ================================================= -->

        <section>

            <!-- Heading -->
            <div class="text-center mb-8">

                <span
                    class="inline-flex items-center gap-2 bg-blue-100 text-blue-800 text-xs font-bold px-4 py-2 rounded-full uppercase tracking-wider mb-4">

                    <i class="fa-solid fa-book-open"></i>

                    Apa Itu Rupiah?

                </span>


                <h2
                    class="text-3xl md:text-4xl font-extrabold text-blue-950 mb-3">

                    Apa itu Rupiah?

                </h2>


                <p
                    class="text-slate-500 max-w-lg mx-auto text-sm md:text-base leading-relaxed">

                    Kenali Rupiah lebih dekat melalui informasi dasar berikut.

                </p>

            </div>



            <!-- KOTAK INFO -->
            <div
                class="max-w-3xl mx-auto mb-10">

                <div
                    class="bg-blue-50 border border-blue-200 rounded-xl px-5 py-4 flex items-center gap-4 shadow-sm">

                    <div
                        class="w-9 h-9 rounded-full bg-white flex items-center justify-center text-blue-600 shrink-0 shadow-sm">

                        <i class="fa-solid fa-circle-info"></i>

                    </div>


                    <p
                        class="text-xs md:text-sm text-blue-800 font-medium leading-relaxed">

                        Rupiah memiliki peran penting sebagai mata uang
                        resmi Republik Indonesia dan digunakan dalam
                        berbagai aktivitas ekonomi masyarakat.

                    </p>

                </div>


                <!-- DOTTED LINE -->
                <div class="dot-divider mt-8"></div>

            </div>



            <!-- ACCORDIONS -->
            <div class="space-y-4">


                <!-- CARD 1 -->
                <div
                    class="bg-white rounded-2xl border-l-4 border-blue-500 shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">

                    <div
                        onclick="toggleAccordion('acc1')"
                        class="p-6 flex justify-between items-center cursor-pointer select-none">

                        <div class="flex items-center gap-4">

                            <div
                                class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shadow-inner">

                                <i class="fa-solid fa-shield-halved text-xl"></i>

                            </div>

                            <div>

                                <h3
                                    class="font-bold text-lg text-blue-950">

                                    Apa itu Rupiah?

                                </h3>

                                <p
                                    class="text-xs text-slate-400">

                                    Mata uang resmi Republik Indonesia.

                                </p>

                            </div>

                        </div>


                        <button
                            class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 hover:bg-blue-100 transition-colors transform duration-300"
                            id="btn-acc1">

                            <i
                                class="fa-solid fa-chevron-down text-sm transition-transform duration-300"
                                id="icon-acc1">
                            </i>

                        </button>

                    </div>


                    <div
                        id="content-acc1"
                        class="accordion-content">

                        <div
                            class="p-6 border-t border-slate-100 bg-slate-50/50 space-y-6">

                            <p
                                class="text-slate-600 leading-relaxed text-sm md:text-base">

                                Rupiah (Rp) adalah mata uang resmi Republik
                                Indonesia yang diterbitkan dan dikelola oleh
                                Bank Indonesia. Rupiah digunakan sebagai alat
                                pembayaran yang sah di seluruh wilayah
                                kedaulatan Indonesia.

                            </p>


                            <div
                                class="grid grid-cols-2 lg:grid-cols-4 gap-3">


                                <div
                                    class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm flex items-center gap-3">

                                    <span class="text-blue-600">
                                        <i class="fa-solid fa-shield-heart text-xl"></i>
                                    </span>

                                    <div>

                                        <h4
                                            class="text-[11px] text-slate-400 uppercase font-bold tracking-wider">

                                            Mata Uang Resmi

                                        </h4>

                                        <p
                                            class="text-xs font-bold text-slate-700">

                                            Republik Indonesia

                                        </p>

                                    </div>

                                </div>


                                <div
                                    class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm flex items-center gap-3">

                                    <span class="text-blue-600">
                                        <i class="fa-solid fa-building-columns text-xl"></i>
                                    </span>

                                    <div>

                                        <h4
                                            class="text-[11px] text-slate-400 uppercase font-bold tracking-wider">

                                            Diterbitkan Oleh

                                        </h4>

                                        <p
                                            class="text-xs font-bold text-slate-700">

                                            Bank Indonesia

                                        </p>

                                    </div>

                                </div>


                                <div
                                    class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm flex items-center gap-3">

                                    <span
                                        class="text-blue-600 font-extrabold text-lg">

                                        Rp

                                    </span>

                                    <div>

                                        <h4
                                            class="text-[11px] text-slate-400 uppercase font-bold tracking-wider">

                                            Simbol

                                        </h4>

                                        <p
                                            class="text-xs font-bold text-slate-700">

                                            Rp

                                        </p>

                                    </div>

                                </div>


                                <div
                                    class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm flex items-center gap-3">

                                    <span
                                        class="text-blue-600 font-extrabold text-sm">

                                        IDR

                                    </span>

                                    <div>

                                        <h4
                                            class="text-[11px] text-slate-400 uppercase font-bold tracking-wider">

                                            Kode Mata Uang

                                        </h4>

                                        <p
                                            class="text-xs font-bold text-slate-700">

                                            IDR

                                        </p>

                                    </div>

                                </div>

                            </div>


                            <div
                                class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex gap-3">

                                <div class="text-amber-500 mt-1">
                                    <i class="fa-solid fa-lightbulb"></i>
                                </div>

                                <p
                                    class="text-xs md:text-sm text-amber-800 leading-relaxed">

                                    Rupiah digunakan dalam setiap aktivitas
                                    ekonomi masyarakat Indonesia and menjadi
                                    salah satu simbol utama kedaulatan negara.

                                </p>

                            </div>

                        </div>

                    </div>

                </div>



                <!-- CARD 2 -->
                <div
                    class="bg-white rounded-2xl border-l-4 border-blue-500 shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">

                    <div
                        onclick="toggleAccordion('acc2')"
                        class="p-6 flex justify-between items-center cursor-pointer select-none">

                        <div class="flex items-center gap-4">

                            <div
                                class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shadow-inner">

                                <i class="fa-solid fa-building-columns text-xl"></i>

                            </div>

                            <div>

                                <h3
                                    class="font-bold text-lg text-blue-950">

                                    Siapa yang menerbitkan Rupiah?

                                </h3>

                                <p
                                    class="text-xs text-slate-400">

                                    Mengenal peran Bank Indonesia.

                                </p>

                            </div>

                        </div>


                        <button
                            class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 hover:bg-blue-100 transition-colors transform duration-300"
                            id="btn-acc2">

                            <i
                                class="fa-solid fa-chevron-down text-sm transition-transform duration-300"
                                id="icon-acc2">
                            </i>

                        </button>

                    </div>


                    <div
                        id="content-acc2"
                        class="accordion-content">

                        <div
                            class="p-6 border-t border-slate-100 bg-slate-50/50 space-y-6">

                            <p
                                class="text-slate-600 leading-relaxed text-sm md:text-base">

                                Bank Indonesia (BI) adalah bank sentral
                                Republik Indonesia yang memiliki kewenangan
                                penuh untuk mengelola Rupiah.

                            </p>


                            <div
                                class="bg-blue-50/80 border border-blue-200 rounded-xl p-4">

                                <div
                                    class="flex items-center gap-2 mb-2">

                                    <i
                                        class="fa-solid fa-gavel text-blue-700">
                                    </i>

                                    <h4
                                        class="font-bold text-xs md:text-sm text-blue-900">

                                        Undang-Undang Nomor 7 Tahun 2011

                                    </h4>

                                </div>


                                <p
                                    class="text-xs text-slate-600 italic">

                                    Bank Indonesia merupakan lembaga yang
                                    berwenang melakukan pengeluaran,
                                    pengedaran, pencabutan dan penarikan
                                    Rupiah.

                                </p>

                            </div>


                            <div
                                class="grid grid-cols-1 md:grid-cols-4 gap-4">


                                <div
                                    class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">

                                    <div
                                        class="bg-blue-100 h-28 flex items-center justify-center text-blue-600 text-3xl">

                                        <i class="fa-solid fa-print"></i>

                                    </div>

                                    <div class="p-3 text-center">

                                        <span
                                            class="w-6 h-6 rounded-full bg-blue-600 text-white text-xs font-bold inline-flex items-center justify-center mb-2">

                                            1

                                        </span>

                                        <p
                                            class="font-extrabold text-xs text-blue-950 uppercase">

                                            Menerbitkan Rupiah

                                        </p>

                                    </div>

                                </div>


                                <div
                                    class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">

                                    <div
                                        class="bg-blue-100 h-28 flex items-center justify-center text-blue-600 text-3xl">

                                        <i class="fa-solid fa-truck-ramp-box"></i>

                                    </div>

                                    <div class="p-3 text-center">

                                        <span
                                            class="w-6 h-6 rounded-full bg-blue-600 text-white text-xs font-bold inline-flex items-center justify-center mb-2">

                                            2

                                        </span>

                                        <p
                                            class="font-extrabold text-xs text-blue-950 uppercase">

                                            Pengedaran Uang

                                        </p>

                                    </div>

                                </div>


                                <div
                                    class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">

                                    <div
                                        class="bg-blue-100 h-28 flex items-center justify-center text-blue-600 text-3xl">

                                        <i class="fa-solid fa-hand-holding-dollar"></i>

                                    </div>

                                    <div class="p-3 text-center">

                                        <span
                                            class="w-6 h-6 rounded-full bg-blue-600 text-white text-xs font-bold inline-flex items-center justify-center mb-2">

                                            3

                                        </span>

                                        <p
                                            class="font-extrabold text-xs text-blue-950 uppercase">

                                            Menarik Uang Tidak Layak

                                        </p>

                                    </div>

                                </div>


                                <div
                                    class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">

                                    <div
                                        class="bg-blue-100 h-28 flex items-center justify-center text-blue-600 text-3xl">

                                        <i class="fa-solid fa-fire-burner"></i>

                                    </div>

                                    <div class="p-3 text-center">

                                        <span
                                            class="w-6 h-6 rounded-full bg-blue-600 text-white text-xs font-bold inline-flex items-center justify-center mb-2">

                                            4

                                        </span>

                                        <p
                                            class="font-extrabold text-xs text-blue-950 uppercase">

                                            Pemusnahan Sesuai Prosedur

                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



                <!-- CARD 3 -->
                <div
                    class="bg-white rounded-2xl border-l-4 border-blue-500 shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">

                    <div
                        onclick="toggleAccordion('acc3')"
                        class="p-6 flex justify-between items-center cursor-pointer select-none">

                        <div class="flex items-center gap-4">

                            <div
                                class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shadow-inner">

                                <span class="font-extrabold text-lg">
                                    Rp
                                </span>

                            </div>

                            <div>

                                <h3
                                    class="font-bold text-lg text-blue-950">

                                    Simbol & Kode Rupiah

                                </h3>

                                <p
                                    class="text-xs text-slate-400">

                                    Arti simbol Rp dan kode IDR.

                                </p>

                            </div>

                        </div>


                        <button
                            class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 hover:bg-blue-100 transition-colors transform duration-300"
                            id="btn-acc3">

                            <i
                                class="fa-solid fa-chevron-down text-sm transition-transform duration-300"
                                id="icon-acc3">
                            </i>

                        </button>

                    </div>


                    <div
                        id="content-acc3"
                        class="accordion-content">

                        <div
                            class="p-6 border-t border-slate-100 bg-slate-50/50 space-y-6">


                            <div class="text-center">

                                <h4
                                    class="font-extrabold text-lg text-blue-950">

                                    Kenali seluruh pecahan Rupiah

                                </h4>

                            </div>


                            <div class="fan-container">

                                <img
                                    src="../GAMBAR_GAMBAR/uang_2000.jpg"
                                    alt="Rp 2.000"
                                    class="fan-note"
                                    style="transform: rotate(-16deg);">

                                <img
                                    src="../GAMBAR_GAMBAR/uang_5000.jpg"
                                    alt="Rp 5.000"
                                    class="fan-note"
                                    style="transform: rotate(-8deg);">

                                <img
                                    src="../GAMBAR_GAMBAR/uang_10000.jpg"
                                    alt="Rp 10.000"
                                    class="fan-note"
                                    style="transform: rotate(0deg);">

                                <img
                                    src="../GAMBAR_GAMBAR/uang_50000.jpg"
                                    alt="Rp 50.000"
                                    class="fan-note"
                                    style="transform: rotate(8deg);">

                                <img
                                    src="../GAMBAR_GAMBAR/uang_100000.jpg"
                                    alt="Rp 100.000"
                                    class="fan-note"
                                    style="transform: rotate(16deg);">

                            </div>


                            <div
                                class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex gap-3">

                                <div class="text-amber-500 mt-1">
                                    <i class="fa-solid fa-lightbulb"></i>
                                </div>

                                <p
                                    class="text-xs md:text-sm text-amber-800 leading-relaxed">

                                    Setiap pecahan Rupiah menggunakan simbol
                                    resmi <span class="font-bold">"Rp"</span>,
                                    sedangkan mata uang Indonesia memiliki
                                    kode standar internasional,
                                    yaitu <span class="font-bold">"IDR"</span>.

                                </p>

                            </div>


                            <div
                                class="grid grid-cols-1 lg:grid-cols-2 gap-6">


                                <div
                                    class="bg-blue-50/30 border border-blue-200 rounded-2xl p-6 text-center">

                                    <h5
                                        class="font-bold text-blue-950 mb-3 text-sm">

                                        Simbol Rupiah

                                    </h5>

                                    <div
                                        class="w-16 h-16 bg-white border-2 border-blue-500 rounded-full flex items-center justify-center font-bold text-2xl text-blue-600 mx-auto mb-4 shadow-sm">

                                        Rp

                                    </div>

                                    <p
                                        class="text-xs text-slate-500 mb-4">

                                        Digunakan dalam penulisan nominal
                                        mata uang di dalam negeri.

                                    </p>

                                    <div
                                        class="bg-blue-100 text-blue-800 text-xs font-bold py-2 rounded-lg inline-block px-4">

                                        Contoh: Rp100.000

                                    </div>

                                </div>


                                <div
                                    class="bg-amber-50/30 border border-amber-200 rounded-2xl p-6 text-center">

                                    <h5
                                        class="font-bold text-amber-950 mb-3 text-sm">

                                        Kode Mata Uang

                                    </h5>

                                    <div
                                        class="w-16 h-16 bg-white border-2 border-amber-400 rounded-full flex items-center justify-center font-bold text-xl text-amber-600 mx-auto mb-4 shadow-sm">

                                        IDR

                                    </div>

                                    <p
                                        class="text-xs text-slate-500 mb-4">

                                        Digunakan dalam transaksi internasional,
                                        perbankan, and sistem keuangan global.

                                    </p>

                                    <div
                                        class="bg-amber-100 text-amber-800 text-xs font-bold py-2 rounded-lg inline-block px-4">

                                        Contoh: IDR 100,000

                                    </div>

                                </div>

                            </div>


                            <div
                                class="bg-slate-100 rounded-xl p-4 flex items-center gap-3">

                                <span class="text-slate-500 text-lg">

                                    <i class="fa-solid fa-clipboard-list"></i>

                                </span>

                                <p class="text-xs text-slate-600">

                                    <strong class="text-slate-800">
                                        Fakta Resmi:
                                    </strong>

                                    Kode mata uang Indonesia
                                    <strong class="text-blue-900">
                                        "IDR"
                                    </strong>
                                    ditetapkan berdasarkan standar
                                    internasional
                                    <strong class="text-slate-800">
                                        ISO 4217
                                    </strong>.

                                </p>

                            </div>

                        </div>

                    </div>

                </div>



                <!-- CARD 4 -->
                <div
                    class="bg-white rounded-2xl border-l-4 border-blue-500 shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">

                    <div
                        onclick="toggleAccordion('acc4')"
                        class="p-6 flex justify-between items-center cursor-pointer select-none">

                        <div class="flex items-center gap-4">

                            <div
                                class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shadow-inner">

                                <i class="fa-solid fa-globe text-xl"></i>

                            </div>

                            <div>

                                <h3
                                    class="font-bold text-lg text-blue-950">

                                    Mengapa Rupiah penting?

                                </h3>

                                <p
                                    class="text-xs text-slate-400">

                                    Peran Rupiah dalam kehidupan sehari-hari.

                                </p>

                            </div>

                        </div>


                        <button
                            class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 hover:bg-blue-100 transition-colors transform duration-300"
                            id="btn-acc4">

                            <i
                                class="fa-solid fa-chevron-down text-sm transition-transform duration-300"
                                id="icon-acc4">
                            </i>

                        </button>

                    </div>


                    <div
                        id="content-acc4"
                        class="accordion-content">

                        <div
                            class="p-6 border-t border-slate-100 bg-slate-50/50 space-y-6">

                            <p
                                class="text-slate-600 leading-relaxed text-sm md:text-base">

                                Lebih dari sekadar alat pembayaran,
                                Rupiah memiliki peran penting dalam
                                kehidupan sehari-hari dan mendorong
                                berjalannya roda perekonomian nasional
                                Indonesia.

                            </p>


                            <div
                                class="grid grid-cols-2 md:grid-cols-3 gap-4">


                                <div
                                    class="bg-white rounded-xl p-4 border border-blue-100 shadow-sm">

                                    <div
                                        class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mb-3">

                                        <i class="fa-solid fa-cart-shopping"></i>

                                    </div>

                                    <h5
                                        class="font-bold text-xs text-slate-800">

                                        Belanja

                                    </h5>

                                    <p
                                        class="text-[10px] text-slate-400">

                                        Kebutuhan Pokok

                                    </p>

                                </div>


                                <div
                                    class="bg-white rounded-xl p-4 border border-blue-100 shadow-sm">

                                    <div
                                        class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mb-3">

                                        <i class="fa-solid fa-graduation-cap"></i>

                                    </div>

                                    <h5
                                        class="font-bold text-xs text-slate-800">

                                        Pendidikan

                                    </h5>

                                    <p
                                        class="text-[10px] text-slate-400">

                                        Investasi Masa Depan

                                    </p>

                                </div>


                                <div
                                    class="bg-white rounded-xl p-4 border border-blue-100 shadow-sm">

                                    <div
                                        class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-3">

                                        <i class="fa-solid fa-heart-pulse"></i>

                                    </div>

                                    <h5
                                        class="font-bold text-xs text-slate-800">

                                        Kesehatan

                                    </h5>

                                    <p
                                        class="text-[10px] text-slate-400">

                                        Jaminan Layanan

                                    </p>

                                </div>


                                <div
                                    class="bg-white rounded-xl p-4 border border-blue-100 shadow-sm">

                                    <div
                                        class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center mb-3">

                                        <i class="fa-solid fa-piggy-bank"></i>

                                    </div>

                                    <h5
                                        class="font-bold text-xs text-slate-800">

                                        Perbankan

                                    </h5>

                                    <p
                                        class="text-[10px] text-slate-400">

                                        Tabungan & Investasi

                                    </p>

                                </div>


                                <div
                                    class="bg-white rounded-xl p-4 border border-blue-100 shadow-sm">

                                    <div
                                        class="w-10 h-10 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center mb-3">

                                        <i class="fa-solid fa-industry"></i>

                                    </div>

                                    <h5
                                        class="font-bold text-xs text-slate-800">

                                        Industri

                                    </h5>

                                    <p
                                        class="text-[10px] text-slate-400">

                                        Manufaktur & Usaha

                                    </p>

                                </div>


                                <div
                                    class="bg-white rounded-xl p-4 border border-blue-100 shadow-sm">

                                    <div
                                        class="w-10 h-10 rounded-full bg-violet-100 text-violet-600 flex items-center justify-center mb-3">

                                        <i class="fa-solid fa-train"></i>

                                    </div>

                                    <h5
                                        class="font-bold text-xs text-slate-800">

                                        Transportasi

                                    </h5>

                                    <p
                                        class="text-[10px] text-slate-400">

                                        Mobilitas Logistik

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>



        <!-- =====================================================
             DIVIDER
        ===================================================== -->

        <div class="dot-divider my-20"></div>



        <!-- =====================================================
             CIRI KEAMANAN RUPIAH
        ===================================================== -->

        <section id="keamanan-rupiah">


            <!-- SECTION HEADER -->
            <div class="text-center mb-10">

                <span
                    class="inline-flex items-center gap-2 bg-blue-100 text-blue-800 text-xs font-bold px-4 py-2 rounded-full uppercase tracking-wider mb-4">

                    <i class="fa-solid fa-shield-halved"></i>

                    Kenali Ciri Keamanan

                </span>


                <h2
                    class="text-3xl md:text-4xl font-extrabold text-blue-950 mb-3">

                    Ciri Keamanan Rupiah

                </h2>


                <p
                    class="text-slate-500 max-w-xl mx-auto text-sm md:text-base leading-relaxed">

                    Rupiah memiliki unsur pengaman yang dapat diperiksa
                    melalui penglihatan, penerawangan, dan perabaan.

                </p>

            </div>



            <!-- INFO BOX -->
            <div
                class="max-w-3xl mx-auto mb-10">

                <div
                    class="bg-blue-50 border border-blue-200 rounded-xl px-5 py-4 flex items-center gap-4 shadow-sm">

                    <div
                        class="w-9 h-9 rounded-full bg-white flex items-center justify-center text-blue-600 shrink-0">

                        <i class="fa-solid fa-circle-info"></i>

                    </div>

                    <p
                        class="text-xs md:text-sm text-blue-800 font-medium leading-relaxed">

                        Kenali beberapa ciri keamanan pada Rupiah
                        untuk membantu membedakan uang Rupiah asli
                        dengan lebih mudah.

                    </p>

                </div>


                <div class="dot-divider mt-8"></div>

            </div>



            <!-- SECURITY CARDS -->
            <div
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">


                <!-- CARD 01 -->
                <div
                    class="security-card bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden"
                    data-detail="main-image">

                    <div
                        class="h-40 bg-blue-50 flex items-center justify-center card-art">

                        <img src="../GAMBAR_GAMBAR/gambar utama.jpg" alt="Gambar Utama" class="max-w-[85%] max-h-[85%] object-contain mx-auto">

                    </div>


                    <div class="p-5">

                        <span
                            class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">

                            01 — DILIHAT

                        </span>


                        <h3
                            class="font-bold text-blue-950 mt-2">

                            Gambar Utama

                        </h3>


                        <p
                            class="text-xs text-slate-500 mt-2 leading-relaxed">

                            Kenali karakteristik visual pada Rupiah.

                        </p>


                        <div
                            class="mt-4 text-blue-600 text-xs font-bold flex items-center gap-2">

                            Lihat detail

                            <i class="fa-solid fa-arrow-right"></i>

                        </div>

                    </div>

                </div>



                <!-- CARD 02 -->
                <div
                    class="security-card bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden"
                    data-detail="watermark">

                    <div
                        class="h-40 bg-blue-50 flex items-center justify-center card-art">

                        <img src="../GAMBAR_GAMBAR/watermark tanda air.jpg" alt="Tanda Air" class="max-w-[85%] max-h-[85%] object-contain mx-auto">

                    </div>


                    <div class="p-5">

                        <span
                            class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">

                            02 — DITERAWANG

                        </span>


                        <h3
                            class="font-bold text-blue-950 mt-2">

                            Tanda Air

                        </h3>


                        <p
                            class="text-xs text-slate-500 mt-2 leading-relaxed">

                            Terawang Rupiah ke arah sumber cahaya.

                        </p>


                        <div
                            class="mt-4 text-blue-600 text-xs font-bold flex items-center gap-2">

                            Lihat detail

                            <i class="fa-solid fa-arrow-right"></i>

                        </div>

                    </div>

                </div>



                <!-- CARD 03 -->
                <div
                    class="security-card bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden"
                    data-detail="color">

                    <div
                        class="h-40 bg-blue-50 flex items-center justify-center card-art">

                        <img src="../GAMBAR_GAMBAR/perubahan warna.jpg" alt="Perubahan Warna" class="max-w-[85%] max-h-[85%] object-contain mx-auto">

                    </div>


                    <div class="p-5">

                        <span
                            class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">

                            03 — DILIHAT

                        </span>


                        <h3
                            class="font-bold text-blue-950 mt-2">

                            Perubahan Warna

                        </h3>


                        <p
                            class="text-xs text-slate-500 mt-2 leading-relaxed">

                            Perhatikan efek perubahan warna tertentu.

                        </p>


                        <div
                            class="mt-4 text-blue-600 text-xs font-bold flex items-center gap-2">

                            Lihat detail

                            <i class="fa-solid fa-arrow-right"></i>

                        </div>

                    </div>

                </div>



                <!-- CARD 04 -->
                <div
                    class="security-card bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden"
                    data-detail="rectoverso">

                    <div
                        class="h-40 bg-blue-50 flex items-center justify-center card-art">

                        <img src="../GAMBAR_GAMBAR/rectroverso.jpg" alt="Rectoverso" class="max-w-[85%] max-h-[85%] object-contain mx-auto">

                    </div>


                    <div class="p-5">

                        <span
                            class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">

                            04 — DITERAWANG

                        </span>


                        <h3
                            class="font-bold text-blue-950 mt-2">

                            Rectoverso

                        </h3>


                        <p
                            class="text-xs text-slate-500 mt-2 leading-relaxed">

                            Bagian depan dan belakang saling melengkapi.

                        </p>


                        <div
                            class="mt-4 text-blue-600 text-xs font-bold flex items-center gap-2">

                            Lihat detail

                            <i class="fa-solid fa-arrow-right"></i>

                        </div>

                    </div>

                </div>



                <!-- CARD 05 -->
                <div
                    class="security-card bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden"
                    data-detail="texture">

                    <div
                        class="h-40 bg-blue-50 flex items-center justify-center card-art">

                        <img src="../GAMBAR_GAMBAR/Cetakan terasa kasar.jpg" alt="Cetakan Terasa Kasar" class="max-w-[85%] max-h-[85%] object-contain mx-auto">

                    </div>


                    <div class="p-5">

                        <span
                            class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">

                            05 — DIRABA

                        </span>


                        <h3
                            class="font-bold text-blue-950 mt-2">

                            Cetakan Terasa Kasar

                        </h3>


                        <p
                            class="text-xs text-slate-500 mt-2 leading-relaxed">

                            Rabalah bagian tertentu pada Rupiah.

                        </p>


                        <div
                            class="mt-4 text-blue-600 text-xs font-bold flex items-center gap-2">

                            Lihat detail

                            <i class="fa-solid fa-arrow-right"></i>

                        </div>

                    </div>

                </div>



                <!-- CARD 06 -->
                <div
                    class="security-card bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden"
                    data-detail="blind-code">

                    <div
                        class="h-40 bg-blue-50 flex items-center justify-center card-art">

                        <img src="../GAMBAR_GAMBAR/kode tuna netra.jpg" alt="Kode Tuna Netra" class="max-w-[85%] max-h-[85%] object-contain mx-auto">

                    </div>


                    <div class="p-5">

                        <span
                            class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">

                            06 — DIRABA

                        </span>


                        <h3
                            class="font-bold text-blue-950 mt-2">

                            Kode Tuna Netra

                        </h3>


                        <p
                            class="text-xs text-slate-500 mt-2 leading-relaxed">

                            Kenali tanda tertentu melalui sentuhan.

                        </p>


                        <div
                            class="mt-4 text-blue-600 text-xs font-bold flex items-center gap-2">

                            Lihat detail

                            <i class="fa-solid fa-arrow-right"></i>

                        </div>

                    </div>

                </div>



                <!-- CARD 07 -->
                <div
                    class="security-card bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden"
                    data-detail="security-thread">

                    <div
                        class="h-40 bg-blue-50 flex items-center justify-center card-art">

                        <img src="../GAMBAR_GAMBAR/benang pengaman.jpg" alt="Benang Pengaman" class="max-w-[85%] max-h-[85%] object-contain mx-auto">

                    </div>


                    <div class="p-5">

                        <span
                            class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">

                            07 — DILIHAT

                        </span>


                        <h3
                            class="font-bold text-blue-950 mt-2">

                            Benang Pengaman

                        </h3>


                        <p
                            class="text-xs text-slate-500 mt-2 leading-relaxed">

                            Perhatikan benang pengaman pada Rupiah.

                        </p>


                        <div
                            class="mt-4 text-blue-600 text-xs font-bold flex items-center gap-2">

                            Lihat detail

                            <i class="fa-solid fa-arrow-right"></i>

                        </div>

                    </div>

                </div>



                <!-- CARD 08 -->
                <div
                    class="security-card bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden"
                    data-detail="microtext">

                    <div
                        class="h-40 bg-blue-50 flex items-center justify-center card-art">

                        <img src="../GAMBAR_GAMBAR/detail mikro.jpg" alt="Detail Mikro" class="max-w-[85%] max-h-[85%] object-contain mx-auto">

                    </div>


                    <div class="p-5">

                        <span
                            class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">

                            08 — DILIHAT

                        </span>


                        <h3
                            class="font-bold text-blue-950 mt-2">

                            Detail Mikro

                        </h3>


                        <p
                            class="text-xs text-slate-500 mt-2 leading-relaxed">

                            Perhatikan detail berukuran kecil.

                        </p>


                        <div
                            class="mt-4 text-blue-600 text-xs font-bold flex items-center gap-2">

                            Lihat detail

                            <i class="fa-solid fa-arrow-right"></i>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </main>


    <!-- =====================================================
         SECURITY DETAIL POPUP
    ===================================================== -->

    <div id="securityDetail">

        <div class="security-modal p-6 md:p-10 relative">

            <button
                id="closeDetail"
                class="absolute top-5 right-5 w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500 transition-colors">

                <i class="fa-solid fa-xmark"></i>

            </button>

            <span
                id="detailNumber"
                class="text-xs font-bold text-blue-600 uppercase tracking-widest">
            </span>

            <h3
                id="detailTitle"
                class="text-2xl md:text-3xl font-extrabold text-blue-950 mt-2 mb-6">
            </h3>

            <div
                id="detailVisual"
                class="bg-blue-50 rounded-2xl min-h-[220px] py-6 px-4 flex items-center justify-center mb-6">
            </div>

            <p
                id="detailText"
                class="text-slate-600 text-sm md:text-base leading-relaxed">
            </p>

        </div>

    </div>


    <!-- =====================================================
         FOOTER
    ===================================================== -->
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
                    <a href="../BERANDA/beranda.php"><i data-lucide="chevron-right" style="width:14px; height:14px;"></i>Beranda</a>
                    <a href="../TENTANG RUPIAH/tentangrupiah.php"><i data-lucide="chevron-right" style="width:14px; height:14px;"></i>Tentang Rupiah</a>
                    <a href="../MATERI/edukasi.php"><i data-lucide="chevron-right" style="width:14px; height:14px;"></i>Edukasi</a>
                    <a href="../QUIZ/quiz_intro.php"><i data-lucide="chevron-right" style="width:14px; height:14px;"></i>Quiz</a>
                    <a href="../SCANNER/index_copy.php"><i data-lucide="chevron-right" style="width:14px; height:14px;"></i>Scan</a>
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


    <!-- =====================================================
         JAVASCRIPT
         ACCORDION
    ===================================================== -->

    <script>
        // Inisialisasi Ikon Lucide
        lucide.createIcons();

        function toggleAccordion(id) {

            const content =
                document.getElementById(`content-${id}`);

            const icon =
                document.getElementById(`icon-${id}`);

            const btn =
                document.getElementById(`btn-${id}`);


            if (!content || !icon || !btn) {
                return;
            }


            const isOpen =
                content.classList.contains('open');


            /* Tutup semua accordion */

            document
                .querySelectorAll('.accordion-content')
                .forEach(el => {

                    el.classList.remove('open');

                });


            /* Reset semua icon */

            document
                .querySelectorAll('[id^="icon-"]')
                .forEach(el => {

                    el.classList.remove('rotate-180');

                });


            /* Reset semua tombol */

            document
                .querySelectorAll('[id^="btn-"]')
                .forEach(el => {

                    el.classList.remove(
                        'bg-blue-600',
                        'text-white'
                    );

                    el.classList.add(
                        'bg-blue-50',
                        'text-blue-600'
                    );

                });


            /* Kalau sebelumnya tertutup, buka */

            if (!isOpen) {

                content.classList.add('open');

                icon.classList.add('rotate-180');

                btn.classList.add(
                    'bg-blue-600',
                    'text-white'
                );

                btn.classList.remove(
                    'bg-blue-50',
                    'text-blue-600'
                );

            }

        }


        /* =====================================================
           IMAGE FALLBACK
        ===================================================== */

        document
            .querySelectorAll('.onerror-fallback')
            .forEach(img => {

                img.onerror = function () {

                    this.style.display = 'none';

                };

            });

    </script>



    <!-- =====================================================
         JAVASCRIPT
         SECURITY CARDS
    ===================================================== -->

    <script>

        /* =====================================================
           SECURITY CARDS INTERACTION
        ===================================================== */

        const securityCards =
            document.querySelectorAll(".security-card");


        const securityDetail =
            document.getElementById("securityDetail");


        const closeDetail =
            document.getElementById("closeDetail");


        const detailVisual =
            document.getElementById("detailVisual");


        const detailNumber =
            document.getElementById("detailNumber");


        const detailTitle =
            document.getElementById("detailTitle");


        const detailText =
            document.getElementById("detailText");



        /* =====================================================
           DATA
        ===================================================== */

        const securityInfo = {

            "main-image": {

                number: "01 — DILIHAT",

                title: "Gambar Utama",

                text:
                    "Perhatikan gambar utama pada Rupiah. " +
                    "Kenali karakteristik visualnya sebagai " +
                    "bagian dari ciri keamanan."

            },


            "watermark": {

                number: "02 — DITERAWANG",

                title: "Tanda Air",

                text:
                    "Terawang Rupiah ke arah sumber cahaya " +
                    "untuk melihat tanda air yang terdapat " +
                    "pada bagian tertentu."

            },


            "color": {

                number: "03 — DILIHAT",

                title: "Perubahan Warna",

                text:
                    "Perhatikan bagian tertentu pada Rupiah " +
                    "yang memiliki efek perubahan warna."

            },


            "rectoverso": {

                number: "04 — DITERAWANG",

                title: "Rectoverso",

                text:
                    "Perhatikan bagian depan dan belakang " +
                    "yang dapat saling melengkapi ketika " +
                    "diterawang."

            },


            "texture": {

                number: "05 — DIRABA",

                title: "Cetakan Terasa Kasar",

                text:
                    "Rabalah bagian tertentu pada Rupiah. " +
                    "Cetakan pada bagian tersebut terasa " +
                    "lebih kasar."

            },


            "blind-code": {

                number: "06 — DIRABA",

                title: "Kode Tuna Netra",

                text:
                    "Kenali tanda tertentu pada Rupiah " +
                    "melalui sentuhan."

            },


            "security-thread": {

                number: "07 — DILIHAT",

                title: "Benang Pengaman",

                text:
                    "Perhatikan benang pengaman yang menjadi " +
                    "salah satu unsur keamanan pada Rupiah."

            },


            "microtext": {

                number: "08 — DILIHAT",

                title: "Detail Mikro",

                text:
                    "Perhatikan detail berukuran kecil yang " +
                    "menjadi bagian dari unsur keamanan Rupiah."

            }

        };



        /* =====================================================
           KLIK SECURITY CARD
        ===================================================== */

        securityCards.forEach(card => {

            card.addEventListener("click", () => {

                const type =
                    card.dataset.detail;


                const data =
                    securityInfo[type];


                if (!data) {
                    return;
                }


                /* Nomor */

                detailNumber.textContent =
                    data.number;


                /* Judul */

                detailTitle.textContent =
                    data.title;


                /* Penjelasan */

                detailText.textContent =
                    data.text;



                /* Ambil gambar/visual dari kartu */

                const cardImg =
                    card.querySelector(".card-art img");


                if (cardImg) {

                    detailVisual.innerHTML =
                        `<img src="${cardImg.getAttribute('src')}" alt="${cardImg.getAttribute('alt')}" class="max-w-full max-h-[320px] object-contain mx-auto">`;

                }



                /* Buka popup */

                securityDetail.classList.add("active");

                document.body.style.overflow =
                    "hidden";

            });

        });



        /* =====================================================
           CLOSE POPUP
        ===================================================== */

        function closeSecurityDetail() {

            securityDetail.classList.remove("active");

            document.body.style.overflow = "";

        }



        /* Tombol X */

        if (closeDetail) {

            closeDetail.addEventListener(
                "click",
                closeSecurityDetail
            );

        }



        /* Klik background */

        if (securityDetail) {

            securityDetail.addEventListener(
                "click",
                event => {

                    if (
                        event.target === securityDetail
                    ) {

                        closeSecurityDetail();

                    }

                }
            );

        }



        /* Tombol ESC */

        document.addEventListener(
            "keydown",
            event => {

                if (event.key === "Escape") {

                    closeSecurityDetail();

                }

            }
        );

    </script>


</body>

</html>