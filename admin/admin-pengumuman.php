<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
include '../config.php';
$pesan = "";

// --- LOGIKA BARU UNTUK MODE EDIT ---
$is_editing = false;
// Nilai default untuk form (agar tidak error saat mode 'buat baru')
$edit_data = ['id' => '', 'judul' => '', 'isi' => '', 'tanggal' => '', 'gambar' => '']; 

// 1. CEK JIKA KITA DALAM MODE EDIT (ADA ?edit_id=... DI URL)
if (isset($_GET['edit_id'])) {
    $is_editing = true;
    $id_to_edit = intval($_GET['edit_id']);
    
    // Ambil data yang ada untuk ditampilkan di form
    $stmt_edit = $conn->prepare("SELECT id, judul, isi, tanggal, gambar FROM pengumuman WHERE id = ?");
    $stmt_edit->bind_param("i", $id_to_edit);
    $stmt_edit->execute();
    $result_edit = $stmt_edit->get_result();
    if ($result_edit->num_rows > 0) {
        $edit_data = $result_edit->fetch_assoc();
    }
    $stmt_edit->close();
}


// --- MODIFIKASI PROSES SIMPAN (BISA UPDATE / INSERT) ---
if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $tanggal = $_POST['tanggal'];
    
    // Cek apakah ini UPDATE atau INSERT
    $id_update = isset($_POST['id_update']) ? intval($_POST['id_update']) : 0;
    
    // Ambil nama gambar lama (jika ada)
    $gambar_lama = isset($_POST['gambar_lama']) ? $_POST['gambar_lama'] : '';
    $gambar = $gambar_lama; // Default: pakai gambar lama
    $upload_dir = '../upload/'; // Tentukan direktori upload

    // 2. CEK JIKA ADA GAMBAR BARU DIUPLOAD
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
        
        $nama_file = $_FILES['gambar']['name'];
        $nama_file_unik = time() . '-' . basename($nama_file);
        $target_file = $upload_dir . $nama_file_unik;

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            $gambar = $nama_file_unik; // Gunakan nama gambar baru
            
            // Hapus gambar lama jika ada DAN beda nama
            if (!empty($gambar_lama) && file_exists($upload_dir . $gambar_lama) && $gambar_lama != $gambar) {
                unlink($upload_dir . $gambar_lama);
            }
        }
    }

    if ($id_update > 0) {
        // --- 3. INI LOGIKA UPDATE ---
        $stmt = $conn->prepare("UPDATE pengumuman SET judul = ?, isi = ?, tanggal = ?, gambar = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $judul, $isi, $tanggal, $gambar, $id_update);
        if($stmt->execute()) {
            $pesan = "Pengumuman berhasil diperbarui.";
        } else {
            $pesan = "Gagal memperbarui pengumuman.";
        }
        $stmt->close();
        // Redirect kembali ke halaman utama
        header("Location: admin-pengumuman.php?pesan=" . urlencode($pesan));
        exit;

    } else {
        // --- 4. INI LOGIKA INSERT (YANG SUDAH ADA) ---
        $stmt = $conn->prepare("INSERT INTO pengumuman (judul, isi, tanggal, gambar) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $judul, $isi, $tanggal, $gambar);
        if($stmt->execute()) {
            $pesan = "Pengumuman berhasil ditambahkan.";
        } else {
            $pesan = "Gagal menambahkan pengumuman.";
        }
        $stmt->close();
        // Redirect agar rapi
        header("Location: admin-pengumuman.php?pesan=" . urlencode($pesan));
        exit;
    }
}


// --- MODIFIKASI LOGIKA HAPUS (PATH GAMBAR) ---
if (isset($_GET['hapus_id'])) {
    $id_hapus = $_GET['hapus_id'];
    $upload_dir = '../upload/'; // // PERBAIKAN: Definisikan path yang konsisten
    
    // Ambil nama file untuk dihapus dari folder
    $stmt_get = $conn->prepare("SELECT gambar FROM pengumuman WHERE id = ?");
    $stmt_get->bind_param("i", $id_hapus);
    $stmt_get->execute();
    $result_get = $stmt_get->get_result();
    if($row = $result_get->fetch_assoc()){
        // PERBAIKAN: Gunakan path yang benar
        if(!empty($row['gambar']) && file_exists($upload_dir . $row['gambar'])){
            unlink($upload_dir . $row['gambar']);
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
    <title>Admin - <?= $is_editing ? 'Edit' : 'Kelola' ?> Pengumuman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Kelola Pengumuman</h2>
        <a href="../dashboard-adm.php" class="btn btn-primary rounded-pill shadow-sm" style="padding: 8px 20px; font-weight: 500;">
            Kembali ke Admin Panel
        </a>
    </div>


    <?php if (!empty($pesan) || isset($_GET['pesan'])): ?>
        <div class="alert alert-info alert-dismissible fade show"><?php echo htmlspecialchars(isset($_GET['pesan']) ? $_GET['pesan'] : $pesan); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white"><?= $is_editing ? 'Edit Pengumuman' : 'Buat Pengumuman Baru' ?></div>
        <div class="card-body">
            <form method="post" action="admin-pengumuman.php" enctype="multipart/form-data">
                
                <?php if ($is_editing): ?>
                    <input type="hidden" name="id_update" value="<?= $edit_data['id'] ?>">
                    <input type="hidden" name="gambar_lama" value="<?= htmlspecialchars($edit_data['gambar']) ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($edit_data['judul']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Isi Pengumuman</label>
                    <textarea name="isi" class="form-control" rows="5" required><?= htmlspecialchars($edit_data['isi']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar (Opsional)</label>
                    
                    <?php if ($is_editing && !empty($edit_data['gambar'])): ?>
                        <div class="mb-2">
                            <img src="../upload/<?= htmlspecialchars($edit_data['gambar']) ?>" width="150" class="img-thumbnail">
                            <p class="text-muted small">Gambar saat ini. Unggah file baru untuk mengganti.</p>
                        </div>
                    <?php endif; ?>
                    
                    <input class="form-control" type="file" id="gambar" name="gambar" accept="image/*">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Terbit</label>
                    <input type="date" name="tanggal" class="form-control" value="<?= htmlspecialchars($edit_data['tanggal']) ?>" required>
                </div>
                
                <button type="submit" name="simpan" class="btn btn-primary"><?= $is_editing ? 'Update Pengumuman' : 'Terbitkan' ?></button>
                <?php if ($is_editing): ?>
                    <a href="admin-pengumuman.php" class="btn btn-secondary">Batal Edit</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Daftar Pengumuman</div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead><tr><th>Gambar</th><th>Judul</th><th>Tanggal</th><th style="width: 140px;">Aksi</th></tr></thead>
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
                        
                        <td class="align-middle">
                            <div class="btn-group" role="group">
                                <a href="admin-pengumuman.php?edit_id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-fill"></i> Edit
                                </a>
                                <a href="admin-pengumuman.php?hapus_id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus pengumuman ini?')">
                                    <i class="bi bi-trash-fill"></i> Hapus
                                </a>
                            </div>
                        </td>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>