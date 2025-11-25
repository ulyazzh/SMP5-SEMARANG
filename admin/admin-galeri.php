<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
include '../config.php';
$pesan = "";
$upload_dir = '../upload/'; // Definisikan path upload

// --- LOGIKA BARU UNTUK MODE EDIT ---
$is_editing = false;
// Nilai default untuk form
$edit_data = ['id' => '', 'keterangan' => '', 'nama_file' => '']; 

// 1. CEK JIKA KITA DALAM MODE EDIT (ADA ?edit_id=... DI URL)
if (isset($_GET['edit_id'])) {
    $is_editing = true;
    $id_to_edit = intval($_GET['edit_id']);
    
    // Ambil data yang ada untuk ditampilkan di form
    $stmt_edit = $conn->prepare("SELECT id, keterangan, nama_file FROM galeri WHERE id = ?");
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
    
    // Cek apakah ini UPDATE atau INSERT
    $id_update = isset($_POST['id_update']) ? intval($_POST['id_update']) : 0;
    $keterangan = $_POST['keterangan'];

    if ($id_update > 0) {
        // --- 3. INI LOGIKA UPDATE (Hanya update keterangan) ---
        $stmt = $conn->prepare("UPDATE galeri SET keterangan = ? WHERE id = ?");
        $stmt->bind_param("si", $keterangan, $id_update);
        if($stmt->execute()) {
            $pesan = "Keterangan foto berhasil diperbarui.";
        } else {
            $pesan = "Gagal memperbarui keterangan.";
        }
        $stmt->close();

    } else {
        // --- 4. INI LOGIKA INSERT (UPLOAD FOTO BARU) ---
        
        // Cek jika ada file gambar yang diunggah
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
            
            $nama_file = $_FILES['gambar']['name'];
            $nama_file_unik = time() . '-' . basename($nama_file);
            $target_file = $upload_dir . $nama_file_unik;

            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
                // Simpan ke database
                $stmt = $conn->prepare("INSERT INTO galeri (nama_file, keterangan, tanggal_upload) VALUES (?, ?, NOW())");
                $stmt->bind_param("ss", $nama_file_unik, $keterangan);
                if($stmt->execute()) {
                    $pesan = "Foto berhasil diunggah.";
                } else {
                    $pesan = "Gagal menyimpan data ke database.";
                }
                $stmt->close();
            } else {
                $pesan = "Gagal memindahkan file yang diunggah.";
            }
        } else {
            $pesan = "Tidak ada file yang diunggah atau terjadi error.";
        }
    }
    
    // Redirect agar rapi
    header("Location: admin-galeri.php?pesan=" . urlencode($pesan));
    exit;
}


// --- LOGIKA HAPUS (Sudah ada, tapi kita perbaiki) ---
if (isset($_GET['hapus_id'])) {
    $id_hapus = intval($_GET['hapus_id']);
    
    // Ambil nama file untuk dihapus dari folder
    $stmt_get = $conn->prepare("SELECT nama_file FROM galeri WHERE id = ?");
    $stmt_get->bind_param("i", $id_hapus);
    $stmt_get->execute();
    $result_get = $stmt_get->get_result();
    if($row = $result_get->fetch_assoc()){
        if(!empty($row['nama_file']) && file_exists($upload_dir . $row['nama_file'])){
            unlink($upload_dir . $row['nama_file']); // Hapus file fisik
        }
    }
    $stmt_get->close();

    // Hapus data dari database
    $stmt_delete = $conn->prepare("DELETE FROM galeri WHERE id = ?");
    $stmt_delete->bind_param("i", $id_hapus);
    if($stmt_delete->execute()) {
        $pesan = "Foto berhasil dihapus.";
    } else {
        $pesan = "Gagal menghapus foto.";
    }
    $stmt_delete->close();
    header("Location: admin-galeri.php?pesan=" . urlencode($pesan));
    exit;
}

// Ambil data untuk ditampilkan di galeri
$result = mysqli_query($conn, "SELECT * FROM galeri ORDER BY tanggal_upload DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - <?= $is_editing ? 'Edit' : 'Kelola' ?> Galeri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        .gallery-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Kelola Galeri</h2>
        <a href="../dashboard-adm.php" class="btn btn-primary rounded-pill shadow-sm" style="padding: 8px 20px; font-weight: 500;">
            <i class="bi bi-arrow-left-circle-fill"></i> Kembali ke Admin Panel
        </a>
    </div>

    <?php if (isset($_GET['pesan'])): ?>
        <div class="alert alert-info alert-dismissible fade show">
            <?php echo htmlspecialchars($_GET['pesan']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <?= $is_editing ? 'Edit Keterangan Foto' : 'Upload Foto Baru' ?>
        </div>
        <div class="card-body">
            <form method="post" action="admin-galeri.php" enctype="multipart/form-data">
                
                <?php if ($is_editing): ?>
                    <input type="hidden" name="id_update" value="<?= $edit_data['id'] ?>">
                    <div class="mb-3">
                        <label class="form-label">Foto:</label><br>
                        <img src="../upload/<?= htmlspecialchars($edit_data['nama_file']) ?>" width="150" class="img-thumbnail">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" value="<?= htmlspecialchars($edit_data['keterangan']) ?>" required>
                    </div>
                <?php else: ?>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Pilih Foto</label>
                        <input class="form-control" type="file" id="gambar" name="gambar" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" placeholder="Tulis keterangan singkat foto..." required>
                    </div>
                <?php endif; ?>
                
                <button type="submit" name="simpan" class="btn btn-success"><?= $is_editing ? 'Update Keterangan' : 'Upload' ?></button>
                <?php if ($is_editing): ?>
                    <a href="admin-galeri.php" class="btn btn-secondary">Batal Edit</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-secondary text-white">
            Daftar Foto di Galeri
        </div>
        <div class="card-body">
            <div class="row g-4">
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 shadow-sm">
                        <img src="../upload/<?= htmlspecialchars($row['nama_file']) ?>" class="card-img-top gallery-img" alt="<?= htmlspecialchars($row['keterangan']) ?>">
                        <div class="card-body">
                            <h5 class="card-title" style="font-size: 1rem;"><?= htmlspecialchars($row['keterangan']) ?></h5>
                            <p class="card-text text-muted small"><?= date('d M Y', strtotime($row['tanggal_upload'])) ?></p>
                        </div>
                        <div class="card-footer bg-white border-0 p-3">
                            <div class="btn-group w-100" role="group">
                                <a href="admin-galeri.php?edit_id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-fill"></i> Edit
                                </a>
                                <a href="admin-galeri.php?hapus_id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus foto ini?')">
                                    <i class="bi bi-trash-fill"></i> Hapus
                                </a>
                            </div>
                            </div>
                    </div>
                </div>
                <?php
                    }
                } else {
                    echo "<p class='col-12 text-center'>Tidak ada foto di galeri.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>