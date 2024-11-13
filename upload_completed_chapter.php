<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login_user.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $allowed_types = ['pdf', 'doc', 'docx'];
    $file_name = basename($_FILES['completed_chapter']['name']);
    $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $upload_dir = 'uploads/completed/';
    $completed_chapter_path = $upload_dir . $file_name;

    if (in_array($file_type, $allowed_types)) {
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (move_uploaded_file($_FILES['completed_chapter']['tmp_name'], $completed_chapter_path)) {
            $sql = "INSERT INTO uploads (order_id, file_path) VALUES ('$order_id', '$completed_chapter_path')";
            if ($conn->query($sql) === TRUE) {
                echo "Hasil pengerjaan bab berhasil diunggah!";
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Gagal mengunggah file. Pastikan folder memiliki izin tulis.";
        }
    } else {
        echo "Hanya file PDF, DOC, dan DOCX yang diperbolehkan.";
    }
}

$orders = $conn->query("SELECT * FROM orders WHERE user_id = '{$_SESSION['user_id']}' AND status = 'approved'");
?>

<h1>Upload Hasil Pengerjaan Bab Buku</h1>
<?php if ($orders->num_rows > 0): ?>
    <?php while ($order = $orders->fetch_assoc()): ?>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
            Unggah File Hasil Pengerjaan (PDF, DOC, DOCX): <input type="file" name="completed_chapter" required><br>
            <button type="submit">Upload</button>
        </form>
        <hr>
    <?php endwhile; ?>
<?php else: ?>
    <p>Tidak ada bab buku yang tersedia untuk diunggah hasil pengerjaannya.</p>
<?php endif; ?>
<a href="user_dashboard.php">Kembali ke Dashboard</a>