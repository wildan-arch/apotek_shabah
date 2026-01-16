<?php
include 'admin/db.php';

// Atur username dan password baru di sini
$username = 'admin_shabah';
$password_terang = 'shabah123';

// Proses enkripsi (Hash)
$password_aman = password_hash($password_terang, PASSWORD_DEFAULT);

$query = "INSERT INTO users (username, password) VALUES ('$username', '$password_aman')";

if (mysqli_query($conn, $query)) {
    echo "Akun Admin Berhasil Dibuat!<br>";
    echo "Username: $username<br>";
    echo "Password: $password_terang";
} else {
    echo "Gagal: " . mysqli_error($conn);
}
