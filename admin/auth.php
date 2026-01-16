<?php
session_start();
if (!isset($_SESSION['admin_shabah'])) {
    header("Location: ../login.php"); // Jika belum login, tendang ke halaman login
    exit();
}
