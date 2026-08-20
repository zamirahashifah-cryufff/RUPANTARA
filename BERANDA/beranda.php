<?php
session_start();

// Menyimpan URL halaman ini ke dalam session agar setelah login berhasil, pengguna dikembalikan ke sini
$_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];

// Memeriksa status login pengguna
$is_logged_in = isset($_SESSION['login']) && $_SESSION['login'] === true;
$display_username = $is_logged_in ? $_SESSION['username'] : 'User';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>RUPANTARA - Beranda</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

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
            font-family: "Plus Jakarta Sans", "Inter", sans-serif;
        }

        body {
            background: var(--body);
            color: var(--text);
            line-height: 1.6;
            font-size: 15px;
            overflow-x: hidden;
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
            cursor: pointer;
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

        /* =====================================================
           LAYOUT & MAIN CONTAINER
        ===================================================== */
        .main-container {
            width: 100%;
            max-width: 1300px;
            margin: 40px auto 60px;
            padding: 0 24px;
            display: flex;
            flex-direction: column;
            gap: 50px;
        }

        /* =====================================================
           HERO SECTION
        ===================================================== */
        .hero-section {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 40px;
            align-items: center;
            background: linear-gradient(135deg, #FFFFFF 0%, #F0F6FE 100%);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 45px 50px;
            box-shadow: 0 10px 30px rgba(0, 48, 135, 0.04);
            position: relative;
            overflow: hidden;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #EAF2FF;
            color: var(--blue-dark);
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12.5px;
            font-weight: 700;
            margin-bottom: 18px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .hero-title {
            font-size: 40px;
            font-weight: 800;
            color: var(--navy);
            line-height: 1.25;
            margin-bottom: 18px;
            letter-spacing: -0.5px;
        }

        .hero-title span {
            color: var(--blue-dark);
            background: linear-gradient(135deg, var(--blue-dark), var(--blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-desc {
            font-size: 16px;
            color: var(--muted);
            line-height: 1.65;
            margin-bottom: 28px;
            max-width: 540px;
        }

        .btn-row {
            display: flex;
            gap: 14px;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-fill {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, var(--blue-dark), #1d5fa3);
            color: #fff;
            text-decoration: none;
            padding: 13px 26px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 14px;
            transition: all 0.3s ease;
            box-shadow: 0 6px 18px rgba(23, 76, 132, 0.2);
            cursor: pointer;
        }

        .btn-fill:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 24px rgba(23, 76, 132, 0.3);
            background: linear-gradient(135deg, #123D70, #174C84);
        }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: 2px solid var(--blue-dark);
            color: var(--blue-dark);
            text-decoration: none;
            padding: 11px 24px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 14px;
            transition: all 0.3s ease;
            background: transparent;
        }

        .btn-outline:hover {
            background: #EAF2FF;
            transform: translateY(-2px);
        }

        .hero-visual {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-image-wrapper {
            position: relative;
            width: 100%;
            max-width: 440px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 48, 135, 0.12);
        }

        .hero-image-wrapper img {
            width: 100%;
            height: 310px;
            object-fit: cover;
            display: block;
            transition: transform 0.5s ease;
        }

        .hero-image-wrapper:hover img {
            transform: scale(1.04);
        }

        .hero-float-badge {
            position: absolute;
            bottom: -15px;
            left: -15px;
            background: #FFFFFF;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 12px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            z-index: 10;
        }

        .hero-float-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #EAF2FF;
            color: var(--blue-dark);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-float-text {
            display: flex;
            flex-direction: column;
        }

        .hero-float-title {
            font-size: 13.5px;
            font-weight: 800;
            color: var(--navy);
        }

        .hero-float-sub {
            font-size: 11.5px;
            color: var(--muted);
        }

        /* =====================================================
           QUICK ACCESS CARDS (FITUR UTAMA)
        ===================================================== */
        .section-header {
            text-align: center;
            max-width: 650px;
            margin: 0 auto 30px;
        }

        .section-title {
            font-size: 28px;
            font-weight: 800;
            color: #003087;
            margin-bottom: 8px;
        }

        .section-subtitle {
            font-size: 14.5px;
            color: var(--muted);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 22px;
        }

        .feature-card {
            background: #FFFFFF;
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 28px 24px;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-decoration: none;
            color: var(--text);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--blue), var(--blue-dark));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 30px rgba(23, 76, 132, 0.09);
            border-color: rgba(89, 169, 232, 0.4);
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .feature-icon-wrapper {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: #EAF2FF;
            color: var(--blue-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon-wrapper {
            background: var(--blue-dark);
            color: #FFFFFF;
            transform: scale(1.08) rotate(4deg);
        }

        .feature-card h3 {
            font-size: 18px;
            font-weight: 800;
            color: var(--navy);
            margin-bottom: 8px;
        }

        .feature-card p {
            font-size: 13.5px;
            color: var(--muted);
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .feature-link {
            font-size: 13px;
            font-weight: 700;
            color: var(--blue-dark);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: auto;
            transition: gap 0.25s ease;
        }

        .feature-card:hover .feature-link {
            gap: 10px;
        }

        /* =====================================================
           ANIMATED STATS BAR
        ===================================================== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            background: #FFFFFF;
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        }

        .stat-item {
            text-align: center;
            padding: 10px;
            border-right: 1px solid var(--border);
        }

        .stat-item:last-child {
            border-right: none;
        }

        .stat-number {
            font-size: 36px;
            font-weight: 800;
            color: var(--navy);
            line-height: 1.2;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--muted);
        }

        /* =====================================================
           SECTION KEAMANAN RUPIAH - INTERACTIVE TABS
        ===================================================== */
        .interactive-section {
            background: #FFFFFF;
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        }

        .keamanan-tabs-wrapper {
            margin-top: 24px;
            background: #F4F7FC;
            padding: 8px;
            border-radius: 16px;
            display: flex;
            gap: 8px;
        }

        .keamanan-tab-btn {
            flex: 1;
            background: none;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-size: 14.5px;
            font-weight: 700;
            color: var(--muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.25s ease;
        }

        .keamanan-tab-btn:hover {
            color: var(--blue-dark);
            background: rgba(255, 255, 255, 0.5);
        }

        .keamanan-tab-btn.active {
            background: #fff;
            color: var(--blue-dark);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .keamanan-content-box {
            background: #F8FAFF;
            border: 1px solid #EAF2FF;
            border-radius: 20px;
            padding: 30px;
            margin-top: 20px;
        }

        .keamanan-detail-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 15px;
        }

        .keamanan-card {
            background: #FFFFFF;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            transition: all 0.3s ease;
        }

        .keamanan-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.04);
            border-color: var(--blue);
        }

        .keamanan-card img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 10px;
        }

        .keamanan-card h4 {
            font-size: 15px;
            font-weight: 800;
            color: var(--navy);
        }

        .keamanan-card p {
            font-size: 13px;
            color: var(--muted);
            line-height: 1.55;
        }

        /* =====================================================
           FEATURED MODULES SHOWCASE (ARTIKEL & EDUKASI)
        ===================================================== */
        .modules-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 22px;
        }

        .module-card {
            background: #FFFFFF;
            border: 1px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.35s ease;
            text-decoration: none;
            color: var(--text);
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        }

        .module-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
            border-color: rgba(89, 169, 232, 0.4);
        }

        .module-img-box {
            position: relative;
            width: 100%;
            height: 150px;
            overflow: hidden;
        }

        .module-img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .module-card:hover .module-img-box img {
            transform: scale(1.08);
        }

        .module-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .module-badge {
            display: inline-block;
            background: #EAF2FF;
            color: var(--blue-dark);
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 12px;
            margin-bottom: 10px;
            width: fit-content;
        }

        .module-card h4 {
            font-size: 16px;
            font-weight: 800;
            color: var(--navy);
            margin-bottom: 8px;
        }

        .module-card p {
            font-size: 13px;
            color: var(--muted);
            line-height: 1.55;
            margin-bottom: 16px;
            flex-grow: 1;
        }

        .module-read {
            font-size: 13px;
            font-weight: 700;
            color: var(--blue-dark);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* =====================================================
           QUIZ CTA BANNER
        ===================================================== */
        .cta-banner {
            background: linear-gradient(120deg, var(--navy), var(--blue-dark));
            border-radius: 24px;
            padding: 40px 48px;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 30px;
            box-shadow: 0 10px 30px rgba(10, 52, 88, 0.2);
            flex-wrap: wrap;
        }

        .cta-banner h3 {
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .cta-banner p {
            color: #CFE3FA;
            font-size: 14.5px;
            max-width: 580px;
        }

        .btn-white {
            background: #fff;
            color: var(--blue-dark);
            padding: 13px 28px;
            border-radius: 30px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-white:hover {
            transform: translateY(-2px);
            background: #F8FAFF;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        /* Toast Popup */
        .toast {
            position: fixed;
            top: 90px;
            right: 20px;
            background: #FFFFFF;
            border-left: 4px solid var(--blue-dark);
            border-radius: 10px;
            padding: 14px 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13.5px;
            font-weight: 600;
            z-index: 1000;
            animation: slideInRight 0.4s ease;
            max-width: 320px;
        }

        .toast.hiding {
            animation: fadeOut 0.3s ease forwards;
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(40px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes fadeOut {
            from { opacity: 1; transform: translateX(0); }
            to { opacity: 0; transform: translateX(40px); }
        }

        /* Scroll to Top */
        .scroll-top {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--blue-dark);
            color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: none;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
            z-index: 100;
            box-shadow: 0 4px 15px rgba(0, 48, 135, 0.2);
        }

        .scroll-top.show {
            opacity: 1;
            transform: translateY(0);
        }

        .scroll-top:hover {
            transform: translateY(-4px) scale(1.08);
            background: var(--navy);
        }

        /* =====================================================
           FOOTER (Desain Baru, Modern & Interaktif) - PERSIS EDUKASI.PHP
        ===================================================== */
        footer {
            margin-top: 60px;
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

        /* =====================================================
           RESPONSIVE MEDIA QUERIES
        ===================================================== */
        @media (max-width: 1024px) {
            .features-grid, .modules-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .hero-section {
                grid-template-columns: 1fr;
                padding: 35px 30px;
            }
            .hero-image-wrapper {
                max-width: 100%;
            }
            .keamanan-detail-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 900px) {
            nav {
                width: 95%;
                padding: 0 16px;
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
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
            .stat-item {
                border-right: none;
                border-bottom: 1px solid var(--border);
                padding-bottom: 15px;
            }
            .stat-item:nth-child(3), .stat-item:nth-child(4) {
                border-bottom: none;
            }
        }

        @media (max-width: 576px) {
            nav {
                height: 70px;
            }
            .user-greeting {
                display: none;
            }
            .main-container {
                padding: 0 16px;
                gap: 35px;
            }
            .hero-title {
                font-size: 28px;
            }
            .features-grid, .modules-grid, .keamanan-detail-grid {
                grid-template-columns: 1fr;
            }
            .keamanan-tabs-wrapper {
                flex-direction: column;
            }
            .cta-banner {
                padding: 28px 24px;
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

<!-- HEADER (Floating Glassmorphism) - PERSIS EDUKASI.PHP -->
<nav>
    <a href="../BERANDA/beranda.php" style="display:flex; align-items:center; text-decoration:none;">
        <div class="nav-logo">
            <img src="../GAMBAR_GAMBAR/LOGO.png" alt="Logo RUPANTARA">
        </div>
    </a>

    <ul class="nav-links">
        <li><a href="../BERANDA/beranda.php" class="active">Beranda</a></li>
        <li><a href="../TENTANG RUPIAH/tentangrupiah.php">Tentang Rupiah</a></li>
        <li><a href="../MATERI/edukasi.php">Edukasi</a></li>
        <li><a href="../QUIZ/quiz_intro.php">Quiz</a></li>
        <li><a href="../SCANNER/index_copy.php">Scan</a></li>
    </ul>

    <div class="nav-actions">
        <?php if (!$is_logged_in): ?>
            <a href="../LOGIN/login.php" class="btn-login">Login</a>
        <?php endif; ?>

        <a href="#" class="notification-btn" onclick="showToast('Tidak ada notifikasi baru')">
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

<!-- MAIN CONTENT -->
<div class="main-container">

    <!-- 1. HERO SECTION -->
    <section class="hero-section">
        <div>
            <span class="hero-badge"><i data-lucide="sparkles" style="width:14px; height:14px;"></i> Platform Edukasi Keuangan Nusantara</span>
            <h1 class="hero-title">Cinta, Bangga &amp;<br><span>Paham Rupiah</span></h1>
            <p class="hero-desc">Kenali Rupiah lebih dekat, pahami nilai kedaulatannya, dan jadilah generasi emas yang bangga terhadap mata uang resmi Republik Indonesia.</p>
            <div class="btn-row">
                <a href="../SCANNER/index_copy.php" class="btn-fill">Mulai Scan AI <i data-lucide="qr-code" style="width:18px; height:18px;"></i></a>
                <a href="../MATERI/edukasi.php" class="btn-outline">Pelajari Edukasi <i data-lucide="arrow-right" style="width:18px; height:18px;"></i></a>
                <a href="../QUIZ/quiz_intro.php" class="btn-outline" style="border-color: #3B82F6; color: #1D4ED8;">Mulai Quiz <i data-lucide="award" style="width:18px; height:18px;"></i></a>
            </div>
        </div>
        <div class="hero-visual">
            <div class="hero-image-wrapper">
                <img src="../GAMBAR_GAMBAR/gambar_beranda.jpg" alt="Kedaulatan Rupiah">
                <div class="hero-float-badge">
                    <div class="hero-float-icon">
                        <i data-lucide="shield-check" style="width:20px; height:20px;"></i>
                    </div>
                    <div class="hero-float-text">
                        <span class="hero-float-title">Simbol Kedaulatan</span>
                        <span class="hero-float-sub">NKRI &amp; Bank Indonesia</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. QUICK ACCESS CARDS (FITUR UTAMA) -->
    <section>
        <div class="section-header">
            <h2 class="section-title">Fitur Utama RUPANTARA</h2>
            <p class="section-subtitle">Eksplorasi layanan edukasi interaktif untuk mengenal dan menjaga Rupiah</p>
        </div>

        <div class="features-grid">
            <a href="../SCANNER/index_copy.php" class="feature-card">
                <div>
                    <div class="feature-icon-wrapper">
                        <i data-lucide="scan-line" style="width:26px; height:26px;"></i>
                    </div>
                    <h3>Scan AI Rupiah</h3>
                    <p>Deteksi nominal dan ciri keaslian pecahan uang Rupiah secara instan berbasis teknologi AI camera scanner.</p>
                </div>
                <span class="feature-link">Buka Scanner <i data-lucide="arrow-right" style="width:15px; height:15px;"></i></span>
            </a>

            <a href="../MATERI/edukasi.php" class="feature-card">
                <div>
                    <div class="feature-icon-wrapper">
                        <i data-lucide="book-open-check" style="width:26px; height:26px;"></i>
                    </div>
                    <h3>Edukasi &amp; Materi</h3>
                    <p>Pelajari peran Bank Indonesia, ciri pengaman 3D, sejarah uang, serta panduan merawat Rupiah agar tetap layak edar.</p>
                </div>
                <span class="feature-link">Mulai Belajar <i data-lucide="arrow-right" style="width:15px; height:15px;"></i></span>
            </a>

            <a href="../QUIZ/quiz_intro.php" class="feature-card">
                <div>
                    <div class="feature-icon-wrapper">
                        <i data-lucide="trophy" style="width:26px; height:26px;"></i>
                    </div>
                    <h3>Kuis Interaktif</h3>
                    <p>Uji sejauh mana pemahamanmu tentang uang Rupiah melalui kuis interaktif dengan penentuan skor otomatis.</p>
                </div>
                <span class="feature-link">Ikuti Kuis <i data-lucide="arrow-right" style="width:15px; height:15px;"></i></span>
            </a>

            <a href="../TENTANG RUPIAH/tentangrupiah.php" class="feature-card">
                <div>
                    <div class="feature-icon-wrapper">
                        <i data-lucide="landmark" style="width:26px; height:26px;"></i>
                    </div>
                    <h3>Tentang Rupiah</h3>
                    <p>Pahami makna kedaulatan, filosofi gambar pahlawan, serta peran Rupiah dalam stabilitas ekonomi nasional.</p>
                </div>
                <span class="feature-link">Jelajahi <i data-lucide="arrow-right" style="width:15px; height:15px;"></i></span>
            </a>
        </div>
    </section>

    <!-- 3. ANIMATED STATS BAR -->
    <section class="stats-grid">
        <div class="stat-item">
            <div class="stat-number" data-target="10">0</div>
            <div class="stat-label">Soal Quiz Interaktif</div>
        </div>
        <div class="stat-item">
            <div class="stat-number" data-target="6">0</div>
            <div class="stat-label">Modul Materi Edukasi</div>
        </div>
        <div class="stat-item">
            <div class="stat-number" data-target="1000">0</div>
            <div class="stat-label">Pengguna Terdaftar</div>
        </div>
        <div class="stat-item">
            <div class="stat-number" data-target="99">0</div>
            <div class="stat-label">% Akurasi Scanner AI</div>
        </div>
    </section>

    <!-- 4. SECTION KEAMANAN RUPIAH (INTERACTIVE TABS PREVIEW) -->
    <section class="interactive-section">
        <div style="max-width: 600px; margin-bottom: 20px;">
            <span class="hero-badge"><i data-lucide="shield-alert" style="width:14px; height:14px;"></i> Uji Keaslian Instan</span>
            <h2 class="section-title" style="text-align: left;">Kenali Ciri Keaslian Rupiah (3D)</h2>
            <p class="section-subtitle" style="text-align: left;">Terapkan metode sederhana 3D: Dilihat, Diraba, dan Diterawang untuk membedakan uang Rupiah asli dari uang palsu.</p>
        </div>

        <div class="keamanan-tabs-wrapper">
            <button class="keamanan-tab-btn active" onclick="switchKeamananTab(0)"><i data-lucide="eye" style="width:18px; height:18px;"></i> 1. Dilihat</button>
            <button class="keamanan-tab-btn" onclick="switchKeamananTab(1)"><i data-lucide="hand" style="width:18px; height:18px;"></i> 2. Diraba</button>
            <button class="keamanan-tab-btn" onclick="switchKeamananTab(2)"><i data-lucide="sun" style="width:18px; height:18px;"></i> 3. Diterawang</button>
        </div>

        <div class="keamanan-content-box">
            <!-- TAB 1: DILIHAT -->
            <div class="keamanan-tab-content" id="tab-dilihat" style="display: block;">
                <div class="keamanan-detail-grid">
                    <div class="keamanan-card">
                        <img src="../GAMBAR_GAMBAR/perubahan warna.jpg" alt="Optically Variable Ink">
                        <h4>Perubahan Warna (OVI)</h4>
                        <p>Logo BI di dalam perisai akan berubah warna secara visual jika dilihat dari sudut pandang yang berbeda.</p>
                    </div>
                    <div class="keamanan-card">
                        <img src="../GAMBAR_GAMBAR/benang pengaman.jpg" alt="Benang Pengaman">
                        <h4>Benang Pengaman</h4>
                        <p>Disematkan di dalam kertas uang, dapat memantulkan warna berbeda jika digoyang-goyangkan.</p>
                    </div>
                    <div class="keamanan-card">
                        <img src="../GAMBAR_GAMBAR/uang_50000.jpg" alt="Warna Cerah">
                        <h4>Cetak Warna Cerah</h4>
                        <p>Warna uang asli sangat tegas, kontras, dan presisi tinggi sehingga tidak buram saat dilihat.</p>
                    </div>
                </div>
            </div>

            <!-- TAB 2: DIRABA -->
            <div class="keamanan-tab-content" id="tab-diraba" style="display: none;">
                <div class="keamanan-detail-grid">
                    <div class="keamanan-card">
                        <img src="../GAMBAR_GAMBAR/Cetakan terasa kasar.jpg" alt="Cetak Intaglio">
                        <h4>Hasil Cetak Intaglio</h4>
                        <p>Bagian gambar pahlawan, angka nominal, dan tulisan BANK INDONESIA terasa kasar saat diraba.</p>
                    </div>
                    <div class="keamanan-card">
                        <img src="../GAMBAR_GAMBAR/kode tuna netra.jpg" alt="Blind Code">
                        <h4>Kode Tuna Netra</h4>
                        <p>Sepasang garis timbul di pinggir uang kertas untuk mempermudah penyandang tuna netra mengenali nominal.</p>
                    </div>
                    <div class="keamanan-card">
                        <img src="../GAMBAR_GAMBAR/uang_100000.jpg" alt="Tekstur Kertas">
                        <h4>Kertas Khusus Serat</h4>
                        <p>Uang asli terbuat dari serat kapas pilihan yang terasa tebal, lentur, dan khas saat dipegang.</p>
                    </div>
                </div>
            </div>

            <!-- TAB 3: DITERAWANG -->
            <div class="keamanan-tab-content" id="tab-diterawang" style="display: none;">
                <div class="keamanan-detail-grid">
                    <div class="keamanan-card">
                        <img src="../GAMBAR_GAMBAR/watermark tanda air.jpg" alt="Tanda Air Watermark">
                        <h4>Tanda Air (Watermark)</h4>
                        <p>Saat diterawang ke arah cahaya, akan muncul gambar pahlawan nasional dan ornamen logo BI yang halus.</p>
                    </div>
                    <div class="keamanan-card">
                        <img src="../GAMBAR_GAMBAR/rectroverso.jpg" alt="Gambar Saling Isi">
                        <h4>Rectoverso (Saling Isi)</h4>
                        <p>Logo BI di sisi depan dan belakang saling melengkapi secara presisi membentuk logo BI utuh saat diterawang.</p>
                    </div>
                    <div class="keamanan-card">
                        <img src="../GAMBAR_GAMBAR/memeriksa_uang.jpg" alt="Pemeriksaan Cahaya">
                        <h4>Presisi Bayangan</h4>
                        <p>Elemen grafis micro-text dan elemen tersembunyi akan tampak jelas hanya bila disinari cahaya terang.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. JELAJAHI MODUL EDUKASI UTAMA -->
    <section>
        <div class="section-header">
            <h2 class="section-title">Modul Edukasi Unggulan</h2>
            <p class="section-subtitle">Pelajari berbagai materi menarik untuk memperluas wawasan keuanganmu</p>
        </div>

        <div class="modules-grid">
            <a href="../MATERI/edukasi.php" class="module-card">
                <div class="module-img-box">
                    <img src="../GAMBAR_GAMBAR/uang.jpg" alt="Mengenal Rupiah">
                </div>
                <div class="module-body">
                    <span class="module-badge">Modul 01</span>
                    <h4>Mengenal Rupiah</h4>
                    <p>Pahami definisi, fungsi utama, dan peran strategis Rupiah dalam perekonomian bangsa.</p>
                    <span class="module-read">Baca Selengkapnya <i data-lucide="chevron-right" style="width:14px; height:14px;"></i></span>
                </div>
            </a>

            <a href="../MATERI/edukasi.php" class="module-card">
                <div class="module-img-box">
                    <img src="../GAMBAR_GAMBAR/bank_indonesia.png" alt="Bank Indonesia">
                </div>
                <div class="module-body">
                    <span class="module-badge">Modul 02</span>
                    <h4>Bank Indonesia</h4>
                    <p>Mengenal lebih dekat peran bank sentral independen dalam menjaga stabilitas nilai mata uang.</p>
                    <span class="module-read">Baca Selengkapnya <i data-lucide="chevron-right" style="width:14px; height:14px;"></i></span>
                </div>
            </a>

            <a href="../MATERI/edukasi.php" class="module-card">
                <div class="module-img-box">
                    <img src="../GAMBAR_GAMBAR/kumpulan_uang_lama.jpg" alt="Sejarah Rupiah">
                </div>
                <div class="module-body">
                    <span class="module-badge">Modul 04</span>
                    <h4>Sejarah Rupiah</h4>
                    <p>Menelusuri jejak perkembangan alat pembayaran dari masa kerajaan Nusantara hingga era modern.</p>
                    <span class="module-read">Baca Selengkapnya <i data-lucide="chevron-right" style="width:14px; height:14px;"></i></span>
                </div>
            </a>

            <a href="../MATERI/edukasi.php" class="module-card">
                <div class="module-img-box">
                    <img src="../GAMBAR_GAMBAR/cbdc_digital.png" alt="Rupiah Digital">
                </div>
                <div class="module-body">
                    <span class="module-badge">Modul 06</span>
                    <h4>Rupiah Digital (CBDC)</h4>
                    <p>Mengenal transformasi inovasi uang digital masa depan yang dirancang oleh Bank Indonesia.</p>
                    <span class="module-read">Baca Selengkapnya <i data-lucide="chevron-right" style="width:14px; height:14px;"></i></span>
                </div>
            </a>
        </div>
    </section>

    <!-- 6. QUIZ CTA BANNER -->
    <section class="cta-banner">
        <div>
            <h3>Uji Pengetahuanmu Tentang Rupiah!</h3>
            <p>Sudah seberapa jauh kamu mengenal Rupiah? Yuk ikuti kuis interaktif 10 soal dan dapatkan skor penilaian otomatis.</p>
        </div>
        <a href="../QUIZ/quiz_intro.php" class="btn-white">Mulai Quiz Sekarang <i data-lucide="arrow-right" style="width:16px; height:16px;"></i></a>
    </section>

</div>

<!-- Scroll to top button -->
<button class="scroll-top" id="scrollTop" onclick="window.scrollTo({top:0, behavior:'smooth'})">
    <i data-lucide="arrow-up" style="width:20px; height:20px;"></i>
</button>

<!-- Toast notification container -->
<div id="toastContainer"></div>

<!-- FOOTER - PERSIS EDUKASI.PHP -->
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

<script>
    // Initialize Lucide Icons
    lucide.createIcons();

    // Tab Switcher for Ciri Keamanan (3D)
    function switchKeamananTab(tabIndex) {
        const tabs = document.querySelectorAll(".keamanan-tab-btn");
        const contents = document.querySelectorAll(".keamanan-tab-content");

        tabs.forEach((tab, index) => {
            if (index === tabIndex) {
                tab.classList.add("active");
                contents[index].style.display = "block";
            } else {
                tab.classList.remove("active");
                contents[index].style.display = "none";
            }
        });
        lucide.createIcons();
    }

    // Toast Notifications
    function showToast(msg) {
        const t = document.createElement('div');
        t.className = 'toast';
        t.innerHTML = '<i data-lucide="info" style="width:18px; height:18px; color:var(--blue-dark);"></i><span>' + msg + '</span>';
        document.getElementById('toastContainer').appendChild(t);
        lucide.createIcons();
        setTimeout(() => {
            t.classList.add('hiding');
            setTimeout(() => t.remove(), 300);
        }, 3000);
    }

    // Animated Counter for Stats Bar
    const countObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = parseInt(el.dataset.target);
                let current = 0;
                const step = Math.max(1, Math.floor(target / 40));
                const interval = setInterval(() => {
                    current += step;
                    if (current >= target) {
                        current = target;
                        clearInterval(interval);
                    }
                    el.textContent = current.toLocaleString() + (target >= 1000 ? '+' : '');
                }, 25);
                countObserver.unobserve(el);
            }
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('.stat-number').forEach(el => countObserver.observe(el));

    // Scroll To Top Button
    const scrollTopBtn = document.getElementById('scrollTop');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 350) {
            scrollTopBtn.classList.add('show');
        } else {
            scrollTopBtn.classList.remove('show');
        }
    });
</script>

</body>
</html>