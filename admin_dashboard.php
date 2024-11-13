<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login_admin.php");
    exit();
}

$orders = $conn->query("SELECT orders.order_id, users.email AS user_email, chapters.title AS chapter_title, orders.order_date
                        FROM orders
                        JOIN users ON orders.user_id = users.user_id
                        JOIN chapters ON orders.chapter_id = chapters.chapter_id
                        WHERE orders.status = 'waiting_confirmation'");

$users = $conn->query("SELECT * FROM users");
$chapters = $conn->query("SELECT * FROM chapters");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
</head>

<body>
    <h1>Dashboard Admin - Administrator</h1>
    <div class="nav-tabs">
        <a href="admin_dashboard.php">Verifikasi Pembayaran</a>
        <a href="manage_users.php">Manajemen User</a>
        <a href="manage_chapters.php">Manajemen Bab</a>
        <a href="logout.php">Logout</a>

    </div>


    <!-- Verifikasi Pembayaran -->
    <div id="tab1" class="tab active">
        <h2>Verifikasi Pembayaran Pending</h2>
        <table>
            <tr>
                <th>User</th>
                <th>Bab</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
            <?php while ($order = $orders->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($order['user_email']) ?></td>
                    <td><?= htmlspecialchars($order['chapter_title']) ?></td>
                    <td><?= htmlspecialchars($order['order_date']) ?></td>
                    <td>
                        <form method="POST" action="verify_order.php" style="display:inline;">
                            <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                            <button type="submit" name="action" value="approve" class="btn btn-verify">Verifikasi</button>
                            <button type="submit" name="action" value="reject" class="btn btn-reject">Tolak</button>
                        </form>
                        <a href="view_proof.php?order_id=<?= $order['order_id'] ?>" class="btn btn-view">Lihat Bukti</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>

</html>