<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMP 5 Semarang</title>
    <meta name="description" content="">
    <script src="themekit/scripts/jquery.min.js"></script>
    <script src="themekit/scripts/main.js"></script>
    <link rel="stylesheet" href="themekit/css/bootstrap-grid.css">
    <link rel="stylesheet" href="themekit/css/style.css">
    <link rel="stylesheet" href="themekit/css/content-box.css">
    <link rel="stylesheet" href="themekit/css/media-box.css">
    <link rel="stylesheet" href="skin.css">
    <link rel="icon" href="media/logo-smp5.png">

    <style>
        .cnt-box .img-box img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 8px;
        }

        @media (max-width: 768px) {
            .cnt-box .img-box img {
                height: 180px;
            }
        }
    </style>

</head>
<body class="page-main">
    <div id="preloader"></div>
    <nav class="menu-classic menu-fixed align-right" data-menu-anima="fade-in">
        <div class="container">
            <div class="menu-brand">
                <a href="index.html">
                    <img class="logo-default scroll-hide" src="media/SMP1.png" alt="logo" />
                    <img class="logo-retina scroll-hide" src="mmedia/SMP1.png" alt="logo" />
                    <img class="logo-default scroll-show" src="media/SMP1.png" alt="logo" />
                    <img class="logo-retina scroll-show" src="mmedia/SMP1.png" alt="logo" />
                </a>
            </div>
            <i class="menu-btn"></i>
            <div class="menu-cnt">
                <ul id="main-menu">
                    <li class="dropdown">
                        <a href="index.html">Beranda</a>
                    </li>
                    <li class="dropdown">
                        <a href="#">Profil</a>
                        <ul>
                             <li class="dropdown-submenu">
                                <li><a href="kepalasekolah.html">Profil Kepala Sekolah</a></li>
                            </li>
                            <li class="dropdown-submenu">
                                <li><a href="profil-guru.php">Profil Guru</a></li>   
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="ekstrakurikuler.html">Ekstrakurikuler</a>
                    <li>
                    <li class="dropdown">
                        <a href="galeri.php">Galeri</a>
                    <li>
                    <li>
                        <a href="pengumuman.php">Pengumuman</a>
                    </li>
                    <li>
                        <a href="contacts.php">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <header class="header-image ken-burn-center light" data-parallax="true" data-natural-height="1080" data-natural-width="1920" data-bleed="0" style="background-image:url('media/PENGUMUMAN.png');" data-offset="0">
        <div class="container">
            <h2>SMP NEGERI 5 SEMARANG</h2>
        </div>
    </header>

<?php
include 'config.php';
$result = mysqli_query($conn, "SELECT * FROM pengumuman ORDER BY tanggal DESC");
?>
<main>
    <section class="section-base section-color">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <?php
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <div class="cnt-box cnt-box-blog-side boxed" style="margin-bottom: 30px;">
                            <?php 
                            // TAMPILKAN GAMBAR JIKA ADA
                            if (!empty($row['gambar'])): 
                                $gambar_path = 'upload/' . htmlspecialchars($row['gambar']);
                                if(file_exists($gambar_path)):
                            ?>
                                <a href="#" class="img-box">
                                    <img src="<?= $gambar_path ?>" alt="">
                                </a>
                            <?php 
                                endif;
                            endif; 
                            ?>
                            <div class="caption">
                                <div class="extra-field"><?= date('d F Y', strtotime($row['tanggal'])) ?></div>
                                <h2><?= htmlspecialchars($row['judul']) ?></h2>
                                <p><?= nl2br(htmlspecialchars($row['isi'])) ?></p>
                            </div>
                        </div>
                    <?php
                        }
                    } else {
                        echo "<p class='text-center'>Belum ada pengumuman.</p>";
                    }
                    ?>
                </div>
                <div class="col-lg-4">
                    <div class="cnt-box cnt-box-side-icon-box boxed" style="padding: 20px;">
                        <i class="im-information"></i>
                        <div class="caption">
                            <h3>Info Sekolah</h3>
                            <p>Halaman ini berisi informasi dan pengumuman resmi dari SMP Negeri 5 Semarang.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
