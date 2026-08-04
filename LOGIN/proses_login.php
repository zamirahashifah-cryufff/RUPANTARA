<?php
session_start();
include 'koneksi.php';

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // MENGGUNAKAN TABEL 'register' (Bukan users)
    $query  = "SELECT * FROM register WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Memverifikasi password hash
        if (password_verify($password, $row['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $row['username'];
            
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
            exit;
        }
    } else {
        echo "<script>
                alert('Username tidak ditemukan!');
                window.location.href = 'login.php';
              </script>";
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}
?>