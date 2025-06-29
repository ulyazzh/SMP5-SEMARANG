<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">


    
    <!-- Modal Selamat Datang -->
    <div id="welcomeModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center relative">
            <button id="closeModal" class="absolute top-2 right-2 text-gray-500 hover:text-red-500">&times;</button>
            <h2 class="text-xl font-bold mb-2">Selamat Datang, Admin!</h2>
            <p class="text-gray-600 mb-4">Anda berhasil login ke sistem admin SMP N 5 Semarang.</p>
        </div>
    </div>

    <script>
        document.getElementById('closeModal').addEventListener('click', function () {
            document.getElementById('welcomeModal').style.display = 'none';
        });
    </script>



<!-- Sidebar -->
        <div class="w-64 bg-blue-700 min-h-screen p-4 text-white">
            <h2 class="text-2xl font-bold mb-6">Admin Panel</h2>
            <nav class="space-y-4">
                <a href="/admin/admin-profil-guru.php" class="block hover:bg-blue-800 p-2 rounded">Profil Guru</a>
                <a href="/admin/admin-galeri.php" class="block hover:bg-blue-800 p-2 rounded">Galeri</a>
                <a href="/admin/admin-pengumuman.php" class="block hover:bg-blue-800 p-2 rounded">Pengumuman</a>
                <a href="/admin/admin-messages.php" class="block hover:bg-blue-800 p-2 rounded">Kontak</a>
                <div class="d-flex justify-content-start mb-4">
                    <a href="../Index.html" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda
                    </a>
                </div>
                <a href="logout.php" class="block hover:bg-blue-800 p-2 rounded text-red-300">Logout</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <h1 class="text-3xl font-bold text-gray-700 mb-4">Selamat Datang di Dashboard Admin</h1>
            <p class="text-gray-600 mb-6">Kelola konten website SMP N 5 Semarang melalui panel ini.</p>

            <!-- Placeholder Konten -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    

                <div class="bg-white shadow rounded p-4">
                    <h2 class="text-xl font-bold mb-2">Profil Guru</h2>
                    <p class="text-gray-600 mb-4">Tambah atau edit data guru.</p>
                    <a href="/admin/admin-profil-guru.php" class="bg-blue-600 text-white px-4 py-2 rounded inline-block text-center">Kelola</a>
                </div>

                <div class="bg-white shadow rounded p-4">
                    <h2 class="text-xl font-bold mb-2">Galeri</h2>
                    <p class="text-gray-600 mb-4">Tambah atau hapus foto galeri.</p>
                    <a href="/admin/admin-galeri.php" class="bg-blue-600 text-white px-4 py-2 rounded inline-block text-center">Kelola</a>
                </div>

                <div class="bg-white shadow rounded p-4">
                    <h2 class="text-xl font-bold mb-2">Pengumuman</h2>
                    <p class="text-gray-600 mb-4">Buat dan kelola pengumuman.</p>
                    <a href="/admin/admin-pengumuman.php" class="bg-blue-600 text-white px-4 py-2 rounded inline-block text-center">Kelola</a>
                </div>

                <div class="bg-white shadow rounded p-4">
                    <h2 class="text-xl font-bold mb-2">Kontak</h2>
                    <p class="text-gray-600 mb-4">Kelola informasi kontak sekolah.</p>
                    <a href="/admin/admin-messages.php" class="bg-blue-600 text-white px-4 py-2 rounded inline-block text-center">Kelola</a>
                </div>

                
            </div>
        </div>
    </body>
</html>


