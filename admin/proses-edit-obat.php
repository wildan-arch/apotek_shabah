<?php
include 'koneksi.php';
include 'auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id_obat'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama_obat']);
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $satuan = $_POST['satuan'];
    $min_stok = $_POST['min_stok'];
    $tgl_kadaluwarsa = $_POST['tgl_kadaluwarsa'];

    $query = "UPDATE obat SET 
                nama = '$nama', 
                kategori = '$kategori', 
                harga = '$harga', 
                stok = '$stok', 
                satuan = '$satuan', 
                min_stok = '$min_stok', 
                tgl_kadaluwarsa = '$tgl_kadaluwarsa' 
              WHERE id = '$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Data berhasil diperbarui!');
                window.location.href='manage-obat.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
