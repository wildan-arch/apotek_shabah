<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_obat = $_POST['id_obat'];
    $jumlah_beli = intval($_POST['jumlah']);

    // 1. Ambil detail obat dari database
    $query = mysqli_query($conn, "SELECT * FROM obat WHERE id = '$id_obat'");
    $obat = mysqli_fetch_assoc($query);

    if ($obat) {
        // 2. Cek apakah stok mencukupi
        if ($obat['stok'] < $jumlah_beli) {
            echo "<script>alert('Stok tidak mencukupi! Sisa stok: " . $obat['stok'] . "'); window.location='kasir.php';</script>";
            exit;
        }

        // 3. Struktur data item
        $nama_obat = $obat['nama'];
        $harga = $obat['harga_jual']; // Pastikan nama kolom sesuai di database-mu
        $satuan = $obat['satuan'];

        // 4. Jika keranjang sudah ada, cek apakah obat ini sudah pernah ditambah
        if (isset($_SESSION['keranjang'][$id_obat])) {
            // Jika sudah ada, tambahkan jumlahnya saja
            $_SESSION['keranjang'][$id_obat]['jumlah'] += $jumlah_beli;
            $_SESSION['keranjang'][$id_obat]['subtotal'] = $_SESSION['keranjang'][$id_obat]['jumlah'] * $harga;
        } else {
            // Jika belum ada, buat baris baru di session
            $_SESSION['keranjang'][$id_obat] = [
                'nama' => $nama_obat,
                'harga' => $harga,
                'jumlah' => $jumlah_beli,
                'satuan' => $satuan,
                'subtotal' => $harga * $jumlah_beli
            ];
        }

        header("Location: kasir.php");
    } else {
        echo "<script>alert('Obat tidak ditemukan!'); window.location='kasir.php';</script>";
    }
}
