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
  <meta name="description" content="RUPANTARA — Platform Edukasi Keuangan Masa Depan & Rupiah Scanner Interaktif.">
  <title>RUPANTARA — Hasil Scan & Rupiah Scanner</title>
  
  <!-- Google Fonts: Plus Jakarta Sans & Outfit -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,600;1,700;1,800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- FontAwesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
  
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

      .custom-transition {
          transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
            <img src="../GAMBAR_GAMBAR/LOGO.png" alt="Logo RUPANTARA">
        </div>
    </a>

    <ul class="nav-links">
        <li><a href="../BERANDA/beranda.php">Beranda</a></li>
        <li><a href="../TENTANG RUPIAH/tentangrupiah.php">Tentang Rupiah</a></li>
        <li><a href="../MATERI/edukasi.php">Edukasi</a></li>
        <li><a href="../QUIZ/quiz_intro.php">Quiz</a></li>
        <li><a href="../SCANNER/index_copy.php" class="active">Scan</a></li>
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
            <p class="scanner-subtitle">Arahkan uang Rupiah ke dalam bingkai kamera atau unggah gambar untuk memindai pecahan, pahlawan, dan keaslian 3D.</p>
          </div>

          <!-- BINGKAI VIEWPORT SCANNER DENGAN CORNER RETICLES [ ] -->
          <div class="scanner-viewport-box" id="scannerViewport">
            <div class="corner-reticle top-left"></div>
            <div class="corner-reticle top-right"></div>
            <div class="corner-reticle bottom-left"></div>
            <div class="corner-reticle bottom-right"></div>

            <div class="laser-scanner-line" id="laserLine"></div>

            <div class="viewport-media-area" id="viewportMedia">
              <img src="https://images.unsplash.com/photo-1596489375836-7c093a5a782b?auto=format&fit=crop&w=800&q=80" alt="Sample Rp 2.000 Banknote" class="scanner-preview-img" id="scannerPreviewImg">
              <video id="cameraStream" autoplay muted playsinline class="camera-stream-hidden" aria-label="Kamera Scanner Uang Rupiah">Kamera tidak didukung pada browser ini.</video>
            </div>

            <div class="scanner-status-overlay hidden" id="scannerStatusOverlay">
              <i class="fa-solid fa-camera-retro"></i>
              <span id="statusText">Pilih Kamera, Upload Foto, atau Klik Sampel Pecahan</span>
              <button id="dismissStatusBtn" class="status-dismiss" aria-label="Tutup">✕</button>
            </div>
          </div>

          <!-- KONTROL SCANNER & PILIHAN SAMPEL -->
          <div class="scanner-controls-panel">
            <div class="control-buttons flex flex-wrap gap-4 justify-center">
              <button type="button" class="btn btn-primary-sm" id="captureBtn" title="Jepret untuk memindai" aria-label="Jepret">
                <i class="fa-solid fa-camera"></i> Jepret
              </button>
              <label class="btn btn-outline btn-md file-upload-label cursor-pointer">
                <i class="fa-solid fa-cloud-arrow-up"></i> Upload Foto Uang
                <input type="file" id="imageUploadInput" accept="image/*" class="hidden-input" aria-label="Upload foto uang">
              </label>
            </div>
          </div>
        </div>
      </section>

      <!-- ===================================================================
           VIEW 2: HALAMAN HASIL SCAN (PLEK JIPLEK SESUAI 5 MOCKUP GAMBAR USER)
           =================================================================== -->
      <section class="hasil-scan-page-section" id="hasilScanSection">
        
        <!-- Header Hasil Scan -->
        <div class="hasil-scan-header-bar flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
          <div>
            <h1 class="hasil-scan-title">Hasil Scan</h1>
            <p class="hasil-scan-subtitle">Berikut informasi dari uang yang kamu scan</p>
          </div>
          <button type="button" class="btn btn-outline btn-sm rescan-btn w-full sm:w-auto" id="rescanBtn">
            <i class="fa-solid fa-arrow-left"></i> Pindai Uang Lain
          </button>
        </div>

        <!-- 1. HERO SCAN RESULT CARD (TOP BIG CARD - RESPONSIVE) -->
        <div class="hasil-hero-card flex flex-col md:flex-row items-center gap-6">
          <div class="hasil-banknote-container w-full md:w-1/2">
            <img src="https://images.unsplash.com/photo-1596489375836-7c093a5a782b?auto=format&fit=crop&w=800&q=80" alt="Hasil Scan Banknote" id="resBanknoteImg" class="hasil-banknote-img w-full h-auto">
          </div>

          <div class="hasil-banknote-info w-full md:w-1/2 text-center md:text-left">
            <div class="scan-success-badge inline-flex justify-center md:justify-start">
              <i class="fa-solid fa-circle-check mr-2"></i> Scan Berhasil !
            </div>
            <p class="recognized-label mt-3">Uang berhasil dikenali sebagai</p>
            <h2 class="giant-nominal-text" id="resNominalGiant">Rp2.000</h2>
            <div class="banknote-type-tag inline-block" id="resJenisTag">Rupiah Kertas</div>
            <div class="banknote-type-tag inline-block mt-3" id="resConditionTag" style="display: inline-block;">Kondisi uang belum dapat dianalisis.</div>
          </div>
        </div>

        <!-- 2. MIDDLE ROW 1: MAKNA VISUAL & SEJARAH TOKOH (Responsive Grid) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
          
          <!-- MAKNA VISUAL UANG -->
          <div class="hasil-sub-card">
            <h3 class="card-italic-title">Makna Visual Uang</h3>
            <ul class="makna-visual-list" id="resMaknaVisualList">
              <!-- Inserted dynamically -->
            </ul>
          </div>

          <!-- SEJARAH TOKOH -->
          <div class="hasil-sub-card">
            <h3 class="card-italic-title">Sejarah Tokoh</h3>
            <div class="sejarah-tokoh-box flex flex-col sm:flex-row items-center sm:items-start gap-4">
              <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Mohammad_Husni_Thamrin.jpg/220px-Mohammad_Husni_Thamrin.jpg" alt="Foto Pahlawan" id="resHeroPhoto" class="hero-round-avatar flex-shrink-0">
              <div class="sejarah-tokoh-text text-center sm:text-left">
                <h4 id="resHeroNameTitle">Mohammad Husni Thamrin</h4>
                <p class="hero-ttl" id="resHeroTtl">(16 Februari 1894 – 11 Januari 1941)</p>
                <p class="hero-bio-p mt-2" id="resHeroBioText">
                  Mohammad Husni Thamrin adalah Pahlawan Nasional asal Batavia yang memperjuangkan hak-hak rakyat Indonesia melalui Volksraad. Atas jasa-jasanya, beliau diabadikan pada uang Rupiah pecahan Rp2.000.
                </p>
              </div>
            </div>
          </div>

        </div>

        <!-- 3. MIDDLE ROW 2: FAKTA MENARIK & CIRI KEASLIAN RUPIAH (Responsive Grid) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

          <!-- FAKTA MENARIK -->
          <div class="hasil-sub-card">
            <h3 class="card-italic-title">Fakta Menarik</h3>
            <ul class="fakta-menarik-list" id="resFaktaList">
              <!-- Inserted dynamically -->
            </ul>
          </div>

          <!-- CIRI KEASLIAN RUPIAH -->
          <div class="hasil-sub-card">
            <h3 class="card-italic-title">Ciri Keaslian Rupiah</h3>
            <ul class="ciri-keaslian-list" id="resCiriKeaslianList">
              <!-- Inserted dynamically -->
            </ul>
          </div>

        </div>

        <!-- 4. BOTTOM CARD: CARA MERAWAT RUPIAH (5 Responsive Circle Items) -->
        <div class="hasil-sub-card mt-6 text-center" id="edukasi">
          <h3 class="card-italic-title text-center">Cara merawat Rupiah</h3>
          
          <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-6 mt-6 justify-items-center">
            <div class="care-circle-item">
              <div class="circle-icon-box mx-auto">
                <i class="fa-solid fa-house-chimney-crack"></i>
              </div>
              <p class="mt-2 text-xs sm:text-sm">Jangan simpan<br>di tempat<br>Lembab</p>
            </div>

            <div class="care-circle-item">
              <div class="circle-icon-box mx-auto">
                <i class="fa-solid fa-receipt"></i>
              </div>
              <p class="mt-2 text-xs sm:text-sm">Jangan melipat<br>Uang</p>
            </div>

            <div class="care-circle-item">
              <div class="circle-icon-box mx-auto">
                <i class="fa-solid fa-pen-line"></i>
              </div>
              <p class="mt-2 text-xs sm:text-sm">Jangan<br>Mencoret Uang</p>
            </div>

            <div class="care-circle-item">
              <div class="circle-icon-box mx-auto">
                <i class="fa-solid fa-sun"></i>
              </div>
              <p class="mt-2 text-xs sm:text-sm">Jangan Terkena<br>sinar Matahari<br>langsung</p>
            </div>

            <div class="care-circle-item">
              <div class="circle-icon-box mx-auto">
                <i class="fa-solid fa-wallet"></i>
              </div>
              <p class="mt-2 text-xs sm:text-sm">Simpan di<br>tempat aman<br>dan bersih</p>
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

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@3.20.0/dist/tf.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@0.8.4/dist/teachablemachine-image.min.js"></script>
  <script src="js/app.js"></script>
  <script src="js/scanner.js"></script>

  <!-- Fallback Error Handling Script & Responsivitas Mobile Menu -->
  <script>
      // Fallback Pemuatan Gambar Logo
      document.querySelectorAll('.onerror-fallback').forEach(img => {
          img.onerror = function() {
              this.style.display = 'none';
          };
      });

      // Fungsi Toggle Menu Mobile Navigasi
      function toggleMobileMenu() {
          const menu = document.getElementById('mobileMenu');
          if (menu) menu.classList.toggle('hidden');
      }

      // Inisialisasi Ikon Lucide
      lucide.createIcons();
  </script>
</body>
</html>