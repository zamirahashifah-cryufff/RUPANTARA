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
            font-size: 15px;
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

        /* =====================================================
           LAYOUT & CONTENT (Responsive Layout Grid)
        ===================================================== */
        .container {
            width: 100%;
            max-width: 1300px;
            margin: 50px auto;
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 30px;
            padding: 0 24px;
        }

        .sidebar-materi {
            background: #F4F7FC;
            border-radius: 20px;
            padding: 24px;
            height: fit-content;
            position: sticky;
            top: 130px;
            transition: all 0.3s ease;
        }

        .sidebar-materi h2 { color: #003087; font-size: 24px; font-weight: 800; }
        .sidebar-materi .subtitle { font-size: 14px; color: var(--muted); margin-top: 4px; }

        .materi-list { display: flex; flex-direction: column; gap: 8px; margin-top: 15px;}

        .materi-item {
            display: flex; align-items: center; gap: 15px; padding: 12px 18px;
            border-radius: 12px; color: var(--text); text-decoration: none;
            font-size: 14px; font-weight: 500; cursor: pointer; transition: .25s ease;
        }

        .materi-item.active { background: white; box-shadow: 0 5px 15px rgba(0,0,0,.04); font-weight: 700; color: var(--blue-dark); }
        .materi-item:hover { background: rgba(255,255,255,.6); }

        .content-card { background: white; border-radius: 20px; padding: 35px; box-shadow: 0 5px 25px rgba(0,0,0,.02); animation: fadeIn .5s ease; }

        .hero-banner {
            width: 100%; min-height: 260px; border-radius: 15px;
            background-size: cover; background-position: center;
            display: flex; flex-direction: column; justify-content: center;
            padding: 40px; color: white; margin-bottom: 30px;
        }

        .hero-banner h1 { font-size: 36px; font-weight: 800; text-shadow: 0 2px 10px rgba(0,0,0,0.3); }
        .hero-banner p { font-size: 16px; text-shadow: 0 2px 6px rgba(0,0,0,0.3); }

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
            cursor: pointer;
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
        .prevnext a { text-decoration: none; color: var(--muted); font-size: 12px; cursor: pointer; } /* Ditambahkan cursor: pointer agar interaktif */
        .prevnext a strong { display: block; color: var(--blue-dark); font-size: 14px; margin-top: 3px; }
        .prevnext .next { text-align: right; }
        .prevnext .disabled { opacity: .4; pointer-events: none; }

        .care-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 26px 0; }
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
        .digital-card { border-radius: 16px; padding: 26px; }
        .digital-card.white { background: #fff; border: 1px solid var(--border); }
        .digital-card.blue { background: var(--blue-dark); color: #fff; }
        .digital-card.blue h4 { color: #fff; }
        .digital-card.blue .checklist li { color: #E3F0FF; }
        .digital-card.blue .checklist li i { color: #7DD3FC; }
        .read-more { color: var(--blue-dark); font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; margin-top: 10px; }

        .payment-section { display: grid; grid-template-columns: 1fr 1fr; gap: 35px; align-items: center; margin: 28px 0; }
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
           RESPONSIVE MEDIA QUERIES (HP, Tablet, Desktop, TV)
        ===================================================== */
        
        /* Layar Sangat Besar & TV (>= 1500px) */
        @media (min-width: 1500px) {
            .container {
                max-width: 1440px;
                gap: 50px;
                margin: 70px auto;
            }
            body {
                font-size: 16px;
            }
            .hero-banner {
                min-height: 320px;
            }
            .content-card {
                padding: 45px;
            }
        }

        /* Layar Sedang & Tablet Landscape/Potret (<= 1024px) */
        @media (max-width: 1024px) {
            .container {
                grid-template-columns: 260px 1fr;
                gap: 24px;
                padding: 0 16px;
            }
            .sidebar-materi {
                padding: 16px;
            }
            .materi-item {
                padding: 10px 12px;
                font-size: 13px;
            }
            .content-card {
                padding: 24px;
            }
        }

        /* Mode HP & Tablet Kecil (<= 900px) */
        @media (max-width: 900px) {
            nav {
                width: 95%;
                padding: 0 16px;
            }
            .nav-links {
                display: none; /* Sembunyikan link menu utama di HP */
            }
            .container {
                grid-template-columns: 1fr;
                margin-top: 30px;
                gap: 20px;
            }
            .sidebar-materi {
                position: static;
                width: 100%;
                padding: 15px;
                border-radius: 16px;
            }
            /* Ubah navigasi list materi samping menjadi navigasi horizontal scroll di HP */
            .materi-list {
                flex-direction: row;
                overflow-x: auto;
                white-space: nowrap;
                padding-bottom: 10px;
                gap: 10px;
                -webkit-overflow-scrolling: touch;
            }
            .materi-item {
                flex: 0 0 auto;
                padding: 10px 16px;
            }
            .top-grid {
                grid-template-columns: 1fr;
                gap: 25px;
            }
            .toc-box {
                order: -1; /* Pindahkan daftar isi ke atas konten di mobile */
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

        /* Layar HP Kecil (<= 576px) */
        @media (max-width: 576px) {
            nav {
                height: 70px;
            }
            .user-greeting {
                display: none; /* Sembunyikan sapaan teks di layar sangat sempit */
            }
            .hero-banner {
                padding: 24px;
                min-height: 200px;
            }
            .hero-banner h1 {
                font-size: 26px;
            }
            .hero-banner p {
                font-size: 13px;
            }
            .title-h1 {
                font-size: 24px;
            }
            .content-card {
                padding: 16px;
                border-radius: 16px;
            }
            .card-grid.cols-2, .card-grid.cols-3 {
                grid-template-columns: 1fr;
            }
            .split-block {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            .method-3d {
                grid-template-columns: 1fr;
            }
        }

        /* =====================================================
           INTERACTIVE TABS FOR BANK INDONESIA (NEW STYLE)
        ===================================================== */
        .bi-tabs-container {
            margin: 30px 0;
        }
        .bi-tabs-headers {
            display: flex;
            gap: 12px;
            border-bottom: 2px solid var(--border);
            padding-bottom: 10px;
            margin-bottom: 24px;
        }
        .bi-tab-btn {
            background: none;
            border: none;
            font-size: 15px;
            font-weight: 700;
            color: var(--muted);
            padding: 8px 20px;
            cursor: pointer;
            position: relative;
            transition: all 0.25s ease;
            border-radius: 8px;
        }
        .bi-tab-btn:hover {
            color: var(--blue-dark);
            background: #F4F7FC;
        }
        .bi-tab-btn.active {
            color: var(--blue-dark);
            background: #EAF2FF;
        }
        .bi-tab-btn.active::after {
            content: "";
            position: absolute;
            bottom: -12px;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--blue-dark);
            border-radius: 3px;
        }
        .tugas-card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }
        .tugas-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .tugas-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(23, 76, 132, 0.08);
            border-color: var(--blue);
        }
        .tugas-card h4 {
            font-size: 17px;
            font-weight: 800;
            color: var(--navy);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .tugas-card p {
            font-size: 13.5px;
            color: var(--muted);
            line-height: 1.6;
        }
        .wewenang-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
        }
        .wewenang-item {
            background: #F8FAFF;
            border: 1px solid #EAF2FF;
            border-radius: 12px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: all 0.25s ease;
        }
        .wewenang-item:hover {
            background: #fff;
            border-color: var(--blue);
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }
        .wewenang-badge-num {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #EAF2FF;
            color: var(--blue-dark);
            font-weight: 800;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.25s ease;
        }
        .wewenang-item:hover .wewenang-badge-num {
            background: var(--blue-dark);
            color: #fff;
        }
        .wewenang-text-container {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .wewenang-title {
            font-size: 14.5px;
            color: var(--text);
            font-weight: 700;
        }
        .wewenang-desc {
            font-size: 12.5px;
            color: var(--muted);
        }

        /* =====================================================
           INTERACTIVE TABS FOR CIRI KEAMANAN (NEW STYLE)
        ===================================================== */
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
            background: rgba(255,255,255,0.5);
        }
        .keamanan-tab-btn.active {
            background: #fff;
            color: var(--blue-dark);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .keamanan-content-box {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 30px;
            margin-top: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.01);
        }
        .keamanan-detail-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
            margin-top: 15px;
        }
        .keamanan-detail-item {
            background: #F8FAFF;
            border-left: 4px solid var(--blue-dark);
            padding: 16px 20px;
            border-radius: 0 12px 12px 0;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .keamanan-detail-title {
            font-size: 15px;
            font-weight: 800;
            color: var(--navy);
        }
        .keamanan-detail-desc {
            font-size: 13.5px;
            color: var(--muted);
            line-height: 1.6;
        }

        /* =====================================================
           INTERACTIVE TABS FOR SEJARAH RUPIAH (NEW STYLE)
        ===================================================== */
        .sejarah-tabs-wrapper {
            margin-top: 24px;
            background: #F4F7FC;
            padding: 8px;
            border-radius: 16px;
            display: flex;
            gap: 8px;
        }
        .sejarah-tab-btn {
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
        .sejarah-tab-btn:hover {
            color: var(--blue-dark);
            background: rgba(255,255,255,0.5);
        }
        .sejarah-tab-btn.active {
            background: #fff;
            color: var(--blue-dark);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .sejarah-content-box {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 30px;
            margin-top: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.01);
        }
        .sejarah-detail-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
            margin-top: 15px;
        }
        .sejarah-detail-item {
            background: #F8FAFF;
            border-left: 4px solid var(--blue-dark);
            padding: 16px 20px;
            border-radius: 0 12px 12px 0;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .sejarah-detail-title {
            font-size: 15px;
            font-weight: 800;
            color: var(--navy);
        }
        .sejarah-detail-desc {
            font-size: 13.5px;
            color: var(--muted);
            line-height: 1.6;
        }
    </style>
</head>

<body>

<!-- HEADER (Floating Glassmorphism) -->
<nav>
    <a href="#" style="display:flex; align-items:center; text-decoration:none;">
        <div class="nav-logo">
            <img src="../GAMBAR_GAMBAR/LOGO.png" alt="Logo RUPANTARA">
        </div>
    </a>

    <ul class="nav-links">
        <li><a href="#">Beranda</a></li>
        <li><a href="../TENTANG RUPIAH/tentangrupiah.html">Tentang Rupiah</a></li>
        <li><a href="../MATERI/edukasi.php" class="active">Edukasi</a></li>
        <li><a href="../QUIZ/quiz_intro.html">Quiz</a></li>
        <li><a href="../SCANNER/index.html">Scan</a></li>
    </ul>

    <div class="nav-actions">
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

// Fungsi global untuk berpindah tab Bank Indonesia
function switchBiTab(tabIndex) {
    const tabs = document.querySelectorAll(".bi-tab-btn");
    const contents = document.querySelectorAll(".bi-tab-content");
    
    tabs.forEach((tab, index) => {
        if (index === tabIndex) {
            tab.classList.add("active");
            contents[index].style.display = "block";
        } else {
            tab.classList.remove("active");
            contents[index].style.display = "none";
        }
    });
    // Render ulang ikon Lucide agar ikon dinamis di dalam tab muncul
    lucide.createIcons();
}

// Fungsi global untuk berpindah tab Ciri Keamanan (3D)
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

// Fungsi global untuk berpindah tab Sejarah Rupiah
function switchSejarahTab(tabIndex) {
    const tabs = document.querySelectorAll(".sejarah-tab-btn");
    const contents = document.querySelectorAll(".sejarah-tab-content");
    
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
                            <p class="lead-text">Penggunaan Rupiah di wilayah NKRI merupakan kewajiban hukum yang diatur dalam Undang-Undang No. 7 Tahun 2011. Hal ini bertujuan untuk mendukung terciptanya stabilitas nilai Rupiah and memperkuat integritas nasional melalui kedaulatan moneter.</p>
                        </div>
                        <!-- Bagian ilustrasi di bawah diganti dengan gambar tangan_uang.png -->
                        <img src="${imgPath}tangan_uang.png" alt="Kedaulatan dalam Genggaman" style="width:100%; border-radius:18px; object-fit:cover;">
                    </div>

                    ${prevNextHTML(0)}
                </div>

                <aside class="toc-box">
                    <h4>Daftar Isi</h4>
                    <a href="#">Apa itu Rupiah?</a>
                    <a href="#">Fungsi Rupiah</a>
                    <a href="#">Peran Ekonomi</a>
                    <div class="toc-progress">
                        <span class="label">Progres Belajar &nbsp; 16%</span>
                        <div class="progress-track"><div class="progress-fill" style="width:16%;"></div></div>
                    </div>
                </aside>
            </div>
        `;

    // ======================================================
    // 1. BANK INDONESIA (Diperbarui dengan Banner bank_indonesia.png & Logo bank asli)
    // ======================================================
    } else if (page === 1) {
        content.innerHTML = `
            <div class="hero-banner" style="background-image: linear-gradient(rgba(0,0,0,.45), rgba(0,0,0,.45)), url('${imgPath}bank_indonesia.png');">
                <h1>Bank Indonesia</h1>
                <p>Mengenal lebih dekat bank sentral Republik Indonesia, penjaga stabilitas nilai Rupiah.</p>
            </div>

            <div class="top-grid">
                <div>
                    <span class="page-badge"><i data-lucide="landmark"></i>Lembaga Negara Independen</span>
                    <h2 class="title-h1">Bank Sentral Kita</h2>
                    <p class="lead-text">Bank Indonesia (BI) adalah bank sentral Republik Indonesia yang memiliki kedudukan sebagai lembaga negara independen. Dalam menjalankan tugas dan wewenangnya, Bank Indonesia bebas dari campur tangan pemerintah maupun pihak lain, kecuali dalam hal-hal yang secara tegas diatur dalam undang-undang. Independensi ini diperlukan agar BI dapat mengambil kebijakan secara objektif demi menjaga stabilitas perekonomian nasional.</p>

                    <div class="callout-box">
                        <i data-lucide="target"></i>
                        <div>
                            <h4>Tujuan Tunggal</h4>
                            <p>Tujuan utama Bank Indonesia adalah mencapai dan memelihara kestabilan nilai Rupiah. Untuk mencapai tujuan tersebut, BI merancang berbagai kebijakan yang berkaitan dengan pengendalian inflasi, pengaturan sistem pembayaran, serta menjaga stabilitas sistem keuangan.</p>
                        </div>
                    </div>

                    <h3 class="section-heading">Tugas &amp; Wewenang</h3>
                    
                    <!-- TAB CONTAINER INTERAKTIF (BARU & LEBIH MENARIK) -->
                    <div class="bi-tabs-container">
                        <div class="bi-tabs-headers">
                            <button class="bi-tab-btn active" onclick="switchBiTab(0)">3 Tugas Utama</button>
                            <button class="bi-tab-btn" onclick="switchBiTab(1)">7 Wewenang Strategis</button>
                        </div>

                        <!-- TAB CONTENT 1: TUGAS UTAMA -->
                        <div class="bi-tab-content" id="tab-tugas" style="display: block;">
                            <div class="tugas-card-grid">
                                <div class="tugas-card">
                                    <h4><i data-lucide="trending-up" style="color:#3B82F6;"></i>Kebijakan Moneter</h4>
                                    <p>BI mengatur jumlah uang yang beredar and menetapkan suku bunga acuan untuk menjaga stabilitas inflasi. Kebijakan ini bertujuan menjaga harga barang and jasa agar daya beli masyarakat tetap stabil.</p>
                                </div>
                                <div class="tugas-card">
                                    <h4><i data-lucide="credit-card" style="color:#F59E0B;"></i>Sistem Pembayaran</h4>
                                    <p>BI memastikan seluruh transaksi pembayaran berjalan aman, cepat, and efisien. BI mengelola uang kartal (Rupiah kertas & logam) serta mengawasi layanan transfer, QRIS, kartu debit, and dompet digital.</p>
                                </div>
                                <div class="tugas-card">
                                    <h4><i data-lucide="shield-check" style="color:#10B981;"></i>Stabilitas Sistem Keuangan</h4>
                                    <p>BI bekerja sama dengan pemerintah untuk meminimalkan risiko krisis ekonomi melalui kebijakan makroprudensial demi menjaga kesehatan ekosistem keuangan nasional tetap kokoh.</p>
                                </div>
                            </div>
                        </div>

                        <!-- TAB CONTENT 2: WEWENANG STRATEGIS -->
                        <div class="bi-tab-content" id="tab-wewenang" style="display: none;">
                            <div class="wewenang-grid">
                                <div class="wewenang-item">
                                    <div class="wewenang-badge-num">1</div>
                                    <div class="wewenang-text-container">
                                        <div class="wewenang-title">Menetapkan Sasaran Moneter</div>
                                        <div class="wewenang-desc">Menentukan arah target inflasi jangka pendek and menengah.</div>
                                    </div>
                                </div>
                                <div class="wewenang-item">
                                    <div class="wewenang-badge-num">2</div>
                                    <div class="wewenang-text-container">
                                        <div class="wewenang-title">Menentukan Suku Bunga Acuan</div>
                                        <div class="wewenang-desc">Menetapkan tingkat suku bunga perbankan nasional (BI-Rate).</div>
                                    </div>
                                </div>
                                <div class="wewenang-item">
                                    <div class="wewenang-badge-num">3</div>
                                    <div class="wewenang-text-container">
                                        <div class="wewenang-title">Menerbitkan & Mengedarkan Uang</div>
                                        <div class="wewenang-desc">Memiliki hak tunggal menerbitkan serta mendistribusikan uang Rupiah yang sah.</div>
                                    </div>
                                </div>
                                <div class="wewenang-item">
                                    <div class="wewenang-badge-num">4</div>
                                    <div class="wewenang-text-container">
                                        <div class="wewenang-title">Menarik & Memusnahkan Uang</div>
                                        <div class="wewenang-desc">Menarik kembali uang lusuh atau tidak layak edar dari pasar untuk dimusnahkan secara aman.</div>
                                    </div>
                                </div>
                                <div class="wewenang-item">
                                    <div class="wewenang-badge-num">5</div>
                                    <div class="wewenang-text-container">
                                        <div class="wewenang-title">Mengatur Sistem Pembayaran</div>
                                        <div class="wewenang-desc">Mengevaluasi and memberikan izin operasional kepada penyedia jasa transfer and fintech.</div>
                                    </div>
                                </div>
                                <div class="wewenang-item">
                                    <div class="wewenang-badge-num">6</div>
                                    <div class="wewenang-text-container">
                                        <div class="wewenang-title">Mengelola Cadangan Devisa</div>
                                        <div class="wewenang-desc">Menjaga likuiditas serta keamanan cadangan mata uang asing milik negara.</div>
                                    </div>
                                </div>
                                <div class="wewenang-item">
                                    <div class="wewenang-badge-num">7</div>
                                    <div class="wewenang-text-container">
                                        <div class="wewenang-title">Memberikan Rekomendasi Kajian Ekonomi</div>
                                        <div class="wewenang-desc">Menyediakan analisis berkala kondisi ekonomi makro kepada jajaran Pemerintah.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-grid cols-2">
                        <!-- Kotak kiri yang diperbarui dengan logo_BI.png asli -->
                        <div style="background:var(--navy); border-radius:16px; display:flex; align-items:center; justify-content:center; min-height:150px; padding:20px;">
                            <img src="${imgPath}logo_BI.png" alt="Logo Bank Indonesia" style="max-height:100px; width:auto; object-fit:contain;">
                        </div>
                        <div style="background:var(--blue-dark); border-radius:16px; padding:24px; color:#fff; display:flex; flex-direction:column; justify-content:center;">
                            <span style="font-weight:800; font-size:15px; margin-bottom:8px;">Tahukah Kamu?</span>
                            <p style="font-size:13.5px; color:#CFE3FA; font-style:italic;">"Bank Indonesia merupakan lembaga negara yang independen dan bebas dari campur tangan pemerintah dalam pelaksanaan tugasnya."</p>
                        </div>
                    </div>

                    ${prevNextHTML(1)}
                </div>
                
                <aside class="toc-box">
                    <h4>Daftar Isi</h4>
                    <a href="#">Bank Sentral</a>
                    <a href="#">Tugas BI</a>
                    <a href="#">Wewenang BI</a>
                    <div class="toc-progress">
                        <span class="label">Progres Belajar &nbsp; 35%</span>
                        <div class="progress-track"><div class="progress-fill" style="width:35%;"></div></div>
                    </div>
                </aside>
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
                    <p class="lead-text">Setiap lembar Rupiah memiliki berbagai unsur pengaman yang dirancang untuk menjaga keaslian uang dan membantu masyarakat membedakan uang asli dari uang palsu.</p>
                    <div class="btn-row">
                        <!-- Tombol Mulai Belajar diubah untuk scroll ke bawah secara halus -->
                        <a class="btn-fill" onclick="document.getElementById('section-keamanan').scrollIntoView({ behavior: 'smooth', block: 'start' });">Mulai Belajar <i data-lucide="arrow-right"></i></a>
                    </div>
                </div>
                <div class="hero-split-photo" style="position:relative;">
                    <!-- Bagian ilustrasi ini diganti dengan gambar memeriksa_uang.jpg -->
                    <img src="${imgPath}memeriksa_uang.jpg" alt="Memeriksa Uang" style="width: 100%; height: 220px; object-fit: cover; border-radius: 18px;">
                    <div class="float-badge">
                        <div class="icon-circle" style="margin-bottom:0;"><i data-lucide="lock"></i></div>
                        Aman &amp; Terverifikasi
                    </div>
                </div>
            </div>

            <!-- Bagian ini diubah menjadi grid yang serasi dengan section lain (menghapus mini-nav samping) -->
            <div class="top-grid">
                <div>
                    <h3 class="section-heading" id="section-keamanan" style="margin-top:0; scroll-margin-top: 130px;">Metode 3D</h3>
                    <p class="lead-text">Langkah paling mendasar dan mudah untuk mengecek keaslian uang Rupiah adalah dengan metode 3D: Dilihat, Diraba, dan Diterawang.</p>

                    <!-- TAB UNTUK CIRI KEAMANAN (LEBIH INTERAKTIF & MENARIK) -->
                    <div class="keamanan-tabs-wrapper">
                        <button class="keamanan-tab-btn active" onclick="switchKeamananTab(0)"><i data-lucide="eye"></i> Dilihat</button>
                        <button class="keamanan-tab-btn" onclick="switchKeamananTab(1)"><i data-lucide="hand"></i> Diraba</button>
                        <button class="keamanan-tab-btn" onclick="switchKeamananTab(2)"><i data-lucide="sun"></i> Diterawang</button>
                    </div>

                    <!-- KONTEN DETIL 3D -->
                    <div class="keamanan-content-box">
                        <!-- 1. Dilihat -->
                        <div class="keamanan-tab-content" style="display: block;">
                            <h4 style="font-size: 16.5px; font-weight: 800; color: var(--navy); margin-bottom: 12px;">Unsur Pengaman yang Tampak Langsung</h4>
                            <div class="keamanan-detail-grid">
                                <div class="keamanan-detail-item">
                                    <span class="keamanan-detail-title">Warna Cerah</span>
                                    <span class="keamanan-detail-desc">Uang Rupiah asli dicetak menggunakan kombinasi warna kontras yang tajam dan presisi, sehingga sangat sulit ditiru oleh mesin cetak/printer biasa.</span>
                                </div>
                                <div class="keamanan-detail-item">
                                    <span class="keamanan-detail-title">Optically Variable Ink (OVI)</span>
                                    <span class="keamanan-detail-desc">Terdapat logo Bank Indonesia (BI) di dalam perisai yang akan berubah warna dari hijau menjadi emas secara visual jika dilihat dari sudut pandang yang berbeda.</span>
                                </div>
                                <div class="keamanan-detail-item">
                                    <span class="keamanan-detail-title">Benang Pengaman rajutan</span>
                                    <span class="keamanan-detail-desc">Disematkan seperti dianyam pada kertas uang, benang pengaman ini akan memantulkan warna berbeda jika digoyang-goyangkan.</span>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Diraba -->
                        <div class="keamanan-tab-content" style="display: none;">
                            <h4 style="font-size: 16.5px; font-weight: 800; color: var(--navy); margin-bottom: 12px;">Tekstur Kasar dari Hasil Cetak Intaglio</h4>
                            <div class="keamanan-detail-grid">
                                <div class="keamanan-detail-item">
                                    <span class="keamanan-detail-title">Cetak Intaglio</span>
                                    <span class="keamanan-detail-desc">Uang asli menggunakan teknik cetak timbul khusus. Bagian pahlawan utama, Garuda Pancasila, nominal angka, dan tulisan "BANK INDONESIA" akan terasa kasar ketika Anda meraba permukaannya.</span>
                                </div>
                                <div class="keamanan-detail-item">
                                    <span class="keamanan-detail-title">Kode Tuna Netra (Blind Code)</span>
                                    <span class="keamanan-detail-desc">Sepasang garis timbul di sisi kanan dan kiri ujung uang kertas yang dapat diraba dengan jari untuk mempermudah saudara-saudara tuna netra mengenali nominal uang.</span>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Diterawang -->
                        <div class="keamanan-tab-content" style="display: none;">
                            <h4 style="font-size: 16.5px; font-weight: 800; color: var(--navy); margin-bottom: 12px;">Tanda Air dan Gambar Saling Isi (Rectoverso)</h4>
                            <div class="keamanan-detail-grid">
                                <div class="keamanan-detail-item">
                                    <span class="keamanan-detail-title">Tanda Air (Watermark)</span>
                                    <span class="keamanan-detail-desc">Saat diarahkan ke arah cahaya, akan muncul gambar pahlawan nasional yang sangat detail, lengkap dengan ornamen logo BI di bawahnya.</span>
                                </div>
                                <div class="keamanan-detail-item">
                                    <span class="keamanan-detail-title">Rectoverso (Gambar Saling Isi)</span>
                                    <span class="keamanan-detail-desc">Potongan logo BI di sisi depan dan belakang akan tampak menyatu dengan sempurna membentuk logo BI utuh tanpa ada celah atau potongan saat diterawang ke arah cahaya.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-grid cols-2" style="margin-top: 30px;">
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

                <aside class="toc-box">
                    <h4>Daftar Isi</h4>
                    <a href="#">Metode 3D</a>
                    <a href="#">Fitur Detail</a>
                    <div class="toc-progress">
                        <span class="label">Progres Belajar &nbsp; 50%</span>
                        <div class="progress-track"><div class="progress-fill" style="width:50%;"></div></div>
                    </div>
                </aside>
            </div>
        `;

    // ======================================================
    // 3. SEJARAH RUPIAH (Diperbarui dengan gambar kumpulan_uang_lama.jpg & Konten Interaktif)
    // ======================================================
    } else if (page === 3) {
        content.innerHTML = `
            <span class="page-badge"><i data-lucide="scroll"></i>Sejarah dan Budaya</span>
            <div class="split-block" style="margin-top:0;">
                <div>
                    <h1 class="title-h1">Menelusuri Jejak<br>Sejarah Rupiah</h1>
                    <p class="lead-text">Perjalanan panjang mata uang Indonesia, dari koin kerajaan hingga menjadi lambang kedaulatan bangsa yang kita kenal sekarang.</p>
                    <div class="btn-row">
                        <!-- Tombol Mulai Belajar diubah untuk scroll ke bawah secara halus -->
                        <a class="btn-fill" onclick="document.getElementById('section-sejarah').scrollIntoView({ behavior: 'smooth', block: 'start' });">Mulai Belajar <i data-lucide="arrow-right"></i></a>
                    </div>
                </div>
                <div class="hero-split-photo" style="position:relative; width: 100%;">
                    <!-- Gambar ilustrasi diganti dengan gambar kumpulan_uang_lama.jpg -->
                    <img src="${imgPath}kumpulan_uang_lama.jpg" alt="Sejarah Rupiah" style="width: 100%; height: 250px; object-fit: cover; border-radius: 18px;">
                    <div class="float-badge">
                        <div class="icon-circle" style="margin-bottom:0;"><i data-lucide="history"></i></div>
                        Edisi Sejarah
                    </div>
                </div>
            </div>

            <!-- Bagian ini diubah menjadi grid yang serasi dengan section lain (menghapus mini-nav samping) -->
            <div class="top-grid">
                <div>
                    <h3 class="section-heading" id="section-sejarah" style="margin-top:0; scroll-margin-top: 130px;">Linimasa Sejarah</h3>
                    <p class="lead-text">Pilih era sejarah di bawah ini untuk mempelajari bagaimana alat pembayaran berkembang di Nusantara dari masa ke masa secara dinamis.</p>

                    <!-- TAB UNTUK SEJARAH RUPIAH (INTERAKTIF & MENARIK) -->
                    <div class="sejarah-tabs-wrapper">
                        <button class="sejarah-tab-btn active" onclick="switchSejarahTab(0)"><i data-lucide="coins"></i> Masa Kerajaan</button>
                        <button class="sejarah-tab-btn" onclick="switchSejarahTab(1)"><i data-lucide="ship"></i> Era Kolonial</button>
                        <button class="sejarah-tab-btn" onclick="switchSejarahTab(2)"><i data-lucide="flag"></i> Era Kemerdekaan</button>
                    </div>

                    <!-- KONTEN DETIL SEJARAH -->
                    <div class="sejarah-content-box">
                        <!-- 1. Masa Kerajaan -->
                        <div class="sejarah-tab-content" style="display: block;">
                            <h4 style="font-size: 16.5px; font-weight: 800; color: var(--navy); margin-bottom: 12px;">Masa Kerajaan Nusantara (Abad ke-9)</h4>
                            <p class="lead-text">Sebelum Indonesia mengenal uang kertas modern, kerajaan-kerajaan besar di Nusantara telah menggunakan keping uang logam mulia sebagai simbol kedaulatan transaksi.</p>
                            
                            <div class="timeline-photos" style="margin-top:20px;">
                                <figure style="background: #F4F7FC; border-radius: 14px; overflow: hidden; text-align: center; padding: 15px;">
                                    <!-- Ikon lingkaran diganti dengan uang_acehkuno.png -->
                                    <img src="${imgPath}uang_acehkuno.png" alt="Uang Aceh Kuno" style="width: 100%; height: 120px; object-fit: contain; border-radius: 8px;">
                                    <figcaption style="font-size: 12px; font-weight: 600; color: var(--muted); margin-top: 8px;">Uang Koin Emas & Perak Kerajaan Mataram Kuno</figcaption>
                                </figure>
                                <figure style="background: #F4F7FC; border-radius: 14px; overflow: hidden; text-align: center; padding: 15px;">
                                    <!-- Ikon koin diganti dengan uang_gobog.png -->
                                    <img src="${imgPath}uang_gobog.png" alt="Uang Gobog" style="width: 100%; height: 120px; object-fit: contain; border-radius: 8px;">
                                    <figcaption style="font-size: 12px; font-weight: 600; color: var(--muted); margin-top: 8px;">Uang Gobog Tembaga Kerajaan Majapahit</figcaption>
                                </figure>
                            </div>
                            <p style="font-size: 13.5px; color: var(--muted); margin-top: 20px; line-height: 1.6;">
                                Penggunaan koin-koin ini membuktikan bahwa sistem kemandirian moneter and hubungan niaga internasional Nusantara dengan pedagang Tiongkok, India, and Arab telah terjalin kuat sejak berabad-abad lalu.
                            </p>
                        </div>

                        <!-- 2. Era Kolonial -->
                        <div class="sejarah-tab-content" style="display: none;">
                            <h4 style="font-size: 16.5px; font-weight: 800; color: var(--navy); margin-bottom: 12px;">Era Kolonialisme & Dominasi Gulden Belanda</h4>
                            <p class="lead-text">Masuknya VOC dan imperialisme pemerintah Hindia Belanda menggeser uang logam lokal and memperkenalkan sistem keuangan monopoli barat.</p>
                            
                            <div class="colonial-card" style="margin-top:20px;">
                                <!-- Ikon perbankan diganti dengan gambar gulden.jpg -->
                                <img src="${imgPath}gulden.jpg" alt="Gulden Hindia Belanda" style="width: 110px; height: 80px; object-fit: cover; border-radius: 10px; flex-shrink: 0;">
                                <div>
                                    <h5>Gulden Hindia Belanda</h5>
                                    <p>Seluruh sistem sirkulasi keuangan diatur secara terpusat oleh De Javasche Bank. Penggunaan Gulden kolonial ini memonopoli komoditas perkebunan and sangat membatasi kesejahteraan perdagangan rakyat pribumi.</p>
                                    <span class="tag-pill" style="background:#FEE2E2; color:#B91C1C;">Sistem Monopoli</span>
                                    <span class="tag-pill blue" style="background:#DBEAFE; color:#174C84;">De Javasche Bank</span>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Era Kemerdekaan -->
                        <div class="sejarah-tab-content" style="display: none;">
                            <h4 style="font-size: 16.5px; font-weight: 800; color: var(--navy); margin-bottom: 12px;">Lahirnya Rupiah & Kedaulatan Finansial Bangsa</h4>
                            <p class="lead-text">Pasca proklamasi kemerdekaan, negara Indonesia mengambil langkah berani untuk menegaskan integritas nasionalnya melalui alat pembayaran resmi yang berdaulat.</p>
                            
                            <div class="sejarah-detail-grid" style="margin-top: 20px;">
                                <div class="sejarah-detail-item">
                                    <span class="sejarah-detail-title">Penerbitan ORI (30 Oktober 1946)</span>
                                    <span class="sejarah-detail-desc">Pemerintah meresmikan Oeang Republik Indonesia (ORI) sebagai alat transaksi yang sah. Hal ini melambangkan pernyataan politik penting bahwa Indonesia berdaulat penuh atas wilayah and ekonominya sendiri.</span>
                                </div>
                                <div class="sejarah-detail-item" style="border-left-color: var(--navy);">
                                    <span class="sejarah-detail-title">Nasionalisasi Bank Indonesia (1953)</span>
                                    <span class="sejarah-detail-desc">De Javasche Bank resmi dinasionalisasi oleh Pemerintah Indonesia menjadi Bank Indonesia (BI), memegang mandat tunggal untuk mengendalikan, merancang, and mengedarkan mata uang Rupiah pemersatu bangsa.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    ${prevNextHTML(3)}
                </div>

                <aside class="toc-box">
                    <h4>Daftar Isi</h4>
                    <a href="#">Masa Kerajaan</a>
                    <a href="#">Era Kolonial</a>
                    <a href="#">Era Kemerdekaan</a>
                    <div class="toc-progress">
                        <span class="label">Progres Belajar &nbsp; 65%</span>
                        <div class="progress-track"><div class="progress-fill" style="width:65%;"></div></div>
                    </div>
                </aside>
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