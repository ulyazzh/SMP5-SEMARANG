<?php
$password = "admin123"; // Ganti sesuai password yang kamu mau
$hash = password_hash($password, PASSWORD_DEFAULT);
echo $hash;
?>
