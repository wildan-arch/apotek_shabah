<?php
include 'db.php';
include 'auth.php';

// --- LOGIKA TAMBAH DATA ---
if (isset($_POST['tambah'])) {
  $nama = $_POST['nama'];
  $kategori = $_POST['kategori'];
  $stok = $_POST['stok'];
  $harga = $_POST['harga'];
  $satuan = $_POST['satuan'];

  mysqli_query($conn, "INSERT INTO obat (nama, kategori, stok, harga, satuan) 
                         VALUES ('$nama', '$kategori', '$stok', '$harga', '$satuan')");
  header("Location: manage-obat.php"); // Refresh halaman
}

// --- LOGIKA HAPUS DATA ---
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  mysqli_query($conn, "DELETE FROM obat WHERE id = $id");
  header("Location: manage-obat.php"); // Refresh halaman
}

// --- AMBIL DATA UNTUK TABEL ---
$query = mysqli_query($conn, "SELECT * FROM obat ORDER BY nama ASC");
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
    <nav class="space-y-4">
      <a href="index.php" class="block py-2 px-4 hover:bg-emerald-700 rounded">Dashboard</a>
      <a href="manage-obat.php" class="block py-2 px-4 bg-emerald-900 rounded border-l-4 border-yellow-400">Kelola Stok</a>
    </nav>
  </div>

  <div class="flex-1 p-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Manajemen Stok Obat (PHP Version)</h2>

    <div class="bg-white p-6 rounded-xl shadow-sm mb-8 border border-gray-200">
      <h3 class="font-bold mb-4 text-emerald-800">Tambah Obat Baru</h3>
      <form action="manage-obat.php" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <input type="text" name="nama" placeholder="Nama Obat" class="border p-2 rounded" required />
        <select name="kategori" class="border p-2 rounded">
          <option>Obat Bebas</option>
          <option>Obat Keras</option>
          <option>Vitamin</option>
        </select>
        <input type="number" name="stok" placeholder="Stok" class="border p-2 rounded" required />
        <input type="number" name="harga" placeholder="Harga" class="border p-2 rounded" required />
        <input type="text" name="satuan" placeholder="Satuan (strip/botol)" class="border p-2 rounded" required />
        <button type="submit" name="tambah" class="bg-emerald-600 text-white p-2 rounded font-bold hover:bg-emerald-700 md:col-span-5">Simpan ke Database</button>
      </form>
    </div>

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
                <span class="px-2 py-1 rounded text-xs font-bold <?php echo ($row['stok'] < 15) ? 'bg-red-100 text-red-600' : 'bg-emerald-100 text-emerald-600'; ?>">
                  <?php echo $row['stok'] . " " . $row['satuan']; ?>
                </span>
              </td>
              <td class="p-4 font-bold text-gray-700">
                Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?>
              </td>
              <td class="p-4 text-center">
                <a href="manage-obat.php?hapus=<?php echo $row['id']; ?>"
                  onclick="return confirm('Yakin ingin menghapus <?php echo $row['nama']; ?>?')"
                  class="text-red-500 hover:text-red-700 transition">
                  <i class="fas fa-trash"></i>
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