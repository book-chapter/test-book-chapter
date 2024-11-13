<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['order_id'])) {
    header("Location: login_user.php");
    exit();
}

$order_id = $_GET['order_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $allowed_types = ['png', 'jpg', 'jpeg'];
    $file_name = basename($_FILES['payment_proof']['name']);
    $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $upload_dir = 'uploads/';
    $payment_proof_path = $upload_dir . $file_name;

    if (in_array($file_type, $allowed_types)) {
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (move_uploaded_file($_FILES['payment_proof']['tmp_name'], $payment_proof_path)) {
            $sql = "UPDATE orders SET payment_proof_path = '$payment_proof_path', status = 'waiting_confirmation' WHERE order_id = '$order_id'";
            if ($conn->query($sql) === TRUE) {
                header("Location: pending_confirmation.php");
                exit();
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Failed to upload file. Please check folder permissions.";
        }
    } else {
        echo "Only PNG, JPG, and JPEG files are allowed.";
    }
}
?>

<h1>Upload Bukti Pembayaran</h1>
<form method="POST" enctype="multipart/form-data">
    Upload Bukti Pembayaran (PNG, JPG, JPEG): <input type="file" name="payment_proof" required><br>
    <button type="submit">Submit</button>
</form>