<?php
session_start();
include 'koneksi.php';

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // MENGGUNAKAN TABEL 'register'
    $query  = "SELECT * FROM register WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Memverifikasi password hash
        if (password_verify($password, $row['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $row['username'];
            
            // Cek apakah ada riwayat halaman terakhir yang disimpan
            if (isset($_SESSION['redirect_to'])) {
                $redirect_page = $_SESSION['redirect_to'];
                unset($_SESSION['redirect_to']); // Hapus session agar tidak mengarah ke sana terus menerus
                header("Location: " . $redirect_page);
            } else {
                // Arahkan ke beranda default jika tidak ada riwayat halaman sebelumnya
                // Disarankan mengubah beranda menjadi beranda.php
                header("Location: ../BERANDA/beranda.php");
            }
            exit;
        } else {
            echo "<script>
                    alert('Akun tidak ditemukan!');
                    window.location.href = 'login.php?pesan=gagal';
                  </script>";
            exit;
        }
    } else {
        echo "<script>
                alert('Akun tidak ditemukan!');
                window.location.href = 'login.php?pesan=gagal';
              </script>";
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}
?>