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
    <link rel="icon" href="media/logo-smp5.png">
    <style>
        /* --- CSS Tambahan untuk Header dan Galeri --- */

        /* Style untuk Header Background Slider */
        #hero-slider {
            background-size: cover; /* Pastikan gambar mengisi seluruh area */
            background-position: center center; /* Pusatkan gambar */
            background-repeat: no-repeat; /* Jangan ulangi gambar */
            transition: background-image 1s ease-in-out; /* Transisi untuk perubahan gambar */
            min-height: 400px; /* Tinggi minimum header */
            display: flex; /* Untuk memusatkan konten secara vertikal */
            align-items: center; /* Vertikal tengah */
            justify-content: center; /* Horizontal tengah */
            text-align: center;
            position: relative; /* Penting untuk z-index konten */
        }

        #hero-slider .container {
            z-index: 2; /* Pastikan teks di atas gambar latar belakang */
            position: relative;
            color: white; /* Pastikan teks terlihat di atas background */
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5); /* Bayangan teks agar lebih terbaca */
        }

        /* Style untuk setiap item galeri (sudah ada dari sebelumnya) */
        .grid-item {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease-in-out;
        }

        .grid-item:hover {
            transform: scale(1.03);
        }

        .img-box {
            display: block;
            position: relative;
            width: 100%;
            height: 200px;
            overflow: hidden;
            border-radius: 8px;
        }

        .img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease-in-out;
        }

        .image-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            padding: 10px;
            opacity: 0;
            transform: translateY(100%);
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 50px;
            box-sizing: border-box;
        }

        .caption-galeri {
            margin: 0;
            font-size: 14px;
            text-align: center;
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }

        .img-box:hover .image-overlay {
            opacity: 1;
            transform: translateY(0);
        }

        /* Styling untuk Glide.js arrows and bullets (jika masih digunakan untuk galeri) */
        .glide__arrows {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            transform: translateY(-50%);
            display: flex;
            justify-content: space-between;
            padding: 0 10px;
            pointer-events: none;
            z-index: 10;
        }

        .glide__arrow {
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 50%;
            font-size: 1.2em;
            pointer-events: all;
            transition: background-color 0.3s ease;
        }

        .glide__arrow:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        .glide__bullets {
            text-align: center;
            margin-top: 20px;
        }

        .glide__bullet {
            background-color: #ccc;
            border: none;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin: 0 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .glide__bullet--active {
            background-color: #333;
        }

        /* Responsive adjustments */
        @media (max-width: 991px) { /* Tablet */
            .img-box {
                height: 180px;
            }
        }
        @media (max-width: 767px) { /* Mobile */
            .img-box {
                height: 150px;
            }
            .glide__arrows {
                padding: 0 5px;
            }
            .glide__arrow {
                padding: 8px 12px;
                font-size: 1em;
            }
        }
    </style>
    <header class="header-image ken-burn-center light" data-parallax="true" data-natural-height="1080" data-natural-width="1920" data-bleed="0" data-image-src="media/backgroundgalery.jpeg" data-offset="0" id="hero-slider">
        <div class="container">
            <h1>Galeri</h1>
            <h2>SMP NEGERI 5 SEMARANG</h2>
        </div>
    </header>
</head>

<body class="page-main">
    <div id="preloader"></div>
    <nav class="menu-classic menu-fixed menu-transparent light align-right" data-menu-anima="fade-in">
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
            </div>
        </div>
    </nav>
    <main>
     

        <?php
        include 'config.php';

        // Query untuk galeri utama (slider)
        $result_main_gallery = mysqli_query($conn, "SELECT * FROM galeri ORDER BY tanggal_upload DESC");
        ?>

        <section class="section-base section-color">
            <div class="container">
                <div class="glide" id="gallery-slider">
                    <div class="glide__track" data-glide-el="track">
                        <ul class="glide__slides">
                            <?php
                            if ($result_main_gallery && mysqli_num_rows($result_main_gallery) > 0) {
                                while ($row = mysqli_fetch_assoc($result_main_gallery)) {
                                    $foto_path = 'upload/' . htmlspecialchars($row['nama_file']);
                                    if (!file_exists($foto_path)) continue;
                            ?>
                                <li class="glide__slide">
                                    <div class="grid-item">
                                        <a class="img-box" href="<?php echo $foto_path; ?>" title="<?php echo htmlspecialchars($row['keterangan']); ?>">
                                            <img src="<?php echo $foto_path; ?>" alt="<?php echo htmlspecialchars($row['keterangan']); ?>" />
                                            <?php if (!empty($row['keterangan'])): ?>
                                                <div class="image-overlay">
                                                    <p class="caption-galeri"><?php echo htmlspecialchars($row['keterangan']); ?></p>
                                                </div>
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                </li>
                            <?php
                                }
                            } else {
                                echo "<p class='col-12 text-center'>Belum ada foto di galeri utama.</p>";
                            }
                            ?>
                        </ul>
                    </div>

                    <div class="glide__arrows" data-glide-el="controls">
                        <button class="glide__arrow glide__arrow--left" data-glide-dir="<">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        </button>
                        <button class="glide__arrow glide__arrow--right" data-glide-dir=">">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </button>
                    </div>

                    <div class="glide__bullets" data-glide-el="controls[nav]">
                        <?php
                        $bullet_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM galeri");
                        $total_slides_for_bullets = 0;
                        if ($bullet_result && $row_count = mysqli_fetch_assoc($bullet_result)) {
                            $total_slides_for_bullets = $row_count['total'];
                        }

                        for ($i = 0; $i < $total_slides_for_bullets; $i++) {
                            echo '<button class="glide__bullet" data-glide-dir="' . $i . '"></button>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-base section-color" style="padding-top: 50px; padding-bottom: 50px;">
            <div class="container">
                <h3 class="text-center mb-4">Momen Lainnya</h3>
                <p class="text-center text-muted mb-5">Jelajahi lebih banyak kegiatan dan kenangan dari sekolah kami.</p>

                <div class="row">
                    <?php
                    $offset = 4; 
                    $limit = 6;  

                    $result_additional_gallery = mysqli_query($conn, "SELECT * FROM galeri ORDER BY tanggal_upload DESC LIMIT {$offset}, {$limit}");
                    
                    if ($result_additional_gallery && mysqli_num_rows($result_additional_gallery) > 0) {
                        while ($row_additional = mysqli_fetch_assoc($result_additional_gallery)) {
                            $foto_path_additional = 'upload/' . htmlspecialchars($row_additional['nama_file']);
                            if (!file_exists($foto_path_additional)) continue;
                    ?>
                        <div class="col-md-4 col-sm-6 mb-4">
                            <div class="card h-100 shadow-sm border-0">
                                <img src="<?php echo $foto_path_additional; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row_additional['keterangan']); ?>" style="height: 220px; object-fit: cover; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                                <div class="card-body text-center">
                                    <?php if (!empty($row_additional['keterangan'])): ?>
                                        <p class="card-text small text-muted mb-0"><?php echo htmlspecialchars($row_additional['keterangan']); ?></p>
                                    <?php else: ?>
                                        <p class="card-text small text-muted mb-0">Tanpa Keterangan</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php
                        } // Akhir dari loop
                    } else {
                        echo "<p class='col-12 text-center text-muted'>Belum ada momen tambahan untuk ditampilkan.</p>";
                    }
                    ?>
                </div>
            </div>
        </section>
    </main>

<?php
// Langkah 4: Memanggil footer
include 'footer.php';
?>
<script src="themekit/scripts/glide.min.js"></script>
<script>
    // Script untuk Background Header Slider
    $(document).ready(function() {
        var images = [
            'media/backgroundgalery.jpeg', 
            'media/guru.jpg',
            'media/hut.jpg',
            'media/maulid.jpg'          
        ];
        var currentImage = 0;
        var heroSlider = $('#hero-slider');

        if (images.length > 0) {
            function changeBackground() {
                heroSlider.css('background-image', 'url("' + images[currentImage] + '")');
                currentImage = (currentImage + 1) % images.length;
            }

            changeBackground(); // Panggil pertama kali

            if (images.length > 1) { 
                setInterval(changeBackground, 3000); 
            }
        } else {
            // Jika tidak ada gambar, set warna solid sebagai fallback
            heroSlider.css('background-color', '#336699'); // Warna default jika tidak ada gambar
        }
    });

    // Script untuk Glide.js Galeri Gambar
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Glide !== 'undefined' && document.getElementById('gallery-slider')) {
            new Glide('#gallery-slider', {
                type: 'carousel',
                perView: 3,
                focusAt: 'center',
                autoplay: 3000,
                gap: 15,
                hoverpause: true,
                animationDuration: 800,
                breakpoints: {
                    991: {
                        perView: 2,
                        focusAt: 0
                    },
                    767: {
                        perView: 1,
                        focusAt: 0
                    }
                }
            }).mount();
        } else {
            console.warn("Glide.js is not loaded or #gallery-slider not found. Skipping gallery slider initialization.");
        }
    });
</script>
</body>
</html>