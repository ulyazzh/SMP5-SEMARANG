<?php
include '../config.php';

// Ambil ID dari URL
$id = $_GET['id'];
$query = "SELECT * FROM guru WHERE id = $id";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);

// Proses Update Data
if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $mapel = $_POST['mapel'];
    $old_foto = $_POST['old_foto']; // Field tersembunyi untuk nama foto lama

    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    $folder = "../upload/";

    // Cek apakah ada foto baru diunggah
    if (!empty($foto)) {
        // Hapus foto lama jika ada
        if (file_exists($folder . $old_foto) && !empty($old_foto)) {
            unlink($folder . $old_foto);
        }
        move_uploaded_file($tmp, $folder . $foto);
        $update_query = "UPDATE guru SET nama='$nama', mapel='$mapel', foto='$foto' WHERE id=$id";
    } else {
        // Tidak ada foto baru, gunakan foto lama
        $update_query = "UPDATE guru SET nama='$nama', mapel='$mapel' WHERE id=$id";
    }

    if (mysqli_query($koneksi, $update_query)) {
        header("Location: admin-profil-guru.php"); // Alihkan kembali ke halaman utama
        exit();
    } else {
        echo "Error memperbarui data: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Edit Profil Guru</h2>

    <div class="card mb-4">
        <div class="card-header bg-warning text-white">
            Edit Data Guru
        </div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="old_foto" value="<?= $data['foto'] ?>">
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" value="<?= $data['nama'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mata Pelajaran</label>
                    <input type="text" name="mapel" class="form-control" value="<?= $data['mapel'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Foto Saat Ini</label><br>
                    <?php if (!empty($data['foto'])) : ?>
                        <img src="../upload/<?= $data['foto'] ?>" width="100" class="img-thumbnail mb-2"><br>
                    <?php else : ?>
                        <p>Tidak ada foto tersedia.</p>
                    <?php endif; ?>
                    <label class="form-label">Pilih Foto Baru (opsional)</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                </div>
                <button type="submit" name="update" class="btn btn-warning">Update</button>
                <a href="admin-profil-guru.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>