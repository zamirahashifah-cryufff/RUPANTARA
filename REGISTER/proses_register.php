<?php
include '../LOGIN/koneksi.php';

if (isset($_POST['register'])) {
    $username        = mysqli_real_escape_string($conn, $_POST['username']);
    $email           = mysqli_real_escape_string($conn, $_POST['email']);
    $password        = $_POST['password'];
    $konfirmasi      = $_POST['konfirmasi_password'];
    $status_pengguna = mysqli_real_escape_string($conn, $_POST['status_pengguna']);

    if ($password !== $konfirmasi) {
        echo "<script>
                alert('Konfirmasi password tidak cocok!');
                window.location.href = 'register.php';
              </script>";
        exit;
    }

    // MENGUBAH NAMA TABEL MENJADI 'register'
    $query_cek = "SELECT * FROM register WHERE username = '$username' OR email = '$email'";
    $cek_user  = mysqli_query($conn, $query_cek);

    if (mysqli_num_rows($cek_user) > 0) {
        echo "<script>
                alert('Username atau Email sudah terdaftar!');
                window.location.href = 'register.php';
              </script>";
        exit;
    }

    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // MENGUBAH NAMA TABEL MENJADI 'register'
    $query_insert = "INSERT INTO register (username, email, password, status_pengguna) 
                     VALUES ('$username', '$email', '$password_hashed', '$status_pengguna')";
    
    if (mysqli_query($conn, $query_insert)) {
        echo "<script>
                alert('Pendaftaran akun berhasil! Silakan masuk.');
                window.location.href = '../LOGIN/login.php';
              </script>";
    } else {
        echo "<script>
                alert('Pendaftaran gagal: " . mysqli_error($conn) . "');
                window.location.href = 'register.php';
              </script>";
    }
} else {
    header("Location: register.php");
    exit;
}
?>