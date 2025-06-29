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

<!-- Link Bootstrap Icons (jika belum ada) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<a href="../dashboard-adm.php" class="btn btn-primary rounded-pill shadow-sm mb-3" style="padding: 8px 20px; font-weight: 500; margin-top: 20px; margin-left: 20px;">
    <i class="bi bi-arrow-left-circle-fill"></i> Kembali ke Admin Panel
</a>

<style>
    .btn-outline-primary:hover {
        background-color: #0d6efd;
        color: white;
        transform: scale(1.05);
    }
    
</style>



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
