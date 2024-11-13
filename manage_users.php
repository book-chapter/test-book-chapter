<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login_admin.php");
    exit();
}

// Mengambil daftar user dari database
$users = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User</title>
</head>

<body>
    <h1>Manajemen User</h1>
    <a href="admin_dashboard.php">Kembali ke Dashboard Admin</a>
    <h2>Daftar User Terdaftar</h2>

    <table border="1" cellpadding="10">
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Nama Lengkap</th>
            <th>Tanggal Registrasi</th>
            <th>Aksi</th>
        </tr>
        <?php while ($user = $users->fetch_assoc()): ?>
            <tr>
                <td><?= $user['user_id'] ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['full_name']) ?></td>
                <td><?= $user['created_at'] ?></td>
                <td>
                    <!-- Tombol Hapus User -->
                    <form method="POST" action="delete_user.php" style="display:inline;">
                        <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                        <button type="submit" onclick="return confirm('Yakin ingin menghapus user ini?');">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>

</html>