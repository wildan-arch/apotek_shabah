<?php
session_start(); // WAJIB ada agar keranjang muncul
include 'koneksi.php';
include 'auth.php';

// Ambil semua obat untuk pilihan dropdown
$obat_list = mysqli_query($conn, "SELECT * FROM obat WHERE stok > 0 ORDER BY nama ASC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Kasir - Apotek Shabah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .select2-container--default .select2-selection--single {
            height: 42px !important;
            border-radius: 0.5rem !important;
            border: 1px solid #e5e7eb !important;
            display: flex;
            align-items: center;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
        }
    </style>
</head>

<body class="bg-gray-50 flex">
    <div class="w-64 h-screen bg-emerald-800 text-white p-6 sticky top-0">
        <h1 class="text-xl font-bold mb-8 italic">Apotek Shabah</h1>
        <?php $current_page = basename($_SERVER['PHP_SELF']); ?>

        <nav class="space-y-4">
            <a href="index.php" class="block py-2 px-4 <?= ($current_page == 'index.php') ? 'bg-emerald-900 border-l-4 border-yellow-400' : 'hover:bg-emerald-700' ?> rounded">Dashboard</a>
            <a href="manage-obat.php" class="block py-2 px-4 <?= ($current_page == 'manage-obat.php') ? 'bg-emerald-900 border-l-4 border-yellow-400' : 'hover:bg-emerald-700' ?> rounded">Kelola Stok</a>
            <a href="kasir.php" class="block py-2 px-4 <?= ($current_page == 'kasir.php') ? 'bg-emerald-900 border-l-4 border-yellow-400' : 'hover:bg-emerald-700' ?> rounded">Kasir</a>
            <a href="riwayat-penjualan.php" class="block py-2 px-4 <?= ($current_page == 'riwayat-penjualan.php') ? 'bg-emerald-900 border-l-4 border-yellow-400' : 'hover:bg-emerald-700' ?> rounded">Riwayat</a>
        </nav>
        <a href="logout.php" class="block py-2 px-4 text-red-300">Logout</a>
        </nav>
    </div>

    <div class="flex-1 p-8">
        <h2 class="text-2xl font-bold text-emerald-800 mb-6">Kasir Penjualan</h2>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border h-fit">
                <h3 class="font-bold mb-4 text-gray-700"><i class="fas fa-plus-circle mr-2"></i>Tambah Item</h3>
                <form action="proses-keranjang.php" method="POST" class="space-y-4">
                    <div>
                        <label class="text-sm text-gray-500">Pilih Obat</label>
                        <select name="id_obat" id="pilih_obat" class="w-full" required>
                            <option value="">-- Ketik Nama Obat --</option>
                            <?php while ($o = mysqli_fetch_assoc($obat_list)): ?>
                                <option value="<?= $o['id']; ?>">
                                    <?= $o['nama']; ?> (Stok: <?= $o['stok']; ?>)
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Jumlah Beli</label>
                        <input type="number" name="jumlah" min="1" class="w-full border p-2 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none" placeholder="0" required>
                    </div>
                    <button type="submit" class="w-full bg-emerald-600 text-white py-2 rounded-lg font-bold hover:bg-emerald-700 transition">
                        Tambah ke Keranjang
                    </button>
                </form>
            </div>

            <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border">
                <h3 class="font-bold mb-4 text-gray-700"><i class="fas fa-shopping-cart mr-2"></i>Daftar Belanja</h3>
                <table class="w-full text-left mb-6">
                    <thead class="bg-gray-50 border-b text-gray-600">
                        <tr>
                            <th class="p-3">Obat</th>
                            <th class="p-3 text-center">Jumlah</th>
                            <th class="p-3 text-right">Harga</th>
                            <th class="p-3 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_bayar = 0;
                        if (isset($_SESSION['keranjang']) && !empty($_SESSION['keranjang'])):
                            foreach ($_SESSION['keranjang'] as $id => $item):
                                $total_bayar += $item['subtotal'];
                        ?>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3 text-sm">
                                        <div class="font-bold text-gray-800"><?= $item['nama']; ?></div>
                                        <a href="hapus-item.php?id=<?= $id; ?>" class="text-red-500 text-[10px] hover:underline uppercase">Hapus</a>
                                    </td>
                                    <td class="p-3 text-center text-sm"><?= $item['jumlah']; ?> <?= $item['satuan']; ?></td>
                                    <td class="p-3 text-right text-sm">Rp <?= number_format($item['harga'], 0, ',', '.'); ?></td>
                                    <td class="p-3 text-right font-bold text-emerald-700">Rp <?= number_format($item['subtotal'], 0, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach;
                        else: ?>
                            <tr>
                                <td colspan="4" class="p-8 text-center text-gray-400 italic">Keranjang masih kosong.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <?php if ($total_bayar > 0): ?>
                    <div class="border-t pt-6 bg-emerald-50 p-4 rounded-xl">
                        <div class="flex justify-between text-2xl font-bold text-emerald-800 mb-6">
                            <span>Total:</span>
                            <span>Rp <?= number_format($total_bayar, 0, ',', '.'); ?></span>
                        </div>

                        <form action="checkout.php" method="POST">
                            <input type="hidden" name="total_harga" value="<?= $total_bayar; ?>">
                            <div class="mb-4">
                                <label class="text-sm font-semibold text-emerald-900 mb-2 block">Uang Tunai Pelanggan (Rp)</label>
                                <input type="number" name="bayar" class="w-full border-2 border-emerald-200 p-3 rounded-xl text-2xl font-bold text-emerald-800 focus:border-emerald-500 outline-none" required min="<?= $total_bayar; ?>" placeholder="0">
                            </div>
                            <button type="submit" onclick="return confirm('Proses transaksi ini?')" class="w-full bg-yellow-400 text-emerald-900 py-4 rounded-xl font-bold text-lg hover:bg-yellow-300 transition shadow-lg">
                                <i class="fas fa-check-circle mr-2"></i> Selesaikan Transaksi
                            </button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- fitur ketik untuk beli obat -->
    <script>
        $(document).ready(function() {
            $('#pilih_obat').select2({
                placeholder: "Cari nama obat...",
                allowClear: true
            });
        });

        // fitur shortcut f2 langsung cari obat
        $(document).keydown(function(e) {
            if (e.keyCode == 113) { // 113 adalah kode tombol F2
                $('#pilih_obat').select2('open');
            }
        });
    </script>
</body>

</html>