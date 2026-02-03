<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_SESSION['keranjang'])) {
    $total_harga = $_POST['total_harga'];
    $bayar = $_POST['bayar'];
    $kembalian = $bayar - $total_harga;
    $tanggal = date('Y-m-d H:i:s');

    // Mulai Transaksi
    mysqli_begin_transaction($conn);

    try {
        // 1. Simpan ke tabel penjualan (Header)
        $query_jual = "INSERT INTO penjualan (tanggal, total_harga, bayar, kembalian) 
                       VALUES ('$tanggal', '$total_harga', '$bayar', '$kembalian')";
        mysqli_query($conn, $query_jual);

        // Ambil ID penjualan barusan
        $id_penjualan = mysqli_insert_id($conn);

        // 2. Loop keranjang untuk detail dan potong stok
        foreach ($_SESSION['keranjang'] as $id_obat => $item) {
            $jumlah = $item['jumlah'];
            $subtotal = $item['subtotal'];

            // Simpan ke tabel detail_penjualan
            $query_detail = "INSERT INTO detail_penjualan (id_penjualan, id_obat, jumlah, subtotal) 
                             VALUES ('$id_penjualan', '$id_obat', '$jumlah', '$subtotal')";
            mysqli_query($conn, $query_detail);

            // Update stok obat (Potong stok)
            $query_stok = "UPDATE obat SET stok = stok - $jumlah WHERE id = '$id_obat'";
            mysqli_query($conn, $query_stok);
        }

        // Jika semua berhasil, commit permanen
        mysqli_commit($conn);

        // Kosongkan keranjang
        unset($_SESSION['keranjang']);

        // Arahkan ke nota/struk
        echo "<script>
                alert('Transaksi Berhasil! Kembalian: Rp " . number_format($kembalian, 0, ',', '.') . "');
                window.location='kasir.php'; 
              </script>";
    } catch (Exception $e) {
        // Jika ada error, batalkan semua perubahan
        mysqli_rollback($conn);
        echo "<script>alert('Transaksi Gagal: " . $e->getMessage() . "'); window.location='kasir.php';</script>";
    }
} else {
    header("Location: kasir.php");
}
