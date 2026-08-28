<?php
$host = "localhost";
$user = "root";
$pass = ""; // Kosongkan jika menggunakan pengaturan bawaan XAMPP
$db   = "rupantara"; // Nama database Anda

// Mengubah nama variabel menjadi $conn agar sesuai dengan proses_login.php
$conn = mysqli_connect($host, $user, $pass, $db);

// Memeriksa apakah koneksi berhasil
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>