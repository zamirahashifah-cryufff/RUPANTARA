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

    <title>RUPANTARA - Edukasi</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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
        }

        /* =====================================================
           HEADER (Floating Glassmorphism style)
        ===================================================== */
        nav {
            width: 90%;
            max-width: 1300px;
            height: 80px; /* Desain lebih ramping dan dinamis */
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            display: flex;
            align-items: center;
            padding: 0 28px;
            gap: 20px;
            position: sticky;
            top: 20px; /* Melayang dari batas atas */
            margin: 0 auto;
            border-radius: 20px;
            z-index: 999;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 12px 30px rgba(0, 48, 135, 0.06);
            transition: all 0.3s ease;
        }

        /* LOGO HEADER */
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

        /* MENU (Dengan Desain Pill Bar) */
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

        /* ACTION HEADER */
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        /* LOGIN BUTTON (Lebih presisi & berefek hover interaktif) */
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

        /* NOTIFICATION */
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

        /* USER AREA (Pill design) */
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
           LAYOUT & CONTENT (Disesuaikan untuk navbar melayang)
        ===================================================== */
        .container {
            max-width: 1200px;
            margin: 60px auto 40px; /* Jarak atas ditambah agar tidak tertutup navbar */
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 40px;
            padding: 0 20px;
        }

        .sidebar-materi {
            background: #F4F7FC;
            border-radius: 20px;
            padding: 25px;
            height: fit-content;
            position: sticky;
            top: 130px; /* Diturunkan sedikit menyesuaikan tinggi baru navbar */
        }

        .sidebar-materi h2 { color: #003087; font-size: 24px; font-weight: 800; }
        .sidebar-materi .subtitle { font-size: 14px; color: var(--muted); margin-top: 4px; }

        .materi-list { display: flex; flex-direction: column; gap: 10px; margin-top: 15px;}

        .materi-item {
            display: flex; align-items: center; gap: 20px; padding: 15px 20px;
            border-radius: 14px; color: var(--text); text-decoration: none;
            font-size: 14px; font-weight: 500; cursor: pointer; transition: .3s;
        }

        .materi-item.active { background: white; box-shadow: 0 5px 15px rgba(0,0,0,.06); font-weight: 700; color: var(--blue-dark); }
        .materi-item:hover { background: rgba(255,255,255,.6); }

        .content-card { background: white; border-radius: 20px; padding: 35px; box-shadow: 0 5px 25px rgba(0,0,0,.02); animation: fadeIn .5s ease; }

        .hero-banner {
            width: 100%; min-height: 250px; border-radius: 15px;
            background-size: cover; background-position: center;
            display: flex; flex-direction: column; justify-content: center;
            padding: 40px; color: white; margin-bottom: 30px;
        }

        .hero-banner h1 { font-size: 36px; font-weight: 800; }

        .title-h1 { font-size: 34px; font-weight: 800; color: #003087; margin-bottom: 15px; }

        /* =====================================================
           SHARED PAGE COMPONENTS
        ===================================================== */
        .page-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: #EAF2FF; color: var(--blue-dark);
            padding: 6px 16px; border-radius: 20px;
            font-size: 12px; font-weight: 700; margin-bottom: 14px;
            text-transform: uppercase; letter-spacing: .4px;
        }
        .page-badge i { width: 14px; height: 14px; }

        .lead-text { color: var(--muted); font-size: 15px; margin-bottom: 18px; }

        .btn-fill {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--blue-dark); color: #fff; text-decoration: none;
            padding: 13px 26px; border-radius: 30px; font-weight: 700; font-size: 14px;
            transition: .25s;
        }
        .btn-fill:hover { background: var(--navy-dark); }
        .btn-outline {
            display: inline-flex; align-items: center; gap: 8px;
            border: 2px solid var(--blue-dark); color: var(--blue-dark); text-decoration: none;
            padding: 11px 24px; border-radius: 30px; font-weight: 700; font-size: 14px;
        }
        .btn-row { display: flex; gap: 14px; margin-top: 22px; flex-wrap: wrap; }

        .quote-box {
            background: #F4F7FC; border-left: 4px solid var(--blue);
            padding: 18px 22px; border-radius: 10px;
            font-style: italic; color: #334155; margin: 22px 0; font-size: 14px;
        }

        .top-grid { display: grid; grid-template-columns: 1fr 260px; gap: 35px; align-items: start; }
        @media (max-width: 900px) { .top-grid { grid-template-columns: 1fr; } }

        .toc-box { background: #F4F7FC; border-radius: 18px; padding: 22px; }
        .toc-box h4 { font-size: 12px; text-transform: uppercase; color: var(--muted); letter-spacing: .5px; margin-bottom: 14px; }
        .toc-box a { display: block; padding: 9px 12px; border-radius: 9px; font-size: 13px; color: #334155; text-decoration: none; margin-bottom: 3px; }
        .toc-box a.active { background: #DBEAFE; color: var(--blue-dark); font-weight: 700; }
        .toc-progress { margin-top: 18px; }
        .toc-progress span.label { font-size: 11px; font-weight: 700; color: var(--navy); }
        .progress-track { height: 6px; background: #E2E8F0; border-radius: 10px; margin-top: 8px; overflow: hidden; }
        .progress-fill { height: 100%; background: var(--blue-dark); border-radius: 10px; }

        .card-grid { display: grid; gap: 20px; margin: 26px 0; }
        .card-grid.cols-2 { grid-template-columns: 1fr 1fr; }
        .card-grid.cols-3 { grid-template-columns: repeat(3, 1fr); }
        @media (max-width: 700px) { .card-grid.cols-2, .card-grid.cols-3 { grid-template-columns: 1fr; } }

        .info-card { background: #fff; border: 1px solid var(--border); border-radius: 16px; padding: 24px; }
        .icon-circle {
            width: 44px; height: 44px; border-radius: 12px; background: #EAF2FF; color: var(--blue-dark);
            display: flex; align-items: center; justify-content: center; margin-bottom: 14px;
        }
        .icon-circle.orange { background: #FFF1E6; color: #C2610B; }
        .info-card h4 { font-size: 16px; font-weight: 700; margin-bottom: 8px; color: #0F2942; }
        .info-card p { color: var(--muted); font-size: 13.5px; }

        .checklist { list-style: none; margin-top: 12px; display: flex; flex-direction: column; gap: 9px; }
        .checklist li { display: flex; align-items: center; gap: 9px; font-size: 13.5px; color: #334155; }
        .checklist li i { color: #22C55E; width: 17px; height: 17px; flex-shrink: 0; }

        .section-heading { font-size: 22px; font-weight: 800; color: #003087; margin: 30px 0 6px; }
        .section-sub { color: var(--muted); font-size: 13.5px; margin-bottom: 18px; }

        .split-block { display: grid; grid-template-columns: 1fr 1fr; gap: 35px; align-items: center; margin: 24px 0; }
        .split-block img { width: 100%; border-radius: 16px; object-fit: cover; }
        @media (max-width: 800px) { .split-block { grid-template-columns: 1fr; } }

        .illus-box {
            border-radius: 18px; min-height: 220px; position: relative;
            background: linear-gradient(135deg,#EAF2FF,#DCEBFF);
            display: flex; align-items: center; justify-content: center; color: var(--blue-dark);
        }
        .illus-box i { width: 64px; height: 64px; opacity: .55; }
        .float-badge {
            position: absolute; top: -14px; left: -14px; background: #fff; border-radius: 14px;
            box-shadow: 0 8px 20px rgba(0,0,0,.1); padding: 10px 16px; display: flex; align-items: center; gap: 10px;
            font-size: 12px; font-weight: 700; color: var(--navy);
        }
        .float-badge .icon-circle { margin-bottom: 0; width: 30px; height: 30px; }

        .mini-nav { background: #F4F7FC; border-radius: 16px; padding: 20px; }
        .mini-nav h4 { font-size: 12px; text-transform: uppercase; color: var(--muted); letter-spacing: .5px; margin-bottom: 12px; }
        .mini-nav a { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 10px; color: #334155; text-decoration: none; font-size: 13.5px; font-weight: 500; margin-bottom: 4px; }
        .mini-nav a i { width: 16px; height: 16px; }
        .mini-nav a.active { background: #fff; color: var(--blue-dark); font-weight: 700; box-shadow: 0 3px 10px rgba(0,0,0,.05); }

        .callout-box { background: #EAF2FF; border-radius: 16px; padding: 22px; display: flex; gap: 16px; margin: 22px 0; }
        .callout-box i { color: var(--blue-dark); flex-shrink: 0; width: 24px; height: 24px; }
        .callout-box h4 { font-size: 14.5px; color: var(--navy); margin-bottom: 4px; }
        .callout-box p { font-size: 13.5px; color: #3A5A80; }

        .method-3d { display: grid; grid-template-columns: repeat(3,1fr); gap: 14px; margin: 22px 0; }
        .method-3d .box { background: #F4F7FC; border-radius: 12px; padding: 16px; }
        .method-3d .box .icon-circle { width: 34px; height: 34px; border-radius: 9px; margin-bottom: 10px; }
        .method-3d .box strong { display: block; color: var(--navy); margin-bottom: 6px; font-size: 13.5px; }
        .method-3d .box p { font-size: 12px; color: var(--muted); }
        @media (max-width: 700px) { .method-3d { grid-template-columns: 1fr; } }

        .cta-banner {
            background: linear-gradient(120deg, var(--navy), var(--blue-dark)); border-radius: 20px;
            padding: 34px 38px; color: #fff; display: flex; justify-content: space-between;
            align-items: center; gap: 20px; margin-top: 34px; flex-wrap: wrap;
        }
        .cta-banner h3 { font-size: 20px; margin-bottom: 6px; }
        .cta-banner p { color: #CFE3FA; font-size: 13.5px; }
        .btn-white { background: #fff; color: var(--blue-dark); padding: 12px 24px; border-radius: 30px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; white-space: nowrap; }

        .timeline-block { margin-bottom: 30px; }
        .timeline-block h3 { display: flex; align-items: center; gap: 12px; font-size: 18px; color: var(--navy); font-weight: 800; margin-bottom: 10px; }
        .timeline-block h3 span.num { width: 32px; height: 32px; border-radius: 50%; background: var(--blue-dark); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0; }
        .timeline-block p.desc { color: var(--muted); font-size: 13.5px; margin-bottom: 14px; }

        .timeline-photos { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 6px; }
        .timeline-photos figure { background: #F4F7FC; border-radius: 14px; overflow: hidden; }
        .timeline-photos .ph-icon { height: 100px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg,#EAF2FF,#DCEBFF); color: var(--blue-dark); }
        .timeline-photos .ph-icon i { width: 34px; height: 34px; }
        .timeline-photos figcaption { padding: 10px 14px; font-size: 12px; color: var(--muted); font-weight: 600; }

        .colonial-card { display: flex; gap: 18px; background: #F4F7FC; border-radius: 16px; padding: 18px; align-items: center; }
        .colonial-card .ph-icon { width: 90px; height: 70px; border-radius: 10px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg,#EAF2FF,#DCEBFF); color: var(--blue-dark); }
        .colonial-card .ph-icon i { width: 28px; height: 28px; }
        .colonial-card h5 { font-size: 14px; color: #0F2942; margin-bottom: 4px; }
        .colonial-card p { font-size: 12.5px; color: var(--muted); margin-bottom: 8px; }

        .tag-pill { display: inline-block; background: #FEE2E2; color: #B91C1C; font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 20px; margin-right: 6px; }
        .tag-pill.blue { background: #DBEAFE; color: var(--blue-dark); }

        .sub-events { margin-top: 14px; border-left: 2px solid var(--border); padding-left: 20px; display: flex; flex-direction: column; gap: 16px; }
        .sub-events .ev-date { font-size: 11px; font-weight: 700; color: var(--blue-dark); letter-spacing: .5px; }
        .sub-events .ev-title { font-weight: 700; color: #0F2942; margin: 2px 0; font-size: 14px; }
        .sub-events .ev-desc { font-size: 12.5px; color: var(--muted); }

        .prevnext { display: flex; justify-content: space-between; margin-top: 35px; padding-top: 22px; border-top: 1px solid var(--border); }
        .prevnext a { text-decoration: none; color: var(--muted); font-size: 12px; }
        .prevnext a strong { display: block; color: var(--blue-dark); font-size: 14px; margin-top: 3px; }
        .prevnext .next { text-align: right; }
        .prevnext .disabled { opacity: .4; pointer-events: none; }

        .care-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 26px 0; }
        @media (max-width: 700px) { .care-grid { grid-template-columns: 1fr; } }
        .care-card { border: 1px solid var(--border); border-radius: 16px; padding: 24px; }
        .care-card.highlight { grid-column: 1 / -1; background: var(--navy); color: #fff; border: none; }
        .care-card.highlight .icon-circle { background: rgba(255,255,255,.15); color: #fff; }
        .care-card.highlight p { color: #CFE3FA; }
        .care-tags { display: flex; gap: 10px; margin-top: 16px; flex-wrap: wrap; }
        .care-tags span { background: rgba(255,255,255,.15); padding: 7px 16px; border-radius: 20px; font-size: 12px; font-weight: 600; }

        .tip-box { display: flex; gap: 12px; background: #FFF8E1; border-radius: 14px; padding: 16px 18px; margin-top: 18px; font-size: 13px; color: #7A5B00; }
        .tip-box i { color: #D97706; flex-shrink: 0; width: 20px; height: 20px; }
        .tip-box strong { color: #92650A; }

        .digital-grid { display: grid; grid-template-columns: 1.15fr .85fr; gap: 20px; margin: 26px 0; }
        @media (max-width: 800px) { .digital-grid { grid-template-columns: 1fr; } }
        .digital-card { border-radius: 16px; padding: 26px; }
        .digital-card.white { background: #fff; border: 1px solid var(--border); }
        .digital-card.blue { background: var(--blue-dark); color: #fff; }
        .digital-card.blue h4 { color: #fff; }
        .digital-card.blue .checklist li { color: #E3F0FF; }
        .digital-card.blue .checklist li i { color: #7DD3FC; }
        .read-more { color: var(--blue-dark); font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; margin-top: 10px; }

        .payment-section { display: grid; grid-template-columns: 1fr 1fr; gap: 35px; align-items: center; margin: 28px 0; }
        @media (max-width: 800px) { .payment-section { grid-template-columns: 1fr; } }
        .payment-section img { width: 100%; border-radius: 16px; }

        .hero-photo-caption {
            position: relative; border-radius: 15px; overflow: hidden; margin-bottom: 30px; min-height: 250px;
        }
        .hero-photo-caption img { width: 100%; height: 250px; object-fit: cover; display: block; }
        .hero-photo-caption .cap {
            position: absolute; bottom: 0; left: 0; right: 0; padding: 18px 24px;
            background: linear-gradient(0deg, rgba(0,0,0,.65), transparent); color: #fff; font-weight: 700; font-size: 14px;
        }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

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

        /* BRAND COLUMN */
        .footer-brand-card {
            width: 150px; /* Lebar disesuaikan agar lebih proporsional */
            height: 54px; /* Tinggi disesuaikan */
            background: #FFFFFF; /* Diubah ke Putih Solid agar logo terlihat jelas */
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            padding: 6px 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15); /* Ditambahkan bayangan lembut untuk efek dimensi */
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

        /* HEADER KOLOM FOOTER */
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

        /* LINK NAVIGASI FOOTER */
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

        /* HUBUNGI KAMI */
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

        /* SUB-FOOTER BOTTOM */
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

        @media(max-width:900px) {
            nav { width: 95%; padding: 0 16px; }
            .container { grid-template-columns: 1fr; margin-top: 30px; }
            .nav-links { display: none; }
            .footer-main { grid-template-columns: 1fr; gap: 45px; }
            .footer-bottom { justify-content: center; text-align: center; flex-direction: column-reverse; }
        }
    </style>
</head>

<body>

<!-- HEADER (Floating Glassmorphism) -->
<nav>
    <a href="#" style="display:flex; align-items:center; text-decoration:none;">
        <div class="nav-logo">
            <!-- LOGO DIAMBIL DARI FOLDER GAMBAR_GAMBAR -->
            <img src="../GAMBAR_GAMBAR/LOGO.png" alt="Logo RUPANTARA">
        </div>
    </a>

    <ul class="nav-links">
        <li><a href="#">Beranda</a></li>
        <li><a href="../TENTANG RUPIAH/tentangrupiah.html">Tentang Rupiah</a></li>
        <li><a href="../MATERI/edukasi.php" class="active">Edukasi</a></li>
        <li><a href="../SCANNER/index.html">Scan</a></li>
    </ul>

    <div class="nav-actions">
        <!-- Menggunakan PHP untuk menentukan apakah tombol Login perlu ditampilkan -->
        <?php if (!$is_logged_in): ?>
            <a href="../LOGIN/login.php" class="btn-login">Login</a>
        <?php endif; ?>

        <a href="#" class="notification-btn">
            <i data-lucide="bell" style="width:18px; height:18px;"></i>
            <span class="notification-dot"></span>
        </a>
        <div class="nav-divider"></div>
        <div class="user-area">
            <div class="user-icon">
                <i data-lucide="user-round" style="width:16px; height:16px;"></i>
            </div>
            <!-- Nama pengguna ditampilkan secara dinamis dari Session -->
            <span class="user-greeting">Halo, <?php echo htmlspecialchars($display_username); ?></span>
        </div>
    </div>
</nav>

<!-- CONTENT -->
<div class="container">
    <aside class="sidebar-materi">
        <h2>Materi</h2>
        <p class="subtitle">Panduan Mengenal Rupiah</p>
        <div class="materi-list">
            <a class="materi-item active" onclick="showMateri(0)"><i data-lucide="list"></i>Mengenal Rupiah</a>
            <a class="materi-item" onclick="showMateri(1)"><i data-lucide="landmark"></i>Bank Indonesia</a>
            <a class="materi-item" onclick="showMateri(2)"><i data-lucide="shield-check"></i>Ciri Keamanan</a>
            <a class="materi-item" onclick="showMateri(3)"><i data-lucide="clock"></i>Sejarah Rupiah</a>
            <a class="materi-item" onclick="showMateri(4)"><i data-lucide="heart"></i>Cara Merawat</a>
            <a class="materi-item" onclick="showMateri(5)"><i data-lucide="star"></i>Bangga Rupiah</a>
        </div>
    </aside>

    <main class="content-card" id="content"></main>
</div>

<!-- FOOTER -->
<footer>
    <div class="footer-main">
        <div class="footer-column">
            <div class="footer-brand-card">
                <!-- LOGO DIAMBIL DARI FOLDER GAMBAR_GAMBAR -->
                <img src="../GAMBAR_GAMBAR/LOGO.png" alt="Logo RUPANTARA">
            </div>
            <div class="footer-title">RUP<span>ANTARA</span></div>
            <p class="footer-desc">Ruang Pintar Nusantara (RUPANTARA) adalah platform edukasi keuangan masa depan yang membantu mengenali kedaulatan, nilai, dan keamanan mata uang Rupiah secara interaktif.</p>
        </div>
        <div class="footer-column">
            <h3>NAVIGASI</h3>
            <div class="footer-nav">
                <a href="#"><i data-lucide="chevron-right" style="width:14px; height:14px;"></i>Beranda</a>
                <a href="../TENTANG RUPIAH/tentangrupiah.html"><i data-lucide="chevron-right" style="width:14px; height:14px;"></i>Tentang Rupiah</a>
                <a href="../MATERI/edukasi.php"><i data-lucide="chevron-right" style="width:14px; height:14px;"></i>Edukasi</a>
                <a href="../SCANNER/index.html"><i data-lucide="chevron-right" style="width:14px; height:14px;"></i>Scan</a>
            </div>
        </div>
        <div class="footer-column">
            <h3>HUBUNGI KAMI</h3>
            <div class="footer-contact-list">
                <a href="mailto:info@rupantara.org" class="footer-contact-item">
                    <div class="footer-contact-icon">
                        <i data-lucide="mail" style="width:16px; height:16px;"></i>
                    </div>
                    <span>info@rupantara.org</span>
                </a>
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
// ==========================================================
// DATA MATERI - dipakai untuk navigasi Materi Sebelumnya / Selanjutnya
// ==========================================================
const materiNav = [
    { label: "Mengenal Rupiah", icon: "list" },
    { label: "Bank Indonesia", icon: "landmark" },
    { label: "Ciri Keamanan", icon: "shield-check" },
    { label: "Sejarah Rupiah", icon: "clock" },
    { label: "Cara Merawat", icon: "heart" },
    { label: "Bangga Rupiah", icon: "star" }
];

function prevNextHTML(page) {
    const prev = materiNav[page - 1];
    const next = materiNav[page + 1];
    return `
        <div class="prevnext">
            <a onclick="${prev ? `showMateri(${page - 1})` : ''}" class="${prev ? '' : 'disabled'}">
                MATERI SEBELUMNYA
                <strong>&larr; ${prev ? prev.label : '-'}</strong>
            </a>
            <a onclick="${next ? `showMateri(${page + 1})` : ''}" class="next ${next ? '' : 'disabled'}">
                MATERI SELANJUTNYA
                <strong>${next ? next.label : '-'} &rarr;</strong>
            </a>
        </div>
    `;
}

function showMateri(page) {
    const content = document.getElementById("content");

    // Daftar Path Gambar untuk Hero Banner / konten (disesuaikan folder kamu)
    const imgPath = "../GAMBAR_GAMBAR/";

    // ======================================================
    // 0. MENGENAL RUPIAH
    // ======================================================
    if (page === 0) {
        content.innerHTML = `
            <div class="hero-banner" style="background-image: linear-gradient(rgba(0,0,0,.45), rgba(0,0,0,.45)), url('${imgPath}uang.jpg');">
                <h1>Mengenal Rupiah</h1>
                <p>Simbol kedaulatan bangsa dan jati diri ekonomi Indonesia.</p>
            </div>

            <div class="top-grid">
                <div>
                    <span class="page-badge"><i data-lucide="graduation-cap"></i>Edukasi</span>
                    <h2 class="title-h1">Apa itu Rupiah?</h2>
                    <p class="lead-text">Rupiah adalah mata uang resmi yang berlaku di seluruh wilayah Negara Kesatuan Republik Indonesia (NKRI). Sebagai alat pembayaran yang sah, Rupiah bukan sekadar lembaran kertas atau keping logam, melainkan representasi dari sejarah panjang dan kemandirian bangsa.</p>

                    <div class="quote-box">
                        "Rupiah adalah simbol kedaulatan negara yang wajib kita hormati dan gunakan di setiap transaksi di dalam negeri."
                    </div>

                    <div class="card-grid cols-2">
                        <div class="info-card">
                            <div class="icon-circle"><i data-lucide="book-open"></i></div>
                            <h4>Fungsi Rupiah</h4>
                            <p>Memahami peran dasar uang dalam sistem ekonomi kita.</p>
                            <ul class="checklist">
                                <li><i data-lucide="check-circle"></i>Alat Tukar yang Sah</li>
                                <li><i data-lucide="check-circle"></i>Satuan Hitung Nilai</li>
                                <li><i data-lucide="check-circle"></i>Penyimpan Nilai Kekayaan</li>
                            </ul>
                        </div>
                        <div class="info-card">
                            <div class="icon-circle orange"><i data-lucide="trending-up"></i></div>
                            <h4>Peran Ekonomi</h4>
                            <p>Kontribusi Rupiah terhadap stabilitas makroekonomi.</p>
                            <ul class="checklist">
                                <li><i data-lucide="check-circle"></i>Menjaga Stabilitas Harga</li>
                                <li><i data-lucide="check-circle"></i>Mendorong Pertumbuhan</li>
                                <li><i data-lucide="check-circle"></i>Memfasilitasi Investasi</li>
                            </ul>
                        </div>
                    </div>

                    <div class="split-block">
                        <div>
                            <h3 class="section-heading" style="margin-top:0;">Kedaulatan dalam Genggaman</h3>
                            <p class="lead-text">Penggunaan Rupiah di wilayah NKRI merupakan kewajiban hukum yang diatur dalam Undang-Undang No. 7 Tahun 2011. Hal ini bertujuan untuk mendukung terciptanya stabilitas nilai Rupiah dan memperkuat integritas nasional melalui kedaulatan moneter.</p>
                        </div>
                        <div class="illus-box"><i data-lucide="map"></i></div>
                    </div>

                    ${prevNextHTML(0)}
                </div>

                <aside class="toc-box">
                    <h4>Daftar Isi</h4>
                    <a class="active" href="#">Apa itu Rupiah?</a>
                    <a href="#">Fungsi Rupiah</a>
                    <a href="#">Peran Ekonomi</a>
                    <div class="toc-progress">
                        <span class="label">Progres Belajar &nbsp; 35%</span>
                        <div class="progress-track"><div class="progress-fill" style="width:35%;"></div></div>
                    </div>
                </aside>
            </div>
        `;

    // ======================================================
    // 1. BANK INDONESIA
    // ======================================================
    } else if (page === 1) {
        content.innerHTML = `
            <span class="page-badge"><i data-lucide="landmark"></i>Lembaga Negara Independen</span>

            <div class="split-block" style="margin-top:0;">
                <div>
                    <h1 class="title-h1">Bank Indonesia</h1>
                    <p class="lead-text">Mengenal lebih dekat bank sentral Republik Indonesia yang memiliki peran krusial dalam menjaga stabilitas nilai Rupiah dan sistem keuangan nasional.</p>
                </div>
                <div class="hero-split-photo" style="position:relative;">
                    <img src="${imgPath}bank indo.jpg" alt="Gedung Bank Indonesia" style="min-height:220px;">
                    <div class="float-badge">
                        <div class="icon-circle" style="margin-bottom:0;"><i data-lucide="shield-check"></i></div>
                        Status Resmi
                    </div>
                </div>
            </div>

            <div class="top-grid" style="grid-template-columns: 260px 1fr; margin-top:20px;">
                <aside class="mini-nav">
                    <h4>Materi BI</h4>
                    <a class="active"><i data-lucide="landmark"></i>Bank Sentral</a>
                    <a><i data-lucide="list-checks"></i>Tugas BI</a>
                    <a><i data-lucide="shield"></i>Wewenang BI</a>
                    <a><i data-lucide="clock"></i>Riwayat Digital</a>
                </aside>

                <div>
                    <h3 class="section-heading" style="margin-top:0;">BI sebagai Bank Sentral</h3>
                    <p class="lead-text">Bank Indonesia adalah lembaga negara yang independen dalam melaksanakan tugas dan wewenangnya, bebas dari campur tangan Pemerintah dan/atau pihak lain, kecuali untuk hal-hal yang secara tegas diatur dalam undang-undang.</p>

                    <div class="callout-box">
                        <i data-lucide="target"></i>
                        <div>
                            <h4>Tujuan Tunggal</h4>
                            <p>Mencapai dan memelihara kestabilan nilai Rupiah. Kestabilan ini mengandung dua aspek, yaitu kestabilan nilai mata uang terhadap barang dan jasa, serta kestabilan terhadap mata uang negara lain.</p>
                        </div>
                    </div>

                    <h3 class="section-heading">Tugas &amp; Wewenang</h3>
                    <div class="card-grid cols-2" style="margin-top:14px;">
                        <div class="info-card">
                            <h4>Tugas BI</h4>
                            <ol style="margin-top:10px; padding-left:18px; color:var(--muted); font-size:13.5px; display:flex; flex-direction:column; gap:8px;">
                                <li>Menetapkan dan melaksanakan kebijakan moneter</li>
                                <li>Mengatur dan menjaga kelancaran sistem pembayaran</li>
                                <li>Menjaga stabilitas sistem keuangan untuk mendukung pertumbuhan ekonomi</li>
                            </ol>
                        </div>
                        <div class="info-card">
                            <h4>Wewenang BI</h4>
                            <ul class="checklist" style="margin-top:10px;">
                                <li><i data-lucide="check-circle"></i>Menetapkan sasaran moneter dengan memperhatikan laju inflasi</li>
                                <li><i data-lucide="check-circle"></i>Melakukan pengendalian moneter menggunakan instrumen kebijakan</li>
                                <li><i data-lucide="check-circle"></i>Memberikan izin penyelenggaraan jasa sistem pembayaran</li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-grid cols-2">
                        <div style="background:var(--navy); border-radius:16px; display:flex; align-items:center; justify-content:center; min-height:150px;">
                            <div style="width:110px; height:110px; border-radius:50%; background:#fff; display:flex; flex-direction:column; align-items:center; justify-content:center; color:var(--navy-dark); font-weight:800;">
                                <span style="font-size:22px;">BI</span>
                                <span style="font-size:10px; letter-spacing:1px;">BANK INDONESIA</span>
                            </div>
                        </div>
                        <div style="background:var(--blue-dark); border-radius:16px; padding:24px; color:#fff; display:flex; flex-direction:column; justify-content:center;">
                            <span style="font-weight:800; font-size:15px; margin-bottom:8px;">Tahukah Kamu?</span>
                            <p style="font-size:13.5px; color:#CFE3FA; font-style:italic;">"Bank Indonesia merupakan lembaga negara yang independen and bebas dari campur tangan pemerintah dalam pelaksanaan tugasnya."</p>
                        </div>
                    </div>

                    ${prevNextHTML(1)}
                </div>
            </div>
        `;

    // ======================================================
    // 2. CIRI KEAMANAN
    // ======================================================
    } else if (page === 2) {
        content.innerHTML = `
            <span class="page-badge"><i data-lucide="graduation-cap"></i>Pendidikan Keuangan</span>
            <div class="split-block" style="margin-top:0;">
                <div>
                    <h1 class="title-h1">Ciri Keamanan<br>Rupiah</h1>
                    <p class="lead-text">Mengenali keaslian uang Rupiah adalah langkah awal melindungi diri dari peredaran uang palsu. Pelajari fitur canggih yang tersemat di setiap lembar uang kita.</p>
                    <div class="btn-row">
                        <a class="btn-fill" href="#">Mulai Belajar <i data-lucide="arrow-right"></i></a>
                    </div>
                </div>
                <div class="hero-split-photo" style="position:relative;">
                    <div class="illus-box" style="min-height:220px;"><i data-lucide="scan-line"></i></div>
                    <div class="float-badge">
                        <div class="icon-circle" style="margin-bottom:0;"><i data-lucide="lock"></i></div>
                        Aman &amp; Terverifikasi
                    </div>
                </div>
            </div>

            <div class="top-grid" style="grid-template-columns: 260px 1fr; margin-top:20px;">
                <aside class="mini-nav">
                    <h4>Navigasi Materi</h4>
                    <a class="active"><i data-lucide="scan"></i>3D Methodology</a>
                    <a><i data-lucide="minus"></i>Benang Pengaman</a>
                    <a><i data-lucide="printer"></i>Cetak Intaglio</a>
                </aside>

                <div>
                    <h3 class="section-heading" style="margin-top:0;">Metode 3D</h3>
                    <p class="lead-text">Langkah paling mendasar dan mudah untuk mengecek keaslian uang Rupiah adalah dengan metode 3D: Dilihat, Diraba, dan Diterawang.</p>

                    <div class="method-3d">
                        <div class="box">
                            <div class="icon-circle"><i data-lucide="eye"></i></div>
                            <strong>Dilihat</strong>
                            <p>Perhatikan perubahan warna benang pengaman dan gambar khusus dari sudut pandang berbeda.</p>
                        </div>
                        <div class="box">
                            <div class="icon-circle"><i data-lucide="hand"></i></div>
                            <strong>Diraba</strong>
                            <p>Rasakan tekstur kasar pada bagian tertentu hasil cetak intaglio saat diraba dengan jari.</p>
                        </div>
                        <div class="box">
                            <div class="icon-circle"><i data-lucide="sun"></i></div>
                            <strong>Diterawang</strong>
                            <p>Lihat gambar tersembunyi (watermark) dan benang pengaman saat diterawangkan ke cahaya.</p>
                        </div>
                    </div>

                    <div class="card-grid cols-2">
                        <div class="info-card">
                            <img src="${imgPath}uang_50000.jpg" alt="Benang Pengaman" style="width:100%; border-radius:12px; height:110px; object-fit:cover; margin-bottom:14px;">
                            <div class="icon-circle" style="margin-bottom:8px;"><i data-lucide="minus"></i></div>
                            <h4>Benang Pengaman</h4>
                            <p>Disematkan di dalam kertas uang, akan berubah warna jika dilihat dari sudut pandang berbeda.</p>
                        </div>
                        <div class="info-card">
                            <img src="${imgPath}uang_100000.jpg" alt="Cetak Intaglio" style="width:100%; border-radius:12px; height:110px; object-fit:cover; margin-bottom:14px;">
                            <div class="icon-circle" style="margin-bottom:8px;"><i data-lucide="printer"></i></div>
                            <h4>Cetak Intaglio</h4>
                            <p>Teknik cetak khusus yang menghasilkan tekstur timbul pada gambar utama, angka nominal, dan tulisan tertentu.</p>
                        </div>
                    </div>

                    <div class="cta-banner">
                        <div>
                            <h3>Uji Pengetahuanmu!</h3>
                            <p>Sudah paham dengan ciri-ciri keamanan Rupiah? Ayo kuis kecil interaktif untuk mengetes hasil pemahamanmu.</p>
                        </div>
                        <a class="btn-white" href="#">Mulai Quiz <i data-lucide="arrow-right"></i></a>
                    </div>

                    ${prevNextHTML(2)}
                </div>
            </div>
        `;

    // ======================================================
    // 3. SEJARAH RUPIAH
    // ======================================================
    } else if (page === 3) {
        content.innerHTML = `
            <span class="page-badge"><i data-lucide="scroll"></i>Sejarah dan Budaya</span>
            <div class="split-block" style="margin-top:0;">
                <div>
                    <h1 class="title-h1">Menelusuri Jejak<br>Sejarah Rupiah</h1>
                    <p class="lead-text">Perjalanan panjang mata uang Indonesia, dari koin kerajaan hingga menjadi lambang kedaulatan bangsa yang kita kenal sekarang.</p>
                </div>
                <div class="illus-box" style="min-height:200px;"><i data-lucide="coins"></i></div>
            </div>

            <div class="top-grid" style="grid-template-columns: 260px 1fr; margin-top:10px;">
                <aside class="mini-nav">
                    <h4>Navigasi Materi</h4>
                    <a class="active"><i data-lucide="landmark"></i>Masa Kerajaan</a>
                    <a><i data-lucide="ship"></i>Masa Kolonial</a>
                    <a><i data-lucide="flag"></i>Kemerdekaan</a>
                </aside>

                <div>
                    <div class="quote-box">
                        "Yang lama tak akan dilupakan, dan yang baru akan menyambut masa depan."
                    </div>

                    <div class="timeline-block">
                        <h3><span class="num">1</span>Masa Kerajaan (Abad ke-9)</h3>
                        <p class="desc">Sebelum kata Rupiah dikenal, kerajaan-kerajaan di Nusantara telah menggunakan alat tukar berupa koin logam sebagai bagian dari aktivitas ekonomi dan perdagangan.</p>
                        <div class="timeline-photos">
                            <figure>
                                <div class="ph-icon"><i data-lucide="circle-dollar-sign"></i></div>
                                <figcaption>Uang Koin Kerajaan Mataram</figcaption>
                            </figure>
                            <figure>
                                <div class="ph-icon"><i data-lucide="coins"></i></div>
                                <figcaption>Uang Koin Majapahit</figcaption>
                            </figure>
                        </div>
                    </div>

                    <div class="timeline-block">
                        <h3><span class="num">2</span>Era Kolonialisme</h3>
                        <div class="colonial-card">
                            <div class="ph-icon"><i data-lucide="landmark"></i></div>
                            <div>
                                <h5>Gulden Hindia Belanda</h5>
                                <p>Pada masa penjajahan VOC hingga Pemerintah Hindia Belanda, transaksi ekonomi masyarakat didominasi oleh mata uang Gulden.</p>
                                <span class="tag-pill">Devaluasi</span>
                                <span class="tag-pill blue">Krisis</span>
                            </div>
                        </div>
                    </div>

                    <div class="timeline-block">
                        <h3><span class="num">3</span>Lahirnya Rupiah (Kemerdekaan)</h3>
                        <div class="sub-events">
                            <div>
                                <div class="ev-date">29 OKTOBER 1946</div>
                                <div class="ev-title">Penerbitan ORI (Oeang Republik Indonesia)</div>
                                <p class="ev-desc">Baru pada tahun 1946, pemerintah Republik Indonesia menerbitkan mata uang resmi sebagai wujud kedaulatan ekonomi bangsa yang baru merdeka.</p>
                            </div>
                            <div>
                                <div class="ev-date">1953</div>
                                <div class="ev-title">Nasionalisasi Bank Indonesia</div>
                                <p class="ev-desc">Bank Indonesia resmi dinasionalisasi dari De Javasche Bank dan menjadi bank sentral Republik Indonesia.</p>
                            </div>
                        </div>
                    </div>

                    ${prevNextHTML(3)}
                </div>
            </div>
        `;

    // ======================================================
    // 4. CARA MERAWAT
    // ======================================================
    } else if (page === 4) {
        content.innerHTML = `
            <div class="hero-photo-caption">
                <img src="${imgPath}merawat rupiah.jpg" alt="Cara Merawat Rupiah">
                <div class="cap">Cara Merawat Rupiah - RUPANTARA</div>
            </div>

            <span class="page-badge"><i data-lucide="shield-check"></i>5 Jaga</span>
            <h2 class="title-h1">5 Jaga: Cara Merawat Rupiah</h2>
            <p class="lead-text">Sebagai wujud cinta terhadap negara kita, kita wajib menjaga kondisi fisik uang Rupiah agar tetap layak edar dan terhindar dari kerusakan yang tidak perlu.</p>

            <div class="care-grid">
                <div class="care-card">
                    <div class="icon-circle"><i data-lucide="fold-vertical"></i></div>
                    <h4 style="font-size:16px; margin-bottom:8px; color:#0F2942;">Jangan Dilipat</h4>
                    <p style="color:var(--muted); font-size:13.5px;">Lipatan berulang pada uang kertas dapat merusak serat kertas dan mempercepat sobek pada bagian tengah uang.</p>
                </div>
                <div class="care-card">
                    <div class="icon-circle"><i data-lucide="hand-metal"></i></div>
                    <h4 style="font-size:16px; margin-bottom:8px; color:#0F2942;">Jangan Diremas</h4>
                    <p style="color:var(--muted); font-size:13.5px;">Meremas uang menyebabkan kertas kusut and berkerut, sehingga fitur keamanan menjadi sulit dikenali.</p>
                </div>
                <div class="care-card highlight">
                    <div class="icon-circle"><i data-lucide="wallet"></i></div>
                    <h4 style="font-size:17px; margin-bottom:8px;">Simpan dengan Baik</h4>
                    <p style="font-size:13.5px;">Simpan uang di tempat yang kering and bersih, terpisah dari benda tajam atau bahan kimia yang dapat merusak permukaannya.</p>
                    <div class="care-tags">
                        <span>Dompet Khusus</span>
                        <span>Tempat Kering</span>
                    </div>
                </div>
            </div>

            <div class="tip-box">
                <i data-lucide="lightbulb"></i>
                <div><strong>Tips:</strong> Uang yang dilipat atau kotor tidak akan langsung rusak, tapi menjaga uang tetap dalam kondisi baik akan membuatnya lebih awet dan mudah dikenali keasliannya.</div>
            </div>

            ${prevNextHTML(4)}
        `;

    // ======================================================
    // 5. BANGGA RUPIAH (Rupiah Digital)
    // ======================================================
    } else if (page === 5) {
        content.innerHTML = `
            <span class="page-badge"><i data-lucide="sparkles"></i>Inovasi Bank Sentral</span>
            <div class="split-block" style="margin-top:0;">
                <div>
                    <h1 class="title-h1">Rupiah Digital: Masa Depan Kedaulatan Ekonomi</h1>
                    <p class="lead-text">Meskipun Central Bank Digital Currency (CBDC) masih dalam tahap pengembangan, Rupiah Digital hadir sebagai representasi transformasi masa depan sistem pembayaran nasional, sekaligus wujud kebanggaan dan kedaulatan ekonomi kita.</p>
                    <div class="btn-row">
                        <a class="btn-fill" href="#">Eksplorasi Sekarang <i data-lucide="arrow-right"></i></a>
                        <a class="btn-outline" href="#">Whitepaper</a>
                    </div>
                </div>
                <img src="${imgPath}cbdc_digital.png" alt="Rupiah Digital">
            </div>

            <h3 class="section-heading">Memahami Ekosistem Digital</h3>
            <p class="section-sub">Fungsi lapisan teknologi Rupiah Digital yang mendukung sistem keuangan masa depan.</p>

            <div class="digital-grid">
                <div class="digital-card white">
                    <div class="icon-circle"><i data-lucide="info"></i></div>
                    <h4>Apa itu CBDC?</h4>
                    <p style="color:var(--muted); font-size:13.5px;">Central Bank Digital Currency (CBDC) adalah representasi digital dari mata uang resmi suatu negara yang diterbitkan dan dijamin langsung oleh bank sentral, berbeda dengan aset kripto pada umumnya.</p>
                    <a class="read-more" href="#">Baca Selengkapnya <i data-lucide="arrow-right" style="width:14px;height:14px;"></i></a>
                </div>
                <div class="digital-card blue">
                    <h4 style="font-size:16.5px; font-weight:700; margin-bottom:8px;">Manfaat Rupiah Digital</h4>
                    <ul class="checklist">
                        <li><i data-lucide="check-circle"></i>Efisiensi Transaksi</li>
                        <li><i data-lucide="check-circle"></i>Pengawasan Transaksi</li>
                        <li><i data-lucide="check-circle"></i>Inklusi Keuangan</li>
                        <li><i data-lucide="check-circle"></i>Stabilitas Moneter</li>
                    </ul>
                </div>
            </div>

            <div class="payment-section">
                <img src="${imgPath}infrastruktur_modern.png" alt="Infrastruktur Pembayaran Modern">
                <div>
                    <h3 class="section-heading" style="margin-top:0;">Masa Depan Pembayaran</h3>
                    <p class="lead-text">Penerapan Rupiah Digital akan didukung infrastruktur pembayaran modern yang menghubungkan seluruh lapisan masyarakat, dari perkotaan hingga pelosok negeri, menuju sistem keuangan yang lebih cepat, aman, dan inklusif.</p>
                </div>
            </div>

            <div class="callout-box">
                <i data-lucide="lightbulb"></i>
                <div>
                    <h4>Pro-Tip Pemahaman</h4>
                    <p>Rupiah Digital bukanlah pengganti uang tunai, melainkan pelengkap yang memperluas kanal pembayaran resmi milik Bank Indonesia.</p>
                </div>
            </div>

            <h3 class="section-heading">Alur Kerja Digital</h3>
            <p class="lead-text">Implementasi Rupiah Digital akan dilakukan secara bertahap oleh Bank Indonesia melalui skema "Garuda", mempertimbangkan aspek keamanan siber, edukasi masyarakat, dan kesiapan infrastruktur digital nasional secara menyeluruh.</p>

            ${prevNextHTML(5)}
        `;
    }

    // Aktifkan Sidebar
    const items = document.querySelectorAll(".materi-item");
    items.forEach(item => item.classList.remove("active"));
    if(items[page]) items[page].classList.add("active");

    window.scrollTo({ top: 0, behavior: "smooth" });
    lucide.createIcons();
}

showMateri(0);
lucide.createIcons();
</script>

</body>
</html>