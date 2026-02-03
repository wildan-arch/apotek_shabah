<?php
// Cek apakah session sudah berjalan sebelum memulai baru
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_shabah'])) {
    header("Location: ../login.php");
    exit();
}
