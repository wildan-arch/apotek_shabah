<?php
header("Content-Type: application/json");
include 'db.php'; // Hubungkan ke database

$method = $_SERVER['REQUEST_METHOD'];

// 1. AMBIL DATA (GET)
if ($method === 'GET') {
    $result = mysqli_query($conn, "SELECT * FROM obat ORDER BY id DESC");
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($data);
}

// 2. TAMBAH DATA (POST)
elseif ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $nama = $input['nama'];
    $kategori = $input['kategori'];
    $stok = (int)$input['stok'];
    $harga = (int)$input['harga'];
    $satuan = $input['satuan'];

    $query = "INSERT INTO obat (nama, kategori, stok, harga, satuan) VALUES ('$nama', '$kategori', $stok, $harga, '$satuan')";

    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
}

// 3. HAPUS DATA (DELETE)
elseif ($method === 'DELETE') {
    $id = $_GET['id'] ?? 0; // Hapus berdasarkan ID lebih aman daripada Nama
    $query = "DELETE FROM obat WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
}
