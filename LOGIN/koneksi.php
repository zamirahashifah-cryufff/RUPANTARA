<?php
$host = "localhost";
$user = "root";
$pass = ""; // Kosongkan jika menggunakan pengaturan bawaan XAMPP
$db   = "rupantara"; // Nama database sesuai screenshot phpMyAdmin Anda

// Membuat koneksi ke MySQL
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Memeriksa apakah koneksi berhasil
if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>