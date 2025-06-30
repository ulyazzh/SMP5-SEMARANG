<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "smp5_semarang";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
