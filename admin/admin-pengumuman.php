<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
include '../config.php';
$pesan = "";

// PROSES SIMPAN PENGUMUMAN DENGAN GAMBAR
if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $tanggal = $_POST['tanggal'];
    $gambar = null;

    // Cek jika ada file gambar yang diunggah
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $upload_dir = '../upload/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
        
        $nama_file = $_FILES['gambar']['name'];
        $nama_file_unik = time() . '-' . basename($nama_file);
        $target_file = $upload_dir . $nama_file_unik;

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            $gambar = $nama_file_unik;
        }
    }

    $stmt = $conn->prepare("INSERT INTO pengumuman (judul, isi, tanggal, gambar) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $judul, $isi, $tanggal, $gambar);
    if($stmt->execute()) {
        $pesan = "Pengumuman berhasil ditambahkan.";
    } else {
        $pesan = "Gagal menambahkan pengumuman.";
    }
    $stmt->close();
}

// (Sisa kode untuk hapus dan select tetap sama)
if (isset($_GET['hapus_id'])) {
    $id_hapus = $_GET['hapus_id'];
    
    // Ambil nama file untuk dihapus dari folder
    $stmt_get = $conn->prepare("SELECT gambar FROM pengumuman WHERE id = ?");
    $stmt_get->bind_param("i", $id_hapus);
    $stmt_get->execute();
    $result_get = $stmt_get->get_result();
    if($row = $result_get->fetch_assoc()){
        if(!empty($row['gambar']) && file_exists('uploads/pengumuman/' . $row['gambar'])){
            unlink('uploads/pengumuman/' . $row['gambar']);
        }
    }
    $stmt_get->close();

    $stmt_delete = $conn->prepare("DELETE FROM pengumuman WHERE id = ?");
    $stmt_delete->bind_param("i", $id_hapus);
    if($stmt_delete->execute()) $pesan = "Pengumuman berhasil dihapus.";
    $stmt_delete->close();
    header("Location: admin-pengumuman.php?pesan=" . urlencode($pesan));
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM pengumuman ORDER BY tanggal DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Kelola Pengumuman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Kelola Pengumuman</h2>
        <a href="../dashboard-adm.php" class="btn btn-primary rounded-pill shadow-sm" style="padding: 8px 20px; font-weight: 500;">
            <i class="bi bi-arrow-left-circle-fill"></i> Kembali ke Admin Panel
        </a>
    </div>


    <?php if (!empty($pesan) || isset($_GET['pesan'])): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars(isset($_GET['pesan']) ? $_GET['pesan'] : $pesan); ?></div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Buat Pengumuman Baru</div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Isi Pengumuman</label>
                    <textarea name="isi" class="form-control" rows="5" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar (Opsional)</label>
                    <input class="form-control" type="file" id="gambar" name="gambar" accept="image/*">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Terbit</label>
                    <input type="date" name="tanggal" class="form-control" required>
                </div>
                <button type="submit" name="simpan" class="btn btn-primary">Terbitkan</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Daftar Pengumuman</div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead><tr><th>Gambar</th><th>Judul</th><th>Tanggal</th><th>Aksi</th></tr></thead>
                <tbody>
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td>
                            <?php if(!empty($row['gambar'])): ?>
                                <img src="../upload/<?= htmlspecialchars($row['gambar']) ?>" width="100" class="img-thumbnail">
                            <?php else: ?>
                                <span class="text-muted">No Image</span>
                            <?php endif; ?>
                        </td>
                        <td class="align-middle"><?= htmlspecialchars($row['judul']) ?></td>
                        <td class="align-middle"><?= date('d F Y', strtotime($row['tanggal'])) ?></td>
                        <td class="align-middle"><a href="admin-pengumuman.php?hapus_id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</a></td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="text-center">Belum ada pengumuman.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>