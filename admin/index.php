<?php
include 'koneksi.php';
include 'auth.php';

// 1. Hitung Total Produk
$query_total = mysqli_query($conn, "SELECT COUNT(*) as total FROM obat");
$data_total = mysqli_fetch_assoc($query_total);
$total_produk = $data_total['total'];

// 2. Hitung Stok Menipis (di bawah 15)
$query_rendah = mysqli_query($conn, "SELECT COUNT(*) as total FROM obat WHERE stok < 15");
$data_rendah = mysqli_fetch_assoc($query_rendah);
$stok_menipis = $data_rendah['total'];

// 3. Hitung Estimasi Total Aset (Stok * Harga)
$query_aset = mysqli_query($conn, "SELECT SUM(stok * harga) as total_aset FROM obat");
$data_aset = mysqli_fetch_assoc($query_aset);
$total_aset = $data_aset['total_aset'] ?? 0;

// 4. Ambil Daftar Obat yang Stoknya Menipis untuk List
$list_rendah = mysqli_query($conn, "SELECT nama, stok, satuan FROM obat WHERE stok < 15 ORDER BY stok ASC");

// 5. Hitung Obat Kadaluwarsa (dalam 90 hari)
$query_exp_count = mysqli_query($conn, "SELECT COUNT(*) as total FROM obat WHERE tgl_kadaluwarsa <= DATE_ADD(CURDATE(), INTERVAL 90 DAY)");
$data_exp_count = mysqli_fetch_assoc($query_exp_count);
$total_exp_alert = $data_exp_count['total'];

// 6. Ambil Daftar Obat Mendekati Kadaluwarsa
$list_exp = mysqli_query($conn, "SELECT nama, tgl_kadaluwarsa FROM obat 
                                 WHERE tgl_kadaluwarsa >= CURDATE() 
                                 ORDER BY tgl_kadaluwarsa ASC LIMIT 5");


?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - Apotek Shabah</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>

<body class="bg-gray-100 flex">
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
    <header class="mb-8">
      <h2 class="text-3xl font-bold text-gray-800">Ringkasan Apotek</h2>
      <p class="text-gray-500">Data real-time dari database MySQL.</p>
    </header>
    <div class="flex gap-2 mb-4">
      <a href="export-excel.php" class="bg-emerald-100 text-emerald-700 px-4 py-2 rounded-lg text-sm font-bold hover:bg-emerald-200 transition flex items-center gap-2">
        <i class="fas fa-file-excel"></i>
        Export ke Excel
      </a>
      <a href="export-pdf.php" class="bg-red-100 text-red-700 px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-200 transition flex items-center gap-2">
        <i class="fas fa-file-pdf"></i>
        Export ke PDF
      </a>
      <button onclick="window.print()" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-bold hover:bg-gray-200 transition flex items-center gap-2">
        <i class="fas fa-print"></i>
        Cetak Laporan
      </button>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
      <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-orange-500">
        <p class="text-xs font-bold uppercase text-gray-400 mb-1">Hampir Kadaluwarsa</p>
        <div class="flex items-center justify-between">
          <h3 class="text-3xl font-bold text-gray-800"><?php echo $total_exp_alert; ?></h3>
          <i class="fas fa-calendar-times text-orange-200 text-3xl"></i>
        </div>
      </div>
      <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500">
        <p class="text-xs font-bold uppercase text-gray-400 mb-1">Total Produk</p>
        <div class="flex items-center justify-between">
          <h3 class="text-3xl font-bold text-gray-800"><?php echo $total_produk; ?></h3>
          <i class="fas fa-pills text-blue-200 text-3xl"></i>
        </div>
      </div>

      <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-red-500">
        <p class="text-xs font-bold uppercase text-gray-400 mb-1">Stok Menipis (< 15)</p>
            <div class="flex items-center justify-between">
              <h3 class="text-3xl font-bold text-gray-800"><?php echo $stok_menipis; ?></h3>
              <i class="fas fa-exclamation-triangle text-red-200 text-3xl"></i>
            </div>
      </div>

      <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-500">
        <p class="text-xs font-bold uppercase text-gray-400 mb-1">Estimasi Nilai Aset</p>
        <div class="flex items-center justify-between">
          <h3 class="text-xl font-bold text-gray-800">
            Rp
            <?php echo number_format($total_aset, 0, ',', '.'); ?>
          </h3>
          <i class="fas fa-wallet text-yellow-200 text-3xl"></i>
        </div>
      </div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
      <h3 class="font-bold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-history text-orange-600 mr-2"></i> Peringatan Kadaluwarsa
      </h3>
      <div class="space-y-3">
        <?php if (mysqli_num_rows($list_exp) > 0): ?>
          <?php while ($exp = mysqli_fetch_assoc($list_exp)):
            $tgl_exp = new DateTime($exp['tgl_kadaluwarsa']);
            $skrg = new DateTime();
            $diff = $skrg->diff($tgl_exp)->days;
          ?>
            <div class="flex justify-between items-center p-3 bg-orange-50 rounded-lg border border-orange-100">
              <div>
                <span class="block font-medium text-gray-700"><?php echo $exp['nama']; ?></span>
                <span class="text-[10px] text-gray-500 uppercase">Exp: <?php echo date('d M Y', strtotime($exp['tgl_kadaluwarsa'])); ?></span>
              </div>
              <span class="text-orange-600 font-bold text-xs"><?php echo $diff; ?> Hari Lagi</span>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <p class="text-gray-400 text-sm italic">Tidak ada obat mendekati kadaluwarsa.</p>
        <?php endif; ?>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
      <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="font-bold text-gray-800 mb-4 flex items-center"><i class="fas fa-list text-emerald-600 mr-2"></i> Daftar Re-stok Segera</h3>
        <div class="space-y-3">
          <?php if (
            mysqli_num_rows($list_rendah) >
            0
          ): ?>
            <?php while ($item = mysqli_fetch_assoc($list_rendah)): ?>
              <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg border border-red-100">
                <span class="font-medium text-gray-700"><?php echo $item['nama']; ?></span>
                <span class="text-red-600 font-bold"><?php echo $item['stok'] . " " . $item['satuan']; ?></span>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <p class="text-emerald-600 text-sm italic">Semua stok aman (di atas 15).</p>
          <?php endif; ?>
        </div>
      </div>

      <div class="bg-emerald-800 text-white p-8 rounded-xl relative overflow-hidden shadow-lg">
        <div class="relative z-10">
          <h3 class="text-xl font-bold mb-2">Sistem Apotek Shabah</h3>
          <p class="text-emerald-100 text-sm mb-4">Anda login sebagai Admin. Pastikan untuk selalu memeriksa stok obat keras secara berkala.</p>
          <a href="manage-obat.php" class="inline-block bg-yellow-400 text-emerald-900 px-6 py-2 rounded-lg font-bold text-sm hover:bg-yellow-300 transition"> Kelola Stok Sekarang </a>
        </div>
        <i class="fas fa-clinic-medical absolute -bottom-4 -right-4 text-emerald-700 text-9xl opacity-50"></i>
      </div>
    </div>
  </div>
</body>

</html>