<?php
include '../config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil nama file foto sebelum menghapus record
    $query_get_foto = "SELECT foto FROM guru WHERE id = $id";
    $result_get_foto = mysqli_query($conn, $query_get_foto);
    $row_foto = mysqli_fetch_assoc($result_get_foto);
    $foto_to_delete = $row_foto['foto'];

    // Hapus record dari database
    $query_delete = "DELETE FROM guru WHERE id = $id";
    if (mysqli_query($conn, $query_delete)) {
        // Hapus file foto dari server
        $folder = "../upload/";
        if (!empty($foto_to_delete) && file_exists($folder . $foto_to_delete)) {
            unlink($folder . $foto_to_delete);
        }
        header("Location: admin-profil-guru.php"); // Alihkan kembali ke halaman utama
        exit();
    } else {
        echo "Error menghapus data: " . mysqli_error($conn);
    }
} else {
    header("Location: admin-profil-guru.php"); // Alihkan jika tidak ada ID yang diberikan
    exit();
}
?>