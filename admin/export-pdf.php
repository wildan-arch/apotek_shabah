<?php
require_once __DIR__ . '/dompdf/autoload.inc.php';
include 'koneksi.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Konfigurasi Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$dompdf = new Dompdf($options);

// Ambil data untuk laporan
$query = mysqli_query($conn, "SELECT * FROM obat ORDER BY nama ASC");
$tgl = date('d F Y');

// Buat konten HTML
$html = '
<style>
    body { font-family: sans-serif; font-size: 12px; }
    .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #999; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
    .footer { margin-top: 30px; text-align: right; }
    .text-red { color: red; font-weight: bold; }
</style>

<div class="header">
    <h2 style="margin:0;">APOTEK SHABAH</h2>
    <p style="margin:0;">Laporan Inventaris Stok Obat Terupdate</p>
    <p style="margin:0; font-size:10px;">Dicetak pada: ' . $tgl . '</p>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Obat</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Harga Satuan</th>
            <th>Kadaluwarsa</th>
        </tr>
    </thead>
    <tbody>';

$no = 1;
while ($row = mysqli_fetch_assoc($query)) {
    $html .= '
        <tr>
            <td>' . $no++ . '</td>
            <td>' . $row['nama'] . '</td>
            <td>' . $row['kategori'] . '</td>
            <td>' . $row['stok'] . ' ' . $row['satuan'] . '</td>
            <td>Rp ' . number_format($row['harga'], 0, ',', '.') . '</td>
            <td>' . date('d-m-Y', strtotime($row['tgl_kadaluwarsa'])) . '</td>
        </tr>';
}

$html .= '
    </tbody>
</table>

<div class="footer">
    <p>Penanggung Jawab,</p>
    <br><br><br>
    <p><b>( Admin Apotek Shabah )</b></p>
</div>';

// Proses konversi ke PDF
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Output ke browser (langsung download)
$dompdf->stream("Laporan_Apotek_Shabah.pdf", array("Attachment" => 1));
