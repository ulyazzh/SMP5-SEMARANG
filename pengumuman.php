<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMPN 5 Semarang - Pengumuman</title>
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
    <link rel="stylesheet" href="themekit/media/icons/iconsmind/line-icons.min.css">
    <link rel="stylesheet" href="skin.css">
    <link rel="icon" href="media/logo-smp5.png">
    <style>
        /* Style untuk Header Background Slider */
        #hero-slider {
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            transition: background-image 1s ease-in-out;
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            /* Tambahkan warna background default jika gambar belum termuat */
            background-color: #336699; 
        }

        #hero-slider .container {
            z-index: 2;
            position: relative;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        /* Style untuk gambar di dalam pengumuman */
        .cnt-box-blog .img-box img {
            max-height: 300px;
            width: 100%;
            object-fit: cover;
        }
        
        /* Style untuk daftar link di sidebar */
        .list-links li {
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }
        .list-links li a {
            text-decoration: none;
            cursor: pointer; /* Menunjukkan bisa diklik */
        }

        /* Tombol Baca Selengkapnya */
        .btn-read-more {
            margin-top: 15px;
            display: inline-block;
            font-weight: 600;
            color: #336699; /* Sesuaikan dengan warna tema Anda */
            cursor: pointer;
        }
        .btn-read-more:hover {
            text-decoration: underline;
        }

        /* --- CSS UNTUK OVERLAY (MODAL) --- */
        .overlay-container {
            display: none; /* Tersembunyi secara default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.7); /* Latar belakang gelap transparan */
            z-index: 9999; /* Pastikan di atas segalanya */
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .overlay-content {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            max-width: 800px; /* Lebar maksimal overlay */
            width: 100%;
            max-height: 90vh; /* Tinggi maksimal agar tidak keluar layar */
            overflow-y: auto; /* Scroll jika konten terlalu panjang */
            position: relative;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .close-btn {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 24px;
            font-weight: bold;
            color: #333;
            cursor: pointer;
            transition: color 0.3s;
        }

        .close-btn:hover {
            color: #007bff;
        }
    </style>
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
                    </li>
                    <li class="dropdown">
                        <a href="galeri.php">Galeri</a>
                    </li>
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

    <header class="header-image ken-burn-center light" data-parallax="true" data-natural-height="1080" data-natural-width="1920" data-bleed="0" data-offset="0" id="hero-slider">
        <div class="container">
            <h1>Pengumuman</h1>
            <h2>SMP NEGERI 5 SEMARANG</h2>
            <ol class="breadcrumb">
                <li><a href="Index.html">Beranda</a></li>
                <li><a>Pengumuman</a></li>
            </ol>
        </div>
    </header>

    <main>
        <section class="section-base section-color">
            <div class="container">
                <div class="row">
                    
                    <div class="col-lg-8 col-md-12">
                        <?php
                        include 'config.php';

                        $query = "SELECT * FROM pengumuman ORDER BY tanggal DESC";
                        $result = mysqli_query($conn, $query);

                        // Array untuk menyimpan data semua pengumuman agar bisa diakses JS (Overlay)
                        $all_announcements = [];
                        
                        // --- BARU UNTUK SLIDER: Array untuk menyimpan gambar slider dari DB ---
                        $slider_images_php = []; 
                        $slider_limit = 5; // Batasi maksimal 5 gambar untuk slider

                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                // 1. Cek path gambar
                                $gambar_path = 'upload/' . htmlspecialchars($row['gambar']);
                                $has_image = !empty($row['gambar']) && file_exists($gambar_path);

                                // --- BARU UNTUK SLIDER: Masukkan gambar ke array slider jika ada ---
                                // Kita cek jika ada gambar DAN jumlah gambar di array belum mencapai batas
                                if ($has_image && count($slider_images_php) < $slider_limit) {
                                    $slider_images_php[] = $gambar_path;
                                }
                                // ------------------------------------------------------------------

                                // 2. Simpan data LENGKAP ke array untuk JS (Overlay)
                                $all_announcements[$row['id']] = [
                                    'judul' => $row['judul'],
                                    'tanggal' => date('d F Y', strtotime($row['tanggal'])),
                                    'isi' => nl2br($row['isi']), // Isi lengkap
                                    'gambar' => $has_image ? $gambar_path : null
                                ];

                                // 3. Proses Pemotongan Teks untuk tampilan awal
                                $isi_lengkap = $row['isi'];
                                $isi_singkat = "";
                                $limit_karakter = 250;

                                if (strlen($isi_lengkap) > $limit_karakter) {
                                    $stringCut = substr($isi_lengkap, 0, $limit_karakter);
                                    $endPoint = strrpos($stringCut, ' ');
                                    $isi_singkat = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                    $isi_singkat .= '...';
                                } else {
                                    $isi_singkat = $isi_lengkap;
                                }
                        ?>
                                <div class="cnt-box cnt-box-blog boxed" style="margin-bottom: 30px;">
                                    <?php if ($has_image): ?>
                                        <a href="#" class="img-box overlay-link" data-id="<?php echo $row['id']; ?>">
                                            <img src="<?php echo $gambar_path; ?>" alt="<?php echo htmlspecialchars($row['judul']); ?>">
                                        </a>
                                    <?php endif; ?>
                                    <div class="caption">
                                        <div class="extra-field"><?php echo date('d F Y', strtotime($row['tanggal'])); ?></div>
                                        <h2><a href="#" class="overlay-link" style="text-decoration:none; color:inherit;" data-id="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['judul']); ?></a></h2>
                                        
                                        <p><?php echo nl2br(htmlspecialchars($isi_singkat)); ?></p>

                                        <?php if (strlen($isi_lengkap) > $limit_karakter): ?>
                                            <a href="#" class="btn-text btn-read-more overlay-link" data-id="<?php echo $row['id']; ?>">Baca Selengkapnya</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                            echo "<p class='text-center'>Belum ada pengumuman terbaru.</p>";
                        }
                        ?>
                    </div>

                    <div class="col-lg-4 col-md-12">
                        <div class="cnt-box cnt-box-side-icon-box boxed" style="padding: 20px; margin-bottom: 30px;">
                            <i class="im-information"></i>
                            <div class="caption">
                                <h3>Info Sekolah</h3>
                                <p>Halaman ini berisi informasi dan pengumuman resmi dari SMP Negeri 5 Semarang.</p>
                            </div>
                        </div>
                        
                        <div class="cnt-box cnt-box-side-icon-box boxed" style="padding: 20px; margin-bottom: 30px;">
                            <i class="im-newspaper"></i>
                            <div class="caption">
                                <h3>Pengumuman Terbaru</h3>
                                <ul class="list-links">
                                    <?php
                                    if (isset($result) && mysqli_num_rows($result) > 0) {
                                        mysqli_data_seek($result, 0); 
                                        $counter = 0;
                                        
                                        while ($row_latest = mysqli_fetch_assoc($result)) {
                                            if ($counter >= 5) break;
                                            // Link di sidebar juga menggunakan class 'overlay-link'
                                            echo '<li><a href="#" class="overlay-link" data-id="' . $row_latest['id'] . '">' . htmlspecialchars($row_latest['judul']) . '</a></li>';
                                            $counter++;
                                        }
                                    } else {
                                        echo "<li>Tidak ada pengumuman.</li>";
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>

                        <div class="cnt-box cnt-box-side-icon-box boxed" style="padding: 20px;">
                            <i class="im-phone-2"></i>
                            <div class="caption">
                                <h3>Hubungi Kami</h3>
                                <p style="margin-bottom: 10px;">
                                    Email: smpn5@semarangkota.go.id<br>
                                    Telepon: (024) 8315140
                                </p>
                                <a href="contacts.php" class="btn-text">Kirim Pesan</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php
    include 'footer.php';
    mysqli_close($conn);
    ?>
    
    <div id="announcement-overlay" class="overlay-container">
        <div class="overlay-content cnt-box cnt-box-blog">
            <span class="close-btn">&times;</span>
            <div id="overlay-body">
                </div>
        </div>
    </div>

    <script src="themekit/scripts/parallax.min.js"></script>
    <script src="themekit/scripts/glide.min.js"></script>
    
    <script>
        // Mengirim data PHP lengkap ke variabel JavaScript (Overlay)
        var announcementsData = <?php echo json_encode($all_announcements); ?>;

        // --- BARU UNTUK SLIDER: Mengirim array gambar PHP ke JavaScript ---
        var dbImages = <?php echo json_encode($slider_images_php); ?>;
        // -----------------------------------------------------------------

        $(document).ready(function() {
            // === Script untuk Header Dinamis (DIMODIFIKASI) ===
            
            var images = []; // Inisialisasi array kosong

            // Cek apakah ada gambar dari database
            if (dbImages.length > 0) {
                // Jika ada, gunakan gambar dari DB
                images = dbImages; 
            } else {
                // --- BARU UNTUK SLIDER: Fallback Images ---
                // Jika TIDAK ADA gambar dari database, gunakan gambar default ini
                images = [
                    'media/backgroundgalery.jpeg',
                    'media/hut.jpg'
                    // Tambahkan gambar default lain jika perlu
                ];
            }

            var currentImage = 0;
            var heroSlider = $('#hero-slider');

            // Set gambar pertama kali saat halaman dimuat
            if (images.length > 0) {
                heroSlider.css('background-image', 'url("' + images[0] + '")');
            } else {
                 // Jika benar-benar tidak ada gambar sama sekali (DB kosong, default kosong)
                heroSlider.css('background-color', '#336699');
            }

            // Fungsi untuk mengganti background
            if (images.length > 1) {
                function changeBackground() {
                    currentImage = (currentImage + 1) % images.length;
                    heroSlider.css('background-image', 'url("' + images[currentImage] + '")');
                }
                // Jalankan interval hanya jika ada lebih dari 1 gambar
                setInterval(changeBackground, 5000); // Ubah angka 5000 (ms) untuk mengatur kecepatan
            }

            // === Script untuk Overlay (Modal) ===
            // (Bagian ini tidak berubah dari kode sebelumnya)
            $('.overlay-link').on('click', function(e) {
                e.preventDefault(); 

                var id = $(this).data('id'); 
                var data = announcementsData[id]; 

                if (data) {
                    var htmlContent = '';
                    if (data.gambar) {
                        htmlContent += '<div class="img-box"><img src="' + data.gambar + '" alt="' + data.judul + '" style="max-height:400px; width:100%; object-fit:contain; margin-bottom:20px;"></div>';
                    }
                    htmlContent += '<div class="caption">';
                    htmlContent += '<div class="extra-field">' + data.tanggal + '</div>';
                    htmlContent += '<h2>' + data.judul + '</h2>';
                    htmlContent += '<div>' + data.isi + '</div>';
                    htmlContent += '</div>';

                    $('#overlay-body').html(htmlContent);
                    $('#announcement-overlay').css('display', 'flex');
                }
            });

            $('.close-btn').on('click', function() {
                $('#announcement-overlay').hide();
            });

            $('#announcement-overlay').on('click', function(e) {
                if (e.target === this) {
                    $(this).hide();
                }
            });
        });
    </script>
</body>
</html>