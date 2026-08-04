<?php
session_start();
include 'koneksi.php';

if (isset($_POST['submit'])) {
    // Mengamankan input dari SQL Injection
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Mencari username di database
    $query  = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Memverifikasi password (menggunakan password_verify karena password di DB di-hash)
        if (password_verify($password, $row['password'])) {
            // Set session untuk mengenali user yang login
            $_SESSION['login'] = true;
            $_SESSION['username'] = $row['username'];
            
            // Mengarahkan ke halaman utama/dashboard setelah berhasil login
            echo "<script>
                    alert('Login berhasil! Selamat datang " . $row['username'] . "');
                    window.location.href = 'index.php'; 
                  </script>";
            exit;
        } else {
            echo "<script>
                    alert('Password salah!');
                    window.location.href = 'login.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Username tidak ditemukan!');
                window.location.href = 'login.php';
              </script>";
    }
} else {
    header("Location: login.php");
    exit;
}
?>