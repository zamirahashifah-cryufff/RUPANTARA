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
  <meta name="description" content="RUPANTARA — Platform Edukasi Keuangan Masa Depan & Rupiah Scanner Interaktif Emisi 2022.">
  <title>RUPANTARA — AI Rupiah Scanner & Hasil Scan</title>
  
  <!-- Google Fonts: Plus Jakarta Sans & Outfit -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- FontAwesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
  <link rel="stylesheet" href="../navbar_responsive.css">
  <script src="../navbar_responsive.js" defer></script>
  
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
      tailwind.config = {
          theme: {
              extend: {
                  colors: {
                      brand: {
                          dark: '#0B3564',      // Deep Blue
                          primary: '#004DB3',   // Accent Blue
                          light: '#EBF3FC',     // Light Background Blue
                          slate: '#5A6E85'      // Soft gray text
                      }
                  },
                  fontFamily: {
                      sans: ['Plus Jakarta Sans', 'sans-serif'],
                      heading: ['Outfit', 'sans-serif']
                  }
              }
          }
      }
  </script>

  <!-- Stylesheets -->
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/components.css">
  <link rel="stylesheet" href="css/sections.css">
  <link rel="stylesheet" href="style.css">

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
         FOOTER (Modern Dark Navy Theme)
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
<body>

  <!-- BACKGROUND GRADIENT WITH MONAS SILHOUETTE & DIGITAL DOTS -->
  <div class="sky-background">
    <div class="monas-silhouette"></div>
    <div class="digital-dots-overlay"></div>
    <div class="glowing-orb orb-1"></div>
    <div class="glowing-orb orb-2"></div>
  </div>

<!-- HEADER (Floating Glassmorphism) -->
<nav>
    <a href="../BERANDA/beranda.php" style="display:flex; align-items:center; text-decoration:none;">
        <div class="nav-logo">
            <img src="../GAMBAR_GAMBAR/LOGO.png" alt="Logo RUPANTARA" onerror="this.src='../GAMBAR_GAMBAR/Logorupantara.jpg'">
        </div>
    </a>

    <ul class="nav-links">
        <li><a href="../BERANDA/beranda.php">Beranda</a></li>
        <li><a href="../TENTANG RUPIAH/tentangrupiah.php">Tentang Rupiah</a></li>
        <li><a href="../MATERI/edukasi.php">Edukasi</a></li>
        <li><a href="../QUIZ/quiz_intro.php">Quiz</a></li>
        <li><a href="../SCANNER/index.php" class="active">Scan</a></li>
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

  <!-- CENTER SUB-HEADER TITLE -->
  <div class="center-sub-header" id="beranda">
    <h2 class="sub-brand-title">RUPANTARA</h2>
    <p class="sub-brand-tagline">Cinta • Bangga • Paham • Rupiah</p>
  </div>

  <main class="scanner-page-main">
    <div class="container px-4">

      <!-- ===================================================================
           VIEW 1: CONTAINER SCANNER ("SCAN DISINI !")
           =================================================================== -->
      <section class="scanner-viewport-section" id="scannerInputSection">
        <div class="rupantara-scanner-card">
          <div class="scanner-card-header">
            <h1 class="scanner-main-title">SCAN <span>DISINI !</span></h1>
            <p class="scanner-subtitle">Unggah gambar atau pilih sampel uang Rupiah Emisi 2022 untuk memindai nilai nominal, pahlawan nasional, dan makna visual.</p>
          </div>

          <!-- BINGKAI VIEWPORT SCANNER DENGAN CORNER RETICLES [ ] -->
          <div class="scanner-viewport-box" id="scannerViewport">
            <div class="corner-reticle top-left"></div>
            <div class="corner-reticle top-right"></div>
            <div class="corner-reticle bottom-left"></div>
            <div class="corner-reticle bottom-right"></div>

            <!-- Animasi Garis Laser Scanner -->
            <div class="laser-scanner-line" id="laserLine"></div>

            <!-- Area Preview Gambar -->
            <div class="viewport-media-area" id="viewportMedia">
              <img src="../GAMBAR_GAMBAR/uang_10000.jpg" alt="Preview Uang Rupiah" class="scanner-preview-img" id="scannerPreviewImg" onerror="this.src='../GAMBAR_GAMBAR/uang.jpg'">
            </div>

            <!-- Status Overlay Pill -->
            <div class="scanner-status-overlay" id="scannerStatusOverlay">
              <div class="scanner-status-pill" id="scannerStatusBadge">
                <span class="status-dot"></span>
                <span id="statusText">Unggah foto uang Rupiah untuk memindai</span>
              </div>
              <button id="dismissStatusBtn" class="status-dismiss" aria-label="Tutup">✕</button>
            </div>
          </div>

          <!-- KONTROL SCANNER (Upload Button & Chips) -->
          <div class="scanner-controls-panel">
            <div class="control-buttons flex flex-wrap gap-4 justify-center">
              <label class="btn-upload-primary cursor-pointer">
                <i class="fa-solid fa-cloud-arrow-up text-lg"></i> Upload Foto Uang
                <input type="file" id="imageUploadInput" accept="image/*" class="hidden-input" aria-label="Upload foto uang">
              </label>
            </div>

            <!-- SAMPEL FOTO DENGAN PRESET SCAN (7 PECAHAN EMISI 2022) -->
            <div class="quick-sample-selector mt-4 text-center">
              <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-2.5">Atau uji coba langsung dengan sampel pecahan:</p>
              <div class="sample-chips flex flex-wrap gap-2 justify-center">
                <button type="button" class="sample-chip" data-sample="../GAMBAR_GAMBAR/uang_1000.jpg" data-nominal="1000">Rp 1.000</button>
                <button type="button" class="sample-chip" data-sample="../GAMBAR_GAMBAR/uang_2000.jpg" data-nominal="2000">Rp 2.000</button>
                <button type="button" class="sample-chip" data-sample="../GAMBAR_GAMBAR/uang_5000.jpg" data-nominal="5000">Rp 5.000</button>
                <button type="button" class="sample-chip active" data-sample="../GAMBAR_GAMBAR/uang_10000.jpg" data-nominal="10000">Rp 10.000</button>
                <button type="button" class="sample-chip" data-sample="../GAMBAR_GAMBAR/uang_20000.jpg" data-nominal="20000">Rp 20.000</button>
                <button type="button" class="sample-chip" data-sample="../GAMBAR_GAMBAR/uang_50000.jpg" data-nominal="50000">Rp 50.000</button>
                <button type="button" class="sample-chip" data-sample="../GAMBAR_GAMBAR/uang_100000.jpg" data-nominal="100000">Rp 100.000</button>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ===================================================================
           VIEW 2: HALAMAN HASIL SCAN (MODERN GLASSMORPHISM CARDS)
           =================================================================== -->
      <section class="hasil-scan-page-section" id="hasilScanSection">
        
        <!-- Header Hasil Scan -->
        <div class="hasil-scan-header-bar flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
          <div>
            <h1 class="hasil-scan-title">Hasil Scan</h1>
            <p class="hasil-scan-subtitle">Berikut informasi mendalam dari pecahan Rupiah yang kamu pindai</p>
          </div>
          <button type="button" class="rescan-btn" id="rescanBtn">
            <i class="fa-solid fa-arrow-left"></i> Pindai Uang Lain
          </button>
        </div>

        <!-- 1. HERO SCAN RESULT CARD (TOP BIG CARD - RESPONSIVE) -->
        <div class="hasil-hero-card flex flex-col md:flex-row items-center gap-8 mb-6">
          <div class="hasil-banknote-container w-full md:w-5/12 flex-shrink-0">
            <img src="../GAMBAR_GAMBAR/uang_10000.jpg" alt="Hasil Scan Banknote" id="resBanknoteImg" class="hasil-banknote-img" onerror="this.src='../GAMBAR_GAMBAR/uang.jpg'">
          </div>

          <div class="hasil-banknote-info w-full md:w-7/12 text-center md:text-left">
            <div class="scan-success-badge mb-2">
              <i class="fa-solid fa-circle-check text-emerald-600"></i> Scan Berhasil !
            </div>
            <p class="recognized-label">Uang berhasil dikenali sebagai</p>
            <h2 class="giant-nominal-text" id="resNominalGiant">Rp 10.000</h2>
            <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 mt-1">
              <span class="banknote-type-tag" id="resJenisTag">Rupiah Kertas</span>
              <span class="banknote-type-tag" id="resEmisiTag">Tahun Emisi 2022</span>
              <span class="banknote-type-tag" id="resConditionTag" style="background:#ecfdf5; color:#047857; border-color:#a7f3d0;">Uang Layak Edar (ULE)</span>
            </div>
          </div>
        </div>

        <!-- 2. MIDDLE ROW 1: MAKNA VISUAL & SEJARAH TOKOH (Responsive Grid) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
          
          <!-- MAKNA VISUAL UANG -->
          <div class="hasil-sub-card">
            <h3 class="card-italic-title">
              <i class="fa-solid fa-eye text-blue-600"></i> Makna Visual Uang
            </h3>
            <ul class="makna-visual-list flex flex-col gap-3" id="resMaknaVisualList">
              <li class="makna-item flex items-start gap-3.5 p-3 rounded-xl bg-white/70 hover:bg-white transition-all shadow-xs border border-slate-100">
                <div class="list-icon-badge bg-blue-50 text-blue-600 border border-blue-100">
                  <i class="fa-solid fa-user-tie text-sm"></i>
                </div>
                <div>
                  <strong class="text-slate-800 text-sm block font-bold">Tokoh Utama</strong>
                  <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">Frans Kaisiepo, pahlawan nasional asal Biak Papua pejuang tegaknya kedaulatan NKRI.</p>
                </div>
              </li>
              <li class="makna-item flex items-start gap-3.5 p-3 rounded-xl bg-white/70 hover:bg-white transition-all shadow-xs border border-slate-100">
                <div class="list-icon-badge bg-emerald-50 text-emerald-600 border border-emerald-100">
                  <i class="fa-solid fa-mountain-sun text-sm"></i>
                </div>
                <div>
                  <strong class="text-slate-800 text-sm block font-bold">Keindahan Alam</strong>
                  <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">Taman Nasional Wakatobi di Sulawesi Tenggara, surga terumbu karang tropis dunia.</p>
                </div>
              </li>
              <li class="makna-item flex items-start gap-3.5 p-3 rounded-xl bg-white/70 hover:bg-white transition-all shadow-xs border border-slate-100">
                <div class="list-icon-badge bg-indigo-50 text-indigo-600 border border-indigo-100">
                  <i class="fa-solid fa-masks-theater text-sm"></i>
                </div>
                <div>
                  <strong class="text-slate-800 text-sm block font-bold">Seni Budaya</strong>
                  <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">Tari Pakarena dari Sulawesi Selatan yang mencerminkan kelembutan dan kesabaran.</p>
                </div>
              </li>
              <li class="makna-item flex items-start gap-3.5 p-3 rounded-xl bg-white/70 hover:bg-white transition-all shadow-xs border border-slate-100">
                <div class="list-icon-badge bg-teal-50 text-teal-600 border border-teal-100">
                  <i class="fa-solid fa-seedling text-sm"></i>
                </div>
                <div>
                  <strong class="text-slate-800 text-sm block font-bold">Flora Khas</strong>
                  <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">Bunga Cempaka Hutan Kasar (Magnolia candollei) flora eksotis hutan Sulawesi.</p>
                </div>
              </li>
            </ul>
          </div>

          <!-- SEJARAH TOKOH -->
          <div class="hasil-sub-card">
            <h3 class="card-italic-title">
              <i class="fa-solid fa-landmark text-blue-600"></i> Sejarah Tokoh
            </h3>
            <div class="sejarah-tokoh-box flex flex-col sm:flex-row items-center sm:items-start gap-5">
              <div class="hero-round-avatar-wrapper">
                <img src="../GAMBAR_GAMBAR/frans_kaisepo.jpeg" alt="Foto Pahlawan" id="resHeroPhoto" class="hero-round-avatar" onerror="this.src='../GAMBAR_GAMBAR/frans_kaisepo.jpeg'">
              </div>
              <div class="sejarah-tokoh-text text-center sm:text-left">
                <h4 id="resHeroNameTitle" class="text-lg font-bold text-slate-900">Frans Kaisiepo</h4>
                <p class="hero-ttl" id="resHeroTtl">(1921 – 1979)</p>
                <p class="hero-bio-p mt-2" id="resHeroBioText">
                  Frans Kaisiepo adalah pahlawan nasional dari Papua yang memimpin delegasi Konferensi Malino 1946 dan menjadi Gubernur Papua pertama penjaga kedaulatan NKRI. Atas jasa dan pengabdiannya, beliau diabadikan pada uang Rupiah pecahan Rp 10.000.
                </p>
              </div>
            </div>
          </div>

        </div>

        <!-- 3. MIDDLE ROW 2: FAKTA MENARIK & CIRI KEASLIAN RUPIAH (Responsive Grid) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

          <!-- FAKTA MENARIK -->
          <div class="hasil-sub-card">
            <h3 class="card-italic-title">
              <i class="fa-solid fa-lightbulb text-amber-500"></i> Fakta Menarik
            </h3>
            <ul class="fakta-menarik-list flex flex-col gap-3" id="resFaktaList">
              <li class="flex items-start gap-3.5 p-3 rounded-xl bg-white/70 hover:bg-white transition-all shadow-xs border border-slate-100">
                <div class="list-icon-badge bg-amber-50 text-amber-600 border border-amber-100 flex-shrink-0">
                  <i class="fa-solid fa-star text-xs"></i>
                </div>
                <p class="text-slate-700 text-xs sm:text-sm leading-relaxed mt-0.5">Frans Kaisiepo mengusulkan nama 'Irian' yang berasal dari bahasa Biak (Ikut Republik Indonesia Anti Nederlands).</p>
              </li>
              <li class="flex items-start gap-3.5 p-3 rounded-xl bg-white/70 hover:bg-white transition-all shadow-xs border border-slate-100">
                <div class="list-icon-badge bg-amber-50 text-amber-600 border border-amber-100 flex-shrink-0">
                  <i class="fa-solid fa-star text-xs"></i>
                </div>
                <p class="text-slate-700 text-xs sm:text-sm leading-relaxed mt-0.5">Tampil memukau dengan dominasi warna ungu berdimensi 136 mm × 65 mm.</p>
              </li>
              <li class="flex items-start gap-3.5 p-3 rounded-xl bg-white/70 hover:bg-white transition-all shadow-xs border border-slate-100">
                <div class="list-icon-badge bg-amber-50 text-amber-600 border border-amber-100 flex-shrink-0">
                  <i class="fa-solid fa-star text-xs"></i>
                </div>
                <p class="text-slate-700 text-xs sm:text-sm leading-relaxed mt-0.5">Memuat tulisan mikroteks resolusi tinggi 'BANK INDONESIA 10000' yang sangat tajam.</p>
              </li>
            </ul>
          </div>

          <!-- CIRI KEASLIAN RUPIAH -->
          <div class="hasil-sub-card">
            <h3 class="card-italic-title">
              <i class="fa-solid fa-shield-halved text-emerald-600"></i> Ciri Keaslian Rupiah (3D)
            </h3>
            <ul class="ciri-keaslian-list flex flex-col gap-3" id="resCiriKeaslianList">
              <li class="flex items-start gap-3.5 p-3 rounded-xl bg-white/70 hover:bg-white transition-all shadow-xs border border-slate-100">
                <div class="list-icon-badge bg-amber-50 text-amber-600 border border-amber-100">
                  <i class="fa-solid fa-wand-magic-sparkles text-sm"></i>
                </div>
                <div>
                  <strong class="text-slate-800 text-sm font-bold block mb-0.5">Tinta Berubah Warna (OVI)</strong>
                  <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">Tinta khusus pada ornamen perisai yang berubah warna saat dilihat dari sudut berbeda.</p>
                </div>
              </li>
              <li class="flex items-start gap-3.5 p-3 rounded-xl bg-white/70 hover:bg-white transition-all shadow-xs border border-slate-100">
                <div class="list-icon-badge bg-blue-50 text-blue-600 border border-blue-100">
                  <i class="fa-solid fa-eye text-sm"></i>
                </div>
                <div>
                  <strong class="text-slate-800 text-sm font-bold block mb-0.5">Watermark Frans Kaisiepo</strong>
                  <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">Gambar pahlawan Frans Kaisiepo dan electrotype angka 10 menyala terang saat diterawang.</p>
                </div>
              </li>
              <li class="flex items-start gap-3.5 p-3 rounded-xl bg-white/70 hover:bg-white transition-all shadow-xs border border-slate-100">
                <div class="list-icon-badge bg-purple-50 text-purple-600 border border-purple-100">
                  <i class="fa-solid fa-fingerprint text-sm"></i>
                </div>
                <div>
                  <strong class="text-slate-800 text-sm font-bold block mb-0.5">Cetak Timbul Intaglio</strong>
                  <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">Tekstur cetak terasa bergerigi kasar pada gambar pahlawan dan tulisan nominal.</p>
                </div>
              </li>
            </ul>
          </div>

        </div>

        <!-- 4. BOTTOM CARD: CARA MERAWAT RUPIAH (5J - 5 Interactive SVG Circles) -->
        <div class="hasil-sub-card text-center" id="edukasi">
          <h3 class="card-italic-title justify-center text-center">
            <i class="fa-solid fa-hand-holding-heart text-rose-500"></i> Cara Merawat Uang Rupiah (5J)
          </h3>
          
          <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-6 mt-6 justify-items-center">
            <!-- 1. Jangan Lembap -->
            <div class="care-circle-item">
              <div class="circle-icon-box mx-auto">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/>
                  <line x1="2" y1="2" x2="22" y2="22"/>
                </svg>
              </div>
              <p>Jangan simpan<br>di tempat Lembap</p>
            </div>

            <!-- 2. Jangan Melipat -->
            <div class="care-circle-item">
              <div class="circle-icon-box mx-auto">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                  <rect width="18" height="14" x="3" y="5" rx="2"/>
                  <line x1="12" y1="5" x2="12" y2="19"/>
                  <line x1="3" y1="19" x2="21" y2="5"/>
                </svg>
              </div>
              <p>Jangan melipat<br>Uang Kertas</p>
            </div>

            <!-- 3. Jangan Mencoret -->
            <div class="care-circle-item">
              <div class="circle-icon-box mx-auto">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                  <line x1="2" y1="2" x2="22" y2="22"/>
                </svg>
              </div>
              <p>Jangan<br>Mencoret Uang</p>
            </div>

            <!-- 4. Jangan Menstapler -->
            <div class="care-circle-item">
              <div class="circle-icon-box mx-auto">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M6 3h12a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"/>
                  <line x1="4" y1="17" x2="20" y2="17"/>
                  <line x1="2" y1="2" x2="22" y2="22"/>
                </svg>
              </div>
              <p>Jangan menstapler<br>/ merusak fisik</p>
            </div>

            <!-- 5. Simpan di Dompet Bersih -->
            <div class="care-circle-item">
              <div class="circle-icon-box mx-auto">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/>
                  <path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/>
                  <path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/>
                </svg>
              </div>
              <p>Simpan rapi di<br>dompet bersih</p>
            </div>
          </div>
        </div>

      </section>

    </div>
  </main>

  <!-- FOOTER -->
  <footer>
      <div class="footer-main">
          <div class="footer-column">
              <div class="footer-brand-card">
                  <img src="../GAMBAR_GAMBAR/LOGO.png" alt="Logo RUPANTARA" onerror="this.src='../GAMBAR_GAMBAR/Logorupantara.jpg'">
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
                  <a href="../SCANNER/index.php"><i data-lucide="chevron-right" style="width:14px; height:14px;"></i>Scan</a>
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

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@3.20.0/dist/tf.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@0.8.4/dist/teachablemachine-image.min.js"></script>
  <script src="js/app.js"></script>
  <script src="js/scanner.js"></script>

  <!-- Fallback Error Handling Script & Inisialisasi Ikon -->
  <script>
      // Fallback Pemuatan Gambar
      document.querySelectorAll('img').forEach(img => {
          img.onerror = function() {
              if (this.id === 'resHeroPhoto') {
                  this.src = '../GAMBAR_GAMBAR/frans_kaisepo.jpeg';
              } else if (this.id === 'resBanknoteImg' || this.id === 'scannerPreviewImg') {
                  this.src = '../GAMBAR_GAMBAR/uang_10000.jpg';
              }
          };
      });

      // Inisialisasi Ikon Lucide
      if (window.lucide) {
          lucide.createIcons();
      }
  </script>
</body>
</html>