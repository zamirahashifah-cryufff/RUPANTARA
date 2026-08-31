<?php
session_start();
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
$is_logged_in = isset($_SESSION['login']) && $_SESSION['login'] === true;
$display_username = $is_logged_in ? $_SESSION['username'] : 'User';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Rupiah Runner 100K - RUPANTARA</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Plus Jakarta Sans", sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        html, body {
            width: 100vw;
            height: 100vh;
            overflow: hidden;
            background: #0D1321;
            color: #FFFFFF;
            user-select: none;
        }

        /* =====================================================
           FULL SCREEN GAME CONTAINER
        ===================================================== */
        .game-screen {
            position: relative;
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: column;
            background: #0D1321;
            overflow: hidden;
        }

        /* HEADER ATAS */
        .game-top-bar {
            height: 65px;
            background: #111A2E;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 10;
            flex-shrink: 0;
        }

        .game-title-badge {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 18px;
            font-weight: 800;
            color: #FFFFFF;
        }

        .game-icon-pill {
            background: #FF3366;
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(255, 51, 102, 0.35);
        }

        .btn-icon-top {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #1C2638;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #94A3B8;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-icon-top:hover {
            background: #2A364F;
            color: #FFFFFF;
            transform: scale(1.05);
        }

        /* CANVAS WRAPPER */
        .canvas-wrapper {
            position: relative;
            flex: 1;
            width: 100%;
            height: calc(100vh - 150px);
            background: #090E17;
            overflow: hidden;
        }

        canvas {
            display: block;
            width: 100%;
            height: 100%;
        }

        /* HUD SKOR TABUNGAN */
        .score-hud {
            position: absolute;
            top: 20px;
            left: 24px;
            font-size: 19px;
            font-weight: 800;
            color: #FDE047;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.8);
            background: rgba(17, 26, 46, 0.85);
            padding: 8px 18px;
            border-radius: 14px;
            border: 1px solid rgba(253, 224, 71, 0.3);
            backdrop-filter: blur(8px);
            pointer-events: none;
            z-index: 5;
        }

        /* FLOATING TEXT SAAT DAPAT 100K */
        .score-float {
            position: absolute;
            color: #4ADE80;
            font-size: 20px;
            font-weight: 900;
            animation: floatUp 0.8s ease-out forwards;
            pointer-events: none;
            text-shadow: 0 2px 6px rgba(0,0,0,0.8);
            z-index: 6;
        }

        @keyframes floatUp {
            0% { opacity: 1; transform: translateY(0) scale(1); }
            100% { opacity: 0; transform: translateY(-45px) scale(1.2); }
        }

        /* BOTTOM ACTION CONTROLS */
        .bottom-action-bar {
            height: 85px;
            background: #111A2E;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            padding: 0 24px;
            flex-shrink: 0;
            z-index: 10;
        }

        .btn-jump {
            flex: 1;
            max-width: 620px;
            height: 54px;
            background: linear-gradient(180deg, #FBBF24 0%, #F59E0B 100%);
            border: none;
            border-radius: 16px;
            color: #0F172A;
            font-size: 16.5px;
            font-weight: 900;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.35);
            transition: all 0.15s ease;
        }

        .btn-jump:active {
            transform: translateY(2px) scale(0.98);
            background: #D97706;
        }

        .btn-close-bottom {
            height: 54px;
            padding: 0 28px;
            background: #1E293B;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            color: #E2E8F0;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-close-bottom:hover {
            background: #334155;
            color: #FFFFFF;
        }

        /* =====================================================
           MODAL GAME OVER
        ===================================================== */
        .modal-overlay {
            position: absolute;
            inset: 0;
            background: rgba(7, 11, 20, 0.75);
            backdrop-filter: blur(8px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 100;
            padding: 20px;
        }

        .modal-card {
            background: #0E1626;
            border: 2px solid rgba(255, 77, 109, 0.35);
            border-radius: 28px;
            padding: 34px 30px;
            width: 100%;
            max-width: 440px;
            text-align: center;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6);
            animation: popUp 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes popUp {
            from { transform: scale(0.85); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .modal-trophy {
            font-size: 52px;
            margin-bottom: 8px;
        }

        .modal-title {
            font-size: 25px;
            font-weight: 900;
            color: #FFFFFF;
            margin-bottom: 12px;
        }

        .badge-duta {
            display: inline-block;
            background: #FF3366;
            color: #FFFFFF;
            font-size: 13.5px;
            font-weight: 800;
            padding: 6px 24px;
            border-radius: 30px;
            margin-bottom: 16px;
            box-shadow: 0 4px 15px rgba(255, 51, 102, 0.35);
            letter-spacing: 0.5px;
        }

        .modal-label-savings {
            font-size: 14.5px;
            color: #94A3B8;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .modal-total-value {
            font-size: 32px;
            font-weight: 900;
            color: #2DD4BF;
            margin-bottom: 22px;
        }

        .modal-btn-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .btn-restart {
            width: 100%;
            height: 50px;
            background: linear-gradient(180deg, #FBBF24 0%, #F59E0B 100%);
            border: none;
            border-radius: 14px;
            color: #0F172A;
            font-size: 16px;
            font-weight: 900;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-restart:hover {
            background: #FBBF24;
            transform: translateY(-2px);
        }

        .btn-kembali {
            width: 100%;
            height: 48px;
            background: #1E293B;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            color: #E2E8F0;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .btn-kembali:hover {
            background: #334155;
            color: #FFFFFF;
        }

        @media (max-width: 600px) {
            .game-top-bar { height: 55px; padding: 0 16px; }
            .score-hud { font-size: 15px; top: 12px; left: 14px; padding: 6px 14px; }
            .bottom-action-bar { height: 75px; padding: 0 16px; }
            .btn-jump { font-size: 15px; height: 48px; }
            .btn-close-bottom { height: 48px; padding: 0 18px; font-size: 13.5px; }
        }
    </style>
</head>

<body>

<div class="game-screen">
    <!-- TOP BAR -->
    <div class="game-top-bar">
        <div class="game-title-badge">
            <div class="game-icon-pill">
                <i data-lucide="gamepad-2" style="width:20px; height:20px;"></i>
            </div>
            <span>Rupiah Runner</span>
        </div>
        <a href="quiz_intro.php" class="btn-icon-top" title="Tutup Permainan">
            <i data-lucide="x" style="width:20px; height:20px;"></i>
        </a>
    </div>

    <!-- CANVAS AREA (FULLSCREEN) -->
    <div class="canvas-wrapper" id="canvas-container">
        <div class="score-hud" id="hud-score">Tabungan Rp100k: Rp 0</div>
        <canvas id="gameCanvas"></canvas>
    </div>

    <!-- BOTTOM ACTION BAR -->
    <div class="bottom-action-bar">
        <button class="btn-jump" id="btn-jump-action" onmousedown="triggerJump(event)" ontouchstart="triggerJump(event)">
            <i data-lucide="arrow-up" style="width:22px; height:22px; stroke-width:3;"></i>
            Lompat! (Ambil Rp100k)
        </button>
        <a href="quiz_intro.php" class="btn-close-bottom">Tutup</a>
    </div>

    <!-- MODAL GAME OVER -->
    <div class="modal-overlay" id="gameOverModal">
        <div class="modal-card">
            <div class="modal-trophy">🏆</div>
            <h2 class="modal-title">Permainan Selesai!</h2>
            <div class="badge-duta" id="rankBadge">RUPANTARA</div>
            
            <div class="modal-label-savings">Total Tabungan:</div>
            <div class="modal-total-value" id="finalScoreText">Rp 0</div>

            <div class="modal-btn-group">
                <button class="btn-restart" onclick="restartGame()">Main Lagi</button>
                <a href="quiz_intro.php" class="btn-kembali">Kembali</a>
            </div>
        </div>
    </div>
</div>

<script>
// ==========================================
// AUDIO SYNTHESIZER (WEB AUDIO API)
// ==========================================
let audioCtx = null;

function initAudio() {
    if (!audioCtx) {
        audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    }
    if (audioCtx.state === 'suspended') {
        audioCtx.resume();
    }
}

function playSound(type) {
    try {
        initAudio();
        const osc = audioCtx.createOscillator();
        const gain = audioCtx.createGain();
        osc.connect(gain);
        gain.connect(audioCtx.destination);

        if (type === 'jump') {
            osc.type = 'square';
            osc.frequency.setValueAtTime(150, audioCtx.currentTime);
            osc.frequency.exponentialRampToValueAtTime(400, audioCtx.currentTime + 0.12);
            gain.gain.setValueAtTime(0.1, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.12);
            osc.start();
            osc.stop(audioCtx.currentTime + 0.12);
        } else if (type === 'coin') {
            osc.type = 'sine';
            osc.frequency.setValueAtTime(587.33, audioCtx.currentTime);
            osc.frequency.setValueAtTime(880, audioCtx.currentTime + 0.08);
            gain.gain.setValueAtTime(0.18, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.25);
            osc.start();
            osc.stop(audioCtx.currentTime + 0.25);
        } else if (type === 'hit') {
            osc.type = 'sawtooth';
            osc.frequency.setValueAtTime(220, audioCtx.currentTime);
            osc.frequency.linearRampToValueAtTime(60, audioCtx.currentTime + 0.25);
            gain.gain.setValueAtTime(0.2, audioCtx.currentTime);
            gain.gain.linearRampToValueAtTime(0.01, audioCtx.currentTime + 0.25);
            osc.start();
            osc.stop(audioCtx.currentTime + 0.25);
        }
    } catch (e) {}
}

// ==========================================
// GAME ENGINE & SETUP
// ==========================================
const canvas = document.getElementById('gameCanvas');
const ctx = canvas.getContext('2d');
const container = document.getElementById('canvas-container');
const hudScore = document.getElementById('hud-score');
const gameOverModal = document.getElementById('gameOverModal');
const finalScoreText = document.getElementById('finalScoreText');

let totalSavings = 0;
let isGameOver = false;
let gameSpeed = 6;
let animationFrameId = null;
let spawnTimer = 0;
let particles = [];

// Ground Configuration
const groundHeight = 85;

// Player Object
const player = {
    x: 80,
    y: 0,
    width: 46,
    height: 50,
    velocityY: 0,
    gravity: 0.8,
    jumpPower: -16,
    isGrounded: false
};

// Lists for Money & Obstacles
let moneys = [];
let obstacles = [];

// Dynamic Canvas Resize
function resizeCanvas() {
    canvas.width = container.clientWidth;
    canvas.height = container.clientHeight;
    if (player.isGrounded) {
        player.y = canvas.height - groundHeight - player.height;
    }
}
window.addEventListener('resize', resizeCanvas);

// Restart Game
function restartGame() {
    totalSavings = 0;
    isGameOver = false;
    gameSpeed = 6;
    moneys = [];
    obstacles = [];
    particles = [];
    spawnTimer = 0;
    
    resizeCanvas();
    player.y = canvas.height - groundHeight - player.height;
    player.velocityY = 0;
    player.isGrounded = true;

    hudScore.innerText = 'Tabungan Rp100k: Rp 0';
    gameOverModal.style.display = 'none';

    if (animationFrameId) cancelAnimationFrame(animationFrameId);
    gameLoop();
}

// Jump Action
function triggerJump(e) {
    if (e) e.preventDefault();
    if (isGameOver) return;

    if (player.isGrounded) {
        player.velocityY = player.jumpPower;
        player.isGrounded = false;
        playSound('jump');
        createJumpDust(player.x + player.width / 2, player.y + player.height);
    }
}

// Keyboard Listeners
window.addEventListener('keydown', (e) => {
    if (e.code === 'Space' || e.code === 'ArrowUp' || e.code === 'KeyW') {
        e.preventDefault();
        triggerJump();
    }
});

// Canvas Click & Touch
canvas.addEventListener('touchstart', (e) => {
    e.preventDefault();
    triggerJump();
}, { passive: false });

canvas.addEventListener('mousedown', () => {
    triggerJump();
});

// Particle Effects
function createJumpDust(x, y) {
    for (let i = 0; i < 6; i++) {
        particles.push({
            x: x,
            y: y,
            vx: (Math.random() - 0.5) * 4,
            vy: (Math.random() - 1) * 2,
            radius: Math.random() * 3 + 2,
            alpha: 1
        });
    }
}

function showFloatText(x, y, text) {
    const floatEl = document.createElement('div');
    floatEl.className = 'score-float';
    floatEl.innerText = text;
    floatEl.style.left = `${x}px`;
    floatEl.style.top = `${y}px`;
    container.appendChild(floatEl);
    setTimeout(() => floatEl.remove(), 800);
}

// ==========================================
// SPAWN LOGIC (MONEY & OBSTACLES)
// ==========================================
function spawnEntities() {
    spawnTimer++;
    if (spawnTimer % 95 === 0) {
        const rand = Math.random();

        // Spawn Uang 100K Melayang
        if (rand > 0.35) {
            moneys.push({
                x: canvas.width + 30,
                y: canvas.height - groundHeight - (Math.random() * 85 + 75),
                width: 60,
                height: 30,
                collected: false
            });
        }
        
        // Spawn Rintangan Kotak Kuning (Hazard ⚠️)
        if (rand < 0.65) {
            obstacles.push({
                x: canvas.width + 120,
                y: canvas.height - groundHeight - 44,
                width: 44,
                height: 44
            });
        }
    }
}

// ==========================================
// MAIN GAME ANIMATION LOOP
// ==========================================
function gameLoop() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // 1. UPDATE & FALL PLAYER
    player.velocityY += player.gravity;
    player.y += player.velocityY;

    const floorY = canvas.height - groundHeight - player.height;
    if (player.y >= floorY) {
        player.y = floorY;
        player.velocityY = 0;
        player.isGrounded = true;
    }

    // 2. DRAW GROUND (MERAH DENGAN GARIS KUNING EMAS)
    ctx.fillStyle = '#A31D1D';
    ctx.fillRect(0, canvas.height - groundHeight, canvas.width, groundHeight);

    ctx.fillStyle = '#F59E0B';
    ctx.fillRect(0, canvas.height - groundHeight, canvas.width, 6);

    // 3. DRAW & UPDATE OBSTACLES (KOTAK KUNING HAZARD ⚠️)
    for (let i = obstacles.length - 1; i >= 0; i--) {
        const obs = obstacles[i];
        obs.x -= gameSpeed;

        // Kotak Kuning
        ctx.fillStyle = '#EAB308';
        ctx.fillRect(obs.x, obs.y, obs.width, obs.height);
        
        // Border
        ctx.strokeStyle = '#B45309';
        ctx.lineWidth = 3;
        ctx.strokeRect(obs.x, obs.y, obs.width, obs.height);

        // Icon Segitiga Bahaya ⚠️
        ctx.fillStyle = '#78350F';
        ctx.font = '22px sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText('⚠', obs.x + obs.width / 2, obs.y + obs.height - 12);

        // Collision Check
        if (
            player.x + 6 < obs.x + obs.width &&
            player.x + player.width - 6 > obs.x &&
            player.y + 6 < obs.y + obs.height &&
            player.y + player.height > obs.y + 4
        ) {
            handleGameOver();
            return;
        }

        if (obs.x + obs.width < -50) obstacles.splice(i, 1);
    }

    // 4. DRAW & UPDATE 100K MONEY
    for (let i = moneys.length - 1; i >= 0; i--) {
        const m = moneys[i];
        m.x -= gameSpeed;

        if (!m.collected) {
            // Lembaran Uang Merah
            ctx.fillStyle = '#DC2626';
            ctx.fillRect(m.x, m.y, m.width, m.height);

            // Garis Emas
            ctx.strokeStyle = '#FDE047';
            ctx.lineWidth = 2;
            ctx.strokeRect(m.x, m.y, m.width, m.height);

            // Tulisan 100K
            ctx.fillStyle = '#FFFFFF';
            ctx.font = 'bold 12px "Plus Jakarta Sans"';
            ctx.textAlign = 'center';
            ctx.fillText('100K', m.x + m.width / 2, m.y + m.height / 2 + 4);

            // Ambil Uang
            if (
                player.x < m.x + m.width &&
                player.x + player.width > m.x &&
                player.y < m.y + m.height &&
                player.y + player.height > m.y
            ) {
                m.collected = true;
                totalSavings += 100000;
                hudScore.innerText = `Tabungan Rp100k: Rp ${totalSavings.toLocaleString('id-ID')}`;
                playSound('coin');
                showFloatText(m.x, m.y, '+Rp 100.000');
                
                if (gameSpeed < 11.5) gameSpeed += 0.12;
            }
        }

        if (m.x + m.width < -50) moneys.splice(i, 1);
    }

    // 5. DRAW PLAYER (KOTAK MERAH DENGAN WAJAH)
    ctx.fillStyle = '#E11D48';
    ctx.fillRect(player.x, player.y, player.width, player.height);

    ctx.strokeStyle = '#9F1239';
    ctx.lineWidth = 3;
    ctx.strokeRect(player.x, player.y, player.width, player.height);

    // Area Wajah
    ctx.fillStyle = '#FDE047';
    ctx.fillRect(player.x + 8, player.y + 10, player.width - 16, 20);

    // Biji Mata Hitam
    ctx.fillStyle = '#0F172A';
    ctx.fillRect(player.x + 23, player.y + 16, 7, 8);

    // 6. DRAW PARTICLES
    for (let i = particles.length - 1; i >= 0; i--) {
        const p = particles[i];
        p.x += p.vx;
        p.y += p.vy;
        p.alpha -= 0.04;
        
        ctx.fillStyle = `rgba(251, 191, 36, ${Math.max(0, p.alpha)})`;
        ctx.beginPath();
        ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
        ctx.fill();

        if (p.alpha <= 0) particles.splice(i, 1);
    }

    spawnEntities();

    if (!isGameOver) {
        animationFrameId = requestAnimationFrame(gameLoop);
    }
}

// ==========================================
// GAME OVER HANDLER
// ==========================================
function handleGameOver() {
    isGameOver = true;
    playSound('hit');

    finalScoreText.innerText = `Rp ${totalSavings.toLocaleString('id-ID')}`;
    gameOverModal.style.display = 'flex';

    if (totalSavings > 0) {
        confetti({ particleCount: 80, spread: 70, origin: { y: 0.6 } });
    }
}

// Inisialisasi Game
window.addEventListener('DOMContentLoaded', () => {
    restartGame();
    lucide.createIcons();
});
</script>

</body>
</html>