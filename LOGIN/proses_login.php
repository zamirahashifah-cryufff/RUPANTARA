<?php
session_start();
include 'koneksi.php';

if (isset($_POST['submit'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM register WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    // CEK APAKAH QUERY BERHASIL
    if (!$result) {
        die("Query login gagal: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) === 1) {

        $row = mysqli_fetch_assoc($result);

        // Verifikasi password
        if (password_verify($password, $row['password'])) {

            $_SESSION['login'] = true;
            $_SESSION['username'] = $row['username'];

            if (isset($_SESSION['redirect_to'])) {

                $redirect_page = $_SESSION['redirect_to'];
                unset($_SESSION['redirect_to']);

                header("Location: " . $redirect_page);

            } else {

                header("Location: ../BERANDA/beranda.php");
            }

            exit;

        } else {

            echo "<script>
                    alert('Password salah!');
                    window.location.href = 'login.php?pesan=gagal';
                  </script>";
            exit;
        }

    } else {

        echo "<script>
                alert('Username tidak ditemukan!');
                window.location.href = 'login.php?pesan=gagal';
              </script>";
        exit;
    }

} else {

    header("Location: login.php");
    exit;
}
?>