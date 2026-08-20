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

        img {
            max-width: 100%;
            height: auto;
        }

        body {
            background: var(--body);
            color: var(--text);
            line-height: 1.6;
            font-size: 15px;
            overflow-x: hidden;
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
           LAYOUT & CONTENT
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
        .btn-fill:hover { background: var(--navy-dark); transform: translateY(-2px); box-shadow: 0 6px 16px rgba(23,76,132,0.2); }
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

        .split-block { display: grid; grid-template-columns: 1fr 1fr; gap: 35px; align-items: center; margin: 24px 0; }
        .split-block img { width: 100%; border-radius: 16px; object-fit: cover; }

        .float-badge {
            position: absolute; top: -14px; left: -14px; background: #fff; border-radius: 14px;
            box-shadow: 0 8px 20px rgba(0,0,0,.1); padding: 10px 16px; display: flex; align-items: center; gap: 10px;
            font-size: 12px; font-weight: 700; color: var(--navy);
        }

        .callout-box { background: #EAF2FF; border-radius: 16px; padding: 22px; display: flex; gap: 16px; margin: 22px 0; }
        .callout-box i { color: var(--blue-dark); flex-shrink: 0; width: 24px; height: 24px; }
        .callout-box h4 { font-size: 14.5px; color: var(--navy); margin-bottom: 4px; }
        .callout-box p { font-size: 13.5px; color: #3A5A80; }

        .timeline-photos { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 6px; }
        .colonial-card { display: flex; gap: 18px; background: #F4F7FC; border-radius: 16px; padding: 18px; align-items: center; }
        .colonial-card h5 { font-size: 14px; color: #0F2942; margin-bottom: 4px; }
        .colonial-card p { font-size: 12.5px; color: var(--muted); margin-bottom: 8px; }

        .tag-pill { display: inline-block; background: #FEE2E2; color: #B91C1C; font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 20px; margin-right: 6px; }
        .tag-pill.blue { background: #DBEAFE; color: var(--blue-dark); }

        .prevnext { display: flex; justify-content: space-between; margin-top: 35px; padding-top: 22px; border-top: 1px solid var(--border); }
        .prevnext a { text-decoration: none; color: var(--muted); font-size: 12px; cursor: pointer; }
        .prevnext a strong { display: block; color: var(--blue-dark); font-size: 14px; margin-top: 3px; }
        .prevnext .next { text-align: right; }
        .prevnext .disabled { opacity: .4; pointer-events: none; }

        /* =====================================================
           CARA MERAWAT 5J STYLES (NEW, VIBRANT & INTERACTIVE)
        ===================================================== */
        .care-5j-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin: 26px 0;
        }

        .care-5j-card {
            background: #FFFFFF;
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }

        .care-5j-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(14, 63, 107, 0.08);
            border-color: rgba(89, 169, 232, 0.4);
        }

        .care-icon-badge {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }

        .care-5j-card:hover .care-icon-badge {
            transform: scale(1.08) rotate(3deg);
        }

        .care-icon-badge.amber { background: #FEF3C7; color: #D97706; }
        .care-icon-badge.rose { background: #FFE4E6; color: #E11D48; }
        .care-icon-badge.purple { background: #F3E8FF; color: #7E22CE; }
        .care-icon-badge.orange { background: #FFEDD5; color: #EA580C; }
        .care-icon-badge.cyan { background: #E0F2FE; color: #0284C7; }
        .care-icon-badge.emerald { background: #D1FAE5; color: #059669; }

        .care-5j-card h4 {
            font-size: 16.5px;
            font-weight: 800;
            color: var(--navy);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .larangan-badge {
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            background: #FEE2E2;
            color: #DC2626;
            text-transform: uppercase;
        }

        .care-5j-card p {
            font-size: 13.5px;
            color: var(--muted);
            line-height: 1.6;
        }

        .care-card-highlight {
            grid-column: 1 / -1;
            background: linear-gradient(135deg, #0A3458, #0E3F6B);
            color: #FFFFFF;
            border-radius: 20px;
            padding: 28px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            flex-wrap: wrap;
        }

        .care-card-highlight h4 {
            font-size: 18px;
            font-weight: 800;
            color: #FFFFFF;
            margin-bottom: 6px;
        }

        .care-card-highlight p {
            color: #CFE3FA;
            font-size: 13.5px;
            max-width: 580px;
        }

        /* Interactive Checklist Kebiasaan */
        .interactive-checklist-box {
            background: #F8FAFF;
            border: 2px dashed rgba(89, 169, 232, 0.4);
            border-radius: 20px;
            padding: 28px;
            margin: 30px 0;
        }

        .checklist-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 18px;
        }

        .checklist-items-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .custom-check-item {
            background: #FFFFFF;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            cursor: pointer;
            user-select: none;
            transition: all 0.25s ease;
        }

        .custom-check-item:hover {
            border-color: var(--blue);
            background: #F0F7FF;
            transform: translateY(-2px);
        }

        .custom-check-item input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--blue-dark);
            cursor: pointer;
        }

        .custom-check-text {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text);
        }

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
           TABS STYLES (BI, KEAMANAN, SEJARAH, RUPIAH DIGITAL)
        ===================================================== */
        .bi-tabs-container { margin: 30px 0; }
        .bi-tabs-headers {
            display: flex; gap: 12px; border-bottom: 2px solid var(--border); padding-bottom: 10px; margin-bottom: 24px;
        }
        .bi-tab-btn {
            background: none; border: none; font-size: 15px; font-weight: 700; color: var(--muted);
            padding: 8px 20px; cursor: pointer; position: relative; transition: all 0.25s ease; border-radius: 8px;
        }
        .bi-tab-btn:hover { color: var(--blue-dark); background: #F4F7FC; }
        .bi-tab-btn.active { color: var(--blue-dark); background: #EAF2FF; }
        .bi-tab-btn.active::after {
            content: ""; position: absolute; bottom: -12px; left: 0; width: 100%; height: 3px; background: var(--blue-dark); border-radius: 3px;
        }
        .tugas-card-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }
        .tugas-card {
            background: #fff; border: 1px solid var(--border); border-radius: 16px; padding: 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02); transition: all 0.3s ease; display: flex; flex-direction: column; gap: 14px;
        }
        .tugas-card:hover { transform: translateY(-5px); box-shadow: 0 12px 24px rgba(23, 76, 132, 0.08); border-color: var(--blue); }
        .tugas-card h4 { font-size: 17px; font-weight: 800; color: var(--navy); display: flex; align-items: center; gap: 10px; }
        .tugas-card p { font-size: 13.5px; color: var(--muted); line-height: 1.6; }

        .wewenang-grid { display: grid; grid-template-columns: 1fr; gap: 12px; }
        .wewenang-item {
            background: #F8FAFF; border: 1px solid #EAF2FF; border-radius: 12px; padding: 16px 20px;
            display: flex; align-items: center; gap: 16px; transition: all 0.25s ease;
        }
        .wewenang-item:hover { background: #fff; border-color: var(--blue); transform: translateX(5px); }
        .wewenang-badge-num {
            width: 32px; height: 32px; border-radius: 50%; background: #EAF2FF; color: var(--blue-dark);
            font-weight: 800; font-size: 13px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .wewenang-item:hover .wewenang-badge-num { background: var(--blue-dark); color: #fff; }
        .wewenang-text-container { display: flex; flex-direction: column; gap: 2px; }
        .wewenang-title { font-size: 14.5px; color: var(--text); font-weight: 700; }
        .wewenang-desc { font-size: 12.5px; color: var(--muted); }

        .keamanan-tabs-wrapper, .sejarah-tabs-wrapper, .cbdc-tabs-wrapper {
            margin-top: 24px; background: #F4F7FC; padding: 8px; border-radius: 16px; display: flex; gap: 8px;
        }
        .keamanan-tab-btn, .sejarah-tab-btn, .cbdc-tab-btn {
            flex: 1; background: none; border: none; padding: 14px; border-radius: 12px; font-size: 14.5px;
            font-weight: 700; color: var(--muted); cursor: pointer; display: flex; align-items: center;
            justify-content: center; gap: 10px; transition: all 0.25s ease;
        }
        .keamanan-tab-btn:hover, .sejarah-tab-btn:hover, .cbdc-tab-btn:hover { color: var(--blue-dark); background: rgba(255,255,255,0.5); }
        .keamanan-tab-btn.active, .sejarah-tab-btn.active, .cbdc-tab-btn.active {
            background: #fff; color: var(--blue-dark); box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .keamanan-content-box, .sejarah-content-box, .cbdc-content-box {
            background: #fff; border: 1px solid var(--border); border-radius: 20px; padding: 30px; margin-top: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.01);
        }
        .keamanan-detail-grid, .sejarah-detail-grid, .cbdc-detail-grid { display: grid; grid-template-columns: 1fr; gap: 16px; margin-top: 15px; }
        .keamanan-detail-item, .sejarah-detail-item, .cbdc-detail-item {
            background: #F8FAFF; border-left: 4px solid var(--blue-dark); padding: 16px 20px; border-radius: 0 12px 12px 0;
            display: flex; flex-direction: column; gap: 4px;
        }
        .keamanan-detail-title, .sejarah-detail-title, .cbdc-detail-title { font-size: 15px; font-weight: 800; color: var(--navy); }
        .keamanan-detail-desc, .sejarah-detail-desc, .cbdc-detail-desc { font-size: 13.5px; color: var(--muted); line-height: 1.6; }

        .compare-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-top: 20px;
        }
        .compare-card {
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px;
            background: #fff;
            display: flex;
            flex-direction: column;
            gap: 10px;
            transition: all 0.25s ease;
        }
        .compare-card:hover {
            border-color: var(--blue);
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.04);
        }
        .compare-card.highlighted {
            background: linear-gradient(135deg, #F0F7FF, #FFFFFF);
            border: 2px solid var(--blue);
        }

        /* =====================================================
           FOOTER
        ===================================================== */
        footer {
            margin-top: 100px;
            background: #06152B;
            color: #E2E8F0;
            padding: 70px 8% 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            position: relative;
            overflow: hidden;
            z-index: 10;
        }

        .footer-main {
            display: grid;
            grid-template-columns: 1.3fr 0.8fr 1fr;
            gap: 60px;
            padding-bottom: 45px;
            position: relative;
            z-index: 2;
        }

        .footer-column {
            display: flex;
            flex-direction: column;
        }

        .footer-brand-card {
            width: 150px;
            height: 48px;
            max-width: 150px;
            max-height: 48px;
            background: #FFFFFF;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            padding: 6px 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .footer-brand-card img {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
            display: block;
        }

        .footer-desc {
            font-size: 13.5px;
            color: #94A3B8;
            line-height: 1.65;
            max-width: 320px;
        }

        .footer-column h3 {
            color: #FFFFFF;
            font-size: 13.5px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 22px;
            position: relative;
            padding-bottom: 8px;
        }

        .footer-column h3::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 28px;
            height: 2px;
            background: var(--blue);
            border-radius: 2px;
        }

        .footer-nav {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .footer-nav a {
            color: #94A3B8;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.25s ease;
        }

        .footer-nav a:hover {
            color: #FFFFFF;
            transform: translateX(5px);
        }

        .footer-contact-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .footer-contact-item {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13.5px;
            color: #94A3B8;
            text-decoration: none;
            transition: color 0.25s ease;
        }

        .footer-contact-item:hover {
            color: #FFFFFF;
        }

        .footer-contact-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--blue);
            flex-shrink: 0;
        }

        .footer-bottom {
            margin-top: 30px;
            padding-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            position: relative;
            z-index: 2;
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
            transition: color 0.2s;
        }

        .footer-bottom-links a:hover {
            color: #94A3B8;
        }

        /* =====================================================
           RESPONSIVE
        ===================================================== */
        @media (max-width: 900px) {
            nav { width: 95%; padding: 0 16px; }
            .nav-links { display: none; }
            .container { grid-template-columns: 1fr; margin-top: 30px; gap: 20px; }
            .sidebar-materi { position: static; width: 100%; padding: 15px; border-radius: 16px; }
            .materi-list { flex-direction: row; overflow-x: auto; white-space: nowrap; padding-bottom: 10px; gap: 10px; }
            .materi-item { flex: 0 0 auto; padding: 10px 16px; }
            .top-grid { grid-template-columns: 1fr; gap: 25px; }
            .toc-box { order: -1; }
            .checklist-items-grid { grid-template-columns: 1fr; }
            .footer-main { grid-template-columns: 1fr; gap: 40px; }
            .footer-bottom { justify-content: center; text-align: center; flex-direction: column-reverse; }
            .keamanan-tabs-wrapper, .sejarah-tabs-wrapper, .cbdc-tabs-wrapper { flex-direction: column; }
        }
    </style>
</head>

<body>

<!-- HEADER -->
<nav>
    <a href="../BERANDA/beranda.html" style="display:flex; align-items:center; text-decoration:none;">
        <div class="nav-logo">
            <img src="../GAMBAR_GAMBAR/LOGO.png" alt="Logo RUPANTARA">
        </div>
    </a>

    <ul class="nav-links">
        <li><a href="../BERANDA/beranda.php">Beranda</a></li>
        <li><a href="../TENTANG RUPIAH/tentangrupiah.php">Tentang Rupiah</a></li>
        <li><a href="../MATERI/edukasi.php" class="active">Edukasi</a></li>
        <li><a href="../QUIZ/quiz_intro.php">Quiz</a></li>
        <li><a href="../SCANNER/index_copy.php">Scan</a></li>
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

<!-- CONTENT CONTAINER -->
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
                        <i data-lucide="phone" style="width:15px; height:15px;"></i>
                    </div>
                    <span>+62 823-4095-0845</span>
                </a>
                <div class="footer-contact-item">
                    <div class="footer-contact-icon">
                        <i data-lucide="map-pin" style="width:15px; height:15px;"></i>
                    </div>
                    <span>Purwokerto, Indonesia</span>
                </div>
            </div>
        </div>
    </div>

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
    lucide.createIcons();
}

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

function switchCbdcTab(tabIndex) {
    const tabs = document.querySelectorAll(".cbdc-tab-btn");
    const contents = document.querySelectorAll(".cbdc-tab-content");
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

// Fungsi Interaktif untuk Mengecek Skor Perawatan Rupiah
function updateCareScore() {
    const checkboxes = document.querySelectorAll('.care-check-input');
    let checkedCount = 0;
    checkboxes.forEach(cb => {
        if (cb.checked) checkedCount++;
    });
    const scoreBadge = document.getElementById('care-score-text');
    if (scoreBadge) {
        if (checkedCount === 4) {
            scoreBadge.innerHTML = '<span style="color:#059669; font-weight:800;">🌟 Sempurna! Anda Sahabat Rupiah Sejati (4/4)</span>';
        } else if (checkedCount >= 2) {
            scoreBadge.innerHTML = `<span style="color:#D97706; font-weight:700;">👍 Cukup Baik (${checkedCount}/4) - Tingkatkan Lagi!</span>`;
        } else {
            scoreBadge.innerHTML = `<span style="color:#DC2626; font-weight:700;">⚠️ Perlu Diperbaiki (${checkedCount}/4)</span>`;
        }
    }
}

function showMateri(page) {
    const content = document.getElementById("content");
    const imgPath = "../GAMBAR_GAMBAR/";

    // 0. MENGENAL RUPIAH
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

    // 1. BANK INDONESIA
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
                    <p class="lead-text">Bank Indonesia (BI) adalah bank sentral Republik Indonesia yang memiliki kedudukan sebagai lembaga negara independen. Dalam menjalankan tugas dan wewenangnya, Bank Indonesia bebas dari campur tangan pemerintah maupun pihak lain, kecuali dalam hal-hal yang secara tegas diatur dalam undang-undang.</p>

                    <div class="callout-box">
                        <i data-lucide="target"></i>
                        <div>
                            <h4>Tujuan Tunggal</h4>
                            <p>Tujuan utama Bank Indonesia adalah mencapai dan memelihara kestabilan nilai Rupiah melalui pengendalian inflasi, pengelolaan sistem pembayaran, dan stabilitas sistem keuangan nasional.</p>
                        </div>
                    </div>

                    <h3 class="section-heading">Tugas &amp; Wewenang</h3>
                    
                    <div class="bi-tabs-container">
                        <div class="bi-tabs-headers">
                            <button class="bi-tab-btn active" onclick="switchBiTab(0)">3 Tugas Utama</button>
                            <button class="bi-tab-btn" onclick="switchBiTab(1)">7 Wewenang Strategis</button>
                        </div>

                        <div class="bi-tab-content" id="tab-tugas" style="display: block;">
                            <div class="tugas-card-grid">
                                <div class="tugas-card">
                                    <h4><i data-lucide="trending-up" style="color:#3B82F6;"></i>Kebijakan Moneter</h4>
                                    <p>BI mengatur jumlah uang yang beredar dan menetapkan suku bunga acuan untuk menjaga stabilitas inflasi agar daya beli masyarakat tetap terjaga.</p>
                                </div>
                                <div class="tugas-card">
                                    <h4><i data-lucide="credit-card" style="color:#F59E0B;"></i>Sistem Pembayaran</h4>
                                    <p>BI memastikan seluruh transaksi pembayaran berjalan aman dan cepat, mengelola uang tunai, serta mengawasi layanan transfer, QRIS, and dompet digital.</p>
                                </div>
                                <div class="tugas-card">
                                    <h4><i data-lucide="shield-check" style="color:#10B981;"></i>Stabilitas Sistem Keuangan</h4>
                                    <p>BI menjalankan kebijakan makroprudensial untuk mencegah risiko krisis ekonomi dan menjaga kesehatan ekosistem keuangan nasional.</p>
                                </div>
                            </div>
                        </div>

                        <div class="bi-tab-content" id="tab-wewenang" style="display: none;">
                            <div class="wewenang-grid">
                                <div class="wewenang-item">
                                    <div class="wewenang-badge-num">1</div>
                                    <div class="wewenang-text-container">
                                        <div class="wewenang-title">Menetapkan Sasaran Moneter</div>
                                        <div class="wewenang-desc">Menentukan arah target inflasi jangka pendek dan menengah.</div>
                                    </div>
                                </div>
                                <div class="wewenang-item">
                                    <div class="wewenang-badge-num">2</div>
                                    <div class="wewenang-text-container">
                                        <div class="wewenang-title">Menentukan Suku Bunga Acuan</div>
                                        <div class="wewenang-desc">Menetapkan suku bunga perbankan nasional (BI-Rate).</div>
                                    </div>
                                </div>
                                <div class="wewenang-item">
                                    <div class="wewenang-badge-num">3</div>
                                    <div class="wewenang-text-container">
                                        <div class="wewenang-title">Menerbitkan & Mengedarkan Uang</div>
                                        <div class="wewenang-desc">Hak tunggal mendistribusikan uang Rupiah yang sah ke seluruh nusantara.</div>
                                    </div>
                                </div>
                                <div class="wewenang-item">
                                    <div class="wewenang-badge-num">4</div>
                                    <div class="wewenang-text-container">
                                        <div class="wewenang-title">Menarik & Memusnahkan Uang</div>
                                        <div class="wewenang-desc">Menarik uang lusuh atau tidak layak edar secara aman.</div>
                                    </div>
                                </div>
                                <div class="wewenang-item">
                                    <div class="wewenang-badge-num">5</div>
                                    <div class="wewenang-text-container">
                                        <div class="wewenang-title">Mengatur Sistem Pembayaran</div>
                                        <div class="wewenang-desc">Mengevaluasi and memberi izin operasional bagi penyedia jasa pembayaran.</div>
                                    </div>
                                </div>
                                <div class="wewenang-item">
                                    <div class="wewenang-badge-num">6</div>
                                    <div class="wewenang-text-container">
                                        <div class="wewenang-title">Mengelola Cadangan Devisa</div>
                                        <div class="wewenang-desc">Menjaga likuiditas serta cadangan mata uang asing milik negara.</div>
                                    </div>
                                </div>
                                <div class="wewenang-item">
                                    <div class="wewenang-badge-num">7</div>
                                    <div class="wewenang-text-container">
                                        <div class="wewenang-title">Rekomendasi Kajian Ekonomi</div>
                                        <div class="wewenang-desc">Menyediakan analisis berkala kondisi ekonomi makro kepada pemerintah.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-grid cols-2">
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

    // 2. CIRI KEAMANAN
    } else if (page === 2) {
        content.innerHTML = `
            <span class="page-badge"><i data-lucide="graduation-cap"></i>Pendidikan Keuangan</span>
            <div class="split-block" style="margin-top:0;">
                <div>
                    <h1 class="title-h1">Ciri Keamanan<br>Rupiah</h1>
                    <p class="lead-text">Setiap lembar Rupiah memiliki berbagai unsur pengaman mutakhir yang dirancang untuk melindungi keaslian uang dan membantu masyarakat membedakan uang asli dari uang palsu.</p>
                    <div class="btn-row">
                        <a class="btn-fill" onclick="document.getElementById('section-keamanan').scrollIntoView({ behavior: 'smooth', block: 'start' });">Mulai Eksplorasi 3D <i data-lucide="arrow-down"></i></a>
                    </div>
                </div>
                <div class="hero-split-photo" style="position:relative;">
                    <img src="${imgPath}memeriksa_uang.jpg" alt="Memeriksa Uang" style="width: 100%; height: 220px; object-fit: cover; border-radius: 18px;">
                    <div class="float-badge">
                        <div class="icon-circle" style="margin-bottom:0;"><i data-lucide="lock"></i></div>
                        Aman &amp; Terverifikasi
                    </div>
                </div>
            </div>

            <div class="top-grid">
                <div>
                    <h3 class="section-heading" id="section-keamanan" style="margin-top:0; scroll-margin-top: 130px;">Metode 3D</h3>
                    <p class="lead-text">Langkah paling mendasar dan mudah untuk mengecek keaslian uang Rupiah adalah dengan metode 3D: Dilihat, Diraba, dan Diterawang.</p>

                    <div class="keamanan-tabs-wrapper">
                        <button class="keamanan-tab-btn active" onclick="switchKeamananTab(0)"><i data-lucide="eye"></i> Dilihat</button>
                        <button class="keamanan-tab-btn" onclick="switchKeamananTab(1)"><i data-lucide="hand"></i> Diraba</button>
                        <button class="keamanan-tab-btn" onclick="switchKeamananTab(2)"><i data-lucide="sun"></i> Diterawang</button>
                    </div>

                    <div class="keamanan-content-box">
                        <div class="keamanan-tab-content" style="display: block;">
                            <h4 style="font-size: 16.5px; font-weight: 800; color: var(--navy); margin-bottom: 12px;">Unsur Pengaman yang Tampak Langsung</h4>
                            <div class="keamanan-detail-grid">
                                <div class="keamanan-detail-item">
                                    <span class="keamanan-detail-title">Warna Cerah & Tajam</span>
                                    <span class="keamanan-detail-desc">Uang Rupiah asli dicetak menggunakan kombinasi warna kontras yang tajam dan presisi, sangat sulit ditiru oleh mesin cetak biasa.</span>
                                </div>
                                <div class="keamanan-detail-item">
                                    <span class="keamanan-detail-title">Optically Variable Ink (OVI)</span>
                                    <span class="keamanan-detail-desc">Terdapat logo Bank Indonesia di dalam perisai yang berubah warna jika dilihat dari sudut pandang berbeda.</span>
                                </div>
                                <div class="keamanan-detail-item">
                                    <span class="keamanan-detail-title">Benang Pengaman Rajutan</span>
                                    <span class="keamanan-detail-desc">Disematkan di dalam serat kertas, memantulkan warna berbeda jika digoyang-goyangkan di bawah cahaya.</span>
                                </div>
                            </div>
                        </div>

                        <div class="keamanan-tab-content" style="display: none;">
                            <h4 style="font-size: 16.5px; font-weight: 800; color: var(--navy); margin-bottom: 12px;">Tekstur Kasar dari Hasil Cetak Intaglio</h4>
                            <div class="keamanan-detail-grid">
                                <div class="keamanan-detail-item">
                                    <span class="keamanan-detail-title">Cetak Intaglio</span>
                                    <span class="keamanan-detail-desc">Bagian gambar pahlawan, lambang Garuda Pancasila, angka nominal, and tulisan Bank Indonesia terasa kasar saat disentuh.</span>
                                </div>
                                <div class="keamanan-detail-item">
                                    <span class="keamanan-detail-title">Kode Tuna Netra (Blind Code)</span>
                                    <span class="keamanan-detail-desc">Pasangan garis timbul pada sisi uang untuk mempermudah penyandang tuna netra mengenali nominal uang.</span>
                                </div>
                            </div>
                        </div>

                        <div class="keamanan-tab-content" style="display: none;">
                            <h4 style="font-size: 16.5px; font-weight: 800; color: var(--navy); margin-bottom: 12px;">Tanda Air dan Gambar Saling Isi</h4>
                            <div class="keamanan-detail-grid">
                                <div class="keamanan-detail-item">
                                    <span class="keamanan-detail-title">Tanda Air (Watermark)</span>
                                    <span class="keamanan-detail-desc">Saat diarahkan ke cahaya, akan terlihat siluet pahlawan nasional lengkap dengan logo ornamen BI di bawahnya.</span>
                                </div>
                                <div class="keamanan-detail-item">
                                    <span class="keamanan-detail-title">Rectoverso (Gambar Saling Isi)</span>
                                    <span class="keamanan-detail-desc">Potongan logo BI di sisi depan dan belakang menyatu sempurna membentuk logo utuh saat diterawang ke arah cahaya.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-grid cols-2" style="margin-top: 30px;">
                        <div class="info-card">
                            <img src="${imgPath}uang_50000.jpg" alt="Benang Pengaman" style="width:100%; border-radius:12px; height:110px; object-fit:cover; margin-bottom:14px;">
                            <div class="icon-circle" style="margin-bottom:8px;"><i data-lucide="minus"></i></div>
                            <h4>Benang Pengaman</h4>
                            <p>Disematkan rapi di dalam serat kertas uang, berubah warna dari berbagai sudut pandang.</p>
                        </div>
                        <div class="info-card">
                            <img src="${imgPath}uang_100000.jpg" alt="Cetak Intaglio" style="width:100%; border-radius:12px; height:110px; object-fit:cover; margin-bottom:14px;">
                            <div class="icon-circle" style="margin-bottom:8px;"><i data-lucide="printer"></i></div>
                            <h4>Cetak Intaglio</h4>
                            <p>Teknologi timbul berpresisi tinggi yang memberikan tekstur rabaan autentik pada uang kertas.</p>
                        </div>
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

    // 3. SEJARAH RUPIAH
    } else if (page === 3) {
        content.innerHTML = `
            <span class="page-badge"><i data-lucide="scroll"></i>Sejarah dan Budaya</span>
            <div class="split-block" style="margin-top:0;">
                <div>
                    <h1 class="title-h1">Menelusuri Jejak<br>Sejarah Rupiah</h1>
                    <p class="lead-text">Perjalanan panjang mata uang Indonesia, dari koin kerajaan hingga menjadi lambang kedaulatan bangsa yang kita kenal sekarang.</p>
                    <div class="btn-row">
                        <a class="btn-fill" onclick="document.getElementById('section-sejarah').scrollIntoView({ behavior: 'smooth', block: 'start' });">Mulai Belajar <i data-lucide="arrow-down"></i></a>
                    </div>
                </div>
                <div class="hero-split-photo" style="position:relative; width: 100%;">
                    <img src="${imgPath}kumpulan_uang_lama.jpg" alt="Sejarah Rupiah" style="width: 100%; height: 250px; object-fit: cover; border-radius: 18px;">
                    <div class="float-badge">
                        <div class="icon-circle" style="margin-bottom:0;"><i data-lucide="history"></i></div>
                        Edisi Sejarah
                    </div>
                </div>
            </div>

            <div class="top-grid">
                <div>
                    <h3 class="section-heading" id="section-sejarah" style="margin-top:0; scroll-margin-top: 130px;">Linimasa Sejarah</h3>
                    <p class="lead-text">Pilih era sejarah di bawah ini untuk mempelajari bagaimana alat pembayaran berkembang di Nusantara dari masa ke masa.</p>

                    <div class="sejarah-tabs-wrapper">
                        <button class="sejarah-tab-btn active" onclick="switchSejarahTab(0)"><i data-lucide="coins"></i> Masa Kerajaan</button>
                        <button class="sejarah-tab-btn" onclick="switchSejarahTab(1)"><i data-lucide="ship"></i> Era Kolonial</button>
                        <button class="sejarah-tab-btn" onclick="switchSejarahTab(2)"><i data-lucide="flag"></i> Era Kemerdekaan</button>
                    </div>

                    <div class="sejarah-content-box">
                        <div class="sejarah-tab-content" style="display: block;">
                            <h4 style="font-size: 16.5px; font-weight: 800; color: var(--navy); margin-bottom: 12px;">Masa Kerajaan Nusantara (Abad ke-9)</h4>
                            <p class="lead-text">Sebelum mengenal uang kertas, kerajaan-kerajaan besar di Nusantara telah menggunakan keping logam mulia sebagai simbol kedaulatan.</p>
                            
                            <div class="timeline-photos" style="margin-top:20px;">
                                <figure style="background: #F4F7FC; border-radius: 14px; overflow: hidden; text-align: center; padding: 15px;">
                                    <img src="${imgPath}uang_acehkuno.png" alt="Uang Aceh Kuno" style="width: 100%; height: 120px; object-fit: contain; border-radius: 8px;">
                                    <figcaption style="font-size: 12px; font-weight: 600; color: var(--muted); margin-top: 8px;">Koin Emas & Perak Mataram Kuno</figcaption>
                                </figure>
                                <figure style="background: #F4F7FC; border-radius: 14px; overflow: hidden; text-align: center; padding: 15px;">
                                    <img src="${imgPath}uang_gobog.png" alt="Uang Gobog" style="width: 100%; height: 120px; object-fit: contain; border-radius: 8px;">
                                    <figcaption style="font-size: 12px; font-weight: 600; color: var(--muted); margin-top: 8px;">Uang Gobog Majapahit</figcaption>
                                </figure>
                            </div>
                        </div>

                        <div class="sejarah-tab-content" style="display: none;">
                            <h4 style="font-size: 16.5px; font-weight: 800; color: var(--navy); margin-bottom: 12px;">Era Kolonialisme & Dominasi Gulden</h4>
                            <p class="lead-text">Masuknya VOC dan imperialisme pemerintah Hindia Belanda menggeser uang logam lokal dan memperkenalkan Gulden melalui De Javasche Bank.</p>
                            
                            <div class="colonial-card" style="margin-top:20px;">
                                <img src="${imgPath}gulden.jpg" alt="Gulden Hindia Belanda" style="width: 110px; height: 80px; object-fit: cover; border-radius: 10px; flex-shrink: 0;">
                                <div>
                                    <h5>Gulden Hindia Belanda</h5>
                                    <p>Sistem sirkulasi keuangan terpusat oleh De Javasche Bank yang memonopoli perputaran komoditas perkebunan.</p>
                                    <span class="tag-pill" style="background:#FEE2E2; color:#B91C1C;">Monopoli</span>
                                    <span class="tag-pill blue" style="background:#DBEAFE; color:#174C84;">De Javasche Bank</span>
                                </div>
                            </div>
                        </div>

                        <div class="sejarah-tab-content" style="display: none;">
                            <h4 style="font-size: 16.5px; font-weight: 800; color: var(--navy); margin-bottom: 12px;">Lahirnya Rupiah & Kedaulatan Finansial</h4>
                            <p class="lead-text">Pasca proklamasi kemerdekaan, negara Indonesia mengambil langkah berani menegaskan kedaulatannya melalui mata uang mandiri.</p>
                            
                            <div class="sejarah-detail-grid" style="margin-top: 20px;">
                                <div class="sejarah-detail-item">
                                    <span class="sejarah-detail-title">Penerbitan ORI (30 Oktober 1946)</span>
                                    <span class="sejarah-detail-desc">Oeang Republik Indonesia (ORI) resmi beredar sebagai bukti kedaulatan mutlak ekonomi bangsa.</span>
                                </div>
                                <div class="sejarah-detail-item" style="border-left-color: var(--navy);">
                                    <span class="sejarah-detail-title">Nasionalisasi Bank Indonesia (1953)</span>
                                    <span class="sejarah-detail-desc">De Javasche Bank resmi dinasionalisasi menjadi Bank Indonesia (BI), bank sentral pengelola Rupiah tunggal.</span>
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

    // 4. CARA MERAWAT (Metode 5J dengan Ikon Tepat & Fitur Interaktif Baru)
    } else if (page === 4) {
        content.innerHTML = `
            <div class="hero-photo-caption">
                <img src="${imgPath}merawat rupiah.jpg" alt="Cara Merawat Rupiah">
                <div class="cap">Cara Merawat Rupiah - RUPANTARA</div>
            </div>

            <span class="page-badge"><i data-lucide="shield-check"></i>Edukasi Cinta Rupiah</span>
            <h2 class="title-h1">Merawat Uang dengan Metode 5J</h2>
            <p class="lead-text">Rupiah adalah kehormatan bangsa. Menjaga kondisi fisik uang Rupiah tetap prima mencerminkan penghargaan kita terhadap kedaulatan negara. Terapkan prinsip <strong>5J</strong> untuk mencegah uang cepat lusuh dan rusak.</p>

            <!-- GRID 5J DENGAN IKON RELEVAN & WARNA MODERN -->
            <div class="care-5j-grid">
                <!-- 1. JANGAN DILIPAT -->
                <div class="care-5j-card">
                    <div class="care-icon-badge amber">
                        <i data-lucide="fold-vertical"></i>
                    </div>
                    <h4>1. Jangan Dilipat <span class="larangan-badge">Larangan</span></h4>
                    <p>Melipat uang kertas secara berulang menyebabkan serat selulosa patah dan meninggalkan bekas lekukan permanen yang membuat uang cepat robek di bagian tengah.</p>
                </div>

                <!-- 2. JANGAN DIREMAS -->
                <div class="care-5j-card">
                    <div class="care-icon-badge rose">
                        <i data-lucide="hand"></i>
                    </div>
                    <h4>2. Jangan Diremas <span class="larangan-badge">Larangan</span></h4>
                    <p>Meremas uang merusak lapisan pelindung uang dan mengaburkan tekstur cetak timbul (intaglio), sehingga mempersulit verifikasi keaslian uang.</p>
                </div>

                <!-- 3. JANGAN DICORET -->
                <div class="care-5j-card">
                    <div class="care-icon-badge purple">
                        <i data-lucide="pen-tool"></i>
                    </div>
                    <h4>3. Jangan Dicoret <span class="larangan-badge">Larangan</span></h4>
                    <p>Uang bukan media catatan. Coretan tinta atau spidol menutupi fitur pengaman mikro dan membuat uang dinilai Tidak Layak Edar (TLE) oleh sistem perbankan.</p>
                </div>

                <!-- 4. JANGAN DISTAPLES -->
                <div class="care-5j-card">
                    <div class="care-icon-badge orange">
                        <i data-lucide="paperclip"></i>
                    </div>
                    <h4>4. Jangan Distaples <span class="larangan-badge">Larangan</span></h4>
                    <p>Kawat staples melubangi kertas uang and dapat berkarat. Lubang kecil ini memicu robekan memanjang saat uang diproses di mesin hitung otomatis.</p>
                </div>

                <!-- 5. JANGAN DIBASAHI -->
                <div class="care-5j-card">
                    <div class="care-icon-badge cyan">
                        <i data-lucide="droplets"></i>
                    </div>
                    <h4>5. Jangan Dibasahi <span class="larangan-badge">Larangan</span></h4>
                    <p>Cairan membuat serat kertas mengembang dan lembek. Jika dikeringkan secara terburu-buru, uang akan menjadi kaku, rapuh, dan mudah terkoyak.</p>
                </div>

                <!-- 6. KARTU ANJURAN SIMPAN -->
                <div class="care-5j-card" style="border: 2px solid #10B981; background: #F0FDF4;">
                    <div class="care-icon-badge emerald">
                        <i data-lucide="wallet"></i>
                    </div>
                    <h4 style="color:#065F46;">Anjuran: Simpan Rapi <span class="larangan-badge" style="background:#D1FAE5; color:#065F46;">Solusi</span></h4>
                    <p style="color:#047857;">Gunakan dompet panjang yang tidak melipat uang. Pastikan tempat penyimpanan kering, bersih, dan bebas dari benda tajam.</p>
                </div>
            </div>

            <!-- FITUR INTERAKTIF: CHECKLIST KEBIASAAN MERAWAT RUPIAH -->
            <div class="interactive-checklist-box">
                <div class="checklist-header">
                    <div>
                        <h4 style="font-size: 16.5px; font-weight: 800; color: var(--navy); display:flex; align-items:center; gap:8px;">
                            <i data-lucide="sparkles" style="color:var(--blue-dark); width:20px; height:20px;"></i>
                            Cek Kebiasaanmu Merawat Rupiah
                        </h4>
                        <p style="font-size: 13px; color: var(--muted); margin-top: 3px;">Centang kebiasaan baik yang sudah rutin kamu terapkan sehari-hari:</p>
                    </div>
                    <div id="care-score-text" style="font-size: 13.5px; background: #fff; padding: 6px 14px; border-radius: 12px; border: 1px solid var(--border);">
                        <span style="color:var(--muted); font-weight:600;">Pilih kebiasaan di bawah 👇</span>
                    </div>
                </div>

                <div class="checklist-items-grid">
                    <label class="custom-check-item">
                        <input type="checkbox" class="care-check-input" onchange="updateCareScore()">
                        <span class="custom-check-text">Saya tidak melipat uang di kantong celana</span>
                    </label>
                    <label class="custom-check-item">
                        <input type="checkbox" class="care-check-input" onchange="updateCareScore()">
                        <span class="custom-check-text">Saya selalu menyimpan uang lurus di dompet</span>
                    </label>
                    <label class="custom-check-item">
                        <input type="checkbox" class="care-check-input" onchange="updateCareScore()">
                        <span class="custom-check-text">Saya tidak pernah menstaples nota pada uang</span>
                    </label>
                    <label class="custom-check-item">
                        <input type="checkbox" class="care-check-input" onchange="updateCareScore()">
                        <span class="custom-check-text">Saya memastikan tangan kering saat memegang uang</span>
                    </label>
                </div>
            </div>

            <div class="tip-box">
                <i data-lucide="lightbulb"></i>
                <div><strong>Tahukah Kamu?</strong> Uang Rupiah yang dirawat dengan baik dapat bertahan layak edar hingga bertahun-tahun, menghemat anggaran negara untuk pencetakan uang baru!</div>
            </div>

            ${prevNextHTML(4)}
        `;

    // 5. BANGGA RUPIAH (Rupiah Digital)
    } else if (page === 5) {
        content.innerHTML = `
            <span class="page-badge"><i data-lucide="sparkles"></i>Inovasi Bank Sentral Masa Depan</span>
            <div class="split-block" style="margin-top:0;">
                <div>
                    <h1 class="title-h1">Rupiah Digital: Masa Depan Kedaulatan Ekonomi</h1>
                    <p class="lead-text">Central Bank Digital Currency (CBDC) atau <strong>Rupiah Digital</strong> adalah wujud transformasi digital moneter Indonesia dalam <em>Proyek Garuda</em> untuk menjaga kedaulatan Rupiah di era ekonomi serba digital.</p>
                    <div class="btn-row">
                        <a class="btn-fill" onclick="document.getElementById('section-digital').scrollIntoView({ behavior: 'smooth', block: 'start' });">Eksplorasi Sekarang <i data-lucide="arrow-down"></i></a>
                    </div>
                </div>
                <img src="${imgPath}cbdc_digital.png" alt="Rupiah Digital" style="border-radius:18px; box-shadow: 0 10px 25px rgba(0,0,0,0.06);">
            </div>

            <div class="top-grid" id="section-digital" style="scroll-margin-top: 130px;">
                <div>
                    <h3 class="section-heading" style="margin-top:0;">Eksplorasi Proyek Garuda &amp; Ekosistem CBDC</h3>
                    <p class="lead-text">Klik tab di bawah untuk melihat pilar desain, keunggulan operasional, serta perbedaan mendasar Rupiah Digital dibanding alat bayar lainnya.</p>

                    <div class="cbdc-tabs-wrapper">
                        <button class="cbdc-tab-btn active" onclick="switchCbdcTab(0)"><i data-lucide="layers"></i> 3 Pilar Desain</button>
                        <button class="cbdc-tab-btn" onclick="switchCbdcTab(1)"><i data-lucide="zap"></i> Fitur Unggulan</button>
                        <button class="cbdc-tab-btn" onclick="switchCbdcTab(2)"><i data-lucide="scale"></i> Matriks Perbandingan</button>
                    </div>

                    <div class="cbdc-content-box">
                        <div class="cbdc-tab-content" style="display: block;">
                            <h4 style="font-size: 16.5px; font-weight: 800; color: var(--navy); margin-bottom: 14px;">Arsitektur Proyek Garuda Bank Indonesia</h4>
                            <div class="cbdc-detail-grid">
                                <div class="cbdc-detail-item">
                                    <span class="cbdc-detail-title">1. Wholesale Digital Rupiah (w-Digital Rupiah)</span>
                                    <span class="cbdc-detail-desc">Akses terbatas untuk perbankan dan institusi keuangan besar dalam transaksi pasar uang antarbank, penyelesaian sekuritas, dan transfer bernilai jumbo berkecepatan tinggi.</span>
                                </div>
                                <div class="cbdc-detail-item" style="border-left-color: #3B82F6;">
                                    <span class="cbdc-detail-title">2. Retail Digital Rupiah (r-Digital Rupiah)</span>
                                    <span class="cbdc-detail-desc">Dirancang untuk digunakan langsung oleh masyarakat umum dan UMKM untuk transaksi belanja sehari-hari layaknya uang tunai fisik.</span>
                                </div>
                                <div class="cbdc-detail-item" style="border-left-color: #10B981;">
                                    <span class="cbdc-detail-title">3. Interoperabilitas & Cross-Border Payment</span>
                                    <span class="cbdc-detail-desc">Kemampuan terhubung mulus antar-platform lokal dan pembayaran lintas negara tanpa konversi biaya perantara yang mahal.</span>
                                </div>
                            </div>
                        </div>

                        <div class="cbdc-tab-content" style="display: none;">
                            <h4 style="font-size: 16.5px; font-weight: 800; color: var(--navy); margin-bottom: 14px;">Mengapa Indonesia Membutuhkan Rupiah Digital?</h4>
                            <div class="tugas-card-grid">
                                <div class="tugas-card">
                                    <h4><i data-lucide="shield-check" style="color:#10B981;"></i>Dijamin Penuh oleh BI</h4>
                                    <p>Berbeda dengan kripto yang nilainya fluktuatif tanpa jaminan, Rupiah Digital adalah kewajiban langsung Bank Sentral sehingga bernilai pasti 1:1 dengan Rupiah fisik.</p>
                                </div>
                                <div class="tugas-card">
                                    <h4><i data-lucide="wifi-off" style="color:#3B82F6;"></i>Fitur Offline Transaksi</h4>
                                    <p>Dapat digunakan untuk bertransaksi bahkan di daerah pelosok yang mengalami kendala sinyal internet melalui teknologi token enkripsi aman.</p>
                                </div>
                                <div class="tugas-card">
                                    <h4><i data-lucide="sparkles" style="color:#F59E0B;"></i>Programmable Money</h4>
                                    <p>Mendukung otomatisasi penyaluran bantuan sosial pemerintah (bansos) agar tepat sasaran dan tidak dapat disalahgunakan.</p>
                                </div>
                            </div>
                        </div>

                        <div class="cbdc-tab-content" style="display: none;">
                            <h4 style="font-size: 16.5px; font-weight: 800; color: var(--navy); margin-bottom: 14px;">Membedakan Rupiah Digital vs Uang Lainnya</h4>
                            <div class="compare-grid">
                                <div class="compare-card">
                                    <div style="font-size: 12px; font-weight: 700; color: var(--muted); text-transform: uppercase;">Tradisional</div>
                                    <div style="font-weight: 800; font-size: 15px; color: var(--navy);">Uang Tunai Kertas</div>
                                    <p style="font-size: 12.5px; color: var(--muted);">Diterbitkan BI, berbentuk fisik, rawan rusak atau lusuh, memerlukan biaya cetak & distribusi logistik.</p>
                                </div>
                                <div class="compare-card">
                                    <div style="font-size: 12px; font-weight: 700; color: var(--muted); text-transform: uppercase;">Komersial</div>
                                    <div style="font-weight: 800; font-size: 15px; color: var(--navy);">E-Wallet / Saldo Bank</div>
                                    <p style="font-size: 12.5px; color: var(--muted);">Dikelola bank komersial/fintech swasta, merupakan piutang masyarakat terhadap penerbit swasta.</p>
                                </div>
                                <div class="compare-card highlighted">
                                    <div style="font-size: 12px; font-weight: 700; color: var(--blue-dark); text-transform: uppercase;">Masa Depan</div>
                                    <div style="font-weight: 800; font-size: 15px; color: var(--blue-dark);">Rupiah Digital (CBDC)</div>
                                    <p style="font-size: 12.5px; color: var(--navy-dark); font-weight: 500;">Diterbitkan langsung oleh Bank Indonesia, tanpa risiko gagal bayar, berdaulat penuh, efisiensi maksimal.</p>
                                </div>
                                <div class="compare-card">
                                    <div style="font-size: 12px; font-weight: 700; color: #EF4444; text-transform: uppercase;">Desentralisasi</div>
                                    <div style="font-weight: 800; font-size: 15px; color: var(--navy);">Kripto / Bitcoin</div>
                                    <p style="font-size: 12.5px; color: var(--muted);">Tidak memiliki penerbit resmi, nilai sangat berfluktuasi, bukan alat pembayaran yang sah di wilayah NKRI.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="split-block" style="margin-top: 30px;">
                        <img src="${imgPath}infrastruktur_modern.png" alt="Infrastruktur Pembayaran Modern">
                        <div>
                            <h3 class="section-heading" style="margin-top:0;">Infrastruktur Terintegrasi</h3>
                            <p class="lead-text">Pengembangan Rupiah Digital didukung oleh sistem jaringan terpadu berkeamanan tinggi yang menghubungkan masyarakat perkotaan hingga pelosok 3T (Terdepan, Terluar, Tertinggal).</p>
                        </div>
                    </div>

                    <div class="callout-box">
                        <i data-lucide="check-circle-2"></i>
                        <div>
                            <h4>Satu Bahasa, Satu Nusa, Satu Rupiah</h4>
                            <p>Kehadiran Rupiah Digital memastikan bahwa di era Web3 dan kecerdasan buatan sekalipun, kedaulatan moneter Indonesia tetap terjaga kokoh di tangan rakyatnya.</p>
                        </div>
                    </div>

                    ${prevNextHTML(5)}
                </div>

                <aside class="toc-box">
                    <h4>Daftar Isi</h4>
                    <a href="#">Arsitektur Proyek</a>
                    <a href="#">Fitur Unggulan</a>
                    <a href="#">Matriks Perbandingan</a>
                    <div class="toc-progress">
                        <span class="label">Progres Belajar &nbsp; 100%</span>
                        <div class="progress-track"><div class="progress-fill" style="width:100%; background:#22C55E;"></div></div>
                    </div>
                </aside>
            </div>
        `;
    }

    // Update status aktif pada menu sidebar
    const items = document.querySelectorAll(".materi-item");
    items.forEach(item => item.classList.remove("active"));
    if (items[page]) items[page].classList.add("active");

    window.scrollTo({ top: 0, behavior: "smooth" });
    lucide.createIcons();
}

// Inisialisasi halaman saat pertama kali dimuat
showMateri(0);
lucide.createIcons();
</script>

</body>
</html>