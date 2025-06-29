<?php
require_once 'config.php';

$conn = $koneksi;
$table_name = "contact_messages";

// --- DEBUGGING BARU ---
// Ini akan mencetak semua data yang diterima dari formulir ke respons
// Anda akan melihatnya di tab Network -> Response
error_log(print_r($_POST, true)); // Mencetak ke PHP error log
echo ""; // Mencetak sebagai komentar HTML
// --- AKHIR DEBUGGING BARU ---

// Periksa apakah formulir dikirim menggunakan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kumpulkan dan bersihkan data formulir
    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';
    $message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : '';

    // Validasi dasar
    if (empty($name) || empty($email) || empty($message)) {
        // Karena ini adalah respons AJAX, kita tidak boleh menggunakan die() secara langsung
        // agar JavaScript di frontend bisa memproses responsnya.
        echo json_encode(["success" => false, "message" => "Semua kolom wajib diisi."]);
        // Tidak perlu menutup koneksi di sini karena akan ditutup di bagian akhir skrip
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["success" => false, "message" => "Format email tidak valid."]);
        exit(); // Tidak perlu menutup koneksi di sini
    }

    // Persiapkan dan ikat pernyataan SQL untuk mencegah injeksi SQL
    $stmt = $conn->prepare("INSERT INTO $table_name (name, email, message) VALUES (?, ?, ?)");
    if ($stmt === false) {
        echo json_encode(["success" => false, "message" => "Gagal mempersiapkan pernyataan: " . $conn->error]);
        exit(); // Tidak perlu menutup koneksi di sini
    }
    $stmt->bind_param("sss", $name, $email, $message);

    // Jalankan pernyataan
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Pesan Anda telah berhasil terkirim."]);
    } else {
        echo json_encode(["success" => false, "message" => "Maaf, Pesan Anda belum berhasil terkirim. Error: " . $stmt->error]);
    }

    // Tutup pernyataan
    $stmt->close();
} else {
    // Jika bukan permintaan POST, kembalikan kesalahan
    echo json_encode(["success" => false, "message" => "Metode permintaan tidak valid."]);
}

// Tutup koneksi database di akhir skrip
if ($conn) {
    $conn->close();
}

?>