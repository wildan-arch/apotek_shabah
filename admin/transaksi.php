<?php
// admin/transaksi.php
include 'auth.php'; // Pastikan user sudah login

// Ambil data obat untuk pilihan di dropdown
$obatData = json_decode(file_get_contents('../data/obat.json'), true);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Transaksi Apotek</title>
</head>

<body>
    <h2>Input Transaksi Baru</h2>
    <form action="proses-transaksi.php" method="POST">
        <label>Pilih Obat:</label>
        <select name="id_obat" required>
            <?php foreach ($obatData as $obat): ?>
                <option value="<?= $obat['id'] ?>"><?= $obat['nama'] ?> - Rp<?= $obat['harga'] ?> (Stok: <?= $obat['stok'] ?>)</option>
            <?php endforeach; ?>
        </select>

        <br><br>
        <label>Jumlah Beli:</label>
        <input type="number" name="jumlah" min="1" required>

        <br><br>
        <button type="submit">Simpan Transaksi</button>
    </form>
    <a href="index.php">Kembali ke Dashboard</a>
</body>

</html>