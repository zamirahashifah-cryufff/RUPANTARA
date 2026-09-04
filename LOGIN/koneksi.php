<?php 
$host = "localhost"; 
$user = "ula5m9mv_rupantara_user"; 
$pass = "PASSWORD_DATABASE_KAMU"; 
$db   = "ula5m9mv_rupantara"; 

$conn = mysqli_connect($host, $user, $pass, $db); 

if (!$conn) { 
    die("Koneksi ke database gagal: " . mysqli_connect_error()); 
} 
?>