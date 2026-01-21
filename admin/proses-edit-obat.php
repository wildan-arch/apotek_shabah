<!-- koneksi database -->
<?php
include 'koneksi.php';
include 'auth.php';

//  tangkap data dari form
$id_obat = $_POST['id_obat'];
$nama_obat = $_POST['nama_obat'];
$kategori = $_POST['kategori'];
$harga = $_POST['harga'];
$stok = $_POST['stok'];
$satuan = $_POST['satuan'];

// update data ke database
$query = "UPDATE obat SET nama='$nama_obat', kategori='$kategori', harga='$harga', stok='$stok', satuan='$satuan' WHERE id='$id_obat'";
$hasil = mysqli_query($conn, $query);

// cek apakah query berhasil
if ($hasil) {
    echo "<script>
          alert('Data Berhasil Diubah!');
          window.location.href='manage-obat.php';
        </script>";
} else {
    header("Location: manage-obat.php?pesan=update_failed");
}
