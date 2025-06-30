<?php
// KODE DEBUGGING: Memaksa PHP untuk menampilkan semua error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMP Negeri 5 Semarang</title>
    <meta name="description" content="Website Resmi SMP Negeri 5 Semarang">
    
    <script src="themekit/scripts/jquery.min.js"></script>
    <script src="themekit/scripts/main.js"></script>
    <link rel="stylesheet" href="themekit/css/bootstrap-grid.css">
    <link rel="stylesheet" href="themekit/css/style.css">
    <link rel="stylesheet" href="themekit/css/glide.css">
    <link rel="stylesheet" href="themekit/css/magnific-popup.css">
    <link rel="stylesheet" href="themekit/css/content-box.css">
    <link rel="stylesheet" href="themekit/css/media-box.css">
    <link rel="stylesheet" href="themekit/css/contact-form.css">
    <link rel="stylesheet" href="skin.css"> <link rel="icon" href="media/logo-smp5.png">
</head>
<body class="<?php echo 'page-' . basename($_SERVER['PHP_SELF'], '.php'); ?>">
    <div id="preloader"></div>
    <nav class="menu-classic menu-fixed light align-right" data-menu-anima="fade-in">
        <div class="container">
            <div class="menu-brand">
                <a href="index.php">
                    <img class="logo-default" src="media/logo-smp5.png" alt="logo" />
                    <img class="logo-retina" src="media/logo-smp5.png" alt="logo" />
                </a>
            </div>
            <i class="menu-btn"></i>
            <div class="menu-cnt">
                <ul id="main-menu">
                    <li><a href="index.php">Beranda</a></li>
                    <li class="dropdown">
                        <a href="#">Profil</a>
                        <ul>
                            <li><a href="profil-sekolah.php">Profil Sekolah</a></li>
                            <li><a href="profil-guru.php">Profil Guru</a></li>
                        </ul>
                    </li>
                    <li><a href="ekstrakurikuler.php">Ekstrakurikuler</a></li>
                    <li><a href="galeri.php">Galeri</a></li>
                    <li><a href="pengumuman.php">Pengumuman</a></li>
                    <li><a href="kontak.php">Kontak</a></li>
                    <li><a href="login.php">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>