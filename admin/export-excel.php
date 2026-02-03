<?php
include 'koneksi.php';
include 'auth.php';

// Memberitahu browser bahwa ini adalah file Excel
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Stok_Apotek_Shabah.xls");

?>

<h3>Laporan Stok Obat Apotek Shabah</h3>
<p>Tanggal Cetak: <?php echo date('d-m-Y H:i:s'); ?></p>

<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Obat</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Satuan</th>
            <th>Harga</th>
            <th>Tgl Kadaluwarsa</th>
            <th>Total Nilai Aset</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $query = mysqli_query($conn, "SELECT * FROM obat ORDER BY nama ASC");
        while ($row = mysqli_fetch_assoc($query)) {
            $subtotal = $row['stok'] * $row['harga'];
            echo "<tr>
                    <td>$no</td>
                    <td>{$row['nama']}</td>
                    <td>{$row['kategori']}</td>
                    <td>{$row['stok']}</td>
                    <td>{$row['satuan']}</td>
                    <td>{$row['harga']}</td>
                    <td>{$row['tgl_kadaluwarsa']}</td>
                    <td>$subtotal</td>
                  </tr>";
            $no++;
        }
        ?>
    </tbody>
</table>