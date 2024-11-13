<?php
include 'db.php';

if (!isset($_GET['order_id'])) {
    die("ID Pesanan tidak valid.");
}

$order_id = $_GET['order_id'];
$result = $conn->query("SELECT payment_proof_path FROM orders WHERE order_id = '$order_id'");
$order = $result->fetch_assoc();

if ($order) {
    $proof_path = $order['payment_proof_path'];
    echo "<h1>Bukti Pembayaran</h1>";
    echo "<img src='$proof_path' alt='Bukti Pembayaran' style='max-width:100%; height:auto;'><br>";
    echo "<a href='admin_dashboard.php'>Kembali ke Dashboard Admin</a>";
} else {
    echo "Bukti pembayaran tidak ditemukan.";
}
