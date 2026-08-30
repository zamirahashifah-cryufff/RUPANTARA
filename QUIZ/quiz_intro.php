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
  <title>RUPANTARA - Uji Pengetahuanmu tentang Rupiah</title>
  
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
      --navy-soft: #E7EDF7;
      --card: #ffffff;
      --text-main: #1E2A3A;
      --text-sub: #7A8494;
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
       ANIMATIONS
    ===================================================== */
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
    @keyframes typing { from { width: 0; } to { width: 100%; } }
    @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0; } }
    @keyframes ripple { to { transform: scale(4); opacity: 0; } }

    /* =====================================================
       HERO & CONTENT
    ===================================================== */
    .page-content {
      flex: 1;
      padding: 40px 16px 20px;
    }
    .page-wrapper {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      gap: 24px;
    }

    .hero {
      position: relative;
      border-radius: 24px;
      overflow: hidden;
      border: 1px solid var(--border);
      background-image: linear-gradient(to right, rgba(250,248,255,.94) 0%, rgba(250,248,255,.82) 40%, rgba(250,248,255,.4) 70%, rgba(250,248,255,.1) 100%), url('../GAMBAR_GAMBAR/kumpulan_uang_lama.jpg');
      background-size: cover;
      background-position: center;
      padding: 60px 48px;
      min-height: 420px;
      display: flex;
      align-items: center;
      transition: transform .3s ease;
      box-shadow: 0 10px 30px rgba(0, 48, 135, 0.04);
    }
    .hero:hover { transform: translateY(-2px); }

    .hero-content {
      position: relative;
      z-index: 2;
      max-width: 600px;
      display: flex;
      flex-direction: column;
      gap: 16px;
      animation: fadeInUp .8s ease;
    }
    .hero-title {
      font-size: 50px;
      font-weight: 800;
      font-style: italic;
      line-height: 1.05;
      letter-spacing: -1px;
      background: linear-gradient(90deg, #0A3458 0%, #174C84 60%, #59A9E8 100%);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      animation: fadeInUp .8s ease .1s both;
    }
    .hero-subtitle {
      font-size: 19px;
      font-weight: 700;
      color: var(--blue-dark);
      overflow: hidden;
      white-space: nowrap;
      border-right: 3px solid var(--blue-dark);
      animation: typing 2s steps(40, end), blink .75s step-end infinite;
      width: 0;
      animation-fill-mode: forwards;
    }
    .hero-desc {
      font-size: 14.5px;
      font-weight: 500;
      color: var(--text-sub);
      line-height: 1.7;
      max-width: 500px;
      animation: fadeInUp .8s ease .3s both;
    }
    .hero-cta {
      margin-top: 10px;
      align-self: flex-start;
      background: linear-gradient(135deg, var(--blue-dark), #1d5fa3);
      color: #fff;
      border: none;
      border-radius: 999px;
      padding: 14px 34px;
      font-family: inherit;
      font-weight: 700;
      font-size: 15px;
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: all .3s cubic-bezier(.34, 1.56, .64, 1);
      position: relative;
      overflow: hidden;
      animation: fadeInUp .8s ease .4s both;
      box-shadow: 0 4px 15px rgba(23, 76, 132, 0.25);
    }
    .hero-cta:hover {
      transform: translateY(-3px) scale(1.02);
      box-shadow: 0 12px 25px rgba(23, 76, 132, 0.35);
    }
    .hero-cta:active { transform: scale(.97); }
    .hero-cta .ripple {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, .4);
      transform: scale(0);
      animation: ripple .6s linear;
      pointer-events: none;
    }
    .hero-meta {
      font-size: 13px;
      font-weight: 600;
      color: #8A94A6;
      letter-spacing: .2px;
      display: flex;
      align-items: center;
      gap: 6px;
      animation: fadeIn .8s ease .5s both;
    }

    /* =====================================================
       FEATURES / STATS CARD
    ===================================================== */
    .features-card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 20px;
      box-shadow: 0 12px 30px rgba(0, 48, 135, 0.05);
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      margin-top: -30px;
      position: relative;
      z-index: 3;
      animation: fadeInUp .8s ease .3s both;
    }
    .feature-item {
      display: flex;
      align-items: center;
      gap: 16px;
      padding: 26px 30px;
      border-right: 1px solid var(--border);
      transition: all .3s ease;
    }
    .feature-item:last-child { border-right: none; }
    .feature-item:hover {
      background: #F4F7FC;
      border-radius: 20px;
      transform: translateY(-2px);
    }
    .feature-icon {
      flex-shrink: 0;
      width: 46px;
      height: 46px;
      border-radius: 12px;
      background: #EAF2FF;
      color: var(--blue-dark);
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all .3s ease;
    }
    .feature-item:hover .feature-icon {
      background: var(--blue-dark);
      color: #fff;
      transform: scale(1.08) rotate(4deg);
    }
    .feature-counter {
      font-size: 24px;
      font-weight: 800;
      color: var(--navy);
      margin-bottom: 2px;
    }
    .feature-title {
      font-size: 14px;
      font-weight: 700;
      color: var(--text-main);
    }
    .feature-desc {
      font-size: 13px;
      font-weight: 500;
      color: var(--text-sub);
    }

    /* Ambient particles */
    .particle {
      position: fixed;
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--blue);
      opacity: .15;
      pointer-events: none;
      z-index: 0;
      animation: float 6s ease-in-out infinite;
    }

    /* =====================================================
       FOOTER
    ===================================================== */
    footer {
      margin-top: 80px;
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

    /* Responsive */
    @media(max-width: 900px) {
      nav { width: 95%; padding: 0 16px; }
      .nav-links { display: none; }
      .hero { padding: 40px 24px; }
      .hero-title { font-size: 36px; }
      .hero-subtitle { white-space: normal; border: none; width: auto; }
      .features-card { grid-template-columns: 1fr; margin-top: 15px; }
      .feature-item { border-right: none; border-bottom: 1px solid var(--border); }
      .feature-item:last-child { border-bottom: none; }
      .footer-main { grid-template-columns: 1fr; gap: 40px; }
      .footer-bottom { justify-content: center; text-align: center; flex-direction: column-reverse; }
    }
  </style>
</head>
<body>

<!-- Ambient particles -->
<div id="particles"></div>

<!-- HEADER (Sama persis dengan edukasi.php) -->
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
    <div class="hero" id="hero">
      <div class="hero-content">
        <div class="hero-title">RUPANTARA</div>
        <div class="hero-subtitle">Uji pengetahuanmu tentang Rupiah Indonesia</div>
        <div class="hero-desc">Jawab 10 soal pilihan ganda untuk menguji seberapa jauh pengetahuanmu tentang Rupiah, sejarah, simbol, dan perannya dalam perekonomian Indonesia.</div>
        
        <!-- Tombol langsung diarahkan ke quiz.php -->
        <a href="quiz1.php" class="hero-cta" id="startBtn">
          Mulai Sekarang <i data-lucide="play-circle" style="width: 18px; height: 18px;"></i>
        </a>

        <div class="hero-meta">
          <i data-lucide="check-circle" style="width:16px; height:16px; color:#10B981;"></i>
          <span>10 Soal Pilihan Ganda &nbsp;&middot;&nbsp; Skor & Pembahasan Otomatis</span>
        </div>
      </div>
    </div>

    <!-- FEATURES STATS -->
    <div class="features-card" id="featuresCard">
      <div class="feature-item">
        <div class="feature-icon"><i data-lucide="help-circle"></i></div>
        <div>
          <div class="feature-counter">10</div>
          <div class="feature-title">Soal Interaktif</div>
          <div class="feature-desc">Pilihan ganda terkurasi</div>
        </div>
      </div>
      <div class="feature-item">
        <div class="feature-icon"><i data-lucide="clock"></i></div>
        <div>
          <div class="feature-counter">5 Menit</div>
          <div class="feature-title">Waktu Fleksibel</div>
          <div class="feature-desc">Santai & mudah diakses</div>
        </div>
      </div>
      <div class="feature-item">
        <div class="feature-icon"><i data-lucide="award"></i></div>
        <div>
          <div class="feature-counter">100%</div>
          <div class="feature-title">Skor Akurasi</div>
          <div class="feature-desc">Hasil langsung keluar</div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- FOOTER (Sama persis dengan edukasi.php) -->
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
// Inisialisasi ikon Lucide
lucide.createIcons();

// Efek Ripple saat klik tombol Mulai Sekarang
document.getElementById('startBtn').addEventListener('click', function(e) {
  const r = document.createElement('span');
  r.className = 'ripple';
  const rect = this.getBoundingClientRect();
  const size = Math.max(rect.width, rect.height);
  r.style.width = r.style.height = size + 'px';
  r.style.left = (e.clientX - rect.left - size/2) + 'px';
  r.style.top = (e.clientY - rect.top - size/2) + 'px';
  this.appendChild(r);
  setTimeout(() => r.remove(), 600);
});

// Ambient floating particles
const particles = document.getElementById('particles');
for (let i = 0; i < 15; i++) {
  const p = document.createElement('div');
  p.className = 'particle';
  p.style.left = Math.random() * 100 + 'vw';
  p.style.top = Math.random() * 100 + 'vh';
  p.style.animationDelay = Math.random() * 6 + 's';
  p.style.animationDuration = (4 + Math.random() * 4) + 's';
  p.style.width = p.style.height = (4 + Math.random() * 6) + 'px';
  p.style.opacity = .1 + Math.random() * .1;
  particles.appendChild(p);
}
</script>

</body>
</html>