<?php
$host = "localhost";
$user = "root";
$pass = ""; // sesuaikan password phpMyAdmin
$db = "smp5_semarang";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>



