<?php
session_start();
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
$isLoggedIn = isset($_SESSION['login']) && $_SESSION['login'] === true;
$username = $isLoggedIn ? $_SESSION['username'] : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>RUPANTARA - Quiz</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<!-- Pustaka Ikon Lucide (Sama seperti edukasi.php) -->
<script src="https://unpkg.com/lucide@latest"></script>
<link rel="stylesheet" href="../navbar_responsive.css">
<script src="../navbar_responsive.js" defer></script>

<style>
:root{
  --navy:#17325C; --navy-dark:#10233F; --navy-soft:#E7EDF7; --bg:#FAF8FF;
  --card:#FFFFFF; --border:#E3E7EF; --text-main:#1E2A3A; --text-sub:#7A8494;
  --belum-bg:#F3F5F9; --belum-border:#D8DDE7; --radius-lg:20px; --radius-md:12px; --radius-sm:8px;
  --good:#1E8E5A; --bad:#D0392B; --bad-soft:#FBEAE9;
  --header-border:#ECE9F3; --footer-bg:#E9E7F2;
}
*{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'Plus Jakarta Sans','Inter',sans-serif;font-weight:500;background:var(--bg);color:var(--text-main);
  min-height:100vh;display:flex;flex-direction:column;}

/* =====================================================
   HEADER (Floating Glassmorphism style - Sama seperti edukasi.php)
===================================================== */
nav {
    --nav-navy: #0E3F6B;
    --nav-navy-dark: #0A3458;
    --nav-blue: #59A9E8;
    --nav-blue-dark: #174C84;
    --nav-text: #1E293B;
    --nav-muted: #64748B;
    --nav-border: #E2E8F0;

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
    margin: 20px auto 0;
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
    color: var(--nav-blue-dark);
    background: rgba(255, 255, 255, 0.8);
}

.nav-links a.active {
    color: var(--nav-blue-dark);
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
    background: linear-gradient(135deg, var(--nav-blue-dark), #1d5fa3);
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
    color: var(--nav-blue-dark);
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
    color: var(--nav-blue-dark);
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
}

.user-greeting {
    font-size: 13px;
    font-weight: 600;
    color: #475569;
}

@media (max-width: 900px) {
    nav { width: 95%; padding: 0 16px; }
    .nav-links { display: none; }
}

/* ===================== MAIN QUIZ AREA ===================== */
.page-content{
  flex:1;display:flex;align-items:flex-start;justify-content:center;padding:32px 16px;
  margin-top: 10px;
}
.quiz-wrapper{width:100%;max-width:1000px;display:flex;flex-direction:column;gap:20px;}
.topbar{background:var(--card);border:1px solid var(--border);border-radius:var(--radius-lg);
  padding:14px 22px;display:flex;align-items:center;gap:18px;box-shadow:0 2px 10px rgba(23,50,92,0.05);}
.back-btn{font-size:20px;color:var(--text-sub);background:none;border:none;cursor:pointer;}
.progress-block{flex:1;display:flex;flex-direction:column;gap:6px;}
.progress-label{font-size:13px;font-weight:600;}
.progress-track{width:100%;height:6px;border-radius:999px;background:var(--belum-bg);overflow:hidden;}
.progress-fill{height:100%;width:0%;border-radius:999px;background:var(--navy);transition:width .25s ease;}
.timer{display:flex;align-items:center;gap:6px;font-size:13px;font-weight:600;color:var(--text-sub);white-space:nowrap;}
.timer.warning{color:var(--bad);}
.hint-btn{display:flex;align-items:center;gap:6px;border:1px solid var(--border);border-radius:999px;
  padding:8px 16px;font-family:inherit;font-weight:700;font-size:13px;color:var(--navy);
  background:var(--navy-soft);cursor:pointer;white-space:nowrap;}
.hint-btn:disabled{opacity:.5;cursor:not-allowed;}
.quiz-main{display:grid;grid-template-columns:1fr 260px;gap:20px;align-items:start;}
@media (max-width:760px){.quiz-main{grid-template-columns:1fr;}}
.question-card{background:var(--card);border:1px solid var(--border);border-radius:var(--radius-lg);
  padding:32px;box-shadow:0 2px 10px rgba(23,50,92,0.05);display:flex;flex-direction:column;gap:22px;}
.question-head{display:flex;flex-direction:column;gap:10px;}
.question-text{font-size:18px;font-weight:700;line-height:1.5;}
.question-instruction{font-size:14px;font-style:italic;font-weight:500;color:var(--text-sub);}
.options-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
@media (max-width:520px){.options-grid{grid-template-columns:1fr;}}
.option{display:flex;align-items:center;gap:12px;border:1.5px solid var(--border);border-radius:var(--radius-md);
  padding:14px 16px;background:var(--card);cursor:pointer;font-family:inherit;font-size:14px;font-weight:500;
  color:var(--text-main);text-align:left;transition:border-color .15s ease, background .15s ease, opacity .15s ease;}
.option:hover{border-color:var(--navy);background:var(--navy-soft);}
.option.selected{border-color:var(--navy);background:var(--navy-soft);}
.option.eliminated{opacity:.35;pointer-events:none;text-decoration:line-through;}
.option-badge{flex-shrink:0;width:28px;height:28px;border-radius:8px;background:var(--navy-soft);color:var(--navy);
  font-weight:700;font-size:13px;display:flex;align-items:center;justify-content:center;}
.option.selected .option-badge{background:var(--navy);color:#fff;}
.card-footer{display:flex;align-items:center;justify-content:space-between;margin-top:4px;}
.skip-link{font-size:14px;font-weight:600;color:var(--text-sub);background:none;border:none;cursor:pointer;
  font-family:inherit;text-decoration:underline;}
.footer-actions{display:flex;gap:10px;}
.btn{font-family:inherit;font-weight:700;font-size:14px;border-radius:999px;padding:12px 22px;cursor:pointer;
  border:none;display:flex;align-items:center;gap:8px;}
.btn:disabled{opacity:.5;cursor:not-allowed;}
.btn-primary{background:var(--navy);color:#fff;}
.btn-primary:hover:not(:disabled){background:var(--navy-dark);}
.btn-secondary{background:var(--navy-dark);color:#fff;}
.nav-card{background:var(--card);border:1px solid var(--border);border-radius:var(--radius-lg);padding:22px;
  box-shadow:0 2px 10px rgba(23,50,92,0.05);display:flex;flex-direction:column;gap:18px;}
.nav-title{display:flex;align-items:center;gap:8px;font-size:14px;font-weight:700;}
.nav-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:8px;}
.nav-item{aspect-ratio:1;display:flex;align-items:center;justify-content:center;border-radius:var(--radius-sm);
  font-size:13px;font-weight:700;cursor:pointer;font-family:inherit;border:1.5px solid transparent;}
.nav-item.selesai{background:var(--navy);color:#fff;}
.nav-item.aktif{background:var(--card);color:var(--navy);border-color:var(--navy);}
.nav-item.belum{background:var(--belum-bg);color:var(--text-sub);border-color:var(--belum-border);}
.legend{display:flex;flex-direction:column;gap:10px;font-size:13px;font-weight:500;color:var(--text-sub);}
.legend-item{display:flex;align-items:center;gap:8px;}
.dot{width:10px;height:10px;border-radius:50%;flex-shrink:0;}
.dot-selesai{background:var(--navy);}
.dot-aktif{border:1.5px solid var(--navy);background:transparent;}
.dot-belum{border-radius:3px;background:var(--belum-bg);border:1.5px solid var(--belum-border);}

/* ===================== LOGIN GATE (menutupi area quiz) ===================== */
.quiz-main-shell{ position:relative; }
.login-gate{
  position:absolute; inset:0; z-index:5;
  background:rgba(250,248,255,0.85); backdrop-filter:blur(3px);
  border-radius:var(--radius-lg);
  display:flex; align-items:center; justify-content:center; padding:24px;
}
.login-gate.hidden{ display:none; }
.gate-card{
  background:var(--card); border:1px solid var(--border); border-radius:var(--radius-lg);
  box-shadow:0 8px 24px rgba(23,50,92,0.12);
  padding:32px; max-width:340px; width:100%; text-align:center;
  display:flex; flex-direction:column; gap:12px;
}
.gate-icon{
  width:48px;height:48px;border-radius:50%;background:var(--navy-soft);color:var(--navy);
  display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:700;margin:0 auto;
}
.gate-title{ font-size:16px; font-weight:700; color:var(--text-main); }
.gate-desc{ font-size:13px; color:var(--text-sub); font-weight:500; line-height:1.5; }

/* ===================== RESULT OVERLAY ===================== */
.result-overlay{position:fixed;inset:0;background:rgba(16,35,63,.55);display:none;align-items:center;
  justify-content:center;padding:16px;z-index:10;}
.result-overlay.show{display:flex;}
.result-card{background:var(--card);border-radius:var(--radius-lg);padding:36px;max-width:380px;width:100%;
  text-align:center;display:flex;flex-direction:column;gap:14px;}
.result-badge{
  align-self:center;font-size:12px;font-weight:700;padding:6px 14px;border-radius:999px;
  background:var(--navy-soft);color:var(--navy);
}
.result-card.gagal .result-badge{ background:var(--bad-soft); color:var(--bad); }
.result-score{font-size:42px;font-weight:700;color:var(--navy);}
.result-card.gagal .result-score{ color:var(--bad); }
.result-label{font-size:14px;color:var(--text-sub);font-weight:600;}

/* ===================== FOOTER ===================== */
.site-footer{
  background:var(--footer-bg);
  margin-top:40px;
}
.footer-inner{
  max-width:1200px;margin:0 auto;padding:28px 24px;
  display:flex;align-items:flex-start;justify-content:space-between;gap:24px;flex-wrap:wrap;
}
.footer-brand{ display:flex;flex-direction:column;gap:6px; }
.footer-logo{ font-size:16px;font-weight:800;color:var(--navy); }
.footer-tagline{ font-size:13px;color:#5B6373;font-weight:500; }
.footer-copy{ font-size:12px;color:#8A8FA0;font-weight:500;margin-top:14px; }
.footer-links{ display:flex;align-items:center;gap:28px;flex-wrap:wrap; }
.footer-links a{ font-size:13px;font-weight:600;color:#4B5566;text-decoration:none; }
.footer-links a:hover{ color:var(--navy); }
</style>
</head>
<body>

<!-- ===================== NAVBAR (Floating Glassmorphism) ===================== -->
<nav>
    <a href="#" style="display:flex; align-items:center; text-decoration:none;">
        <div class="nav-logo">
            <img src="../GAMBAR_GAMBAR/LOGO.png" alt="Logo RUPANTARA">
        </div>
    </a>

    <ul class="nav-links">
        <li><a href="../BERANDA/beranda.php">Beranda</a></li>
        <li><a href="../TENTANG RUPIAH/tentangrupiah.php">Tentang Rupiah</a></li>
        <li><a href="../MATERI/edukasi.php">Edukasi</a></li>
        <li><a href="../QUIZ/quiz_intro.php" class="active">Quiz</a></li>
        <li><a href="../SCANNER/index.php">Scan</a></li>
    </ul>

    <div class="nav-actions">
        <!-- Menggunakan PHP untuk menentukan apakah tombol Login perlu ditampilkan -->
        <?php if (!$isLoggedIn): ?>
            <a href="../LOGIN/login.php" class="btn-login">Login</a>
        <?php endif; ?>

        <a href="#" class="notification-btn">
            <i data-lucide="bell" style="width:18px; height:18px;"></i>
            <span class="notification-dot"></span>
        </a>
        <div class="nav-divider"></div>
        <a href="../PROFIL/profil.php" class="user-area" title="Profil Pengguna">
            <div class="user-icon">
                <i data-lucide="user-round" style="width:16px; height:16px;"></i>
            </div>
            <!-- Nama pengguna ditampilkan secara dinamis dari Session -->
            <span class="user-greeting">Halo, <?php echo htmlspecialchars($isLoggedIn ? $username : 'User'); ?></span>
        </a>
    </div>
</nav>

<div class="page-content">
<div class="quiz-wrapper">
  <div class="topbar">
    <button class="back-btn" onclick="history.back()">&#8592;</button>
    <div class="progress-block">
      <span class="progress-label" id="progressLabel">Soal 1 dari 6</span>
      <div class="progress-track"><div class="progress-fill" id="progressFill"></div></div>
    </div>
    <div class="timer" id="timerBox">&#8986; <span id="timer">05:00</span></div>
    <button class="hint-btn" id="hintBtn">&#63; Hint (<span id="hintCount">3</span> Tersisa)</button>
  </div>

  <div class="quiz-main-shell">
    <?php if (!$isLoggedIn): ?>
      <div class="login-gate" id="loginGate">
        <div class="gate-card">
          <div class="gate-icon">&#128274;</div>
          <div class="gate-title">Login dulu yuk!</div>
          <div class="gate-desc">Kamu harus login dulu sebelum bisa mulai mengerjakan Quiz ini.</div>
          <a href="../LOGIN/login.php" class="btn btn-primary" style="justify-content:center;margin-top:6px;text-decoration:none;display:inline-flex;" id="gateLoginBtn">Login Sekarang</a>
        </div>
      </div>
    <?php endif; ?>

    <div class="quiz-main">
    <div class="question-card">
      <div class="question-head">
        <div class="question-text" id="questionText"></div>
        <div class="question-instruction">Pilih satu jawaban yang menurutmu paling tepat.</div>
      </div>
      <div class="options-grid" id="optionsGrid"></div>
      <div class="card-footer">
        <button class="skip-link" id="skipBtn">Lewati</button>
        <div class="footer-actions">
          <button class="btn btn-primary" id="nextBtn">Selanjutnya &#8594;</button>
          <button class="btn btn-secondary" id="finishBtn">Selesai</button>
        </div>
      </div>
    </div>

    <div class="nav-card">
      <div class="nav-title">&#9638; Navigasi Soal</div>
      <div class="nav-grid" id="navGrid"></div>
      <div class="legend">
        <div class="legend-item"><span class="dot dot-selesai"></span> Selesai</div>
        <div class="legend-item"><span class="dot dot-aktif"></span> Aktif</div>
        <div class="legend-item"><span class="dot dot-belum"></span> Belum</div>
      </div>
    </div>
    </div>
  </div>
</div>
</div>

<!-- ===================== FOOTER ===================== -->
<footer class="site-footer">
  <div class="footer-inner">
    <div class="footer-brand">
      <div class="footer-logo">RUPANTARA</div>
      <div class="footer-tagline">Platform Edukasi Literasi Keuangan Masa Depan</div>
      <div class="footer-copy">&copy; 2024 RUPANTARA Educational Platform. All rights reserved.</div>
    </div>
    <div class="footer-links">
      <a href="#">Privacy Policy</a>
      <a href="#">Terms of Service</a>
      <a href="#">Help Center</a>
      <a href="#">Contact Us</a>
    </div>
  </div>
</footer>

<div class="result-overlay" id="resultOverlay">
  <div class="result-card" id="resultCard">
    <div class="result-badge" id="resultBadge">Hasil Quiz Kamu</div>
    <div class="result-score" id="resultScore">0 / 0</div>
    <div class="result-label" id="resultMsg"></div>
    <button class="btn btn-primary" style="justify-content:center;margin-top:10px" onclick="location.reload()">Ulangi Quiz</button>
  </div>
</div>

<script>
// ============================================
// DATA SOAL 
// ============================================
const SOAL = [
  { pertanyaan: "Lembaga yang berwenang mengeluarkan dan mengedarkan Rupiah adalah...",
    opsi: [ {l:'A',t:'Kementerian Keuangan'}, {l:'B',t:'OJK'}, {l:'C',t:'Bank Indonesia'}, {l:'D',t:'BPK'} ], benar: 'C' },
  { pertanyaan: "Satuan mata uang resmi Negara Kesatuan Republik Indonesia adalah...",
    opsi: [ {l:'A',t:'Ringgit'}, {l:'B',t:'Rupiah'}, {l:'C',t:'Peso'}, {l:'D',t:'Dolar'} ], benar: 'B' },
  { pertanyaan: "Salah satu ciri keaslian uang kertas Rupiah yang bisa dicek dengan cara diterawang adalah...",
    opsi: [ {l:'A',t:'Warna uang'}, {l:'B',t:'Tanda air (watermark)'}, {l:'C',t:'Ukuran uang'}, {l:'D',t:'Berat uang'} ], benar: 'B' },
  { pertanyaan: "Slogan cinta, bangga, dan paham terhadap Rupiah biasa disingkat menjadi...",
    opsi: [ {l:'A',t:'CBP Rupiah'}, {l:'B',t:'CBR'}, {l:'C',t:'CPR'}, {l:'D',t:'BCP'} ], benar: 'A' },
  { pertanyaan: "Tindakan yang benar terhadap uang Rupiah adalah...",
    opsi: [ {l:'A',t:'Melipat dan mencoret uang'}, {l:'B',t:'Menyimpan uang dengan rapi'}, {l:'C',t:'Menstaples uang'}, {l:'D',t:'Membasahi uang'} ], benar: 'B' },
  { pertanyaan: "Uang Rupiah yang sudah rusak atau tidak layak edar sebaiknya...",
    opsi: [ {l:'A',t:'Dibakar sendiri'}, {l:'B',t:'Tetap dipakai belanja'}, {l:'C',t:'Ditukar ke Bank Indonesia'}, {l:'D',t:'Dibuang'} ], benar: 'C' },
];

const WAKTU_AWAL = 5 * 60; // 5 menit, dalam detik

let indexSekarang = 0;
let jawabanUser = new Array(SOAL.length).fill(null); 
let hintDipakaiDiSoal = new Array(SOAL.length).fill(false);
let hintTersisa = 3;
let sisaWaktu = WAKTU_AWAL;
let timerInterval = null;
let sudahSelesai = false;

// Status login dari PHP
const sudahLogin = <?php echo $isLoggedIn ? 'true' : 'false'; ?>;

const el = {
  questionText: document.getElementById('questionText'),
  optionsGrid: document.getElementById('optionsGrid'),
  progressLabel: document.getElementById('progressLabel'),
  progressFill: document.getElementById('progressFill'),
  navGrid: document.getElementById('navGrid'),
  nextBtn: document.getElementById('nextBtn'),
  finishBtn: document.getElementById('finishBtn'),
  skipBtn: document.getElementById('skipBtn'),
  hintBtn: document.getElementById('hintBtn'),
  hintCount: document.getElementById('hintCount'),
  timer: document.getElementById('timer'),
  timerBox: document.getElementById('timerBox'),
  resultOverlay: document.getElementById('resultOverlay'),
  resultCard: document.getElementById('resultCard'),
  resultBadge: document.getElementById('resultBadge'),
  resultScore: document.getElementById('resultScore'),
  resultMsg: document.getElementById('resultMsg'),
  authArea: document.getElementById('authArea'),
  loginGate: document.getElementById('loginGate')
};

// Quiz otomatis berjalan jika status dari PHP menyatakan sudah login
if (sudahLogin) {
  mulai();
}

function mulai(){
  renderNavGrid();
  tampilkanSoal(0);
  mulaiTimer();
}

function tampilkanSoal(i){
  if(i<0 || i>=SOAL.length) return;
  indexSekarang = i;
  const soal = SOAL[i];

  el.questionText.textContent = soal.pertanyaan;
  el.progressLabel.textContent = `Soal ${i+1} dari ${SOAL.length}`;
  el.progressFill.style.width = `${((i+1)/SOAL.length)*100}%`;

  el.optionsGrid.innerHTML = '';
  soal.opsi.forEach(opsi=>{
    const btn = document.createElement('button');
    btn.className = 'option';
    btn.dataset.label = opsi.l;

    const dipilih = jawabanUser[i] && jawabanUser[i].label === opsi.l;
    if(dipilih) btn.classList.add('selected');

    btn.innerHTML = `<span class="option-badge">${opsi.l}</span><span>${opsi.t}</span>`;
    btn.addEventListener('click', ()=> pilihJawaban(opsi.l));
    el.optionsGrid.appendChild(btn);
  });

  if(hintDipakaiDiSoal[i]) terapkanHintVisual(i);

  el.nextBtn.disabled = i === SOAL.length - 1;
  perbaruiNavGrid();
}

function pilihJawaban(label){
  jawabanUser[indexSekarang] = { label };
  document.querySelectorAll('.option').forEach(o=>o.classList.remove('selected'));
  document.querySelector(`.option[data-label="${label}"]`).classList.add('selected');
  perbaruiNavGrid();
}

function renderNavGrid(){
  el.navGrid.innerHTML = '';
  SOAL.forEach((_,i)=>{
    const btn = document.createElement('button');
    btn.className = 'nav-item belum';
    btn.textContent = i+1;
    btn.addEventListener('click', ()=> tampilkanSoal(i));
    el.navGrid.appendChild(btn);
  });
}

function perbaruiNavGrid(){
  const items = el.navGrid.querySelectorAll('.nav-item');
  items.forEach((item,i)=>{
    item.classList.remove('selesai','aktif','belum');
    if(i === indexSekarang) item.classList.add('aktif');
    else if(jawabanUser[i]) item.classList.add('selesai');
    else item.classList.add('belum');
  });
}

function lewatiSoal(){
  if(indexSekarang < SOAL.length - 1) tampilkanSoal(indexSekarang + 1);
}

function soalBerikutnya(){
  if(indexSekarang < SOAL.length - 1) tampilkanSoal(indexSekarang + 1);
}

function pakaiHint(){
  if(hintTersisa <= 0 || hintDipakaiDiSoal[indexSekarang]) return;
  hintTersisa -= 1;
  hintDipakaiDiSoal[indexSekarang] = true;
  el.hintCount.textContent = hintTersisa;
  if(hintTersisa === 0) el.hintBtn.disabled = true;
  terapkanHintVisual(indexSekarang);
}

function terapkanHintVisual(i){
  const soal = SOAL[i];
  const opsiButtons = [...el.optionsGrid.querySelectorAll('.option')];
  const salah = opsiButtons.filter(b => b.dataset.label !== soal.benar);
  if(salah[0]) salah[0].classList.add('eliminated');
}

function mulaiTimer(){
  updateTimerText();
  timerInterval = setInterval(()=>{
    sisaWaktu -= 1;
    updateTimerText();
    if(sisaWaktu <= 60) el.timerBox.classList.add('warning');
    if(sisaWaktu <= 0){
      clearInterval(timerInterval);
      selesaiQuiz(true); // true = kehabisan waktu
    }
  }, 1000);
}

function updateTimerText(){
  const m = Math.floor(sisaWaktu/60).toString().padStart(2,'0');
  const s = (sisaWaktu%60).toString().padStart(2,'0');
  el.timer.textContent = `${m}:${s}`;
}

function selesaiQuiz(kehabisanWaktu){
  if(sudahSelesai) return;
  sudahSelesai = true;
  clearInterval(timerInterval);

  let benar = 0;
  SOAL.forEach((soal,i)=>{
    if(jawabanUser[i] && jawabanUser[i].label === soal.benar) benar++;
  });

  if(kehabisanWaktu){
    el.resultCard.classList.add('gagal');
    el.resultBadge.textContent = 'Waktu Habis';
    el.resultScore.textContent = `${benar} / ${SOAL.length}`;
    el.resultMsg.textContent = 'Kamu gagal menyelesaikan quiz tepat waktu. Yuk coba lagi!';
  } else {
    el.resultCard.classList.remove('gagal');
    el.resultBadge.textContent = 'Hasil Quiz Kamu';
    el.resultScore.textContent = `${benar} / ${SOAL.length}`;
    el.resultMsg.textContent = benar === SOAL.length
      ? 'Mantap, kamu paham banget soal Rupiah!'
      : 'Terus belajar biar makin cinta dan paham Rupiah ya!';
  }

  el.resultOverlay.classList.add('show');
}

el.nextBtn.addEventListener('click', soalBerikutnya);
el.finishBtn.addEventListener('click', ()=> selesaiQuiz(false));
el.skipBtn.addEventListener('click', lewatiSoal);
el.hintBtn.addEventListener('click', pakaiHint);

// Inisialisasi ikon Lucide
lucide.createIcons();
</script>
</body>
</html>