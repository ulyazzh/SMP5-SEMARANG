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
// Nilai default untuk form
$edit_data = ['id' => '', 'nama' => '', 'mapel' => '', 'foto' => '']; 

// 1. CEK JIKA KITA DALAM MODE EDIT (ADA ?edit_id=... DI URL)
if (isset($_GET['edit_id'])) {
    $is_editing = true;
    $id_to_edit = intval($_GET['edit_id']);
    
    // Ambil data yang ada untuk ditampilkan di form
    $stmt_edit = $conn->prepare("SELECT id, nama, mapel, foto FROM guru WHERE id = ?");
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
    $nama = $_POST['nama'];
    $mapel = $_POST['mapel'];
    
    // Cek apakah ini UPDATE atau INSERT
    $id_update = isset($_POST['id_update']) ? intval($_POST['id_update']) : 0;
    
    // Ambil nama foto lama (jika ada)
    $foto_lama = isset($_POST['foto_lama']) ? $_POST['foto_lama'] : '';
    $foto = $foto_lama; // Default: pakai foto lama
    $upload_dir = '../upload/'; // Tentukan direktori upload

    // 2. CEK JIKA ADA FOTO BARU DIUPLOAD
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
        
        $nama_file = $_FILES['foto']['name'];
        // PERBAIKAN: Buat nama file unik
        $nama_file_unik = time() . '-' . basename($nama_file);
        $target_file = $upload_dir . $nama_file_unik;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
            $foto = $nama_file_unik; // Gunakan nama foto baru
            
            // Hapus foto lama jika ada DAN beda nama
            if (!empty($foto_lama) && file_exists($upload_dir . $foto_lama) && $foto_lama != $foto) {
                unlink($upload_dir . $foto_lama);
            }
        }
    }

    if ($id_update > 0) {
        // --- 3. INI LOGIKA UPDATE ---
        // PERBAIKAN KEAMANAN: Gunakan Prepared Statements
        $stmt = $conn->prepare("UPDATE guru SET nama = ?, mapel = ?, foto = ? WHERE id = ?");
        $stmt->bind_param("sssi", $nama, $mapel, $foto, $id_update);
        if($stmt->execute()) {
            $pesan = "Data guru berhasil diperbarui.";
        } else {
            $pesan = "Gagal memperbarui data guru.";
        }
        $stmt->close();

    } else {
        // --- 4. INI LOGIKA INSERT ---
        // PERBAIKAN KEAMANAN: Gunakan Prepared Statements
        $stmt = $conn->prepare("INSERT INTO guru (nama, mapel, foto) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nama, $mapel, $foto);
        if($stmt->execute()) {
            $pesan = "Data guru berhasil ditambahkan.";
        } else {
            $pesan = "Gagal menambahkan data guru.";
        }
        $stmt->close();
    }
    
    // Redirect agar rapi
    header("Location: admin-profil-guru.php?pesan=" . urlencode($pesan));
    exit;
}


// --- LOGIKA BARU UNTUK HAPUS ---
if (isset($_GET['hapus_id'])) {
    $id_hapus = intval($_GET['hapus_id']);
    $upload_dir = '../upload/'; 
    
    // Ambil nama file untuk dihapus dari folder
    $stmt_get = $conn->prepare("SELECT foto FROM guru WHERE id = ?");
    $stmt_get->bind_param("i", $id_hapus);
    $stmt_get->execute();
    $result_get = $stmt_get->get_result();
    if($row = $result_get->fetch_assoc()){
        if(!empty($row['foto']) && file_exists($upload_dir . $row['foto'])){
            unlink($upload_dir . $row['foto']);
        }
    }
    $stmt_get->close();

    // Hapus data dari database
    $stmt_delete = $conn->prepare("DELETE FROM guru WHERE id = ?");
    $stmt_delete->bind_param("i", $id_hapus);
    if($stmt_delete->execute()) {
        $pesan = "Data guru berhasil dihapus.";
    } else {
        $pesan = "Gagal menghapus data guru.";
    }
    $stmt_delete->close();
    header("Location: admin-profil-guru.php?pesan=" . urlencode($pesan));
    exit;
}

// Ambil data untuk ditampilkan di tabel
$result = mysqli_query($conn, "SELECT * FROM guru ORDER BY nama ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - <?= $is_editing ? 'Edit' : 'Kelola' ?> Profil Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        /* (Style Anda yang lain bisa ditaruh di sini) */
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Kelola Profil Guru</h2>
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
            <?= $is_editing ? 'Edit Data Guru' : 'Tambah Data Guru' ?>
        </div>
        <div class="card-body">
            <form method="post" action="admin-profil-guru.php" enctype="multipart/form-data">
                
                <?php if ($is_editing): ?>
                    <input type="hidden" name="id_update" value="<?= $edit_data['id'] ?>">
                    <input type="hidden" name="foto_lama" value="<?= htmlspecialchars($edit_data['foto']) ?>">
                <?php endif; ?>
                
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($edit_data['nama']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mata Pelajaran</label>
                    <input type="text" name="mapel" class="form-control" value="<?= htmlspecialchars($edit_data['mapel']) ?>" required>
                </div>
                <div class="mb-3">
                            <label class="form-label">Foto</label>
                            
                            <?php
                            // Tentukan path foto default
                            $path_foto_default = '../upload/default-avatar.jpg'; 
                            $path_foto_tampil = $path_foto_default; // Default
                            $keterangan_foto = 'Ini adalah foto default. Unggah file untuk menambahkan foto.';
                            
                            if ($is_editing) {
                                if (!empty($edit_data['foto']) && file_exists('../upload/' . $edit_data['foto'])) {
                                    $path_foto_tampil = '../upload/' . htmlspecialchars($edit_data['foto']);
                                    $keterangan_foto = 'Foto saat ini. Unggah file baru untuk mengganti.';
                                }
                                // Jika $is_editing tapi fotonya kosong, $path_foto_tampil akan tetap default
                            }
                            ?>
                            
                            <?php if ($is_editing): ?>
                            <div class="mb-2">
                                <img src="<?= htmlspecialchars($path_foto_tampil) ?>" width="100" class="img-thumbnail">
                                <p class="text-muted small"><?= $keterangan_foto ?></p>
                            </div>
                            <?php endif; ?>
                            
                            <input type="file" name="foto" class="form-control" accept="image/*">
                        </div>
                
                <button type="submit" name="simpan" class="btn btn-success"><?= $is_editing ? 'Update Data' : 'Simpan' ?></button>
                <?php if ($is_editing): ?>
                    <a href="admin-profil-guru.php" class="btn btn-secondary">Batal Edit</a>
                <?php endif; ?>
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
                        <th style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td class="align-middle"><?= $no++ ?></td>
                        <td class="align-middle">
                        <?php
                        // Tentukan path foto default
                        $path_foto = '../upload/default-avatar.jpg'; 

                        // Cek jika foto ada dan filenya ada di server
                        if (!empty($row['foto']) && file_exists('../upload/' . $row['foto'])) {
                            $path_foto = '../upload/' . $row['foto'];
                        }
                        ?>
                        <img src="<?= htmlspecialchars($path_foto) ?>" width="80" class="img-thumbnail" alt="Foto <?= htmlspecialchars($row['nama']) ?>">
                    </td>
                        <td class="align-middle"><?= htmlspecialchars($row['nama']) ?></td>
                        <td class="align-middle"><?= htmlspecialchars($row['mapel']) ?></td>
                        
                        <td class="align-middle">
                            <div class="btn-group" role="group">
                                <a href="admin-profil-guru.php?edit_id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-fill"></i> Edit
                                </a>
                                <a href="admin-profil-guru.php?hapus_id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    <i class="bi bi-trash-fill"></i> Hapus
                                </a>
                            </div>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>