<?php
// Sertakan file konfigurasi database
// Pastikan path ke config.php sudah benar.
// Jika config.php ada di direktori yang sama, cukup 'config.php'
require_once '../config.php';

// Gunakan variabel koneksi yang sudah didefinisikan di config.php
// $koneksi adalah objek mysqli yang sudah terhubung ke database
$conn = $koneksi; // Ubah nama variabel agar konsisten jika diinginkan

$table_name = "contact_messages"; // Tabel yang Anda buat untuk pesan kontak

// Karena koneksi sudah dicek di config.php (dengan die()),
// kita bisa langsung melanjutkan jika sampai di sini.

$sql = "SELECT id, name, email, message, submission_date FROM $table_name ORDER BY submission_date DESC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Admin - SMP 5 Semarang</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; color: #555; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        p { color: #666; }
    </style>
</head>
<body>
    <h1>Pesan Kontak Masuk</h1>
    <?php
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<thead><tr><th>ID</th><th>Nama</th><th>Email</th><th>Pesan</th><th>Tanggal Kirim</th></tr></thead>";
        echo "<tbody>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . htmlspecialchars($row["name"]) . "</td>"; // Tambahkan htmlspecialchars
            echo "<td>" . htmlspecialchars($row["email"]) . "</td>"; // Tambahkan htmlspecialchars
            echo "<td>" . nl2br(htmlspecialchars($row["message"])) . "</td>"; // Tambahkan htmlspecialchars
            echo "<td>" . $row["submission_date"] . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>Tidak ada pesan yang masuk.</p>";
    }
    // Tutup koneksi database
    if ($conn) {
        $conn->close();
    }
    ?>
</body>
</html>