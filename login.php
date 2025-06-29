<?php
session_start();
require 'config.php';

$pesanError = "";

// Proses login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = $_POST["password"];

    $query = "SELECT * FROM admin WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $data = mysqli_fetch_assoc($result);

        if (password_verify($password, $data["password"])) {
            $_SESSION["login"] = true;
            header("Location: dashboard-adm.php");
            exit;
        }
    }
    $pesanError = "Username atau password salah!";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - SMP N 5 Semarang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-blue-500 to-blue-700 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-md">
        <div class="text-center mb-6">
            <img src="media/smp1.png" alt="Logo SMP N 5 Semarang" class="mx-auto h-16 mb-2">
            <h1 class="text-2xl font-bold text-gray-700">Login Admin</h1>
        </div>

        <?php if ($pesanError) : ?>
            <div class="bg-red-100 text-red-700 p-2 rounded mb-4 text-center">
                <?= $pesanError; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <label class="block text-gray-700 mb-1" for="username">Username</label>
                <input type="text" id="username" name="username" required
                    class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-1" for="password">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition duration-200">
                Login
            </button>
        </form>
    </div>

</body>
</html>
