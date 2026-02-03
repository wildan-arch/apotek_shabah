<?php
include 'koneksi.php';
include 'auth.php';

// Ambil data penjualan digabung dengan detailnya (optional)
$query = mysqli_query($conn, "SELECT * FROM penjualan ORDER BY tgl_transaksi DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Penjualan - Apotek Shabah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>

<body class="bg-gray-100 flex">
    <div class="w-64 h-screen bg-emerald-800 text-white p-6 sticky top-0">
        <h1 class="text-xl font-bold mb-8 italic">Apotek Shabah</h1>
        <nav class="space-y-4">
            <a href="index.php" class="block py-2 px-4 hover:bg-emerald-700 rounded">Dashboard</a>
            <a href="manage-obat.php" class="block py-2 px-4 hover:bg-emerald-700 rounded">Kelola Stok</a>
            <a href="kasir.php" class="block py-2 px-4 hover:bg-emerald-700 rounded">Kasir</a>
            <a href="riwayat-penjualan.php" class="block py-2 px-4 bg-emerald-900 rounded border-l-4 border-yellow-400">Riwayat Penjualan</a>
            <a href="logout.php" class="block py-2 px-4 text-red-300 hover:text-white">Logout</a>
        </nav>
    </div>

    <div class="flex-1 p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Riwayat Transaksi</h2>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden border">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-4">ID Transaksi</th>
                        <th class="p-4">Waktu</th>
                        <th class="p-4">Total Harga</th>
                        <th class="p-4">Bayar</th>
                        <th class="p-4">Kembalian</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($query)): ?>
                        <tr class="border-b hover:bg-gray-50 text-sm">
                            <td class="p-4 font-mono text-emerald-700">#TRX-<?= $row['id_penjualan']; ?></td>
                            <td class="p-4 text-gray-600"><?= date('d/m/Y H:i', strtotime($row['tgl_transaksi'])); ?></td>
                            <td class="p-4 font-bold">Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                            <td class="p-4 text-gray-600">Rp <?= number_format($row['bayar'], 0, ',', '.'); ?></td>
                            <td class="p-4 text-emerald-600">Rp <?= number_format($row['kembalian'], 0, ',', '.'); ?></td>
                            <td class="p-4 text-center">
                                <a href="detail-transaksi.php?id=<?= $row['id_penjualan']; ?>" class="text-blue-500 hover:underline">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>