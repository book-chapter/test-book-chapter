<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login_user.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Mengambil daftar bab yang tersedia untuk dibeli
$chapters = $conn->query("SELECT * FROM chapters");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
</head>

<body>
    <h1>Dashboard User</h1>
    <p>Selamat datang, <?= htmlspecialchars($_SESSION['username']); ?>!</p>
    <a href="logout.php">Logout</a>

    <h2>Daftar Bab Buku</h2>
    <p>Berikut adalah daftar bab buku yang tersedia untuk dibeli:</p>

    <table border="1" cellpadding="10">
        <tr>
            <th>Judul Bab</th>
            <th>Deskripsi</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
        <?php while ($chapter = $chapters->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($chapter['title']) ?></td>
                <td><?= htmlspecialchars($chapter['description']) ?></td>
                <td>Rp <?= number_format($chapter['price'], 2, ',', '.') ?></td>
                <td>
                    <a href="checkout.php?chapter_id=<?= $chapter['chapter_id'] ?>">Checkout</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Bab yang Sudah Dibeli</h2>
    <p>Anda dapat mengunduh bab buku yang sudah dibayar di sini:</p>

    <?php
    // Mengambil daftar bab yang sudah dibayar (status 'approved')
    $orders = $conn->query("SELECT orders.order_id, chapters.title, chapters.file_path 
                            FROM orders 
                            JOIN chapters ON orders.chapter_id = chapters.chapter_id 
                            WHERE orders.user_id = '$user_id' AND orders.status = 'approved'");
    ?>

    <?php if ($orders->num_rows > 0): ?>
        <ul>
            <?php while ($order = $orders->fetch_assoc()): ?>
                <li>
                    <strong><?= htmlspecialchars($order['title']) ?></strong><br>
                    <a href="<?= htmlspecialchars($order['file_path']) ?>" download>Unduh Bab Buku</a>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>Belum ada bab yang dapat diunduh. Pastikan pembayaran Anda sudah diverifikasi.</p>
    <?php endif; ?>

    <h2>Upload Hasil Pengerjaan Bab Buku</h2>
    <p>Jika Anda sudah selesai mengerjakan bab buku, unggah hasilnya di sini:</p>

    <?php
    // Mengambil daftar bab yang sudah dibayar untuk diunggah hasilnya
    $completed_orders = $conn->query("SELECT * FROM orders WHERE user_id = '$user_id' AND status = 'approved'");
    ?>

    <?php if ($completed_orders->num_rows > 0): ?>
        <?php while ($order = $completed_orders->fetch_assoc()): ?>
            <form method="POST" action="upload_completed_chapter.php" enctype="multipart/form-data">
                <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                Unggah Hasil Bab (PDF/DOC/DOCX): <input type="file" name="completed_chapter" required><br>
                <button type="submit">Upload</button>
            </form>
            <hr>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Tidak ada bab yang dapat diunggah hasil pengerjaannya.</p>
    <?php endif; ?>
</body>

</html>