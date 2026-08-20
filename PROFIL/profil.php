<?php
session_start();
include '../LOGIN/koneksi.php';

// Memeriksa status login pengguna
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    $_SESSION['redirect_to'] = '../PROFIL/profil.php';
    header("Location: ../LOGIN/login.php");
    exit;
}

$username_session = $_SESSION['username'];
$is_logged_in = true;
$display_username = $username_session;

// Ambil data terbaru dari database
$query = "SELECT * FROM register WHERE username = '$username_session'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "Pengguna tidak ditemukan.";
    exit;
}

// Proses pembaruan profil saat form dikirim
$success_message = "";
$error_message = "";

if (isset($_POST['update_profile'])) {
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $status_pengguna = mysqli_real_escape_string($conn, trim($_POST['status_pengguna']));
    $password_baru = trim($_POST['password_baru']);
    
    // Default foto adalah foto lama
    $nama_file_foto = $user['foto_profil'];

    // Proses Upload Foto Profil jika ada file baru yang diunggah
    if (isset($_FILES['foto_profil_upload']) && $_FILES['foto_profil_upload']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['foto_profil_upload']['tmp_name'];
        $file_name = $_FILES['foto_profil_upload']['name'];
        $file_size = $_FILES['foto_profil_upload']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        $ekstensi_diperbolehkan = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        
        if ($file_size > 5 * 1024 * 1024) {
            $error_message = "Ukuran file terlalu besar! Maksimal 5 MB.";
        } elseif (in_array($file_ext, $ekstensi_diperbolehkan)) {
            // Berikan nama unik untuk file gambar guna menghindari bentrok nama
            $nama_file_foto = "avatar_" . preg_replace('/[^a-zA-Z0-9_]/', '', $username_session) . "_" . time() . "." . $file_ext;
            
            // Tentukan folder penyimpanan (buat folder 'uploads' jika belum ada)
            $folder_tujuan = '../uploads/';
            if (!is_dir($folder_tujuan)) {
                mkdir($folder_tujuan, 0755, true);
            }
            
            // Pindahkan file ke folder tujuan
            if (move_uploaded_file($file_tmp, $folder_tujuan . $nama_file_foto)) {
                // Hapus foto lama jika bukan foto bawaan default
                if (!empty($user['foto_profil']) && file_exists($folder_tujuan . $user['foto_profil']) && $user['foto_profil'] !== $nama_file_foto) {
                    unlink($folder_tujuan . $user['foto_profil']);
                }
            } else {
                $error_message = "Gagal mengunggah gambar ke server.";
            }
        } else {
            $error_message = "Format file tidak valid! Gunakan format JPG, JPEG, PNG, WEBP, atau GIF.";
        }
    }

    if (empty($error_message)) {
        // Update query dasar
        $query_update = "UPDATE register SET email = '$email', status_pengguna = '$status_pengguna', foto_profil = '$nama_file_foto'";

        // Jika pengguna ingin mengubah password
        if (!empty($password_baru)) {
            if (strlen($password_baru) < 6) {
                $error_message = "Password baru harus memiliki minimal 6 karakter.";
            } else {
                $password_hashed = password_hash($password_baru, PASSWORD_DEFAULT);
                $query_update .= ", password = '$password_hashed'";
            }
        }

        $query_update .= " WHERE username = '$username_session'";

        if (empty($error_message)) {
            if (mysqli_query($conn, $query_update)) {
                $success_message = "Profil Anda berhasil diperbarui!";
                // Refresh data pengguna setelah update
                $result = mysqli_query($conn, $query);
                $user = mysqli_fetch_assoc($result);
            } else {
                $error_message = "Terjadi kesalahan saat memperbarui database: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>RUPANTARA - Profil Pengguna</title>

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
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
            --coral: #DB8281;
            --coral-dark: #c46d6c;
            --emerald: #10B981;
            --emerald-light: #ECFDF5;
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
        }

        /* =====================================================
           HEADER (Floating Glassmorphism style - matching edukasi.php)
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

        .user-area:hover, .user-area.active {
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
            overflow: hidden;
        }

        .user-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-greeting {
            font-size: 13px;
            font-weight: 600;
            color: #475569;
        }

        /* =====================================================
           MAIN LAYOUT GRID (Matching edukasi.php structure)
        ===================================================== */
        .container {
            width: 100%;
            max-width: 1300px;
            margin: 50px auto;
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 30px;
            padding: 0 24px;
            flex: 1;
        }

        /* --- SIDEBAR PROFIL --- */
        .sidebar-profile {
            background: #F4F7FC;
            border-radius: 20px;
            padding: 28px 24px;
            height: fit-content;
            position: sticky;
            top: 130px;
            transition: all 0.3s ease;
            text-align: center;
        }

        /* Avatar Upload Container */
        .avatar-container {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 16px;
        }

        .avatar-img-wrap {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid #FFFFFF;
            box-shadow: 0 6px 18px rgba(0, 48, 135, 0.12);
            background: #EAF2FF;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .avatar-upload-badge {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 36px;
            height: 36px;
            background: var(--blue-dark);
            color: #FFFFFF;
            border-radius: 50%;
            border: 3px solid #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            transition: all 0.25s ease;
        }

        .avatar-upload-badge:hover {
            background: var(--navy);
            transform: scale(1.1);
        }

        #foto_profil_upload {
            display: none;
        }

        .profile-name {
            font-size: 20px;
            font-weight: 800;
            color: #003087;
            margin-bottom: 4px;
            word-break: break-word;
        }

        .profile-role-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            background: #EAF2FF;
            color: var(--blue-dark);
            margin-bottom: 12px;
            letter-spacing: 0.3px;
        }

        .profile-email-text {
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 20px;
            word-break: break-all;
        }

        .sidebar-divider {
            height: 1px;
            background: #E2E8F0;
            margin: 18px 0;
        }

        .profile-quick-nav {
            display: flex;
            flex-direction: column;
            gap: 8px;
            text-align: left;
        }

        .profile-nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 16px;
            border-radius: 12px;
            color: var(--text);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .profile-nav-item.active {
            background: #FFFFFF;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            color: var(--blue-dark);
            font-weight: 700;
        }

        .profile-nav-item:hover {
            background: rgba(255, 255, 255, 0.7);
            color: var(--blue-dark);
        }

        .profile-nav-item i {
            width: 17px;
            height: 17px;
            flex-shrink: 0;
        }

        /* --- CONTENT CARD --- */
        .content-card {
            background: white;
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.02);
            animation: fadeIn 0.5s ease;
        }

        .page-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #EAF2FF;
            color: var(--blue-dark);
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 14px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .page-badge i { width: 14px; height: 14px; }

        .title-h1 {
            font-size: 32px;
            font-weight: 800;
            color: #003087;
            margin-bottom: 10px;
            letter-spacing: -0.3px;
        }

        .lead-text {
            color: var(--muted);
            font-size: 14.5px;
            margin-bottom: 24px;
            line-height: 1.6;
        }

        /* Alerts */
        .alert-box {
            padding: 14px 18px;
            border-radius: 12px;
            font-size: 14px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: fadeIn 0.3s ease;
        }

        .alert-success {
            background: var(--emerald-light);
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* Interactive Tabs matching edukasi.php */
        .profile-tabs-wrapper {
            background: #F4F7FC;
            padding: 6px;
            border-radius: 14px;
            display: flex;
            gap: 6px;
            margin-bottom: 28px;
            overflow-x: auto;
        }

        .profile-tab-btn {
            flex: 1;
            min-width: 130px;
            background: none;
            border: none;
            padding: 11px 16px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 700;
            color: var(--muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.25s ease;
            white-space: nowrap;
        }

        .profile-tab-btn:hover {
            color: var(--blue-dark);
            background: rgba(255, 255, 255, 0.5);
        }

        .profile-tab-btn.active {
            background: #FFFFFF;
            color: var(--blue-dark);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .tab-panel {
            display: none;
            animation: fadeIn 0.35s ease;
        }

        .tab-panel.active {
            display: block;
        }

        /* Form Inputs & Elements */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 24px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            text-align: left;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            font-size: 12.5px;
            font-weight: 700;
            color: #0F2942;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-label span.note {
            font-size: 11.5px;
            color: var(--muted);
            text-transform: none;
            font-weight: 500;
        }

        .input-box {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-box i.input-icon {
            position: absolute;
            left: 16px;
            color: var(--muted);
            width: 17px;
            height: 17px;
            pointer-events: none;
        }

        .form-control {
            width: 100%;
            height: 48px;
            padding: 0 16px 0 46px;
            font-size: 14px;
            color: var(--text);
            background: #FFFFFF;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            outline: none;
            transition: all 0.25s ease;
        }

        .form-control:focus {
            border-color: var(--blue-dark);
            box-shadow: 0 0 0 3px rgba(23, 76, 132, 0.1);
        }

        .form-control[readonly] {
            background: #F8FAFF;
            color: var(--muted);
            cursor: not-allowed;
        }

        select.form-control {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23174C84' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
            padding-right: 44px;
            cursor: pointer;
        }

        /* Password Toggle */
        .btn-toggle-pwd {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            color: var(--muted);
            cursor: pointer;
            padding: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: color 0.2s ease;
        }

        .btn-toggle-pwd:hover {
            color: var(--blue-dark);
        }

        /* Password Strength Meter */
        .pwd-strength-box {
            margin-top: 10px;
            background: #F8FAFF;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 14px 16px;
        }

        .strength-bars {
            display: flex;
            gap: 6px;
            margin-bottom: 8px;
        }

        .strength-bar-item {
            height: 5px;
            flex: 1;
            background: #E2E8F0;
            border-radius: 10px;
            transition: background 0.3s ease;
        }

        .strength-status {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: var(--muted);
            font-weight: 600;
        }

        .strength-status span.val {
            font-weight: 700;
            color: #0F2942;
        }

        .pwd-hints {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
            margin-top: 8px;
            font-size: 12px;
            color: var(--muted);
        }

        .pwd-hint-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .pwd-hint-item.valid {
            color: #065f46;
            font-weight: 600;
        }

        /* Action Buttons matching edukasi.php */
        .btn-fill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--blue-dark);
            color: #fff;
            text-decoration: none;
            padding: 13px 28px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 14px;
            transition: 0.25s ease;
            cursor: pointer;
            border: none;
        }
        .btn-fill:hover {
            background: var(--navy-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(23, 76, 132, 0.2);
        }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 2px solid #EF4444;
            color: #EF4444;
            text-decoration: none;
            padding: 11px 24px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 14px;
            background: transparent;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .btn-outline:hover {
            background: #FEF2F2;
            transform: translateY(-2px);
        }

        .btn-row-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
            flex-wrap: wrap;
        }

        /* Feature Cards (Tab 3) */
        .card-grid { display: grid; gap: 20px; margin: 10px 0; }
        .card-grid.cols-2 { grid-template-columns: 1fr 1fr; }
        .card-grid.cols-3 { grid-template-columns: repeat(3, 1fr); }

        .info-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .info-card:hover {
            border-color: var(--blue);
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(23, 76, 132, 0.06);
        }

        .icon-circle {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #EAF2FF;
            color: var(--blue-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 6px;
        }

        .icon-circle.orange { background: #FFF1E6; color: #C2610B; }
        .icon-circle.emerald { background: #ECFDF5; color: #059669; }

        .info-card h4 {
            font-size: 16px;
            font-weight: 700;
            color: #0F2942;
        }

        .info-card p {
            color: var(--muted);
            font-size: 13.5px;
            line-height: 1.5;
        }

        /* Confirmation Modal */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(10, 30, 63, 0.6);
            backdrop-filter: blur(4px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            transition: opacity 0.25s ease;
        }

        .modal-overlay.open {
            display: flex;
            opacity: 1;
        }

        .modal-box {
            background: #FFFFFF;
            width: 100%;
            max-width: 420px;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            transform: scale(0.95);
            transition: transform 0.25s ease;
        }

        .modal-overlay.open .modal-box {
            transform: scale(1);
        }

        .modal-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #FEE2E2;
            color: #DC2626;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }

        .modal-box h3 {
            font-size: 20px;
            font-weight: 800;
            color: #0F2942;
            margin-bottom: 8px;
        }

        .modal-box p {
            font-size: 13.5px;
            color: var(--muted);
            margin-bottom: 24px;
        }

        .modal-btn-group {
            display: flex;
            gap: 12px;
        }

        .btn-modal-cancel {
            flex: 1;
            padding: 12px;
            border-radius: 12px;
            background: #F1F5F9;
            color: var(--text);
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-modal-cancel:hover {
            background: #E2E8F0;
        }

        .btn-modal-logout {
            flex: 1;
            padding: 12px;
            border-radius: 12px;
            background: #EF4444;
            color: #FFFFFF;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: 0.2s;
        }

        .btn-modal-logout:hover {
            background: #DC2626;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* =====================================================
           FOOTER (Desain Baru, Modern & Interaktif - dari edukasi.php)
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
            .content-card {
                padding: 45px;
            }
        }

        /* Layar Sedang & Tablet Landscape/Potret (<= 1024px) */
        @media (max-width: 1024px) {
            .container {
                grid-template-columns: 280px 1fr;
                gap: 24px;
                padding: 0 16px;
            }
            .sidebar-profile {
                padding: 20px 16px;
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
            .sidebar-profile {
                position: static;
                width: 100%;
            }
            .form-grid {
                grid-template-columns: 1fr;
            }
            .card-grid.cols-2, .card-grid.cols-3 {
                grid-template-columns: 1fr;
            }
            .btn-row-actions {
                flex-direction: column-reverse;
                align-items: stretch;
            }
            .btn-fill, .btn-outline {
                justify-content: center;
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
            .title-h1 {
                font-size: 24px;
            }
            .content-card {
                padding: 18px;
                border-radius: 16px;
            }
            .profile-tab-btn {
                font-size: 12px;
                padding: 8px 10px;
            }
            .pwd-hints {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<!-- HEADER (Floating Glassmorphism - Persis seperti edukasi.php) -->
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
        <li><a href="../SCANNER/index.php">Scan</a></li>
    </ul>

    <div class="nav-actions">
        <?php if (!$is_logged_in): ?>
            <a href="../LOGIN/login.php" class="btn-login">Login</a>
        <?php endif; ?>

        <a href="#" class="notification-btn" title="Notifikasi">
            <i data-lucide="bell" style="width:18px; height:18px;"></i>
            <span class="notification-dot"></span>
        </a>
        <div class="nav-divider"></div>
        <a href="profil.php" class="user-area active" title="Profil Pengguna">
            <div class="user-icon">
                <?php 
                $foto_profil_src = "../uploads/" . $user['foto_profil'];
                if (!empty($user['foto_profil']) && file_exists($foto_profil_src)) {
                    $avatar_header = $foto_profil_src;
                } else {
                    $avatar_header = "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' fill='%23174C84' viewBox='0 -960 960 960'><path d='M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-240v-32q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q30 15 47 43.5t17 62.5v32H160Z'/></svg>";
                }
                ?>
                <img src="<?php echo $avatar_header; ?>" alt="Avatar" id="navAvatarImg">
            </div>
            <span class="user-greeting">Halo, <?php echo htmlspecialchars($display_username); ?></span>
        </a>
    </div>
</nav>

<!-- CONTENT (Grid Container) -->
<div class="container">
    
    <!-- SIDEBAR PROFIL KIRI -->
    <aside class="sidebar-profile">
        <form action="profil.php" method="POST" enctype="multipart/form-data" id="profileForm">
            
            <!-- Avatar Upload Area -->
            <div class="avatar-container">
                <div class="avatar-img-wrap">
                    <img src="<?php echo $avatar_header; ?>" alt="Foto Profil" id="avatarPreview">
                </div>
                <label for="foto_profil_upload" class="avatar-upload-badge" title="Ganti Foto Profil">
                    <i data-lucide="camera" style="width:17px; height:17px;"></i>
                </label>
                <input type="file" id="foto_profil_upload" name="foto_profil_upload" accept="image/jpeg, image/png, image/webp, image/gif">
            </div>

            <h2 class="profile-name"><?php echo htmlspecialchars($user['username']); ?></h2>
            <div class="profile-role-badge">
                <i data-lucide="award" style="width:13px; height:13px;"></i>
                <span><?php echo htmlspecialchars(!empty($user['status_pengguna']) ? $user['status_pengguna'] : 'Umum'); ?></span>
            </div>
            <p class="profile-email-text"><?php echo htmlspecialchars($user['email']); ?></p>

            <div class="sidebar-divider"></div>

            <div class="profile-quick-nav">
                <a class="profile-nav-item active" onclick="switchProfileTab(0)">
                    <i data-lucide="user-check"></i>
                    <span>Informasi Akun</span>
                </a>
                <a class="profile-nav-item" onclick="switchProfileTab(1)">
                    <i data-lucide="shield-check"></i>
                    <span>Keamanan & Sandi</span>
                </a>
                <a class="profile-nav-item" onclick="switchProfileTab(2)">
                    <i data-lucide="compass"></i>
                    <span>Modul Rupantara</span>
                </a>
            </div>
    </aside>

    <!-- CONTENT CARD KANAN -->
    <main class="content-card">
        <span class="page-badge"><i data-lucide="user-cog"></i>Pengaturan Akun</span>
        <h1 class="title-h1">Profil Pengguna</h1>
        <p class="lead-text">Kelola informasi akun dasar, perbarui alamat email aktif, dan tingkatkan keamanan kata sandi Anda.</p>

        <!-- Notifikasi -->
        <?php if (!empty($success_message)): ?>
            <div class="alert-box alert-success">
                <i data-lucide="check-circle-2" style="width:18px; height:18px; flex-shrink:0;"></i>
                <span><?php echo htmlspecialchars($success_message); ?></span>
            </div>
        <?php endif; ?>

        <?php if (!empty($error_message)): ?>
            <div class="alert-box alert-error">
                <i data-lucide="alert-circle" style="width:18px; height:18px; flex-shrink:0;"></i>
                <span><?php echo htmlspecialchars($error_message); ?></span>
            </div>
        <?php endif; ?>

        <!-- Tabs Navigation -->
        <div class="profile-tabs-wrapper">
            <button type="button" class="profile-tab-btn active" onclick="switchProfileTab(0)">
                <i data-lucide="user"></i> Data Pribadi
            </button>
            <button type="button" class="profile-tab-btn" onclick="switchProfileTab(1)">
                <i data-lucide="key-round"></i> Kata Sandi
            </button>
            <button type="button" class="profile-tab-btn" onclick="switchProfileTab(2)">
                <i data-lucide="sparkles"></i> Akses Modul
            </button>
        </div>

        <!-- ================= TAB 1: DATA PRIBADI ================= -->
        <div class="tab-panel active" id="tabContent0">
            <div class="form-grid">
                
                <!-- Username (Readonly) -->
                <div class="form-group">
                    <label class="form-label" for="username">
                        <span>Username</span>
                        <span class="note"><i data-lucide="lock" style="width:11px; height:11px; display:inline-block; vertical-align:middle;"></i> Permanen</span>
                    </label>
                    <div class="input-box">
                        <i data-lucide="at-sign" class="input-icon"></i>
                        <input type="text" id="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
                    </div>
                </div>

                <!-- Email Aktif -->
                <div class="form-group">
                    <label class="form-label" for="email">
                        <span>Email Aktif</span>
                        <span class="note">*Wajib diisi</span>
                    </label>
                    <div class="input-box">
                        <i data-lucide="mail" class="input-icon"></i>
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required autocomplete="email" placeholder="nama@email.com">
                    </div>
                </div>

                <!-- Status Pengguna -->
                <div class="form-group full-width">
                    <label class="form-label" for="status_pengguna">
                        <span>Status / Peran Pengguna</span>
                    </label>
                    <div class="input-box">
                        <i data-lucide="badge-check" class="input-icon"></i>
                        <select id="status_pengguna" name="status_pengguna" class="form-control" required>
                            <option value="Siswa" <?php echo ($user['status_pengguna'] == 'Siswa') ? 'selected' : ''; ?>>Siswa (SD / SMP / SMA / SMK)</option>
                            <option value="Mahasiswa" <?php echo ($user['status_pengguna'] == 'Mahasiswa') ? 'selected' : ''; ?>>Mahasiswa (Perguruan Tinggi)</option>
                            <option value="Guru" <?php echo ($user['status_pengguna'] == 'Guru') ? 'selected' : ''; ?>>Guru / Tenaga Pendidik</option>
                            <option value="Umum" <?php echo ($user['status_pengguna'] == 'Umum' || empty($user['status_pengguna'])) ? 'selected' : ''; ?>>Umum / Profesional</option>
                        </select>
                    </div>
                </div>

            </div>
        </div>

        <!-- ================= TAB 2: KATA SANDI ================= -->
        <div class="tab-panel" id="tabContent1">
            <div class="form-group full-width">
                <label class="form-label" for="password_baru">
                    <span>Password Baru</span>
                    <span class="note">Kosongkan jika tidak ingin mengubah</span>
                </label>
                <div class="input-box">
                    <i data-lucide="lock-keyhole" class="input-icon"></i>
                    <input type="password" id="password_baru" name="password_baru" class="form-control" placeholder="Masukkan kata sandi baru (min. 6 karakter)" autocomplete="new-password">
                    <button type="button" class="btn-toggle-pwd" onclick="togglePasswordVisibility()" title="Lihat password">
                        <i data-lucide="eye" id="eyeIcon" style="width:18px; height:18px;"></i>
                    </button>
                </div>

                <!-- Password Strength Evaluator -->
                <div class="pwd-strength-box" id="pwdStrengthBox" style="display: none;">
                    <div class="strength-bars">
                        <div class="strength-bar-item" id="bar1"></div>
                        <div class="strength-bar-item" id="bar2"></div>
                        <div class="strength-bar-item" id="bar3"></div>
                        <div class="strength-bar-item" id="bar4"></div>
                    </div>
                    <div class="strength-status">
                        <span>Kekuatan Sandi:</span>
                        <span class="val" id="strengthStatusText">Sangat Lemah</span>
                    </div>
                    <div class="pwd-hints">
                        <div class="pwd-hint-item" id="hintLength"><i data-lucide="circle" style="width:11px; height:11px;"></i> Minimal 6 Karakter</div>
                        <div class="pwd-hint-item" id="hintCase"><i data-lucide="circle" style="width:11px; height:11px;"></i> Huruf Besar & Kecil</div>
                        <div class="pwd-hint-item" id="hintNumber"><i data-lucide="circle" style="width:11px; height:11px;"></i> Mengandung Angka</div>
                        <div class="pwd-hint-item" id="hintSymbol"><i data-lucide="circle" style="width:11px; height:11px;"></i> Simbol Khusus</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= TAB 3: MODUL RUPANTARA ================= -->
        <div class="tab-panel" id="tabContent2">
            <div class="card-grid cols-3">
                <a href="../MATERI/edukasi.php" class="info-card">
                    <div class="icon-circle"><i data-lucide="book-open"></i></div>
                    <h4>Materi Edukasi</h4>
                    <p>Pelajari anatomi, ciri pengaman, dan sejarah Rupiah.</p>
                </a>
                <a href="../SCANNER/index.php" class="info-card">
                    <div class="icon-circle emerald"><i data-lucide="scan-line"></i></div>
                    <h4>Scan AI</h4>
                    <p>Deteksi nominal uang secara cepat melalui kamera.</p>
                </a>
                <a href="../QUIZ/quiz_intro.php" class="info-card">
                    <div class="icon-circle orange"><i data-lucide="trophy"></i></div>
                    <h4>Quiz Interaktif</h4>
                    <p>Uji pemahaman Anda seputar mata uang kebanggaan kita.</p>
                </a>
            </div>
        </div>

        <!-- TOMBOL AKSI SIMPAN & LOGOUT -->
        <div class="btn-row-actions">
            <button type="button" class="btn-outline" onclick="openLogoutModal()">
                <i data-lucide="log-out" style="width:16px; height:16px;"></i>
                <span>Keluar Akun</span>
            </button>

            <button type="submit" name="update_profile" class="btn-fill">
                <i data-lucide="check" style="width:16px; height:16px;"></i>
                <span>Simpan Perubahan</span>
            </button>
        </div>

        </form>
    </main>

</div>

<!-- DIALOG MODAL LOGOUT -->
<div class="modal-overlay" id="logoutModal">
    <div class="modal-box">
        <div class="modal-icon">
            <i data-lucide="alert-triangle" style="width:28px; height:28px;"></i>
        </div>
        <h3>Keluar dari Akun?</h3>
        <p>Anda akan mengakhiri sesi login saat ini. Anda dapat masuk kembali kapan saja.</p>
        <div class="modal-btn-group">
            <button type="button" class="btn-modal-cancel" onclick="closeLogoutModal()">Batal</button>
            <a href="logout.php" class="btn-modal-logout">
                <i data-lucide="log-out" style="width:16px; height:16px;"></i>
                <span>Ya, Keluar</span>
            </a>
        </div>
    </div>
</div>

<!-- FOOTER (Persis seperti edukasi.php) -->
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

<!-- SCRIPT LOGIC -->
<script>
    // Inisialisasi ikon Lucide
    lucide.createIcons();

    // Live preview avatar saat upload foto baru
    const fileInput = document.getElementById('foto_profil_upload');
    const previewImg = document.getElementById('avatarPreview');
    const navImg = document.getElementById('navAvatarImg');

    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            if (file.size > 5 * 1024 * 1024) {
                alert('Ukuran gambar maksimal 5 MB!');
                this.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                if (navImg) navImg.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    // Tab switcher fungsi global
    function switchProfileTab(tabIndex) {
        const tabs = document.querySelectorAll('.profile-tab-btn');
        const panels = document.querySelectorAll('.tab-panel');
        const navItems = document.querySelectorAll('.profile-nav-item');

        tabs.forEach((tab, i) => {
            if (i === tabIndex) {
                tab.classList.add('active');
                if (panels[i]) panels[i].classList.add('active');
            } else {
                tab.classList.remove('active');
                if (panels[i]) panels[i].classList.remove('active');
            }
        });

        navItems.forEach((item, i) => {
            if (i === tabIndex) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });

        lucide.createIcons();
    }

    // Toggle lihat/sembunyikan password
    function togglePasswordVisibility() {
        const pwd = document.getElementById('password_baru');
        const icon = document.getElementById('eyeIcon');
        if (pwd.type === 'password') {
            pwd.type = 'text';
            icon.setAttribute('data-lucide', 'eye-off');
        } else {
            pwd.type = 'password';
            icon.setAttribute('data-lucide', 'eye');
        }
        lucide.createIcons();
    }

    // Evaluasi kekuatan kata sandi secara real-time
    const pwdInput = document.getElementById('password_baru');
    const strengthBox = document.getElementById('pwdStrengthBox');
    const bar1 = document.getElementById('bar1');
    const bar2 = document.getElementById('bar2');
    const bar3 = document.getElementById('bar3');
    const bar4 = document.getElementById('bar4');
    const statusText = document.getElementById('strengthStatusText');

    const hintLen = document.getElementById('hintLength');
    const hintCase = document.getElementById('hintCase');
    const hintNum = document.getElementById('hintNumber');
    const hintSym = document.getElementById('hintSymbol');

    if (pwdInput) {
        pwdInput.addEventListener('input', function() {
            const val = this.value;
            if (val.length === 0) {
                strengthBox.style.display = 'none';
                return;
            }
            strengthBox.style.display = 'block';

            let score = 0;
            const isLen = val.length >= 6;
            const isCase = /[A-Z]/.test(val) && /[a-z]/.test(val);
            const isNum = /[0-9]/.test(val);
            const isSym = /[^A-Za-z0-9]/.test(val);

            updateHint(hintLen, isLen);
            updateHint(hintCase, isCase);
            updateHint(hintNum, isNum);
            updateHint(hintSym, isSym);

            if (isLen) score++;
            if (isCase) score++;
            if (isNum) score++;
            if (isSym) score++;

            [bar1, bar2, bar3, bar4].forEach(b => b.style.background = '#E2E8F0');

            if (score <= 1) {
                bar1.style.background = '#EF4444';
                statusText.textContent = 'Sangat Lemah';
                statusText.style.color = '#EF4444';
            } else if (score === 2) {
                bar1.style.background = '#F59E0B';
                bar2.style.background = '#F59E0B';
                statusText.textContent = 'Cukup';
                statusText.style.color = '#F59E0B';
            } else if (score === 3) {
                bar1.style.background = 'var(--blue)';
                bar2.style.background = 'var(--blue)';
                bar3.style.background = 'var(--blue)';
                statusText.textContent = 'Kuat';
                statusText.style.color = 'var(--blue-dark)';
            } else if (score === 4) {
                bar1.style.background = 'var(--emerald)';
                bar2.style.background = 'var(--emerald)';
                bar3.style.background = 'var(--emerald)';
                bar4.style.background = 'var(--emerald)';
                statusText.textContent = 'Sangat Kuat & Aman';
                statusText.style.color = 'var(--emerald)';
            }
        });
    }

    function updateHint(el, valid) {
        if (!el) return;
        if (valid) {
            el.classList.add('valid');
            el.querySelector('i')?.setAttribute('data-lucide', 'check-circle');
        } else {
            el.classList.remove('valid');
            el.querySelector('i')?.setAttribute('data-lucide', 'circle');
        }
        lucide.createIcons();
    }

    // Modal Konfirmasi Logout
    const modal = document.getElementById('logoutModal');
    function openLogoutModal() {
        if (modal) modal.classList.add('open');
    }
    function closeLogoutModal() {
        if (modal) modal.classList.remove('open');
    }
    window.addEventListener('click', function(e) {
        if (e.target === modal) closeLogoutModal();
    });
</script>

</body>
</html>