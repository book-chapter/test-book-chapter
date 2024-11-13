<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $username;
            $_SESSION['role'] = 'user';
            header("Location: user_dashboard.php");
            exit();
        } else {
            echo "Password salah.";
        }
    } else {
        echo "User tidak ditemukan.";
    }
}
?>

<h1>Login User</h1>
<form method="POST">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Login</button>

    <p>Belum punya akun? <a href="register_user.php">Registrasi di sini</a></p>

</form>