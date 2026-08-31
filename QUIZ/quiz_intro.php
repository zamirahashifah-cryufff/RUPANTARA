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
  <title>RUPANTARA - Quiz & Game Rupiah</title>
  
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
      --card-bg: #FFFFFF;
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
      font-size: 14.5px;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      overflow-x: hidden;
    }

    /* =====================================================
       NAVBAR (Glassmorphism Floating)
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
      text-decoration: none;
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
       COMPACT PAGE LAYOUT
    ===================================================== */
    .page-content {
      flex: 1;
      padding: 30px 16px 20px;
    }

    .page-wrapper {
      max-width: 1240px;
      margin: 0 auto;
    }

    .section-header {
      text-align: center;
      margin-bottom: 28px;
    }

    .section-tag {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: #EAF2FF;
      color: var(--blue-dark);
      padding: 4px 14px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 8px;
    }

    .section-title {
      font-size: 26px;
      font-weight: 800;
      color: var(--navy);
      margin-bottom: 4px;
    }

    .section-subtitle {
      font-size: 14px;
      color: var(--muted);
      max-width: 580px;
      margin: 0 auto;
    }

    /* GRID 3 KOLOM RAMPING */
    .game-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 22px;
    }

    .game-card {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: 20px;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      box-shadow: 0 6px 24px rgba(0, 48, 135, 0.04);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
    }

    .game-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 14px 30px rgba(14, 63, 107, 0.1);
      border-color: rgba(89, 169, 232, 0.4);
    }

    /* HEADER BANNER DI DALAM KARTU */
    .card-banner {
      height: 125px;
      background-size: cover;
      background-position: center;
      padding: 16px 20px;
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      position: relative;
    }

    .card-banner::before {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(180deg, rgba(10, 52, 88, 0.7) 0%, rgba(10, 52, 88, 0.35) 100%);
    }

    .card-banner.banner-quiz {
      background-image: url('../GAMBAR_GAMBAR/kumpulan_uang_lama.jpg');
    }

    .card-banner.banner-tts {
      background-image: url('../GAMBAR_GAMBAR/TTS_hero.png');
    }

    .card-banner.banner-runner {
      background-image: url('../GAMBAR_GAMBAR/rupiahrunner_hero.png');
    }

    .card-badge {
      position: relative;
      z-index: 2;
      background: rgba(255, 255, 255, 0.95);
      color: var(--navy);
      font-size: 11px;
      font-weight: 800;
      padding: 4px 12px;
      border-radius: 20px;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .card-badge.orange {
      color: #EA580C;
    }

    .card-badge.rose {
      color: #E11D48;
    }

    .card-icon-circle {
      position: relative;
      z-index: 2;
      width: 36px;
      height: 36px;
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(8px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* BODY KARTU */
    .card-body {
      padding: 20px 22px;
      display: flex;
      flex-direction: column;
      flex: 1;
    }

    .card-title {
      font-size: 18px;
      font-weight: 800;
      color: var(--navy);
      margin-bottom: 6px;
    }

    .card-desc {
      font-size: 13px;
      color: var(--muted);
      line-height: 1.55;
      margin-bottom: 16px;
      min-height: 40px;
    }

    /* MINI STATS / PILL DI DALAM KARTU */
    .card-pills {
      display: flex;
      gap: 6px;
      margin-bottom: 18px;
      flex-wrap: wrap;
    }

    .pill-item {
      background: #F4F7FC;
      border: 1px solid #E2E8F0;
      padding: 4px 9px;
      border-radius: 8px;
      font-size: 11.5px;
      font-weight: 600;
      color: #475569;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .pill-item i {
      color: var(--blue-dark);
      width: 13px;
      height: 13px;
    }

    /* TOMBOL AKSI KARTU */
    .card-footer {
      margin-top: auto;
      padding-top: 12px;
      border-top: 1px solid #F1F5F9;
    }

    .btn-action {
      width: 100%;
      background: linear-gradient(135deg, var(--blue-dark), #1d5fa3);
      color: white;
      border: none;
      padding: 10px 16px;
      border-radius: 12px;
      font-size: 13.5px;
      font-weight: 700;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: all 0.25s ease;
      cursor: pointer;
      box-shadow: 0 4px 12px rgba(23, 76, 132, 0.15);
    }

    .btn-action.btn-tts {
      background: linear-gradient(135deg, #0A3458, #0E3F6B);
      box-shadow: 0 4px 12px rgba(14, 63, 107, 0.15);
    }

    .btn-action.btn-runner {
      background: linear-gradient(135deg, #E11D48, #BE123C);
      box-shadow: 0 4px 12px rgba(225, 29, 72, 0.2);
    }

    .btn-action:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(23, 76, 132, 0.25);
    }

    /* =====================================================
       FOOTER
    ===================================================== */
    footer {
      margin-top: 60px;
      background: #06152B;
      color: #E2E8F0;
      padding: 50px 8% 24px;
      border-top: 1px solid rgba(255, 255, 255, 0.08);
      position: relative;
      overflow: hidden;
      z-index: 10;
    }

    .footer-main {
      display: grid;
      grid-template-columns: 1.3fr 0.8fr 1fr;
      gap: 50px;
      padding-bottom: 35px;
      position: relative;
      z-index: 2;
    }

    .footer-column {
      display: flex;
      flex-direction: column;
    }

    .footer-brand-card {
      width: 140px;
      height: 44px;
      background: #FFFFFF;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 16px;
      padding: 5px 10px;
      overflow: hidden;
    }

    .footer-brand-card img {
      max-width: 100%;
      max-height: 100%;
      object-fit: contain;
    }

    .footer-desc {
      font-size: 13px;
      color: #94A3B8;
      line-height: 1.6;
      max-width: 320px;
    }

    .footer-column h3 {
      color: #FFFFFF;
      font-size: 13px;
      font-weight: 700;
      letter-spacing: 1px;
      text-transform: uppercase;
      margin-bottom: 18px;
      position: relative;
      padding-bottom: 6px;
    }

    .footer-column h3::after {
      content: "";
      position: absolute;
      left: 0;
      bottom: 0;
      width: 24px;
      height: 2px;
      background: var(--blue);
      border-radius: 2px;
    }

    .footer-nav {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .footer-nav a {
      color: #94A3B8;
      text-decoration: none;
      font-size: 13px;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: all 0.25s ease;
    }

    .footer-nav a:hover {
      color: #FFFFFF;
      transform: translateX(4px);
    }

    .footer-contact-list {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .footer-contact-item {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 13px;
      color: #94A3B8;
      text-decoration: none;
    }

    .footer-contact-item:hover {
      color: #FFFFFF;
    }

    .footer-contact-icon {
      width: 30px;
      height: 30px;
      border-radius: 8px;
      background: rgba(255, 255, 255, 0.05);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--blue);
      flex-shrink: 0;
    }

    .footer-bottom {
      margin-top: 20px;
      padding-top: 20px;
      border-top: 1px solid rgba(255, 255, 255, 0.06);
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 14px;
    }

    .footer-copy {
      font-size: 12.5px;
      color: #64748B;
    }

    .footer-bottom-links {
      display: flex;
      gap: 18px;
    }

    .footer-bottom-links a {
      color: #64748B;
      text-decoration: none;
      font-size: 12.5px;
    }

    .footer-bottom-links a:hover {
      color: #94A3B8;
    }

    /* =====================================================
       RESPONSIVE
    ===================================================== */
    @media (max-width: 1024px) {
      .game-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 768px) {
      nav { width: 95%; padding: 0 16px; }
      .nav-links { display: none; }
      .game-grid { grid-template-columns: 1fr; }
      .footer-main { grid-template-columns: 1fr; gap: 35px; }
      .footer-bottom { justify-content: center; text-align: center; flex-direction: column-reverse; }
    }
  </style>
</head>
<body>

<!-- HEADER -->
<nav>
    <a href="../BERANDA/beranda.php" style="display:flex; align-items:center; text-decoration:none;">
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

<!-- PAGE CONTENT -->
<div class="page-content">
  <div class="page-wrapper">

    <!-- HEADER JUDUL HALAMAN -->
    <div class="section-header">
      <span class="section-tag"><i data-lucide="sparkles" style="width:14px; height:14px;"></i> Arena Belajar & Bermain</span>
      <h1 class="section-title">Pilih Aktivitas Permainan</h1>
      <p class="section-subtitle">Asah wawasanmu mengenai kedaulatan, ciri fisik, dan sejarah Rupiah melalui kuis, teka-teki silang, atau game arkade seru.</p>
    </div>

    <!-- GRID 3 PILIHAN MODE -->
    <div class="game-grid">

      <!-- 1. KARTU KUIS -->
      <div class="game-card">
        <div class="card-banner banner-quiz">
          <span class="card-badge"><i data-lucide="award" style="width:13px; height:13px;"></i> Pilihan Ganda</span>
          <div class="card-icon-circle"><i data-lucide="help-circle" style="width:18px; height:18px;"></i></div>
        </div>
        <div class="card-body">
          <h2 class="card-title">Kuis Pengetahuan Rupiah</h2>
          <p class="card-desc">Uji pemahamanmu tentang kedaulatan moneter, metode 3D, dan peran Bank Indonesia dalam 10 soal.</p>
          
          <div class="card-pills">
            <span class="pill-item"><i data-lucide="list-ordered"></i> 10 Soal</span>
            <span class="pill-item"><i data-lucide="clock"></i> 5 Menit</span>
            <span class="pill-item"><i data-lucide="check-circle"></i> Skor Instan</span>
          </div>

          <div class="card-footer">
            <a href="quiz1.php" class="btn-action">
              Mulai Kuis <i data-lucide="play" style="width:15px; height:15px;"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- 2. KARTU TTS -->
      <div class="game-card">
        <div class="card-banner banner-tts">
          <span class="card-badge orange"><i data-lucide="puzzle" style="width:13px; height:13px;"></i> Teka-Teki Silang</span>
          <div class="card-icon-circle"><i data-lucide="grid" style="width:18px; height:18px;"></i></div>
        </div>
        <div class="card-body">
          <h2 class="card-title">TTS Gambar Uang Rupiah</h2>
          <p class="card-desc">Tebak pahlawan nasional, kesenian nusantara, flora-fauna, dan unsur pengaman pada uang kertas.</p>
          
          <div class="card-pills">
            <span class="pill-item"><i data-lucide="layers"></i> 7 Kata Silang</span>
            <span class="pill-item"><i data-lucide="lightbulb"></i> Fitur Hint</span>
            <span class="pill-item"><i data-lucide="timer"></i> Live Timer</span>
          </div>

          <div class="card-footer">
            <a href="TTS.php" class="btn-action btn-tts">
              Mulai TTS <i data-lucide="arrow-right" style="width:15px; height:15px;"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- 3. KARTU RUPIAH RUNNER -->
      <div class="game-card">
        <div class="card-banner banner-runner">
          <span class="card-badge rose"><i data-lucide="gamepad-2" style="width:13px; height:13px;"></i> Runner Arcade</span>
          <div class="card-icon-circle"><i data-lucide="zap" style="width:18px; height:18px;"></i></div>
        </div>
        <div class="card-body">
          <h2 class="card-title">Rupiah Runner</h2>
          <p class="card-desc">Lompat dan kumpulkan lembaran uang Rp100.000 sebanyak mungkin sambil menghindari rintangan!</p>
          
          <div class="card-pills">
            <span class="pill-item"><i data-lucide="trophy"></i> Skor Tertinggi</span>
          </div>

          <div class="card-footer">
            <a href="rupiahrunner.php" class="btn-action btn-runner">
              Mulai Game <i data-lucide="play" style="width:15px; height:15px;"></i>
            </a>
          </div>
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

<script>
// Inisialisasi ikon Lucide
lucide.createIcons();
</script>

</body>
</html>