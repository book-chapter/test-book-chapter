<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $action = $_POST['action'];
    $status = ($action == 'approve') ? 'approved' : 'rejected';

    $sql = "UPDATE orders SET status = '$status' WHERE order_id = '$order_id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: admin_dashboard.php");
    } else {
        echo "Error updating order: " . $conn->error;
    }
}
