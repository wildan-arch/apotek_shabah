<?php
// koneksi database dan autentikasi
include 'koneksi.php';
include 'auth.php';

// --- LOGIKA TAMBAH DATA ---
// --- LOGIKA TAMBAH DATA ---
if (isset($_POST['tambah'])) {
  $nama = ucwords(strtolower($_POST['nama']));
  $kategori = $_POST['kategori'];
  $stok = $_POST['stok'];
  $harga = $_POST['harga'];
  $satuan = $_POST['satuan'];
  $tgl_kadaluwarsa = $_POST['tgl_kadaluwarsa']; // Kolom baru
  $min_stok = $_POST['min_stok']; // Kolom baru

  // Sesuaikan nama kolom dengan database kamu
  $sql = "INSERT INTO obat (nama, kategori, stok, harga, satuan, tgl_kadaluwarsa, min_stok) 
          VALUES ('$nama', '$kategori', '$stok', '$harga', '$satuan', '$tgl_kadaluwarsa', '$min_stok')";

  if (mysqli_query($conn, $sql)) {
    echo "<script>
            alert('Data Berhasil Ditambahkan!');
            window.location.href='manage-obat.php';
          </script>";
    exit();
  }
}

// --- LOGIKA HAPUS DATA ---
// hapus data berdasarkan id obat
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  mysqli_query($conn, "DELETE FROM obat WHERE id = $id");
  header("Location: manage-obat.php"); // Refresh halaman
}

// --- AMBIL DATA UNTUK TABEL ---
$query = mysqli_query($conn, "SELECT * FROM obat ORDER BY nama ASC");

// --- LOGIKA PENCARIAN DATA ---
// --- AMBIL DATA UNTUK TABEL & LOGIKA PENCARIAN ---
$keyword = "";
if (isset($_GET['cari'])) {
  $keyword = mysqli_real_escape_string($conn, $_GET['cari']);
  // Mencari berdasarkan nama atau kategori
  $query = mysqli_query($conn, "SELECT * FROM obat WHERE nama LIKE '%$keyword%' OR kategori LIKE '%$keyword%' ORDER BY nama ASC");
} else {
  $query = mysqli_query($conn, "SELECT * FROM obat ORDER BY nama ASC");
}


?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <title>Kelola Stok - Apotek Shabah</title>
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
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Manajemen Stok Obat (PHP Version)</h2>

    <div class="bg-white p-6 rounded-xl shadow-sm mb-8 border border-gray-200">
      <h3 class="font-bold mb-4 text-emerald-800">Tambah Obat Baru</h3>
      <form action="manage-obat.php" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <input type="text" name="nama" placeholder="Nama Obat" class="border p-2 rounded capitalize" required />

        <select name="kategori" class="border p-2 rounded">
          <option>Obat Bebas</option>
          <option>Obat Keras</option>
        </select>

        <input type="number" name="stok" placeholder="Stok Awal" class="border p-2 rounded" required />

        <input type="number" name="min_stok" placeholder="Min. Stok Alert" class="border p-2 rounded" value="5" required />

        <input type="number" name="harga" placeholder="Harga" class="border p-2 rounded" required />

        <select name="satuan" class="border p-2 rounded">
          <option>Strip</option>
          <option>Botol</option>
        </select>

        <div class="flex flex-col">
          <label class="text-xs text-gray-500 ml-1">Tanggal Kadaluwarsa</label>
          <input type="date" name="tgl_kadaluwarsa" class="border p-2 rounded" required />
        </div>

        <button type="submit" name="tambah" class="bg-emerald-600 text-white p-2 rounded font-bold hover:bg-emerald-700 md:col-span-4">
          Simpan ke Database
        </button>
      </form>
    </div>

    <!-- fitur pencarian -->
    <div class="flex justify-between items-center mb-4">
      <h3 class="font-bold text-emerald-800">Daftar Stok Obat</h3>

      <form action="manage-obat.php" method="GET" class="flex gap-2">
        <div class="relative">
          <input type="text" name="cari" autocomplete="off" value="<?php echo $keyword; ?>"
            placeholder="Cari nama atau kategori..."
            class="pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none w-64">
          <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
        </div>
        <button type="submit" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg text-sm font-semibold">
          Cari
        </button>
        <?php if ($keyword != ""): ?>
          <a href="manage-obat.php" class="bg-red-100 text-red-600 px-4 py-2 rounded-lg text-sm font-semibold">Reset</a>
        <?php endif; ?>
      </form>
    </div>
    <!-- end fitur pencarian -->

    <div class="bg-white rounded-xl shadow-sm overflow-hidden border">
      <table class="w-full text-left">
        <thead class="bg-gray-50 border-b">
          <tr>
            <th class="p-4 text-center">ID</th>
            <th class="p-4">Nama Obat</th>
            <th class="p-4">Kategori</th>
            <th class="p-4">Stok</th>
            <th class="p-4">Harga</th>
            <th class="p-4 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1; // 1. Inisialisasi nomor mulai dari 1
          while ($row = mysqli_fetch_assoc($query)):
          ?>
            <tr class="border-b hover:bg-gray-50">
              <td class="p-4 text-center text-gray-500 font-medium">
                <?php echo $no++; ?>
              </td>

              <td class="p-4 font-bold text-gray-800"><?php echo $row['nama']; ?></td>
              <td class="p-4 text-gray-600"><?php echo $row['kategori']; ?></td>
              <td class="p-4">
                <span class="px-2 py-1 rounded text-xs font-bold <?php echo ($row['stok'] <= $row['min_stok']) ? 'bg-red-100 text-red-600' : 'bg-emerald-100 text-emerald-600'; ?>">
                  <?php echo $row['stok'] . " " . $row['satuan']; ?>
                </span>

                <div class="text-[10px] text-gray-400 mt-1">
                  Exp: <?php echo date('d/m/Y', strtotime($row['tgl_kadaluwarsa'])); ?>
                </div>
              </td>
              <td class="p-4 font-bold text-gray-700">
                Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?>
              </td>
              <td class="p-4 text-center">
                <a href="edit-obat.php?id=<?php echo $row['id']; ?>"
                  class="text-blue-500 hover:text-blue-700 transition mr-3">
                  <i class="fas fa-edit"></i>
                </a>

                <a href="manage-obat.php?hapus=<?php echo $row['id']; ?>"
                  onclick="return confirm('Yakin ingin menghapus <?php echo $row['nama']; ?>?')"
                  class="text-red-500 hover:text-red-700 transition">
                  <i class="fas fa-trash"></i>
                </a>
              </td>
            </tr>
          <?php endwhile; ?>

          <!-- pesan fitur pencarian -->

          <?php if (mysqli_num_rows($query) == 0): ?>
            <tr>
              <td colspan="6" class="p-8 text-center text-gray-500 italic">
                Data "<?php echo $keyword; ?>" tidak ditemukan.
              </td>
            </tr>
          <?php else: ?>
            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($query)):
            ?>
            <?php endwhile; ?>
          <?php endif; ?>
          <!-- end pesan fitur pencarien  -->
        </tbody>
      </table>
    </div>
  </div>
  <!-- icons -->
  <script src="https://unpkg.com/lucide@latest/dist/lucide.min.js"></script>
  <script>
    lucide.createIcons();
  </script>
</body>

</html>