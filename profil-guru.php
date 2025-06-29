<?php
// Include konfigurasi database
// Sesuaikan path 'config.php' jika letaknya berbeda
include 'config.php';

// Query untuk mengambil data guru dari database
// Urutkan berdasarkan nama agar teratur
$query = "SELECT * FROM guru ORDER BY nama ASC"; // Anda bisa menyesuaikan ORDER BY sesuai kebutuhan
$result = mysqli_query($koneksi, $query);

// Cek jika query gagal
if (!$result) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Team | 2 | Alpins | Mountain And Trekking Template</title>
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
    <link rel="icon" href="media/favicon.png">
</head>
<body class="page-main">
    <div id="preloader"></div>
    <nav class="menu-classic menu-fixed align-right" data-menu-anima="fade-in">
        <div class="container">
            <div class="menu-brand">
                <a href="index.html">
                    <img class="logo-default scroll-hide" src="media/SMP1.png" alt="logo" />
                    <img class="logo-retina scroll-hide" src="media/SMP1.png" alt="logo" />
                    <img class="logo-default scroll-show" src="media/SMP1.png" alt="logo" />
                    <img class="logo-retina scroll-show" src="media/SMP1.png" alt="logo" />
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
                                <a>Profil</a>
                                <ul>
                                    <li><a href="about.html">Profil Sekolah</a></li>
                                    <li><a href="profil-guru.php">Profil Guru</a></li>
                                    <li><a href="profil-siswa.html">Profil Siswa</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a>Special</a>
                                <ul>
                                    <li><a href="food.html">Food</a></li>
                                    <li><a href="shelters.html">Shelters</a></li>
                                    <li><a href="events.html">Events</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a>Others</a>
                                <ul>
                                    <li><a href="prices.html">Prices</a></li>
                                    <li><a href="history.html">History</a></li>
                                    <li><a href="gallery.html">Gallery</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="elements/components/buttons.html">Elements</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="galeri.html">Galeri</a>
                    </li>
                    <li>
                        <a href="pengumuman.html">Pengumuman</a>
                    </li>
                    <li>
                        <a href="contacts.html">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <header class="header-image ken-burn-center light" data-parallax="true" data-natural-height="1080" data-natural-width="1920" data-bleed="0" data-image-src="http://via.placeholder.com/1920x1080" data-offset="0">
        <div class="container">
            <h1>Our team</h1>
            <h2>Talent wins games, but teamwork win championships</h2>
            <ol class="breadcrumb">
                <li><a href="index.html">Home</a></li>
                <li><a href="#">Pages</a></li>
                <li><a href="#">Team</a></li>
            </ol>
        </div>
    </header>

    <main>
        <section class="section-base ">
            <div class="container">
                <div class="menu-inner">
                    <div><i class="menu-btn"></i><span>Menu</span></div>
                    <ul>
                        <li class="active"><a data-filter="maso-item" href="#">All</a></li>
                        <li><a data-filter="cat-pai" href="#">PAI</a></li>
                        <li><a data-filter="cat-b.indonesia" href="#">B.Indonesia</a></li>
                        <li><a data-filter="cat-ppkn" href="#">PPKN</a></li>
                        <li><a data-filter="cat-mtk" href="#">MTK</a></li>
                        <li><a data-filter="cat-ipa" href="#">IPA</a></li>
                        <li><a data-filter="cat-b.inggris" href="#">B.Inggris</a></li>
                        <li><a data-filter="cat-ips" href="#">IPS</a></li>
                        <li><a data-filter="cat-pjok" href="#">PJOK</a></li>
                        <li><a data-filter="cat-prakarya" href="#">Prakarya</a></li>
                        <li><a data-filter="cat-b.jawa" href="#">B.Jawa</a></li>
                        <li><a data-filter="cat-seni" href="#">Seni</a></li>
                        <li><a data-filter="cat-bk" href="#">BK</a></li>
                        <li><a data-filter="cat-tu" href="#">TU</a></li>
                        <li><a class="maso-order" data-sort="asc"></a></li>
                    </ul>
                </div>
                <div class="grid-list gap-60" data-columns="4" data-columns-md="2" data-columns-sm="1" data-gap="60">
                    <div class="grid-box">
                        <?php
                        // Perulangan untuk menampilkan setiap guru dari database
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                // Tentukan path foto. Sesuaikan jika 'upload/' tidak tepat.
                                // Misal: jika folder 'upload' berada di root, dan profil-guru.php di subfolder, maka pakai '../upload/'
                                $foto_path = "upload/" . $row['foto'];
                                // Jika foto tidak ada atau nama file kosong, gunakan gambar placeholder
                                if (!file_exists($foto_path) || empty($row['foto'])) {
                                    $foto_path = "media/nofoto.png"; // Pastikan file nofoto.png ada di folder media Anda
                                }

                                // Format mata pelajaran untuk data-category agar sesuai dengan filter template Themekit
                                // Contoh: "Guru Agama Islam" -> "cat-guru-agama-islam"
                                // "B.Indonesia" -> "cat-b.indonesia" (jika filter Anda pakai titik)
                                // Perhatikan bahwa filter di menu Anda menggunakan "cat-1", "cat-2", dll.
                                // Ini berarti nilai 'mapel' di database harus konsisten dengan 'cat-1', 'cat-2', dll.
                                // ATAU, Anda harus mengubah data-filter di menu Anda agar sesuai dengan mapel.
                                // Saya akan mengasumsikan format 'cat-nama_mapel_dislug'.
                                // Jika 'mapel' di DB adalah 'PAI', maka jadi 'cat-pai'.
                                $mapel_slug = "cat-" . strtolower(str_replace([' ', '.', ',', '/'], '-', $row['mapel']));
                        ?>
                                <div class="grid-item <?= $mapel_slug ?>"> <div class="cnt-box cnt-box-team lightbox" data-href="#user-<?= $row['id'] ?>" data-lightbox-anima="fade-in">
                                        <img src="<?= $foto_path ?>" alt="<?= htmlspecialchars($row['nama']) ?>" />
                                        <div class="caption">
                                            <h2><?= htmlspecialchars($row['nama']) ?></h2>
                                            <hr class="space-sm" />
                                            <p><?= htmlspecialchars($row['mapel']) ?></p>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                            echo "<p class='text-center'>Belum ada data guru yang tersedia.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php
    // Reset pointer result untuk membuat lightbox dari data yang sama
    mysqli_data_seek($result, 0);
    while ($row = mysqli_fetch_assoc($result)) {
        $foto_path = "upload/" . $row['foto'];
        if (!file_exists($foto_path) || empty($row['foto'])) {
            $foto_path = "media/nofoto.png";
        }
    ?>
    
    <?php
    }
    ?>

    <footer class="light">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <h3>Alpins</h3>
                    <p>Somewhere between the bottom of the climb and the summit is the answer to the mystery why we climb.</p>
                </div>
                <div class="col-lg-4">
                    <h3>Contacts</h3>
                    <ul class="icon-list icon-line">
                        <li>San Pellegrino, BG, Italy</li>
                        <li>hello@example.com</li>
                        <li>02 123 333 444</li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <div class="icon-links icon-social icon-links-grid social-colors">
                        <a class="facebook"><i class="icon-facebook"></i></a>
                        <a class="twitter"><i class="icon-twitter"></i></a>
                        <a class="instagram"><i class="icon-instagram"></i></a>
                        <a class="google"><i class="icon-google"></i></a>
                    </div>
                    <hr class="space-sm" />
                    <p>Subscribe to our newsletter of follow us on the social channels to stay tuned.</p>
                </div>
            </div>
        </div>
        <div class="footer-bar">
            <div class="container">
                <span>© 2019 Alpins - Hiking & Outdoor Template Handmade by <a href="https://schiocco.com" target="_blank">schiocco.com</a>.</span>
                <span><a href="contacts.html">Contact us</a> | <a href="#">Privacy policy</a></span>
            </div>
        </div>
        <link rel="stylesheet" href="themekit/media/icons/iconsmind/line-icons.min.css">
        <script src="themekit/scripts/parallax.min.js"></script>
        <script src="themekit/scripts/glide.min.js"></script>
        <script src="themekit/scripts/progress.js"></script>
        <script src="themekit/scripts/magnific-popup.min.js"></script>
        <script src="themekit/scripts/contact-form/contact-form.js"></script>
    </footer>
</body>
</html>