<?php
session_start();
session_destroy(); // Mengakhiri semua sesi

// Arahkan pengguna kembali ke halaman utama atau login
header("Location: index.php");
exit();
