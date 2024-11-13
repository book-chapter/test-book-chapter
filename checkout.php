<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login_user.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$chapter_id = $_GET['chapter_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "INSERT INTO orders (user_id, chapter_id, status) VALUES ('$user_id', '$chapter_id', 'pending')";
    if ($conn->query($sql) === TRUE) {
        header("Location: upload_payment_proof.php?order_id=" . $conn->insert_id);
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<h1>Checkout</h1>
<p>Silakan lakukan pembayaran ke nomor rekening berikut:</p>
<p><strong>Bank ABC - 1234567890</strong> (atas nama Book Chapter App)</p>

<form method="POST">
    <button type="submit">Saya Sudah Membayar</button>
</form>