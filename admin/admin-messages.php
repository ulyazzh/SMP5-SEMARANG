<?php
$servername = "localhost";
$username = "root"; // Sesuaikan dengan username database Anda
$password = "";     // Sesuaikan dengan password database Anda
$dbname = "smp5_semarang"; // Nama database Anda seperti di screenshot

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// 2. Logika untuk Menghapus Pesan
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id_to_delete = intval($_GET['id']); 

    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Siapkan statement untuk menghapus data
    $stmt_delete = $conn->prepare("DELETE FROM contact_messages WHERE id = ?");

    if ($stmt_delete === false) { // Cek apakah prepare berhasil
        echo "Error preparing statement: " . $conn->error;
        exit(); // Hentikan eksekusi untuk melihat error ini
    }

    $stmt_delete->bind_param("i", $id_to_delete); // "i" for integer

    if ($stmt_delete->execute()) {
        $delete_status = "success";
        // echo "Pesan berhasil dihapus."; // Opsional: untuk melihat output langsung
    } else {
        $delete_status = "error";
        echo "Gagal menghapus pesan: " . $stmt_delete->error; // Tampilkan error SQL
        error_log("Error deleting message: " . $stmt_delete->error); // Untuk debugging log
        exit(); // Hentikan eksekusi untuk melihat error ini
    }
    $stmt_delete->close();

    // Redirect untuk menghilangkan parameter GET setelah delete (mencegah double submission)
    header("Location: admin-messages.php?delete_status=" . $delete_status);
    exit();
}

// 3. Ambil Data Pesan dari Database
// Ganti nama tabel jika Anda menggunakan nama yang berbeda (misal: 'messages')
$sql = "SELECT id, name, email, message, created_at FROM contact_messages ORDER BY created_at DESC"; // Urutkan dari terbaru
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel - Pesan Kontak</title>
    <link rel="stylesheet" href="themekit/css/bootstrap-grid.css">
    <link rel="stylesheet" href="themekit/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="media/logo-smp5.png">

    <style>
        /* Basic Admin Styling - Anda bisa menyempurnakan ini dengan CSS themekit Anda */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }
        .admin-container {
            max-width: 1200px;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        .admin-header {
            background-color: #007bff; /* Warna biru cerah */
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .admin-header .logo {
            font-size: 24px;
            font-weight: bold;
        }
        .admin-nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .admin-nav ul li {
            margin-left: 20px;
        }
        .admin-nav ul li a {
            color: white;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        .admin-nav ul li a:hover, .admin-nav ul li a.active {
            background-color: #0056b3; /* Biru lebih gelap saat hover/active */
        }
        .admin-content {
            padding: 20px;
        }
        h1 {
            color: #007bff;
            margin-bottom: 20px;
        }
        .message-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .message-table th, .message-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            vertical-align: top; /* Untuk pesan yang panjang */
        }
        .message-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .message-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .message-table tr:hover {
            background-color: #e9e9e9;
        }
        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-right: 5px;
            text-decoration: none; /* For anchor tags styled as buttons */
            display: inline-block; /* For anchor tags styled as buttons */
        }
        .btn-danger {
            background-color: #dc3545; /* Merah */
            color: white;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .btn-info {
            background-color: #17a2b8; /* Biru terang */
            color: white;
        }
        .btn-info:hover {
            background-color: #138496;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-weight: bold;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1000; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            max-width: 600px;
            border-radius: 8px;
            position: relative;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            animation-name: animatetop;
            animation-duration: 0.4s
        }
        /* Add Animation */
        @keyframes animatetop {
            from {top: -300px; opacity: 0}
            to {top: 0; opacity: 1}
        }
        .close-button {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            line-height: 1; /* Adjust to prevent cutting off top */
        }
        .close-button:hover,
        .close-button:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        #detailMessage {
            white-space: pre-wrap; /* Preserves whitespace and line breaks */
            word-break: break-word; /* Breaks long words */
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div id="preloader"></div>
    <div class="admin-container">
        <header class="admin-header">
            <div class="logo">Admin SMP 5 Semarang</div>
            <nav class="admin-nav">
                <ul>
                    <li><a href="../dashboard-adm.php">Dashboard</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </nav>
        </header>

        <main class="admin-content">
            <h1>Manajemen Pesan Kontak</h1>

            <?php
            // Tampilkan pesan status setelah delete
            if (isset($_GET['delete_status'])) {
                if ($_GET['delete_status'] == 'success') {
                    echo '<div class="alert alert-success">Pesan berhasil dihapus.</div>';
                } elseif ($_GET['delete_status'] == 'error') {
                    echo '<div class="alert alert-danger">Gagal menghapus pesan. Silakan coba lagi.</div>';
                }
            }
            ?>

            <?php if ($result && $result->num_rows > 0): ?>
                <table class="message-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Pesan (Ringkasan)</th>
                            <th>Tanggal Kirim</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td>
                                <?php
                                    // Tampilkan hanya sebagian pesan, dan tambahkan ellipsis jika terlalu panjang
                                    $short_message = htmlspecialchars($row['message']);
                                    if (strlen($short_message) > 100) {
                                        echo substr($short_message, 0, 100) . '...';
                                    } else {
                                        echo $short_message;
                                    }
                                ?>
                            </td>
                            <td><?php echo date('d M Y H:i', strtotime($row['created_at'])); ?></td>
                            <td>
                                <button class="btn btn-info view-message"
                                        data-id="<?php echo $row['id']; ?>"
                                        data-name="<?php echo htmlspecialchars($row['name']); ?>"
                                        data-email="<?php echo htmlspecialchars($row['email']); ?>"
                                        data-message="<?php echo htmlspecialchars($row['message']); ?>"
                                        data-date="<?php echo htmlspecialchars($row['created_at']); ?>">
                                    Lihat
                                </button>
                                <a href="admin-messages.php?action=delete&id=<?php echo $row['id']; ?>"
                                   class="btn btn-danger"
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus pesan ini?');">
                                    Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Tidak ada pesan yang masuk saat ini.</p>
            <?php endif; ?>
        </main>
    </div>

    <div id="messageDetailModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2>Detail Pesan</h2>
            <p><strong>ID Pesan:</strong> <span id="detailId"></span></p>
            <p><strong>Dari:</strong> <span id="detailName"></span></p>
            <p><strong>Email:</strong> <span id="detailEmail"></span></p>
            <p><strong>Tanggal Kirim:</strong> <span id="detailDate"></span></p>
            <p><strong>Pesan:</strong></p>
            <p id="detailMessage" style="white-space: pre-wrap; word-break: break-word;"></p>
            <button class="btn btn-danger" id="modalDeleteButton">Hapus Pesan</button>
        </div>
    </div>

    <script>
        // JavaScript untuk Modal Detail Pesan
        var modal = document.getElementById("messageDetailModal");
        var closeButton = document.getElementsByClassName("close-button")[0];
        var viewButtons = document.getElementsByClassName("view-message");
        var modalDeleteButton = document.getElementById("modalDeleteButton");

        for (var i = 0; i < viewButtons.length; i++) {
            viewButtons[i].onclick = function() {
                var id = this.getAttribute('data-id');
                var name = this.getAttribute('data-name');
                var email = this.getAttribute('data-email');
                var message = this.getAttribute('data-message');
                var date = this.getAttribute('data-date');

                document.getElementById('detailId').innerText = id;
                document.getElementById('detailName').innerText = name;
                document.getElementById('detailEmail').innerText = email;
                document.getElementById('detailMessage').innerText = message;
                document.getElementById('detailDate').innerText = date;

                // Set delete button URL in modal
                modalDeleteButton.onclick = function() {
                    if (confirm('Apakah Anda yakin ingin menghapus pesan ini?')) {
                        window.location.href = 'admin-messages.php?action=delete&id=' + id;
                    }
                };

                modal.style.display = "block";
            }
        }

        closeButton.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

    <script src="themekit/scripts/jquery.min.js"></script>
    <script src="themekit/scripts/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>

<?php
// Tutup koneksi database setelah semua data diambil dan ditampilkan
$conn->close();
?>