<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login_user.php");
    exit();
}
?>

<h1>Pembayaran dalam Proses Verifikasi</h1>
<p>Terima kasih, bukti pembayaran Anda sedang diverifikasi oleh admin. Silakan cek kembali nanti.</p>
<a href="user_dashboard.php">Kembali ke Dashboard</a>