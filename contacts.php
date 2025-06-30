<!DOCTYPE html>
<html lang="id"> 
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kontak Kami - SMP 5 Semarang</title>
    <meta name="description" content="Halaman Kontak SMP 5 Semarang">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
                    <li class="dropdown"><a href="index.html">Beranda</a></li>
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
                    <li class="dropdown"><a href="ekstrakurikuler.html">Ekstrakurikuler</a></li>
                    <li class="dropdown"><a href="galeri.php">Galeri</a></li>
                    <li><a href="pengumuman.php ">Pengumuman</a></li>
                    <li class="active"><a href="contacts.php">Kontak</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main>
        <section class="section-base">
            <div class="container">
                <div id="map" style="height: 400px;"></div>
                <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
                <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>

                <script>
                var map = L.map('map').setView([-6.9902602,110.4004778], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);
                var marker = L.marker([-7.010739274794841, 110.41704787879696]).addTo(map);
                marker.bindPopup("Lokasi SMP 5 Semarang").openPopup();
                </script>

                <hr class="space" />
                <div class="row">
                    <div class="col-lg-8">
                        <div class="title">
                            <h2>Hubungi kami disini</h2>
                        </div>

                        <?php
                        if (isset($_GET['status'])) {
                            if ($_GET['status'] == 'success') {
                                echo '<div class="alert alert-success">Pesan Anda telah berhasil terkirim.</div>';
                            } elseif ($_GET['status'] == 'error') {
                                echo '<div class="alert alert-warning">Maaf, Pesan Anda belum berhasil terkirim.</div>';
                            }
                        }
                        ?>

                        <form action="contact_process.php" class="form-box" method="post">
                            <div class="row">
                                <div class="col-lg-6">
                                    <p>Nama</p>
                                    <input id="name" name="name" placeholder="Nama" type="text" class="input-text" required>
                                </div>
                                <div class="col-lg-6">
                                    <p>Email</p>
                                    <input id="email" name="email" placeholder="Email" type="email" class="input-text" required>
                                </div>
                            </div>
                            <p>Pesan</p>
                            <textarea id="message" name="message" class="input-textarea" placeholder="Tulis sesuatu ..." required></textarea>
                            <button class="btn btn-sm" type="submit">Kirim Pesan</button>
                        </form>
                    </div>
                    <div class="col-lg-4">
                        <div class="title">
                            <h2>Kontak</h2>
                        </div>
                        <div class="contact-info">
                            <p><strong>Alamat:</strong> Jl. Sultan Agung No. 9 Candisari Kota Semarang</p>
                            <p><strong>Email:</strong> smpn5.semarangkota.go.id/</p>
                            <p><strong>Telp:</strong> (024) 8315140</p>
                        </div>
                        <hr class="space-sm" />
                        <div class="icon-links icon-social icon-links-grid social-colors-hover">
                            <a href="https://www.facebook.com/profile.php?id=100061439505169" target="_blank" rel="noopener noreferrer"><i class="icon-facebook"></i></a>
                            <a href="https://www.instagram.com/smpn5semarangofficial/" target="_blank" rel="noopener noreferrer"><i class="icon-instagram"></i></a>
                            <a href="https://www.instagram.com/smpn5semarangofficial/" target="_blank" rel="noopener noreferrer"><i class="icon-google"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer class="light">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <h3>SMP 5 Semarang</h3>
                    <p>Sekolah menengah pertama di Kota Semarang, Jawa Tengah.</p>
                </div>
                <div class="col-lg-4">
                    <h3>Kontak</h3>
                    <ul class="icon-list icon-line">
                        <li>smpn5@semarangkota.go.id</li>
                        <li>(024) 8315140</li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <div class="icon-links icon-social icon-links-grid social-colors-hover">
                        <a href="https://www.facebook.com/profile.php?id=100061439505169" target="_blank" rel="noopener noreferrer"><i class="icon-facebook"></i></a>
                        <a href="https://www.instagram.com/smpn5semarangofficial/" target="_blank" rel="noopener noreferrer"><i class="icon-instagram"></i></a>
                        <a href="https://www.instagram.com/smpn5semarangofficial/" target="_blank" rel="noopener noreferrer"><i class="icon-google"></i></a>
                    </div>
                    <hr class="space-sm" />
                </div>
            </div>
        </div>
        <div class="footer-bar">
            <div class="container">
                <span>© 2025 SMP 5 Semarang</span>
                <span><a href="contacts.php">Contact us</a> | <a href="#">Privacy policy</a></span>
            </div>
        </div>
        <link rel="stylesheet" href="themekit/media/icons/iconsmind/line-icons.min.css">
        <script src="themekit/scripts/parallax.min.js"></script>
        <script src="themekit/scripts/glide.min.js"></script>
        <script src="themekit/scripts/progress.js"></script>
        <script src="themekit/scripts/magnific-popup.min.js"></script>
        <script src="themekit/scripts/contact-form/contact-form.js"></script>
        <script src='themekit/scripts/maps.min.js'></script>
        <script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyDl7p8SWg-5kLe7i-usdYCu5m3eVllMDTs'></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </footer>
</body>
</html>
