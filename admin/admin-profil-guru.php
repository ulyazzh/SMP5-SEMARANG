<?php
include '../config.php';

// Proses Simpan Data
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $mapel = $_POST['mapel'];

    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    $folder = "../upload/" . $foto;

    if (move_uploaded_file($tmp, $folder)) {
        $query = "INSERT INTO guru (nama, mapel, foto) VALUES ('$nama', '$mapel', '$foto')";
        mysqli_query($koneksi, $query);
    }
}
?>









<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


<body class="page-main">
    <div id="preloader"></div>
    <nav class="menu-classic menu-fixed menu-transparent light align-right" data-menu-anima="fade-in">
        <div class="container">
            <i class="menu-btn"></i>
            <div class="menu-cnt">
                <ul id="main-menu">
                    <li class="dropdown">
                        <a href="index-2.html">BERANDA</a>
                    </li>
                    <li class="dropdown">
                        <a href="#">PROFIL</a>
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
                            <li>
                                <a href="elements/components/buttons.html">Elements</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="ekstrakurikuler.html">Ekstrakurikuler</a>
                    <li>
                                        <li class="dropdown">
                        <a href="galeri.html">Galeri</a>
                    <li>
                        <a href="pengumuman.html">Pengumuman</a>
                    </li>
                    <li>
                        <a href="contacts.html">Kontak</a>
                    </li>
                    <li>
                        <a href="login.php">Login</a>
                    </li>
                  
            </div>
        </div>
    </nav>

<div class="container mt-5">
    <h2 class="mb-4">Kelola Profil Guru</h2>

    <!-- Form Tambah Guru -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Tambah Data Guru
        </div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mata Pelajaran</label>
                    <input type="text" name="mapel" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Foto</label>
                    <input type="file" name="foto" class="form-control" accept="image/*" required>
                </div>
                <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>

    <!-- Tabel Data Guru -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            Data Guru
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Mata Pelajaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            <tbody>

    <?php
        $result = mysqli_query($koneksi, "SELECT * FROM guru");
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
    ?>

 <tr>
            <td><?= $no++ ?></td>
            <td><img src="../upload/<?= $row['foto'] ?>" width="80"></td>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['mapel'] ?></td>
            <td>
                <a href="edit-guru.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="hapus-guru.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
