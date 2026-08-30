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
  <title>RUPANTARA - Quiz Level 1</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  
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
      --card: #FFFFFF;
      --text-main: #1E2A3A;
      --text-sub: #7A8494;
      --belum-bg: #F3F5F9;
      --belum-border: #D8DDE7;
      --radius-lg: 20px;
      --radius-md: 12px;
      --radius-sm: 8px;
      --good: #1E8E5A;
      --good-soft: #E6F4ED;
      --bad: #D0392B;
      --bad-soft: #FBEAE9;
      --warning: #E8A838;
      --accent-glow: rgba(23, 50, 92, 0.15);
    }
    * { box-sizing: border-box; margin: 0; padding: 0; font-family: "Plus Jakarta Sans", "Inter", sans-serif; }
    html { scroll-behavior: smooth; }
    body {
      background: var(--body); color: var(--text-main);
      min-height: 100vh; display: flex; flex-direction: column; overflow-x: hidden;
      line-height: 1.6; font-size: 15px;
    }

    /* =====================================================
       HEADER / NAVBAR (Floating Glassmorphism style)
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
      text-decoration: none;
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

    .streak-badge {
      display: none;
      align-items: center;
      gap: 4px;
      background: linear-gradient(135deg, #E8A838, #D48920);
      color: #fff;
      padding: 6px 12px;
      border-radius: 10px;
      font-size: 12px;
      font-weight: 700;
      animation: streak-pop 0.5s cubic-bezier(0.34,1.56,0.64,1);
      box-shadow: 0 4px 12px rgba(232,168,56,0.3);
    }
    .streak-badge.show { display: flex; }
    .streak-badge .fire { font-size: 14px; }

    /* =====================================================
       ANIMATIONS
    ===================================================== */
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes slideInRight { from { opacity: 0; transform: translateX(60px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes slideInLeft { from { opacity: 0; transform: translateX(-60px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes shake { 0%,100%{transform:translateX(0)} 10%,30%,50%,70%,90%{transform:translateX(-6px)} 20%,40%,60%,80%{transform:translateX(6px)} }
    @keyframes pulse { 0%,100%{transform:scale(1)} 50%{transform:scale(1.05)} }
    @keyframes pulse-ring { 0%{transform:scale(0.8);opacity:1} 100%{transform:scale(1.5);opacity:0} }
    @keyframes bounce { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
    @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }
    @keyframes glow { 0%,100%{box-shadow:0 0 5px var(--accent-glow)} 50%{box-shadow:0 0 20px var(--accent-glow),0 0 40px rgba(23,50,92,0.08)} }
    @keyframes countUp { from { opacity: 0; transform: translateY(20px) scale(0.8); } to { opacity: 1; transform: translateY(0) scale(1); } }
    @keyframes ripple { to { transform: scale(4); opacity: 0; } }
    @keyframes timer-pulse { 0%,100%{transform:scale(1)} 50%{transform:scale(1.08)} }
    @keyframes streak-pop { 0%{transform:scale(0) rotate(-10deg);opacity:0} 60%{transform:scale(1.2) rotate(5deg);opacity:1} 100%{transform:scale(1) rotate(0deg);opacity:1} }
    @keyframes progress-shine { 0%{background-position:-200% center} 100%{background-position:200% center} }
    @keyframes toast-in { from { transform: translateX(120%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    @keyframes toast-out { from { transform: translateX(0); opacity: 1; } to { transform: translateX(120%); opacity: 0; } }
    @keyframes particle-burst { 0%{transform:translate(0,0) scale(1);opacity:1} 100%{transform:translate(var(--tx),var(--ty)) scale(0);opacity:0} }

    /* =====================================================
       PAGE CONTENT & QUIZ LAYOUT
    ===================================================== */
    .page-content { flex: 1; display: flex; align-items: flex-start; justify-content: center; padding: 40px 16px 20px; position: relative; }
    .quiz-wrapper { width: 100%; max-width: 1200px; display: flex; flex-direction: column; gap: 20px; }

    .topbar { background: var(--card); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 14px 22px; display: flex; align-items: center; gap: 18px; box-shadow: 0 2px 10px rgba(23,50,92,0.05); animation: fadeInUp 0.5s ease; transition: all 0.3s ease; }
    .topbar:hover { box-shadow: 0 4px 20px rgba(23,50,92,0.1); transform: translateY(-1px); }
    .back-btn { font-size: 20px; color: var(--text-sub); background: none; border: none; cursor: pointer; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; }
    .back-btn:hover { background: var(--navy-soft); color: var(--navy); transform: translateX(-3px); }
    .progress-block { flex: 1; display: flex; flex-direction: column; gap: 6px; }
    .progress-label { font-size: 13px; font-weight: 600; display: flex; justify-content: space-between; align-items: center; }
    .progress-track { width: 100%; height: 8px; border-radius: 999px; background: var(--belum-bg); overflow: hidden; position: relative; }
    .progress-fill { height: 100%; width: 0%; border-radius: 999px; background: linear-gradient(90deg, var(--navy), #2a5a9a, var(--navy)); background-size: 200% 100%; transition: width 0.6s cubic-bezier(0.34,1.56,0.64,1); position: relative; animation: progress-shine 2s linear infinite; }
    .progress-fill::after { content: ''; position: absolute; right: 0; top: 0; bottom: 0; width: 20px; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4)); border-radius: 999px; }
    .timer { display: flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 700; color: var(--text-sub); white-space: nowrap; padding: 6px 12px; border-radius: 999px; background: var(--belum-bg); transition: all 0.3s ease; }
    .timer.warning { color: var(--bad); background: var(--bad-soft); animation: timer-pulse 1s ease infinite; }
    .timer.critical { color: #fff; background: var(--bad); animation: timer-pulse 0.5s ease infinite; }
    .hint-btn { display: flex; align-items: center; gap: 6px; border: 1.5px solid var(--border); border-radius: 999px; padding: 8px 16px; font-family: inherit; font-weight: 700; font-size: 13px; color: var(--navy); background: var(--navy-soft); cursor: pointer; white-space: nowrap; transition: all 0.3s cubic-bezier(0.34,1.56,0.64,1); position: relative; overflow: hidden; }
    .hint-btn:hover:not(:disabled) { transform: translateY(-2px) scale(1.03); box-shadow: 0 6px 20px rgba(23,50,92,0.15); border-color: var(--navy); }
    .hint-btn:disabled { opacity: .4; cursor: not-allowed; transform: none; }
    .hint-btn .hint-icon { transition: transform 0.3s ease; }
    .hint-btn:hover:not(:disabled) .hint-icon { transform: rotate(15deg) scale(1.2); }

    .quiz-main { display: grid; grid-template-columns: 1fr 280px; gap: 24px; align-items: start; }
    @media (max-width:900px) { .quiz-main { grid-template-columns: 1fr; } }

    .question-card { background: var(--card); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 36px; box-shadow: 0 4px 20px rgba(0,48,135,0.04); display: flex; flex-direction: column; gap: 22px; animation: slideInRight 0.5s cubic-bezier(0.34,1.56,0.64,1); transition: all 0.3s ease; position: relative; overflow: hidden; }
    .question-card.slide-left { animation: slideInLeft 0.5s cubic-bezier(0.34,1.56,0.64,1); }
    .question-card:hover { box-shadow: 0 10px 30px rgba(23,50,92,0.08); }
    .question-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, var(--navy), #3a6aaa); border-radius: var(--radius-lg) var(--radius-lg) 0 0; transform: scaleX(0); transform-origin: left; transition: transform 0.5s ease; }
    .question-card:hover::before { transform: scaleX(1); }
    .question-head { display: flex; flex-direction: column; gap: 10px; }
    .question-badges { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
    .question-number { font-size: 12px; font-weight: 700; color: var(--navy); background: var(--navy-soft); padding: 4px 12px; border-radius: 999px; display: inline-block; width: fit-content; animation: fadeIn 0.4s ease; }
    .level-badge { font-size: 12px; font-weight: 700; color: #8A5A00; background: linear-gradient(135deg, #FCEBC7, #F8DFA0); padding: 4px 12px; border-radius: 999px; display: inline-flex; align-items: center; gap: 5px; width: fit-content; animation: fadeIn 0.4s ease .05s both; box-shadow: 0 2px 8px rgba(232,168,56,0.2); }
    .level-badge .level-dot { width: 6px; height: 6px; border-radius: 50%; background: #E8A838; }
    .question-text { font-size: 19px; font-weight: 800; line-height: 1.5; color: var(--navy); animation: fadeInUp 0.5s ease 0.1s both; }
    .question-instruction { font-size: 13.5px; font-style: italic; font-weight: 500; color: var(--text-sub); animation: fadeIn 0.5s ease 0.2s both; }
    .options-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    @media (max-width:560px) { .options-grid { grid-template-columns: 1fr; } }

    .option { display: flex; align-items: center; gap: 12px; border: 2px solid var(--border); border-radius: var(--radius-md); padding: 14px 16px; background: var(--card); cursor: pointer; font-family: inherit; font-size: 14px; font-weight: 600; color: var(--text-main); text-align: left; transition: all 0.25s cubic-bezier(0.34,1.56,0.64,1); position: relative; overflow: hidden; animation: fadeInUp 0.4s ease both; }
    .option:nth-child(1) { animation-delay: 0.05s; }
    .option:nth-child(2) { animation-delay: 0.1s; }
    .option:nth-child(3) { animation-delay: 0.15s; }
    .option:nth-child(4) { animation-delay: 0.2s; }
    .option:hover { border-color: var(--navy); background: var(--navy-soft); transform: translateY(-2px) scale(1.01); box-shadow: 0 6px 20px rgba(23,50,92,0.1); }
    .option:active { transform: translateY(0) scale(0.98); }
    .option.selected { border-color: var(--navy); background: linear-gradient(135deg, var(--navy-soft), #d4e0f5); box-shadow: 0 4px 15px rgba(23,50,92,0.15); transform: translateY(-1px); }
    .option.correct { border-color: var(--good); background: linear-gradient(135deg, var(--good-soft), #d4edda); animation: bounce 0.5s ease; }
    .option.wrong { border-color: var(--bad); background: var(--bad-soft); animation: shake 0.5s ease; }
    .option.eliminated { opacity: .25; pointer-events: none; text-decoration: line-through; transform: scale(0.95); }
    .option-badge { flex-shrink: 0; width: 32px; height: 32px; border-radius: 10px; background: var(--navy-soft); color: var(--navy); font-weight: 700; font-size: 13px; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; }
    .option.selected .option-badge { background: var(--navy); color: #fff; transform: scale(1.1); }
    .option.correct .option-badge { background: var(--good); color: #fff; }
    .option.wrong .option-badge { background: var(--bad); color: #fff; }
    .option-key { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); font-size: 11px; font-weight: 700; color: var(--text-sub); background: var(--belum-bg); padding: 2px 8px; border-radius: 6px; opacity: 0.7; }
    .ripple { position: absolute; border-radius: 50%; background: rgba(23,50,92,0.15); transform: scale(0); animation: ripple 0.6s linear; pointer-events: none; }

    .card-footer { display: flex; align-items: center; justify-content: space-between; margin-top: 4px; animation: fadeIn 0.5s ease 0.3s both; }
    .skip-link { font-size: 14px; font-weight: 600; color: var(--text-sub); background: none; border: none; cursor: pointer; font-family: inherit; text-decoration: underline; text-underline-offset: 3px; transition: all 0.3s ease; padding: 8px 12px; border-radius: 8px; }
    .skip-link:hover { color: var(--navy); background: var(--navy-soft); transform: translateX(3px); }
    .footer-actions { display: flex; gap: 10px; }
    .btn { font-family: inherit; font-weight: 700; font-size: 14px; border-radius: 999px; padding: 12px 24px; cursor: pointer; border: none; display: flex; align-items: center; gap: 8px; transition: all 0.3s cubic-bezier(0.34,1.56,0.64,1); position: relative; overflow: hidden; }
    .btn:disabled { opacity: .4; cursor: not-allowed; transform: none !important; }
    .btn-primary { background: linear-gradient(135deg, var(--blue-dark), #1d5fa3); color: #fff; box-shadow: 0 4px 15px rgba(23,76,132,0.25); }
    .btn-primary:hover:not(:disabled) { transform: translateY(-2px) scale(1.03); box-shadow: 0 8px 25px rgba(23,76,132,0.35); }
    .btn-primary:active:not(:disabled) { transform: translateY(0) scale(0.97); }
    .btn-secondary { background: linear-gradient(135deg, var(--navy-dark), #1a3050); color: #fff; box-shadow: 0 4px 15px rgba(15,31,56,0.2); }
    .btn-secondary:hover:not(:disabled) { transform: translateY(-2px) scale(1.03); box-shadow: 0 8px 25px rgba(15,31,56,0.35); }
    .btn-secondary:active:not(:disabled) { transform: translateY(0) scale(0.97); }
    .btn-success { background: linear-gradient(135deg, var(--good), #167a4a); color: #fff; box-shadow: 0 4px 15px rgba(30,142,90,0.25); }
    .btn-success:hover:not(:disabled) { transform: translateY(-2px) scale(1.03); box-shadow: 0 8px 25px rgba(30,142,90,0.35); }

    .nav-card { background: var(--card); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 22px; box-shadow: 0 4px 20px rgba(0,48,135,0.04); display: flex; flex-direction: column; gap: 18px; animation: fadeInUp 0.6s ease 0.2s both; transition: all 0.3s ease; position: sticky; top: 120px; }
    .nav-card:hover { box-shadow: 0 8px 30px rgba(23,50,92,0.1); }
    .nav-title { display: flex; align-items: center; gap: 8px; font-size: 15px; font-weight: 800; color: var(--navy); }
    .nav-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 8px; }
    .nav-item { aspect-ratio: 1; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-sm); font-size: 13px; font-weight: 700; cursor: pointer; font-family: inherit; border: 2px solid transparent; transition: all 0.3s cubic-bezier(0.34,1.56,0.64,1); position: relative; }
    .nav-item:hover { transform: translateY(-2px) scale(1.1); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    .nav-item:active { transform: scale(0.95); }
    .nav-item.selesai { background: linear-gradient(135deg, var(--navy), #2a4a7a); color: #fff; box-shadow: 0 4px 12px rgba(23,50,92,0.25); }
    .nav-item.aktif { background: var(--card); color: var(--navy); border-color: var(--navy); box-shadow: 0 0 0 3px rgba(23,50,92,0.1); animation: pulse 2s ease infinite; }
    .nav-item.belum { background: var(--belum-bg); color: var(--text-sub); border-color: var(--belum-border); }
    .nav-item.belum:hover { border-color: var(--navy); color: var(--navy); }
    .legend { display: flex; flex-direction: column; gap: 10px; font-size: 13px; font-weight: 500; color: var(--text-sub); }
    .legend-item { display: flex; align-items: center; gap: 8px; }
    .dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
    .dot-selesai { background: var(--navy); }
    .dot-aktif { border: 2px solid var(--navy); background: transparent; }
    .dot-belum { border-radius: 3px; background: var(--belum-bg); border: 2px solid var(--belum-border); }

    .particle-container { position: fixed; pointer-events: none; z-index: 9999; }
    .particle { position: absolute; width: 8px; height: 8px; border-radius: 50%; pointer-events: none; animation: particle-burst 0.8s ease-out forwards; }

    .toast-container { position: fixed; top: 110px; right: 20px; z-index: 1000; display: flex; flex-direction: column; gap: 10px; pointer-events: none; }
    .toast { background: var(--card); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 14px 20px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); display: flex; align-items: center; gap: 10px; font-size: 14px; font-weight: 600; pointer-events: auto; animation: toast-in 0.4s cubic-bezier(0.34,1.56,0.64,1); max-width: 320px; }
    .toast.hiding { animation: toast-out 0.3s ease forwards; }
    .toast.success { border-left: 4px solid var(--good); }
    .toast.error { border-left: 4px solid var(--bad); }
    .toast.info { border-left: 4px solid var(--navy); }
    .toast.warning { border-left: 4px solid var(--warning); }

    .result-overlay { position: fixed; inset: 0; background: rgba(16,35,63,.65); backdrop-filter: blur(8px); display: none; align-items: center; justify-content: center; padding: 16px; z-index: 10000; opacity: 0; transition: opacity 0.4s ease; }
    .result-overlay.show { display: flex; opacity: 1; }
    .result-card { background: var(--card); border-radius: 28px; padding: 36px 32px; max-width: 520px; width: 100%; text-align: center; display: flex; flex-direction: column; gap: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.2); animation: fadeInUp 0.6s cubic-bezier(0.34,1.56,0.64,1); position: relative; overflow: hidden; max-height: 90vh; overflow-y: auto; }
    .result-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 5px; background: linear-gradient(90deg, var(--navy), #3a6aaa, var(--navy)); }
    .result-badge { align-self: center; font-size: 12px; font-weight: 700; padding: 8px 18px; border-radius: 999px; background: var(--navy-soft); color: var(--navy); animation: fadeIn 0.5s ease 0.2s both; }
    .result-card.gagal .result-badge { background: var(--bad-soft); color: var(--bad); }
    .result-score { font-size: 48px; font-weight: 900; color: var(--navy); animation: countUp 0.8s cubic-bezier(0.34,1.56,0.64,1) 0.3s both; line-height: 1; }
    .result-card.gagal .result-score { color: var(--bad); }
    .result-label { font-size: 18px; color: var(--navy); font-weight: 800; animation: fadeIn 0.5s ease 0.5s both; }
    .result-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin: 8px 0; animation: fadeInUp 0.5s ease 0.6s both; }
    .stat-box { background: var(--navy-soft); border-radius: var(--radius-md); padding: 14px 8px; display: flex; flex-direction: column; gap: 4px; }
    .stat-box .stat-value { font-size: 22px; font-weight: 800; color: var(--navy); }
    .stat-box .stat-label { font-size: 11px; font-weight: 600; color: var(--text-sub); }
    .review-section { max-height: 180px; overflow-y: auto; text-align: left; margin-top: 8px; animation: fadeIn 0.5s ease 0.7s both; padding-right: 4px; }
    .review-item { padding: 10px 14px; border-radius: var(--radius-sm); margin-bottom: 8px; font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 8px; transition: all 0.3s ease; cursor: pointer; }
    .review-item:hover { transform: translateX(4px); }
    .review-item.correct { background: var(--good-soft); color: var(--good); border: 1px solid #A7F3D0; }
    .review-item.wrong { background: var(--bad-soft); color: var(--bad); border: 1px solid #FECACA; }
    .review-item.empty { background: var(--belum-bg); color: var(--text-sub); }
    .review-pembahasan { font-size: 12px; font-weight: 500; color: var(--text-sub); margin-top: 4px; padding-left: 28px; line-height: 1.4; display: none; }
    .review-item.expanded .review-pembahasan { display: block; animation: fadeIn 0.3s ease; }

    .level-prompt { font-size: 13.5px; font-weight: 600; color: var(--muted); margin-top: 6px; line-height: 1.5; animation: fadeIn 0.5s ease 0.75s both; }
    .result-actions { display: flex; gap: 12px; margin-top: 10px; animation: fadeInUp 0.5s ease 0.8s both; }
    .result-actions .btn { flex: 1; justify-content: center; }

    #confettiCanvas { position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 10001; }

    .keyboard-hints { display: flex; gap: 8px; flex-wrap: wrap; justify-content: center; margin-top: 8px; animation: fadeIn 0.5s ease 0.8s both; }
    .kbd { display: inline-flex; align-items: center; justify-content: center; min-width: 28px; height: 28px; padding: 0 8px; background: var(--belum-bg); border: 1px solid var(--belum-border); border-radius: 6px; font-size: 11px; font-weight: 700; color: var(--text-sub); font-family: inherit; box-shadow: 0 2px 0 var(--belum-border); }

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

    .save-indicator { position: fixed; bottom: 20px; left: 20px; background: var(--card); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 10px 16px; font-size: 12px; font-weight: 600; color: var(--text-sub); box-shadow: 0 4px 15px rgba(0,0,0,0.08); display: flex; align-items: center; gap: 8px; z-index: 90; transition: all 0.3s ease; opacity: 0; transform: translateY(20px); }
    .save-indicator.show { opacity: 1; transform: translateY(0); }
    .save-indicator .dot-pulse { width: 8px; height: 8px; background: var(--good); border-radius: 50%; position: relative; }
    .save-indicator .dot-pulse::after { content: ''; position: absolute; inset: -4px; border-radius: 50%; border: 2px solid var(--good); animation: pulse-ring 1.5s ease-out infinite; }

    @media (max-width: 900px) {
      nav { width: 95%; padding: 0 16px; }
      .nav-links { display: none; }
      .quiz-wrapper { margin-top: 20px; }
      .footer-main { grid-template-columns: 1fr; gap: 40px; }
      .footer-bottom { justify-content: center; text-align: center; flex-direction: column-reverse; }
    }

    @media (max-width: 520px) {
      .question-card { padding: 20px; }
      .result-card { padding: 28px 20px; }
      .result-score { font-size: 40px; }
      .topbar { flex-wrap: wrap; gap: 10px; }
      .timer { font-size: 12px; padding: 4px 8px; }
      .hint-btn { font-size: 12px; padding: 6px 12px; }
      .result-stats { grid-template-columns: 1fr 1fr; }
    }
  </style>
</head>
<body>

<div class="toast-container" id="toastContainer"></div>
<div class="particle-container" id="particleContainer"></div>
<div class="save-indicator" id="saveIndicator"><div class="dot-pulse"></div><span>Progress tersimpan otomatis</span></div>
<canvas id="confettiCanvas"></canvas>

<!-- HEADER (Floating Glassmorphism style - sama persis dengan edukasi.php) -->
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

    <div class="nav-actions" id="authArea">
        <?php if (!$is_logged_in): ?>
            <a href="../LOGIN/login.php" class="btn-login" id="headerLoginBtn">Login</a>
        <?php endif; ?>

        <!-- Streak Counter -->
        <div class="streak-badge" id="streakBadge"><span class="fire">🔥</span><span id="streakCount">0</span></div>

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

<div class="page-content">
  <div class="quiz-wrapper">
    <div class="topbar">
      <button class="back-btn" id="backBtn" title="Kembali (&#8592;)">&#8592;</button>
      <div class="progress-block">
        <span class="progress-label" id="progressLabel">Soal 1 dari 10</span>
        <div class="progress-track"><div class="progress-fill" id="progressFill"></div></div>
      </div>
      <div class="timer" id="timerBox">&#8986; <span id="timer">05:00</span></div>
      <button class="hint-btn" id="hintBtn" title="Tekan H untuk hint"><span class="hint-icon">&#63;</span> Hint (<span id="hintCount">3</span>)</button>
    </div>

    <div class="quiz-main-shell">
      <div class="quiz-main">
        <div class="question-card" id="questionCard">
          <div class="question-head">
            <div class="question-badges">
              <div class="question-number" id="questionNumber">Soal #1</div>
              <div class="level-badge"><span class="level-dot"></span> Level 1 &middot; Dasar</div>
            </div>
            <div class="question-text" id="questionText"></div>
            <div class="question-instruction">Pilih satu jawaban yang menurutmu paling tepat. (Tekan 1-4 di keyboard)</div>
          </div>
          <div class="options-grid" id="optionsGrid"></div>
          <div class="card-footer">
            <button class="skip-link" id="skipBtn">Lewati Soal</button>
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

<div class="result-overlay" id="resultOverlay">
  <div class="result-card" id="resultCard">
    <div class="result-badge" id="resultBadge">Hasil Quiz Kamu</div>
    <div class="result-score" id="resultScore">0 / 0</div>
    <div class="result-label" id="resultMsg"></div>
    <div class="result-stats" id="resultStats"></div>
    <div class="review-section" id="reviewSection"></div>
    <div class="level-prompt" id="levelPrompt">Mau lanjut ke Level 2 atau ulangi Level 1 dulu?</div>
    <div class="result-actions">
      <button class="btn btn-secondary" id="retryBtn">&#8635; Ulangi Level 1</button>
      <button class="btn btn-success" id="nextLevelBtn">Lanjut ke Level 2 &#8594;</button>
    </div>
    <div class="keyboard-hints"><span class="kbd">R</span> Ulangi</div>
  </div>
</div>

<script>
const SOAL = [
  { pertanyaan: "Lembaga yang berwenang mengeluarkan dan mengedarkan Rupiah adalah...",
    opsi: [{l:'A',t:'Kementerian Keuangan'},{l:'B',t:'OJK'},{l:'C',t:'Bank Indonesia'},{l:'D',t:'BPK'}], benar:'C',
    pembahasan: "Bank Indonesia (BI) adalah lembaga yang berwenang mengeluarkan dan mengedarkan uang Rupiah sesuai UU No. 23 Tahun 1999." },
  { pertanyaan: "Satuan mata uang resmi Negara Kesatuan Republik Indonesia adalah...",
    opsi: [{l:'A',t:'Ringgit'},{l:'B',t:'Rupiah'},{l:'C',t:'Peso'},{l:'D',t:'Dolar'}], benar:'B',
    pembahasan: "Rupiah (IDR/Rp) adalah mata uang resmi Indonesia yang telah digunakan sejak zaman kemerdekaan." },
  { pertanyaan: "Salah satu ciri keaslian uang kertas Rupiah yang bisa dicek dengan cara diterawang adalah...",
    opsi: [{l:'A',t:'Warna uang'},{l:'B',t:'Tanda air (watermark)'},{l:'C',t:'Ukuran uang'},{l:'D',t:'Berat uang'}], benar:'B',
    pembahasan: "Watermark atau tanda air adalah ciri keaslian uang yang terlihat saat diterawang terhadap cahaya." },
  { pertanyaan: "Slogan cinta, bangga, dan paham terhadap Rupiah biasa disingkat menjadi...",
    opsi: [{l:'A',t:'CBP Rupiah'},{l:'B',t:'CBR'},{l:'C',t:'CPR'},{l:'D',t:'BCP'}], benar:'A',
    pembahasan: "CBP Rupiah (Cinta, Bangga, Paham) adalah slogan yang digalakkan Bank Indonesia untuk meningkatkan apresiasi masyarakat terhadap Rupiah." },
  { pertanyaan: "Tindakan yang benar terhadap uang Rupiah adalah...",
    opsi: [{l:'A',t:'Melipat dan mencoret uang'},{l:'B',t:'Menyimpan uang dengan rapi'},{l:'C',t:'Menstaples uang'},{l:'D',t:'Membasahi uang'}], benar:'B',
    pembahasan: "Uang Rupiah harus dirawat dengan baik. Menyimpan uang dengan rapi dan kering adalah tindakan yang benar." },
  { pertanyaan: "Uang Rupiah yang sudah rusak atau tidak layak edar sebaiknya...",
    opsi: [{l:'A',t:'Dibakar sendiri'},{l:'B',t:'Tetap dipakai belanja'},{l:'C',t:'Ditukar ke Bank Indonesia'},{l:'D',t:'Dibuang'}], benar:'C',
    pembahasan: "Uang rusak dapat ditukar ke Bank Indonesia atau bank umum sesuai ketentuan yang berlaku." },
  { pertanyaan: "Apa yang dimaksud dengan \u201cPaham Rupiah\u201d dalam konsep Cinta, Bangga, Paham Rupiah?",
    opsi: [{l:'A',t:'Mengetahui dan memahami fungsi serta karakteristik Rupiah'},{l:'B',t:'Menyimpan Rupiah sebanyak mungkin'},{l:'C',t:'Menggunakan mata uang asing dalam transaksi'},{l:'D',t:'Mengoleksi berbagai jenis mata uang'}], benar:'A',
    pembahasan: "Paham Rupiah berarti memiliki pengetahuan mengenai Rupiah, termasuk fungsi, karakteristik, serta cara memperlakukannya dengan baik." },
  { pertanyaan: "Apa fungsi utama Rupiah dalam kehidupan sehari-hari?",
    opsi: [{l:'A',t:'Sebagai alat pembayaran yang sah di Indonesia'},{l:'B',t:'Sebagai alat untuk menentukan harga mata uang asing'},{l:'C',t:'Sebagai mata uang yang digunakan semua negara'},{l:'D',t:'Sebagai alat untuk mencetak uang baru'}], benar:'A',
    pembahasan: "Rupiah berfungsi sebagai alat pembayaran yang sah di wilayah Indonesia dan digunakan dalam berbagai kegiatan transaksi." },
  { pertanyaan: "Sikap yang menunjukkan pemahaman yang baik terhadap Rupiah adalah...",
    opsi: [{l:'A',t:'Menggunakan uang tanpa memperhatikan kondisinya'},{l:'B',t:'Mengenali pecahan dan memperlakukan uang dengan baik'},{l:'C',t:'Melipat semua uang agar lebih kecil'},{l:'D',t:'Menganggap semua pecahan memiliki nilai yang sama'}], benar:'B',
    pembahasan: "Memahami Rupiah dapat ditunjukkan dengan mengenali nilai dan pecahannya serta memperlakukan uang dengan baik dalam kehidupan sehari-hari." },
  { pertanyaan: "Apa manfaat mengenali berbagai karakteristik pada uang Rupiah?",
    opsi: [{l:'A',t:'Membuat nilai Rupiah menjadi lebih tinggi'},{l:'B',t:'Membantu mengenali dan memahami Rupiah dengan lebih baik'},{l:'C',t:'Membuat uang dapat digunakan di semua negara'},{l:'D',t:'Mengubah pecahan uang menjadi lebih besar'}], benar:'B',
    pembahasan: "Mengenali karakteristik Rupiah membantu masyarakat memahami uang yang digunakan serta lebih mengenal ciri-ciri yang terdapat pada Rupiah." }
];

const WAKTU_AWAL = 5 * 60;
let indexSekarang = 0, jawabanUser = new Array(SOAL.length).fill(null), hintDipakaiDiSoal = new Array(SOAL.length).fill(false);
let hintTersisa = 3, sisaWaktu = WAKTU_AWAL, timerInterval = null, sudahSelesai = false;
let streak = 0, maxStreak = 0, waktuMulai = Date.now(), arahSlide = 'right', answeredQuestions = new Set();

const el = {
  questionCard: document.getElementById('questionCard'), questionNumber: document.getElementById('questionNumber'),
  questionText: document.getElementById('questionText'), optionsGrid: document.getElementById('optionsGrid'),
  progressLabel: document.getElementById('progressLabel'), progressFill: document.getElementById('progressFill'),
  navGrid: document.getElementById('navGrid'), nextBtn: document.getElementById('nextBtn'),
  finishBtn: document.getElementById('finishBtn'), skipBtn: document.getElementById('skipBtn'),
  hintBtn: document.getElementById('hintBtn'), hintCount: document.getElementById('hintCount'),
  timer: document.getElementById('timer'), timerBox: document.getElementById('timerBox'),
  resultOverlay: document.getElementById('resultOverlay'), resultCard: document.getElementById('resultCard'),
  resultBadge: document.getElementById('resultBadge'), resultScore: document.getElementById('resultScore'),
  resultMsg: document.getElementById('resultMsg'), resultStats: document.getElementById('resultStats'),
  reviewSection: document.getElementById('reviewSection'), authArea: document.getElementById('authArea'),
  streakBadge: document.getElementById('streakBadge'), streakCount: document.getElementById('streakCount'),
  backBtn: document.getElementById('backBtn'), retryBtn: document.getElementById('retryBtn'),
  nextLevelBtn: document.getElementById('nextLevelBtn'), levelPrompt: document.getElementById('levelPrompt'),
  saveIndicator: document.getElementById('saveIndicator'), toastContainer: document.getElementById('toastContainer'),
  particleContainer: document.getElementById('particleContainer'), headerLoginBtn: document.getElementById('headerLoginBtn')
};

// AUDIO
const AudioCtx = window.AudioContext || window.webkitAudioContext;
let audioCtx = null;
function getAudioCtx() { if (!audioCtx) audioCtx = new AudioCtx(); return audioCtx; }
function playSound(type) {
  try {
    const ctx = getAudioCtx(), osc = ctx.createOscillator(), gain = ctx.createGain();
    osc.connect(gain); gain.connect(ctx.destination); const now = ctx.currentTime;
    if (type === 'correct') {
      osc.type='sine'; osc.frequency.setValueAtTime(523,now); osc.frequency.setValueAtTime(659,now+0.1); osc.frequency.setValueAtTime(784,now+0.2);
      gain.gain.setValueAtTime(0.15,now); gain.gain.exponentialRampToValueAtTime(0.001,now+0.4); osc.start(now); osc.stop(now+0.4);
    } else if (type === 'wrong') {
      osc.type='sawtooth'; osc.frequency.setValueAtTime(200,now); osc.frequency.setValueAtTime(150,now+0.15);
      gain.gain.setValueAtTime(0.1,now); gain.gain.exponentialRampToValueAtTime(0.001,now+0.3); osc.start(now); osc.stop(now+0.3);
    } else if (type === 'click') {
      osc.type='sine'; osc.frequency.setValueAtTime(800,now);
      gain.gain.setValueAtTime(0.08,now); gain.gain.exponentialRampToValueAtTime(0.001,now+0.08); osc.start(now); osc.stop(now+0.08);
    } else if (type === 'hint') {
      osc.type='sine'; osc.frequency.setValueAtTime(440,now); osc.frequency.setValueAtTime(554,now+0.1);
      gain.gain.setValueAtTime(0.1,now); gain.gain.exponentialRampToValueAtTime(0.001,now+0.25); osc.start(now); osc.stop(now+0.25);
    } else if (type === 'finish') {
      osc.type='sine'; osc.frequency.setValueAtTime(523,now); osc.frequency.setValueAtTime(659,now+0.15); osc.frequency.setValueAtTime(784,now+0.3); osc.frequency.setValueAtTime(1047,now+0.45);
      gain.gain.setValueAtTime(0.15,now); gain.gain.exponentialRampToValueAtTime(0.001,now+0.8); osc.start(now); osc.stop(now+0.8);
    } else if (type === 'tick') {
      osc.type='square'; osc.frequency.setValueAtTime(1000,now);
      gain.gain.setValueAtTime(0.03,now); gain.gain.exponentialRampToValueAtTime(0.001,now+0.03); osc.start(now); osc.stop(now+0.03);
    }
  } catch(e){}
}

function showToast(message, type='info', duration=3000) {
  const toast = document.createElement('div'); toast.className = 'toast ' + type;
  const icons = {success:'✓', error:'✕', info:'ℹ', warning:'!'};
  toast.innerHTML = '<span style="font-size:16px;font-weight:800">'+(icons[type]||'ℹ')+'</span><span>'+message+'</span>';
  el.toastContainer.appendChild(toast);
  setTimeout(()=>{ toast.classList.add('hiding'); setTimeout(()=>toast.remove(),300); }, duration);
}

function spawnParticles(x,y,color,count=12) {
  for(let i=0;i<count;i++){
    const p=document.createElement('div'); p.className='particle';
    p.style.left=x+'px'; p.style.top=y+'px'; p.style.background=color;
    const angle=(Math.PI*2*i)/count, dist=30+Math.random()*60;
    p.style.setProperty('--tx',Math.cos(angle)*dist+'px');
    p.style.setProperty('--ty',Math.sin(angle)*dist+'px');
    p.style.animationDelay=(Math.random()*0.1)+'s';
    el.particleContainer.appendChild(p); setTimeout(()=>p.remove(),900);
  }
}

function createRipple(e,element){
  const ripple=document.createElement('span'); ripple.className='ripple';
  const rect=element.getBoundingClientRect();
  const size=Math.max(rect.width,rect.height);
  ripple.style.width=ripple.style.height=size+'px';
  ripple.style.left=(e.clientX-rect.left-size/2)+'px';
  ripple.style.top=(e.clientY-rect.top-size/2)+'px';
  element.appendChild(ripple); setTimeout(()=>ripple.remove(),600);
}

function launchConfetti(){
  const canvas=document.getElementById('confettiCanvas'), ctx=canvas.getContext('2d');
  canvas.width=window.innerWidth; canvas.height=window.innerHeight;
  const colors=['#17325C','#1E8E5A','#E8A838','#D0392B','#3a6aaa','#2a5a9a'];
  const particles=[];
  for(let i=0;i<150;i++){
    particles.push({
      x:Math.random()*canvas.width, y:Math.random()*canvas.height-canvas.height,
      w:Math.random()*10+5, h:Math.random()*6+3, color:colors[Math.floor(Math.random()*colors.length)],
      speed:Math.random()*3+2, rotation:Math.random()*360, rotSpeed:Math.random()*4-2, sway:Math.random()*2-1
    });
  }
  let frame=0;
  function draw(){
    ctx.clearRect(0,0,canvas.width,canvas.height); let active=false;
    particles.forEach(p=>{
      p.y+=p.speed; p.x+=Math.sin(frame*0.02)*p.sway+p.sway; p.rotation+=p.rotSpeed;
      if(p.y<canvas.height+20) active=true;
      ctx.save(); ctx.translate(p.x,p.y); ctx.rotate((p.rotation*Math.PI)/180);
      ctx.fillStyle=p.color; ctx.fillRect(-p.w/2,-p.h/2,p.w,p.h); ctx.restore();
    });
    frame++; if(active) requestAnimationFrame(draw); else ctx.clearRect(0,0,canvas.width,canvas.height);
  }
  draw();
}

function saveProgress(){
  const data={jawabanUser,hintDipakaiDiSoal,hintTersisa,sisaWaktu,indexSekarang,streak,maxStreak,waktuMulai,answeredQuestions:Array.from(answeredQuestions),timestamp:Date.now()};
  localStorage.setItem('rupantara_quiz_progress',JSON.stringify(data));
  el.saveIndicator.classList.add('show'); setTimeout(()=>el.saveIndicator.classList.remove('show'),2000);
}

function loadProgress(){
  try{
    const saved=localStorage.getItem('rupantara_quiz_progress'); if(!saved) return false;
    const data=JSON.parse(saved);
    if(Date.now()-data.timestamp>24*60*60*1000){ localStorage.removeItem('rupantara_quiz_progress'); return false; }
    jawabanUser=data.jawabanUser||jawabanUser; hintDipakaiDiSoal=data.hintDipakaiDiSoal||hintDipakaiDiSoal;
    hintTersisa=data.hintTersisa??hintTersisa; sisaWaktu=data.sisaWaktu??sisaWaktu;
    indexSekarang=data.indexSekarang??indexSekarang; streak=data.streak??streak;
    maxStreak=data.maxStreak??maxStreak; waktuMulai=data.waktuMulai??waktuMulai;
    if(data.answeredQuestions) answeredQuestions=new Set(data.answeredQuestions);
    return true;
  }catch(e){return false;}
}

function clearProgress(){ localStorage.removeItem('rupantara_quiz_progress'); }

function mulai(){
  renderNavGrid(); 
  tampilkanSoal(indexSekarang); 
  mulaiTimer();
  document.addEventListener('keydown', handleKeyboard);
}

function tampilkanSoal(i, animate=true){
  if(i<0||i>=SOAL.length) return;
  indexSekarang=i; const soal=SOAL[i];
  if(animate){
    el.questionCard.style.animation='none';
    el.questionCard.offsetHeight;
    el.questionCard.style.animation=arahSlide==='right'?'slideInRight 0.5s cubic-bezier(0.34,1.56,0.64,1)':'slideInLeft 0.5s cubic-bezier(0.34,1.56,0.64,1)';
  }
  el.questionNumber.textContent='Soal #'+(i+1);
  el.questionText.textContent=soal.pertanyaan;
  el.progressLabel.innerHTML='Soal '+(i+1)+' dari '+SOAL.length+' <span style="color:var(--text-sub);font-weight:500">('+(jawabanUser.filter(x=>x!==null).length)+'/'+SOAL.length+' terjawab)</span>';
  el.progressFill.style.width=(((i+1)/SOAL.length)*100)+'%';
  el.optionsGrid.innerHTML='';
  soal.opsi.forEach((opsi,idx)=>{
    const btn=document.createElement('button'); btn.className='option'; btn.dataset.label=opsi.l;
    const dipilih=jawabanUser[i]&&jawabanUser[i].label===opsi.l;
    if(dipilih) btn.classList.add('selected');
    if(answeredQuestions.has(i)){
      if(opsi.l===soal.benar) btn.classList.add('correct');
      else if(dipilih) btn.classList.add('wrong');
    }
    btn.innerHTML='<span class="option-badge">'+opsi.l+'</span><span>'+opsi.t+'</span><span class="option-key">'+(idx+1)+'</span>';
    btn.addEventListener('click',(e)=>{ createRipple(e,btn); playSound('click'); pilihJawaban(opsi.l); });
    el.optionsGrid.appendChild(btn);
  });
  if(hintDipakaiDiSoal[i]) terapkanHintVisual(i);
  el.nextBtn.disabled=i===SOAL.length-1;
  el.nextBtn.innerHTML=i===SOAL.length-1?'Selesai &#10003;':'Selanjutnya &#8594;';
  perbaruiNavGrid();
  saveProgress();
}

function pilihJawaban(label){
  if(sudahSelesai) return;
  const soal=SOAL[indexSekarang];
  jawabanUser[indexSekarang]={label};
  answeredQuestions.add(indexSekarang);
  document.querySelectorAll('.option').forEach(o=>{ o.classList.remove('selected','correct','wrong'); });
  const selectedBtn=document.querySelector('.option[data-label="'+label+'"]');
  if(selectedBtn) selectedBtn.classList.add('selected');

  setTimeout(()=>{
    const btns=document.querySelectorAll('.option');
    btns.forEach(btn=>{
      const lbl=btn.dataset.label;
      if(lbl===soal.benar) btn.classList.add('correct');
      else if(lbl===label && lbl!==soal.benar) btn.classList.add('wrong');
    });
    if(label===soal.benar){
      streak++; if(streak>maxStreak) maxStreak=streak;
      playSound('correct');
      const rect=selectedBtn.getBoundingClientRect();
      spawnParticles(rect.left+rect.width/2,rect.top+rect.height/2,'#1E8E5A',16);
      showToast('Benar! 🔥 Streak: '+streak,'success',2000);
    } else {
      streak=0; playSound('wrong');
      const rect=selectedBtn.getBoundingClientRect();
      spawnParticles(rect.left+rect.width/2,rect.top+rect.height/2,'#D0392B',8);
      const correctBtn=document.querySelector('.option[data-label="'+soal.benar+'"]');
      if(correctBtn) correctBtn.classList.add('correct');
      showToast('Salah! Jawaban yang benar: '+soal.benar,'error',2500);
    }
    updateStreakDisplay();
    perbaruiNavGrid();
    saveProgress();
    if(indexSekarang<SOAL.length-1){
      setTimeout(()=>{ arahSlide='right'; soalBerikutnya(); }, 1200);
    }
  }, 200);
}

function updateStreakDisplay(){
  if(el.streakCount) el.streakCount.textContent=streak;
  if(el.streakBadge){
    if(streak>=2) el.streakBadge.classList.add('show');
    else el.streakBadge.classList.remove('show');
  }
}

function renderNavGrid(){
  el.navGrid.innerHTML='';
  SOAL.forEach((_,i)=>{
    const btn=document.createElement('button'); btn.className='nav-item belum'; btn.textContent=i+1;
    btn.addEventListener('click',()=>{ playSound('click'); arahSlide=i>indexSekarang?'right':'left'; tampilkanSoal(i); });
    el.navGrid.appendChild(btn);
  });
}

function perbaruiNavGrid(){
  const items=el.navGrid.querySelectorAll('.nav-item');
  items.forEach((item,i)=>{
    item.classList.remove('selesai','aktif','belum');
    if(i===indexSekarang) item.classList.add('aktif');
    else if(jawabanUser[i]) item.classList.add('selesai');
    else item.classList.add('belum');
  });
}

function lewatiSoal(){ playSound('click'); if(indexSekarang<SOAL.length-1){ arahSlide='right'; tampilkanSoal(indexSekarang+1); } }
function soalBerikutnya(){ playSound('click'); if(indexSekarang<SOAL.length-1){ arahSlide='right'; tampilkanSoal(indexSekarang+1); } }
function soalSebelumnya(){ playSound('click'); if(indexSekarang>0){ arahSlide='left'; tampilkanSoal(indexSekarang-1); } }

function pakaiHint(){
  if(hintTersisa<=0||hintDipakaiDiSoal[indexSekarang]){ playSound('wrong'); showToast('Hint tidak tersedia!','warning'); return; }
  hintTersisa-=1; hintDipakaiDiSoal[indexSekarang]=true;
  el.hintCount.textContent=hintTersisa;
  if(hintTersisa===0) el.hintBtn.disabled=true;
  playSound('hint');
  terapkanHintVisual(indexSekarang);
  showToast('Hint digunakan! 1 opsi salah dihilangkan.','info',2000);
  saveProgress();
}

function terapkanHintVisual(i){
  const soal=SOAL[i]; const opsiButtons=[...el.optionsGrid.querySelectorAll('.option')];
  const salah=opsiButtons.filter(b=>b.dataset.label!==soal.benar&&!b.classList.contains('selected'));
  if(salah[0]){ salah[0].classList.add('eliminated'); salah[0].style.transition='all 0.5s ease'; }
}

function mulaiTimer(){
  updateTimerText();
  timerInterval=setInterval(()=>{
    sisaWaktu-=1; updateTimerText();
    if(sisaWaktu<=60){ el.timerBox.classList.add('warning'); el.timerBox.classList.remove('critical'); }
    if(sisaWaktu<=15){ el.timerBox.classList.remove('warning'); el.timerBox.classList.add('critical'); playSound('tick'); }
    if(sisaWaktu<=0){ clearInterval(timerInterval); selesaiQuiz(true); }
    if(sisaWaktu%10===0) saveProgress();
  },1000);
}

function updateTimerText(){
  const m=Math.floor(sisaWaktu/60).toString().padStart(2,'0');
  const s=(sisaWaktu%60).toString().padStart(2,'0');
  el.timer.textContent=m+':'+s;
}

function selesaiQuiz(kehabisanWaktu){
  if(sudahSelesai) return; sudahSelesai=true; clearInterval(timerInterval); clearProgress();
  let benar=0; SOAL.forEach((soal,i)=>{ if(jawabanUser[i]&&jawabanUser[i].label===soal.benar) benar++; });
  const durasi=Math.floor((Date.now()-waktuMulai)/1000);
  const persen=Math.round((benar/SOAL.length)*100);
  if(kehabisanWaktu){
    el.resultCard.classList.add('gagal'); el.resultBadge.textContent='Waktu Habis!';
    el.resultScore.textContent=benar+' / '+SOAL.length; playSound('wrong');
    el.resultMsg.textContent='Kamu gagal menyelesaikan quiz tepat waktu. Yuk coba lagi!';
  } else {
    el.resultCard.classList.remove('gagal'); el.resultBadge.textContent='Hasil Quiz Kamu';
    playSound('finish');
    if(persen>=80) launchConfetti();
    el.resultScore.textContent=benar+' / '+SOAL.length;
    if(persen===100) el.resultMsg.textContent='Sempurna! 🌟 Kamu paham banget soal Rupiah!';
    else if(persen>=80) el.resultMsg.textContent='Luar biasa! 🎉 Kamu hampir sempurna!';
    else if(persen>=60) el.resultMsg.textContent='Bagus! 💪 Terus belajar biar makin jago!';
    else if(persen>=40) el.resultMsg.textContent='Lumayan! 📚 Perlu latihan lebih lagi ya!';
    else el.resultMsg.textContent='Jangan menyerah! 🔥 Yuk coba lagi dan pelajari materinya!';
  }
  if(kehabisanWaktu){
    el.levelPrompt.textContent='Waktu habis nih. Ulangi dulu Level 1, atau langsung coba tantangan Level 2?';
  } else if(persen>=60){
    el.levelPrompt.textContent='Kerja bagus di Level 1! Mau lanjut ke Level 2 atau ulangi dulu biar makin mantap?';
  } else {
    el.levelPrompt.textContent='Skor kamu masih bisa ditingkatkan. Mau ulangi Level 1 dulu, atau langsung coba Level 2?';
  }
  
  // Stats
  el.resultStats.innerHTML=
    '<div class="stat-box"><div class="stat-value">'+benar+'</div><div class="stat-label">Benar</div></div>'+
    '<div class="stat-box"><div class="stat-value">'+(SOAL.length-benar)+'</div><div class="stat-label">Salah</div></div>'+
    '<div class="stat-box"><div class="stat-value">'+maxStreak+'</div><div class="stat-label">Streak</div></div>'+
    '<div class="stat-box"><div class="stat-value">'+Math.floor(durasi/60)+':'+String(durasi%60).padStart(2,'0')+'</div><div class="stat-label">Waktu</div></div>'+
    '<div class="stat-box"><div class="stat-value">'+persen+'%</div><div class="stat-label">Akurasi</div></div>';
    
  // Review
  el.reviewSection.innerHTML='<div style="font-size:13px;font-weight:700;color:var(--text-sub);margin-bottom:8px;">Klik soal untuk lihat pembahasan:</div>';
  SOAL.forEach((soal,i)=>{
    const jwb=jawabanUser[i];
    const isCorrect=jwb&&jwb.label===soal.benar;
    const isEmpty=!jwb;
    const item=document.createElement('div');
    item.className='review-item '+(isCorrect?'correct':(isEmpty?'empty':'wrong'));
    item.innerHTML='<span style="font-size:16px">'+(isCorrect?'✓':(isEmpty?'○':'✕'))+'</span> Soal '+(i+1)+': '+(jwb?jwb.label:'-')+' / '+soal.benar;
    const pembahasan=document.createElement('div'); pembahasan.className='review-pembahasan';
    pembahasan.textContent=soal.pembahasan;
    item.appendChild(pembahasan);
    item.addEventListener('click',()=>{ item.classList.toggle('expanded'); });
    el.reviewSection.appendChild(item);
  });
  el.resultOverlay.classList.add('show');
}

function handleKeyboard(e){
  if(sudahSelesai){
    if(e.key==='r'||e.key==='R') location.reload();
    return;
  }
  if(e.key>='1'&&e.key<='4'){
    const idx=parseInt(e.key)-1;
    const soal=SOAL[indexSekarang];
    if(idx<soal.opsi.length){ playSound('click'); pilihJawaban(soal.opsi[idx].l); }
  } else if(e.key==='ArrowRight'){
    e.preventDefault(); soalBerikutnya();
  } else if(e.key==='ArrowLeft'){
    e.preventDefault(); soalSebelumnya();
  } else if(e.key==='h'||e.key==='H'){
    e.preventDefault(); pakaiHint();
  } else if(e.key==='s'||e.key==='S'){
    e.preventDefault(); lewatiSoal();
  } else if(e.key==='Enter'){
    e.preventDefault();
    if(indexSekarang===SOAL.length-1) selesaiQuiz(false);
    else soalBerikutnya();
  }
}

// Event listeners
el.nextBtn.addEventListener('click',(e)=>{ createRipple(e,el.nextBtn); soalBerikutnya(); });
el.finishBtn.addEventListener('click',(e)=>{ createRipple(e,el.finishBtn); selesaiQuiz(false); });
el.skipBtn.addEventListener('click',(e)=>{ createRipple(e,el.skipBtn); lewatiSoal(); });
el.hintBtn.addEventListener('click',(e)=>{ createRipple(e,el.hintBtn); pakaiHint(); });
el.backBtn.addEventListener('click',(e)=>{ createRipple(e,el.backBtn); soalSebelumnya(); });
el.retryBtn.addEventListener('click',(e)=>{ createRipple(e,el.retryBtn); clearProgress(); location.reload(); });
el.nextLevelBtn.addEventListener('click',(e)=>{
  createRipple(e,el.nextLevelBtn); playSound('click'); clearProgress();
  window.location.href = 'quiz2.php';
});

// Add ripple to all buttons
document.querySelectorAll('.btn, .option, .nav-item, .back-btn, .hint-btn, .skip-link').forEach(btn=>{
  btn.addEventListener('click',(e)=>createRipple(e,btn));
});

// Prevent context menu on right click for extra interactivity
document.addEventListener('contextmenu',(e)=>{
  if(e.target.closest('.option')) e.preventDefault();
});

// Initialize
const loaded = loadProgress();
mulai();
if(loaded) showToast('Progress tersimpan ditemukan! Melanjutkan quiz...', 'info', 4000);
lucide.createIcons();
</script>
</body>
</html>