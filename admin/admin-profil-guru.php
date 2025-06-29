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
        // PERHATIAN: Ini masih rentan SQL Injection. Sangat disarankan menggunakan Prepared Statements.
        $query = "INSERT INTO guru (nama, mapel, foto) VALUES ('$nama', '$mapel', '$foto')";
        if (mysqli_query($koneksi, $query)) {
            // Redirect untuk mencegah resubmission form
            header("Location: admin-profil-guru.php");
            exit();
        } else {
            echo "<div class='alert alert-danger mt-3'>Error menyimpan data: " . mysqli_error($koneksi) . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger mt-3'>Error mengunggah foto. Pastikan file adalah gambar yang valid.</div>";
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
    <div class="d-flex justify-content-start mb-4">
        <a href="../dashboard-adm.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke admin panel
        </a>
    </div>

    <h2 class="mb-4">Kelola Profil Guru</h2>

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
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><img src="../upload/<?= htmlspecialchars($row['foto']) ?>" width="80" alt="Foto <?= htmlspecialchars($row['nama']) ?>"></td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['mapel']) ?></td>
                        <td>
                            <a href="edit-guru.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="hapus-guru.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>Tidak ada data guru.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>