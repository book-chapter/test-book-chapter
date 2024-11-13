<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login_user.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$order_result = $conn->query("SELECT orders.order_id, chapters.title, chapters.file_path
                              FROM orders 
                              JOIN chapters ON orders.chapter_id = chapters.chapter_id 
                              WHERE orders.user_id = '$user_id' AND orders.status = 'approved'");

?>

<h1>Download Bab Buku</h1>
<?php if ($order_result->num_rows > 0): ?>
    <ul>
        <?php while ($order = $order_result->fetch_assoc()): ?>
            <li>
                <strong><?= htmlspecialchars($order['title']) ?></strong><br>
                <a href="<?= htmlspecialchars($order['file_path']) ?>" download>Unduh Bab Buku</a>
            </li>
        <?php endwhile; ?>
    </ul>
<?php else: ?>
    <p>Tidak ada bab yang tersedia untuk diunduh. Pastikan pembayaran telah diverifikasi oleh admin.</p>
<?php endif; ?>
<a href="user_dashboard.php">Kembali ke Dashboard</a>