<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
include '../config.php';
$pesan = "";

// PROSES UPLOAD FOTO
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto'])) {
    $keterangan = $_POST['keterangan'] ?? '';
    $nama_file = $_FILES['foto']['name'];
    $tmp_file = $_FILES['foto']['tmp_name'];
    $upload_dir = '../upload/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

    $nama_file_unik = time() . '-' . basename($nama_file);
    if (move_uploaded_file($tmp_file, $upload_dir . $nama_file_unik)) {
        $stmt = $conn->prepare("INSERT INTO galeri (nama_file, keterangan) VALUES (?, ?)");
        $stmt->bind_param("ss", $nama_file_unik, $keterangan);
        if ($stmt->execute()) $pesan = "Foto berhasil diunggah.";
        else $pesan = "Gagal menyimpan data.";
        $stmt->close();
    }
}

// PROSES HAPUS FOTO
if (isset($_GET['hapus_id'])) {
    $id_hapus = $_GET['hapus_id'];
    $stmt_get = $conn->prepare("SELECT nama_file FROM galeri WHERE id = ?");
    $stmt_get->bind_param("i", $id_hapus);
    $stmt_get->execute();
    $result_get = $stmt_get->get_result();
    if ($row = $result_get->fetch_assoc()) {
        $file_path = 'uploads/galeri/' . $row['nama_file'];
        if (file_exists($file_path)) unlink($file_path);
    }
    $stmt_get->close();

    $stmt_delete = $conn->prepare("DELETE FROM galeri WHERE id = ?");
    $stmt_delete->bind_param("i", $id_hapus);
    if ($stmt_delete->execute()) $pesan = "Foto berhasil dihapus.";
    $stmt_delete->close();
    header("Location: admin-galeri.php?pesan=" . urlencode($pesan));
    exit;
}

$result_select = mysqli_query($conn, "SELECT * FROM galeri ORDER BY tanggal_upload DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Kelola Galeri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Kelola Galeri Foto</h1>
        <a href="../dashboard-adm.php" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>

    <?php if (!empty($pesan) || isset($_GET['pesan'])): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars(isset($_GET['pesan']) ? $_GET['pesan'] : $pesan); ?></div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Upload Foto Baru</div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan Foto (Opsional)</label>
                    <input type="text" class="form-control" id="keterangan" name="keterangan">
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Pilih File Gambar</label>
                    <input class="form-control" type="file" id="foto" name="foto" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Daftar Foto di Galeri</div>
        <div class="card-body">
            <div class="row">
                <?php if ($result_select && mysqli_num_rows($result_select) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result_select)): ?>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <img src="../upload/<?php echo htmlspecialchars($row['nama_file']); ?>" class="card-img-top" style="height: 150px; object-fit: cover;">
                                <div class="card-body text-center">
                                    <p class="card-text small text-muted"><?php echo htmlspecialchars($row['keterangan']); ?></p>
                                    <a href="admin-galeri.php?hapus_id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm w-100" onclick="return confirm('Yakin ingin hapus foto ini?')">Hapus</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-center text-muted">Belum ada foto di galeri.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>