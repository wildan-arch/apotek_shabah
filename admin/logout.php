<?php
session_start();
// Menghapus semua session
session_unset();
session_destroy();

// Mengarahkan kembali ke halaman login di luar folder admin
header("Location: ../login.php");
exit();
