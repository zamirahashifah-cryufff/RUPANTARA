<?php
session_start();
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

    <title>RUPANTARA - Teka Teki Silang Rupiah</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Canvas Confetti untuk Efek Menang -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

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
            --correct: #10B981;
            --wrong: #EF4444;
            --active-cell: #FEF08A;
            --highlight-cell: #E0F2FE;
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
           MAIN GAME CONTAINER
        ===================================================== */
        .game-wrapper {
            width: 90%;
            max-width: 1300px;
            margin: 40px auto;
        }

        .game-header {
            background: linear-gradient(135deg, #0A3458 0%, #0E3F6B 50%, #174C84 100%);
            border-radius: 24px;
            padding: 35px 40px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            box-shadow: 0 10px 30px rgba(14, 63, 107, 0.15);
            margin-bottom: 30px;
        }

        .game-header-info h1 {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .game-header-info p {
            color: #CFE3FA;
            font-size: 14.5px;
            max-width: 600px;
        }

        .game-stats {
            display: flex;
            gap: 15px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 12px 20px;
            border-radius: 14px;
            text-align: center;
            min-width: 110px;
        }

        .stat-value {
            font-size: 20px;
            font-weight: 800;
            color: #FFFFFF;
        }

        .stat-label {
            font-size: 11.5px;
            color: #CFE3FA;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .game-layout {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 30px;
            align-items: start;
        }

        /* BOARD SECTION */
        .board-container {
            background: white;
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 8px 30px rgba(0, 48, 135, 0.04);
            border: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .controls-toolbar {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
            flex-wrap: wrap;
            gap: 12px;
        }

        .hint-badge {
            background: #EAF2FF;
            color: var(--blue-dark);
            font-weight: 700;
            font-size: 13px;
            padding: 6px 14px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-group {
            display: flex;
            gap: 10px;
        }

        .btn-game {
            border: none;
            padding: 10px 18px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .btn-check {
            background: var(--blue-dark);
            color: white;
        }

        .btn-check:hover {
            background: var(--navy-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(23, 76, 132, 0.2);
        }

        .btn-hint {
            background: #FFFBEB;
            color: #D97706;
            border: 1px solid #FDE68A;
        }

        .btn-hint:hover {
            background: #FEF3C7;
        }

        .btn-reset {
            background: #F1F5F9;
            color: var(--muted);
        }

        .btn-reset:hover {
            background: #E2E8F0;
            color: var(--text);
        }

        /* GRID TTS MATRIX */
        .tts-grid {
            display: grid;
            grid-template-columns: repeat(10, 44px);
            grid-template-rows: repeat(7, 44px);
            gap: 5px;
            padding: 15px;
            background: #F4F7FC;
            border-radius: 18px;
            border: 1px solid #E2E8F0;
            user-select: none;
        }

        .grid-cell {
            position: relative;
            width: 44px;
            height: 44px;
            background: white;
            border-radius: 8px;
            border: 1.5px solid #CBD5E1;
            transition: all 0.2s ease;
        }

        .grid-cell.empty {
            background: transparent;
            border-color: transparent;
        }

        .grid-cell input {
            width: 100%;
            height: 100%;
            border: none;
            outline: none;
            background: transparent;
            text-align: center;
            font-size: 18px;
            font-weight: 800;
            color: var(--navy);
            text-transform: uppercase;
            caret-color: var(--blue);
            cursor: pointer;
        }

        .grid-cell .cell-number {
            position: absolute;
            top: 2px;
            left: 3px;
            font-size: 9.5px;
            font-weight: 800;
            color: var(--muted);
            line-height: 1;
            pointer-events: none;
        }

        .grid-cell.highlighted {
            background: var(--highlight-cell);
            border-color: var(--blue);
        }

        .grid-cell.active-input {
            background: var(--active-cell);
            border-color: #CA8A04;
            box-shadow: 0 0 0 2px rgba(202, 138, 4, 0.3);
        }

        .grid-cell.is-correct {
            background: #ECFDF5 !important;
            border-color: var(--correct) !important;
        }
        .grid-cell.is-correct input {
            color: #065F46 !important;
        }

        .grid-cell.is-wrong {
            background: #FEF2F2 !important;
            border-color: var(--wrong) !important;
            animation: shake 0.35s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-4px); }
            75% { transform: translateX(4px); }
        }

        /* CLUES SECTION */
        .clues-container {
            background: white;
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 8px 30px rgba(0, 48, 135, 0.04);
            border: 1px solid var(--border);
        }

        .clue-group {
            margin-bottom: 24px;
        }

        .clue-group-title {
            font-size: 16px;
            font-weight: 800;
            color: var(--navy);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 2px solid #F1F5F9;
            padding-bottom: 8px;
        }

        .clue-group-title i {
            color: var(--blue-dark);
        }

        .clue-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .clue-item {
            padding: 12px 16px;
            border-radius: 12px;
            background: #F8FAFF;
            border: 1px solid #EAF2FF;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .clue-item:hover {
            background: #F0F7FF;
            border-color: var(--blue);
            transform: translateX(4px);
        }

        .clue-item.active {
            background: #EAF2FF;
            border-color: var(--blue-dark);
            box-shadow: 0 2px 8px rgba(23, 76, 132, 0.08);
        }

        .clue-item.solved {
            background: #F0FDF4;
            border-color: #BBF7D0;
            opacity: 0.75;
        }

        .clue-num {
            background: var(--blue-dark);
            color: white;
            font-size: 11px;
            font-weight: 800;
            width: 22px;
            height: 22px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .clue-item.solved .clue-num {
            background: var(--correct);
        }

        .clue-text {
            font-size: 13.5px;
            color: #334155;
            font-weight: 500;
            line-height: 1.5;
        }

        .clue-text strong {
            color: var(--navy);
            font-weight: 700;
        }

        /* MODAL VICTORY */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(10, 52, 88, 0.6);
            backdrop-filter: blur(8px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 20px;
        }

        .modal-card {
            background: white;
            border-radius: 24px;
            padding: 40px;
            max-width: 460px;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
            animation: zoomIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes zoomIn {
            from { transform: scale(0.85); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .modal-icon {
            width: 70px;
            height: 70px;
            background: #ECFDF5;
            color: var(--correct);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            font-size: 32px;
        }

        .modal-card h2 {
            color: var(--navy);
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .modal-card p {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 24px;
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
        @media (max-width: 992px) {
            .game-layout {
                grid-template-columns: 1fr;
            }
            .tts-grid {
                grid-template-columns: repeat(10, 36px);
                grid-template-rows: repeat(7, 36px);
            }
            .grid-cell {
                width: 36px;
                height: 36px;
            }
            .grid-cell input {
                font-size: 15px;
            }
        }

        @media (max-width: 900px) {
            nav { width: 95%; padding: 0 16px; }
            .nav-links { display: none; }
            .footer-main { grid-template-columns: 1fr; gap: 40px; }
            .footer-bottom { justify-content: center; text-align: center; flex-direction: column-reverse; }
        }

        @media (max-width: 480px) {
            .tts-grid {
                grid-template-columns: repeat(10, 29px);
                grid-template-rows: repeat(7, 29px);
                padding: 8px;
                gap: 3px;
            }
            .grid-cell {
                width: 29px;
                height: 29px;
            }
            .grid-cell input {
                font-size: 13px;
            }
            .grid-cell .cell-number {
                font-size: 8px;
            }
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
        <li><a href="../MATERI/edukasi.php">Edukasi</a></li>
        <li><a href="../QUIZ/quiz_intro.php" class="active">Quiz & Game</a></li>
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

<!-- MAIN GAME CONTAINER -->
<div class="game-wrapper">
    <!-- BANNER ATAS -->
    <div class="game-header">
        <div class="game-header-info">
            <h1><i data-lucide="puzzle"></i> TTS Gambar Uang Rupiah</h1>
            <p>Uji ketelitianmu mengenai gambar pahlawan, seni budaya, dan flora-fauna yang tertera pada lembaran mata uang Rupiah kita!</p>
        </div>
        <div class="game-stats">
            <div class="stat-card">
                <div class="stat-value" id="score-text">0/7</div>
                <div class="stat-label">Terjawab</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" id="timer-text">00:00</div>
                <div class="stat-label">Waktu</div>
            </div>
        </div>
    </div>

    <!-- GAMEPLAY AREA (GRID & PERTANYAAN) -->
    <div class="game-layout">
        <!-- PAPAN KOTAK TTS -->
        <div class="board-container">
            <div class="controls-toolbar">
                <span class="hint-badge">
                    <i data-lucide="sparkles" style="width:16px; height:16px;"></i>
                    Sisa Bantuan: <strong id="hint-count">3</strong>
                </span>
                <div class="btn-group">
                    <button class="btn-game btn-hint" onclick="useHint()">
                        <i data-lucide="lightbulb" style="width:16px; height:16px;"></i> Bantuan
                    </button>
                    <button class="btn-game btn-reset" onclick="resetBoard()">
                        <i data-lucide="rotate-ccw" style="width:16px; height:16px;"></i> Reset
                    </button>
                    <button class="btn-game btn-check" onclick="checkAnswers(true)">
                        <i data-lucide="check-circle-2" style="width:16px; height:16px;"></i> Periksa
                    </button>
                </div>
            </div>

            <!-- RENDER GRID 10x7 -->
            <div class="tts-grid" id="tts-grid"></div>
        </div>

        <!-- DAFTAR SOAL / CLUES -->
        <div class="clues-container">
            <!-- MENDATAR -->
            <div class="clue-group">
                <div class="clue-group-title">
                    <i data-lucide="arrow-right"></i> Mendatar (Across)
                </div>
                <div class="clue-list">
                    <div class="clue-item" id="clue-1" onclick="highlightWord('1-mendatar')">
                        <div class="clue-num">1</div>
                        <div class="clue-text"><strong>(8 Huruf)</strong> Tokoh Proklamator utama yang gambarnya ada di uang Rp100.000.</div>
                    </div>
                    <div class="clue-item" id="clue-3" onclick="highlightWord('3-mendatar')">
                        <div class="clue-num">3</div>
                        <div class="clue-text"><strong>(7 Huruf)</strong> Uang sisa lebih bayar yang diterima pembeli saat bertransaksi tunai.</div>
                    </div>
                    <div class="clue-item" id="clue-5" onclick="highlightWord('5-mendatar')">
                        <div class="clue-num">5</div>
                        <div class="clue-text"><strong>(6 Huruf)</strong> Wadah untuk menyimpan uang kertas agar tidak terlipat sesuai prinsip 5J.</div>
                    </div>
                    <div class="clue-item" id="clue-6" onclick="highlightWord('6-mendatar')">
                        <div class="clue-num">6</div>
                        <div class="clue-text"><strong>(3 Huruf)</strong> Singkatan mata uang pertama Republik Indonesia yang terbit 30 Oktober 1946.</div>
                    </div>
                </div>
            </div>

            <!-- MENURUN -->
            <div class="clue-group">
                <div class="clue-group-title">
                    <i data-lucide="arrow-down"></i> Menurun (Down)
                </div>
                <div class="clue-list">
                    <div class="clue-item" id="clue-2" onclick="highlightWord('2-menurun')">
                        <div class="clue-num">2</div>
                        <div class="clue-text"><strong>(6 Huruf)</strong> Satwa langka khas NTT yang ada pada gambar uang Rp50.000.</div>
                    </div>
                    <div class="clue-item" id="clue-4" onclick="highlightWord('4-menurun')">
                        <div class="clue-num">4</div>
                        <div class="clue-text"><strong>(5 Huruf)</strong> Gunung berapi indah di Jawa Timur pada sisi belakang uang Rp2.000.</div>
                    </div>
                    <div class="clue-item" id="clue-7" onclick="highlightWord('7-menurun')">
                        <div class="clue-num">7</div>
                        <div class="clue-text"><strong>(3 Huruf)</strong> Singkatan tinta berubah warna (<em>Optically Variable Ink</em>) pengaman uang kertas.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL POPUP SELESAI -->
<div class="modal-overlay" id="victory-modal">
    <div class="modal-card">
        <div class="modal-icon">
            <i data-lucide="trophy"></i>
        </div>
        <h2>Luar Biasa! 🎉</h2>
        <p>Kamu berhasil memecahkan semua teka-teki silang gambar mata uang Rupiah dengan sempurna!</p>
        <button class="btn-game btn-check" style="width: 100%; justify-content: center; padding: 14px;" onclick="resetBoard(); document.getElementById('victory-modal').style.display='none';">
            Main Lagi
        </button>
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
                <a href="../BERANDA/beranda.php"><i data-lucide="chevron-right" style="width:14px; height:14px;"></i>Beranda</a>
                <a href="../TENTANG RUPIAH/tentangrupiah.php"><i data-lucide="chevron-right" style="width:14px; height:14px;"></i>Tentang Rupiah</a>
                <a href="../MATERI/edukasi.php"><i data-lucide="chevron-right" style="width:14px; height:14px;"></i>Edukasi</a>
                <a href="../QUIZ/quiz_intro.php"><i data-lucide="chevron-right" style="width:14px; height:14px;"></i>Quiz & Game</a>
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

<!-- SCRIPT LOGIKA GAME TTS -->
<script>
// Definisi Grid TTS (7 Baris x 10 Kolom)
const ROWS = 7;
const COLS = 10;

// Data Kata & Kunci Jawaban (Diperbarui: 3-mendatar = KEMBALI)
const WORDS = [
    { id: '1-mendatar', num: 1, dir: 'across', word: 'SOEKARNO', r: 0, c: 1 },
    { id: '2-menurun',  num: 2, dir: 'down',   word: 'KOMODO',   r: 0, c: 4 },
    { id: '7-menurun',  num: 7, dir: 'down',   word: 'OVI',      r: 0, c: 8 },
    { id: '3-mendatar', num: 3, dir: 'across', word: 'KEMBALI',  r: 2, c: 2 },
    { id: '4-menurun',  num: 4, dir: 'down',   word: 'BROMO',    r: 2, c: 5 },
    { id: '5-mendatar', num: 5, dir: 'across', word: 'DOMPET',   r: 4, c: 4 },
    { id: '6-mendatar', num: 6, dir: 'across', word: 'ORI',      r: 6, c: 5 }
];

// Matriks Cell Data
let matrix = Array(ROWS).fill(null).map(() => Array(COLS).fill(null));
let hintsLeft = 3;
let timerSeconds = 0;
let timerInterval = null;
let currentActiveWord = null;

// Mengisi Peta Karakter & Label Nomor
WORDS.forEach(w => {
    for (let i = 0; i < w.word.length; i++) {
        let currR = w.dir === 'across' ? w.r : w.r + i;
        let currC = w.dir === 'across' ? w.c + i : w.c;
        
        if (!matrix[currR][currC]) {
            matrix[currR][currC] = {
                char: w.word[i],
                words: [w.id],
                number: (i === 0) ? w.num : null
            };
        } else {
            matrix[currR][currC].words.push(w.id);
            if (i === 0 && !matrix[currR][currC].number) {
                matrix[currR][currC].number = w.num;
            }
        }
    }
});

// Render Grid ke HTML
function renderGrid() {
    const gridEl = document.getElementById('tts-grid');
    gridEl.innerHTML = '';

    for (let r = 0; r < ROWS; r++) {
        for (let c = 0; c < COLS; c++) {
            const cellData = matrix[r][c];
            const cellDiv = document.createElement('div');
            cellDiv.className = 'grid-cell' + (cellData ? '' : ' empty');
            cellDiv.id = `cell-${r}-${c}`;

            if (cellData) {
                if (cellData.number) {
                    const numSpan = document.createElement('span');
                    numSpan.className = 'cell-number';
                    numSpan.innerText = cellData.number;
                    cellDiv.appendChild(numSpan);
                }

                const input = document.createElement('input');
                input.maxLength = 1;
                input.autocomplete = 'off';
                input.dataset.r = r;
                input.dataset.c = c;

                // Event Listeners Input
                input.addEventListener('focus', () => onCellFocus(r, c));
                input.addEventListener('input', (e) => onCellInput(e, r, c));
                input.addEventListener('keydown', (e) => onCellKeyDown(e, r, c));

                cellDiv.appendChild(input);
            }
            gridEl.appendChild(cellDiv);
        }
    }
}

// Navigasi Fokus dan Input
function onCellFocus(r, c) {
    const cellData = matrix[r][c];
    if (!cellData) return;

    // Pilih kata yang akan disorot
    let selectedWordId = cellData.words[0];
    if (currentActiveWord && cellData.words.includes(currentActiveWord.id)) {
        selectedWordId = currentActiveWord.id;
    }
    highlightWord(selectedWordId, false);
}

function onCellInput(e, r, c) {
    const val = e.target.value.toUpperCase();
    e.target.value = val;

    if (val && currentActiveWord) {
        moveToNextCell(r, c, 1);
    }
    checkAnswers(false);
}

function onCellKeyDown(e, r, c) {
    if (e.key === 'Backspace' && !e.target.value) {
        moveToNextCell(r, c, -1);
    } else if (e.key === 'ArrowRight') {
        moveTo(r, c + 1);
    } else if (e.key === 'ArrowLeft') {
        moveTo(r, c - 1);
    } else if (e.key === 'ArrowDown') {
        moveTo(r + 1, c);
    } else if (e.key === 'ArrowUp') {
        moveTo(r - 1, c);
    }
}

function moveToNextCell(r, c, step) {
    if (!currentActiveWord) return;
    const w = currentActiveWord;
    let nextR = r + (w.dir === 'down' ? step : 0);
    let nextC = c + (w.dir === 'across' ? step : 0);

    const nextInput = document.querySelector(`#cell-${nextR}-${nextC} input`);
    if (nextInput) {
        nextInput.focus();
        nextInput.select();
    }
}

function moveTo(r, c) {
    const target = document.querySelector(`#cell-${r}-${c} input`);
    if (target) target.focus();
}

// Highlight Kata & Soal
function highlightWord(wordId, setFocus = true) {
    const wordObj = WORDS.find(w => w.id === wordId);
    if (!wordObj) return;

    currentActiveWord = wordObj;

    // Bersihkan highlight lama
    document.querySelectorAll('.grid-cell').forEach(c => {
        c.classList.remove('highlighted', 'active-input');
    });
    document.querySelectorAll('.clue-item').forEach(cl => cl.classList.remove('active'));

    // Highlight soal aktif
    const clueElem = document.getElementById(`clue-${wordObj.num}`);
    if (clueElem) clueElem.classList.add('active');

    // Highlight sel-sel terkait
    for (let i = 0; i < wordObj.word.length; i++) {
        let currR = wordObj.dir === 'across' ? wordObj.r : wordObj.r + i;
        let currC = wordObj.dir === 'across' ? wordObj.c + i : wordObj.c;
        const cell = document.getElementById(`cell-${currR}-${currC}`);
        if (cell) cell.classList.add('highlighted');
    }

    if (setFocus) {
        const firstInput = document.querySelector(`#cell-${wordObj.r}-${wordObj.c} input`);
        if (firstInput) firstInput.focus();
    }
}

// Cek Jawaban
function checkAnswers(showWarning = false) {
    let solvedWords = 0;

    WORDS.forEach(w => {
        let wordComplete = true;
        let wordCorrect = true;

        for (let i = 0; i < w.word.length; i++) {
            let currR = w.dir === 'across' ? w.r : w.r + i;
            let currC = w.dir === 'across' ? w.c + i : w.c;
            const input = document.querySelector(`#cell-${currR}-${currC} input`);
            
            if (!input || !input.value) {
                wordComplete = false;
                wordCorrect = false;
            } else if (input.value.toUpperCase() !== w.word[i]) {
                wordCorrect = false;
            }
        }

        const clueItem = document.getElementById(`clue-${w.num}`);
        if (wordCorrect) {
            solvedWords++;
            if (clueItem) clueItem.classList.add('solved');
            // Tandai sel hijau
            for (let i = 0; i < w.word.length; i++) {
                let currR = w.dir === 'across' ? w.r : w.r + i;
                let currC = w.dir === 'across' ? w.c + i : w.c;
                const cell = document.getElementById(`cell-${currR}-${currC}`);
                if (cell) cell.classList.add('is-correct');
            }
        } else {
            if (clueItem) clueItem.classList.remove('solved');
            if (showWarning && wordComplete) {
                for (let i = 0; i < w.word.length; i++) {
                    let currR = w.dir === 'across' ? w.r : w.r + i;
                    let currC = w.dir === 'across' ? w.c + i : w.c;
                    const cell = document.getElementById(`cell-${currR}-${currC}`);
                    if (cell) {
                        cell.classList.add('is-wrong');
                        setTimeout(() => cell.classList.remove('is-wrong'), 800);
                    }
                }
            }
        }
    });

    document.getElementById('score-text').innerText = `${solvedWords}/${WORDS.length}`;

    // Menang!
    if (solvedWords === WORDS.length) {
        clearInterval(timerInterval);
        confetti({ particleCount: 120, spread: 80, origin: { y: 0.6 } });
        setTimeout(() => {
            document.getElementById('victory-modal').style.display = 'flex';
        }, 500);
    }
}

// Bantuan (Hint)
function useHint() {
    if (hintsLeft <= 0) {
        alert('Kesempatan bantuanmu sudah habis!');
        return;
    }

    const emptyInputs = [];
    WORDS.forEach(w => {
        for (let i = 0; i < w.word.length; i++) {
            let currR = w.dir === 'across' ? w.r : w.r + i;
            let currC = w.dir === 'across' ? w.c + i : w.c;
            const input = document.querySelector(`#cell-${currR}-${currC} input`);
            if (input && input.value.toUpperCase() !== w.word[i]) {
                emptyInputs.push({ input, char: w.word[i] });
            }
        }
    });

    if (emptyInputs.length > 0) {
        const randomTarget = emptyInputs[Math.floor(Math.random() * emptyInputs.length)];
        randomTarget.input.value = randomTarget.char;
        hintsLeft--;
        document.getElementById('hint-count').innerText = hintsLeft;
        checkAnswers(false);
    }
}

// Reset Game
function resetBoard() {
    document.querySelectorAll('.grid-cell input').forEach(input => input.value = '');
    document.querySelectorAll('.grid-cell').forEach(cell => cell.classList.remove('is-correct', 'is-wrong', 'highlighted'));
    document.querySelectorAll('.clue-item').forEach(clue => clue.classList.remove('solved', 'active'));
    document.getElementById('score-text').innerText = `0/${WORDS.length}`;
    hintsLeft = 3;
    document.getElementById('hint-count').innerText = hintsLeft;
    timerSeconds = 0;
    highlightWord('1-mendatar');
}

// Timer
function startTimer() {
    timerInterval = setInterval(() => {
        timerSeconds++;
        const mins = String(Math.floor(timerSeconds / 60)).padStart(2, '0');
        const secs = String(timerSeconds % 60).padStart(2, '0');
        document.getElementById('timer-text').innerText = `${mins}:${secs}`;
    }, 1000);
}

// Inisialisasi Saat Halaman Terbuka
window.addEventListener('DOMContentLoaded', () => {
    renderGrid();
    highlightWord('1-mendatar');
    startTimer();
    lucide.createIcons();
});
</script>

</body>
</html>