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
    <link rel="stylesheet" href="themekit/css/glide.css">
    <link rel="stylesheet" href="themekit/css/magnific-popup.css">
    <link rel="stylesheet" href="themekit/css/content-box.css">
    <link rel="stylesheet" href="themekit/css/media-box.css">
    <link rel="stylesheet" href="themekit/css/contact-form.css">
    <link rel="stylesheet" href="skin.css">
    <link rel="icon" href="media/lOGOSD.png">
</head>

<body class="page-main">
    <div id="preloader"></div>
    <nav class="menu-classic menu-fixed menu-transparent light align-right" data-menu-anima="fade-in">
        <div class="container">
            <i class="menu-btn"></i>
            <div class="menu-cnt">
                <ul id="main-menu">
                    <li class="dropdown">
                        <a href="Index.html">BERANDA</a>
                    </li>
                    <li class="dropdown">
                        <a href="#">PROFIL</a>
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
                        <a href="pengumuman.php">Pengumuman</a>
                    </li>
                    <li>
                        <a href="contacts.php">Kontak</a>
                    </li>
                    <li>
                        <a href="login.php">Login</a>
                    </li>    
            </div>
        </div>
    </nav>

<?php
include 'config.php';

// Langkah 2: Ambil semua data dari tabel 'galeri', diurutkan dari yang terbaru
$result = mysqli_query($conn, "SELECT * FROM galeri ORDER BY tanggal_upload DESC");
?>

<main>
    <header class="header-image ken-burn-center light" style="background-image:url('media/backgroundgalery.jpeg');">
        <div class="container">
            <h1>Galeri Sekolah</h1>
            <h2>Momen dan Kenangan di SMP Negeri 5 Semarang</h2>
        </div>
    </header>

    <section class="section-base section-color">
        <div class="container">
            <div class="grid-list list-gallery" data-lightbox-anima="fade-top" data-columns="3" data-columns-md="2" data-columns-sm="1">
                <div class="grid-box">
                    <?php
                    // Langkah 3: Cek apakah ada data foto di database
                    if ($result && mysqli_num_rows($result) > 0) {
                        // Looping untuk setiap foto
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Menentukan path (lokasi) file gambar
                            $foto_path = 'upload/' . htmlspecialchars($row['nama_file']);
                            if (!file_exists($foto_path)) continue; // Jika file tidak ada, lewati
                    ?>
                    
                    <div class="grid-item">
                        <a class="img-box" href="<?php echo $foto_path; ?>" title="<?php echo htmlspecialchars($row['keterangan']); ?>">
                            <img src="<?php echo $foto_path; ?>" alt="<?php echo htmlspecialchars($row['keterangan']); ?>" />
                        </a>
                    </div>
                    
                    <?php
                        } // Akhir dari loop
                    } else {
                        // Pesan jika tidak ada foto sama sekali
                        echo "<p class='col-12 text-center'>Belum ada foto di galeri. Silakan unggah melalui panel admin.</p>";
                    }
                    ?>
                </div> </div> </div> </section>
</main>

<?php
// Langkah 4: Memanggil footer
include 'footer.php';
?>