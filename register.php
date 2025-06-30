<?php
require 'config.php';

$pesanError = "";
$pesanSukses = "";

// Proses register
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = $_POST["password"];
    $konfirmasi = $_POST["konfirmasi"];

    // Cek konfirmasi password
    if ($password !== $konfirmasi) {
        $pesanError = "Konfirmasi password tidak sesuai!";
    } else {
        // Cek username sudah ada atau belum
        $query = "SELECT * FROM admin WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $pesanError = "Username sudah terdaftar!";
        } else {
            // Hash password dan simpan ke database
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $insert = "INSERT INTO admin (username, password) VALUES ('$username', '$passwordHash')";
            
            if (mysqli_query($conn, $insert)) {
                $pesanSukses = "Registrasi berhasil, silakan login!";
            } else {
                $pesanError = "Terjadi kesalahan saat registrasi!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register Admin - SMP N 5 Semarang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-blue-500 to-blue-700 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-md">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-700">Register Admin</h1>
            <p class="text-gray-500">SMP N 5 Semarang</p>
        </div>

        <?php if ($pesanError) : ?>
            <div class="bg-red-100 text-red-700 p-2 rounded mb-4 text-center">
                <?= $pesanError; ?>
            </div>
        <?php endif; ?>

        <?php if ($pesanSukses) : ?>
            <div class="bg-green-100 text-green-700 p-2 rounded mb-4 text-center">
                <?= $pesanSukses; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <label class="block text-gray-700 mb-1" for="username">Username</label>
                <input type="text" id="username" name="username" required
                    class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1" for="password">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-1" for="konfirmasi">Konfirmasi Password</label>
                <input type="password" id="konfirmasi" name="konfirmasi" required
                    class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <button type="submit"
                class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-lg transition duration-200">
                Register
            </button>
        </form>

        <p class="text-center text-gray-500 mt-4">Sudah punya akun? <a href="login.php" class="text-green-700 font-semibold">Login di sini</a></p>
    </div>

</body>
</html>
