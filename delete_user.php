<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login_admin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];

    // Menghapus user berdasarkan ID
    $sql = "DELETE FROM users WHERE user_id = '$user_id'";
    if ($conn->query($sql) === TRUE) {
        echo "User berhasil dihapus.";
    } else {
        echo "Error: " . $conn->error;
    }

    // Kembali ke halaman manage_users.php
    header("Location: manage_users.php");
    exit();
}
