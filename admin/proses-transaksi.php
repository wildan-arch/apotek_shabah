<?php
// admin/proses-transaksi.php
include 'auth.php';

if ($_SERVER['REQUEST_SERVER'] == 'POST') {
    $id_obat = $_POST['id_obat'];
    $jumlah = (int)$_POST['jumlah'];
    $fileObat = '../data/obat.json';
    $fileTransaksi = '../data/transaksi.json';

    // 1. Update Stok di obat.json
    $obats = json_decode(file_get_contents($fileObat), true);
    foreach ($obats as &$o) {
        if ($o['id'] == $id_obat) {
            if ($o['stok'] < $jumlah) {
                die("Gagal: Stok tidak mencukupi!");
            }
            $o['stok'] -= $jumlah;
            $harga_satuan = $o['harga'];
            $nama_obat = $o['nama'];
            break;
        }
    }
    file_put_contents($fileObat, json_encode($obats, JSON_PRETTY_PRINT));

    // 2. Simpan Riwayat ke transaksi.json
    $transaksiLama = file_exists($fileTransaksi) ? json_decode(file_get_contents($fileTransaksi), true) : [];

    $newTransaksi = [
        "id_transaksi" => uniqid(),
        "tanggal" => date("Y-m-d H:i:s"),
        "nama_obat" => $nama_obat,
        "jumlah" => $jumlah,
        "total_bayar" => $jumlah * $harga_satuan
    ];

    $transaksiLama[] = $newTransaksi;
    file_put_contents($fileTransaksi, json_encode($transaksiLama, JSON_PRETTY_PRINT));

    echo "<script>alert('Transaksi Berhasil!'); window.location='transaksi.php';</script>";
}
