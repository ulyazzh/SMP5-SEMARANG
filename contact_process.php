<?php
include "config.php"; // Pastikan file config.php berisi koneksi database

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

$sql = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";
$result = mysqli_query($conn, $sql);

if ($result) {
    header("Location: contacts.php?status=success");
} else {
    header("Location: contacts.php?status=error");
}
exit();
?>
